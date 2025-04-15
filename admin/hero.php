<?php
session_start();
include '../db.php';

// Oturum kontrolü
if (!isset($_SESSION['loggedin'])) {
    echo '<div class="alert alert-danger">Bu sayfayı görüntülemek için giriş yapmalısınız!</div>';
    exit;
}

// HTML etiketlerini - ile değiştir (düzenleme için)
function convertBrTagsToHyphens($text) {
    $patterns = [
        '/<br\s*\/?>/',                          // <br>, <br/>, <br />
        '/<br\s+class="d-none d-md-inline"\s*\/?>/', // <br class="d-none d-md-inline">
    ];
    return preg_replace($patterns, ' - ', $text);
}

// AJAX isteği olup olmadığını kontrol et
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Hero içeriğini güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_hero'])) {
    // Form verilerini al
    $topTitle = $_POST['top_title'];
    $mainTitle = $_POST['main_title'];
    $description = $_POST['description'];
    
    // Font boyutlarını al
    $topTitleSize = isset($_POST['top_title_size']) ? intval($_POST['top_title_size']) : 14;
    $mainTitleSize = isset($_POST['main_title_size']) ? intval($_POST['main_title_size']) : 36;
    $descriptionSize = isset($_POST['description_size']) ? intval($_POST['description_size']) : 16;
    
    // Geçerli aralıklarda olduğundan emin olalım
    $topTitleSize = max(10, min(36, $topTitleSize));
    $mainTitleSize = max(18, min(72, $mainTitleSize));
    $descriptionSize = max(10, min(24, $descriptionSize));
    
    // Eğer JavaScript ile <br> dönüşümü yapılmadıysa burada yapalım
    if (strpos($mainTitle, '<br>') === false && strpos($mainTitle, ' - ') !== false) {
        $mainTitle = str_replace(' - ', '<br>', $mainTitle);
    }
    
    if (strpos($description, '<br class="d-none d-md-inline">') === false && strpos($description, ' - ') !== false) {
        $description = str_replace(' - ', '<br class="d-none d-md-inline">', $description);
    }
    
    // SQL için güvenli hale getir
    $topTitle = mysqli_real_escape_string($conn, $topTitle);
    $mainTitle = mysqli_real_escape_string($conn, $mainTitle);
    $description = mysqli_real_escape_string($conn, $description);
    
    // Hero content tablosunu kontrol et
    $tableExists = $conn->query("SHOW TABLES LIKE 'hero_content'");
    if ($tableExists->num_rows == 0) {
        // Tablo yoksa oluştur
        $createTable = "CREATE TABLE hero_content (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            top_title VARCHAR(255) NOT NULL,
            main_title TEXT NOT NULL,
            description TEXT NOT NULL,
            top_title_size INT(11) DEFAULT 14,
            main_title_size INT(11) DEFAULT 36,
            description_size INT(11) DEFAULT 16,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if (!$conn->query($createTable)) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'Tablo oluşturma hatası: ' . $conn->error]);
                exit;
            } else {
                echo '<div class="alert alert-danger">Tablo oluşturma hatası: ' . $conn->error . '</div>';
            }
        }
    } else {
        // Tablo varsa, gerekli sütunları ekle (font boyutları için)
        $columnCheck = $conn->query("SHOW COLUMNS FROM hero_content LIKE 'top_title_size'");
        if ($columnCheck->num_rows == 0) {
            $alterTable = "ALTER TABLE hero_content 
                ADD COLUMN top_title_size INT(11) DEFAULT 14,
                ADD COLUMN main_title_size INT(11) DEFAULT 36,
                ADD COLUMN description_size INT(11) DEFAULT 16";
            
            if (!$conn->query($alterTable)) {
                if ($isAjax) {
                    echo json_encode(['success' => false, 'message' => 'Tablo güncelleme hatası: ' . $conn->error]);
                    exit;
                } else {
                    echo '<div class="alert alert-danger">Tablo güncelleme hatası: ' . $conn->error . '</div>';
                }
            }
        }
    }
    
    // Kayıt var mı kontrol et
    $result = $conn->query("SELECT * FROM hero_content WHERE id = 1");
    $successMessage = '';
    
    if ($result && $result->num_rows > 0) {
        // Kayıt varsa güncelle
        $sql = "UPDATE hero_content SET 
            top_title = '$topTitle',
            main_title = '$mainTitle',
            description = '$description',
            top_title_size = $topTitleSize,
            main_title_size = $mainTitleSize,
            description_size = $descriptionSize
            WHERE id = 1";
            
        if ($conn->query($sql)) {
            $successMessage = 'Hero içeriği başarıyla güncellendi!';
        } else {
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'Güncelleme hatası: ' . $conn->error]);
                exit;
            } else {
                echo '<div class="alert alert-danger">Güncelleme hatası: ' . $conn->error . '</div>';
            }
        }
    } else {
        // Kayıt yoksa ekle
        $sql = "INSERT INTO hero_content (id, top_title, main_title, description, top_title_size, main_title_size, description_size) 
                VALUES (1, '$topTitle', '$mainTitle', '$description', $topTitleSize, $mainTitleSize, $descriptionSize)";
                
        if ($conn->query($sql)) {
            $successMessage = 'Hero içeriği başarıyla eklendi!';
        } else {
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'Ekleme hatası: ' . $conn->error]);
                exit;
            } else {
                echo '<div class="alert alert-danger">Ekleme hatası: ' . $conn->error . '</div>';
            }
        }
    }
    
    // AJAX isteği ise JSON dön
    if ($isAjax) {
        echo json_encode(['success' => true, 'message' => $successMessage]);
        exit;
    }
}

// Hero içeriğini getir
$hero_data = $conn->query("SELECT * FROM hero_content WHERE id = 1");

if ($hero_data && $hero_data->num_rows > 0) {
    $hero = $hero_data->fetch_assoc();
    $topTitle = $hero['top_title'];
    $mainTitle = $hero['main_title'];
    $description = $hero['description'];
    
    // Font boyutlarını al (sütun yoksa varsayılan değerleri kullan)
    $topTitleSize = isset($hero['top_title_size']) ? $hero['top_title_size'] : 14;
    $mainTitleSize = isset($hero['main_title_size']) ? $hero['main_title_size'] : 36;
    $descriptionSize = isset($hero['description_size']) ? $hero['description_size'] : 16;
} else {
    // Varsayılan değerler
    $topTitle = 'İ s t a n b u l   T i c a r e t   Ü n i v e r s i t e s i';
    $mainTitle = 'IoT Zirvesi <br>ve Eğitimleri';
    $description = 'Temel amacımız siber güvenlik alanında eğitimler, <br class="d-none d-md-inline"> seminerler ve tanıtım içerikleri üreterek bu alana ilgisi olan kişileri <br class="d-none d-md-inline"> geliştirmektir.';
    $topTitleSize = 14;
    $mainTitleSize = 36;
    $descriptionSize = 16;
}

// HTML etiketlerini - ile değiştir (düzenleme formu için)
$mainTitle_edit = convertBrTagsToHyphens($mainTitle);
$description_edit = convertBrTagsToHyphens($description);

// AJAX isteği ise burada sonlandır
if ($isAjax && $_SERVER['REQUEST_METHOD'] === 'POST') {
    exit;
}
?>

<style>
    .preview-card {
        background-color: #212529;
        border-radius: 8px;
        padding: 1.5rem;
    }
    
    .preview-title {
        color: white !important;
        margin-bottom: 0.75rem;
    }
    
    .preview-subtitle {
        color: rgba(255,255,255,0.61) !important;
        margin-bottom: 0.25rem;
    }
    
    .preview-description {
        color: rgba(255,255,255,0.61) !important;
    }
    
    .font-size-control {
        display: flex;
        align-items: center;
        margin-top: 5px;
    }
    
    .font-size-control input[type=range] {
        flex-grow: 1;
        margin-right: 10px;
    }
    
    .font-size-control .font-size-value {
        min-width: 45px;
        text-align: center;
        background-color: #f8f9fa;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.875rem;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Hero İçeriği Düzenle</h4>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form id="heroForm">
            <div class="mb-3">
                <label for="top_title" class="form-label">Üst Başlık</label>
                <input type="text" class="form-control" id="top_title" name="top_title" value="<?php echo htmlspecialchars($topTitle); ?>" required>
                <small class="form-text text-muted">Örnek: İ s t a n b u l   T i c a r e t   Ü n i v e r s i t e s i</small>
                
                <div class="font-size-control">
                    <label class="me-2 small">Punto:</label>
                    <input type="range" class="form-range" id="top_title_size" name="top_title_size" min="10" max="36" step="1" value="<?php echo $topTitleSize; ?>">
                    <span class="font-size-value" id="top_title_size_value"><?php echo $topTitleSize; ?>px</span>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="main_title" class="form-label">Ana Başlık</label>
                <textarea class="form-control" id="main_title" name="main_title" rows="2" required><?php echo htmlspecialchars($mainTitle_edit); ?></textarea>
                <small class="form-text text-muted">Not: Satır kesmesi için orta tire (-) kullanabilirsiniz. Örnek: IoT Zirvesi - ve Eğitimleri</small>
                
                <div class="font-size-control">
                    <label class="me-2 small">Punto:</label>
                    <input type="range" class="form-range" id="main_title_size" name="main_title_size" min="18" max="72" step="1" value="<?php echo $mainTitleSize; ?>">
                    <span class="font-size-value" id="main_title_size_value"><?php echo $mainTitleSize; ?>px</span>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Açıklama</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($description_edit); ?></textarea>
                <small class="form-text text-muted">Not: Satır kesmesi için orta tire (-) kullanın. Responsive yapı otomatik ayarlanacaktır.</small>
                
                <div class="font-size-control">
                    <label class="me-2 small">Punto:</label>
                    <input type="range" class="form-range" id="description_size" name="description_size" min="10" max="24" step="1" value="<?php echo $descriptionSize; ?>">
                    <span class="font-size-value" id="description_size_value"><?php echo $descriptionSize; ?>px</span>
                </div>
            </div>
            
            <div class="mb-4">
                <h5>Önizleme</h5>
                <div class="preview-card">
                    <p class="preview-subtitle mb-1" id="preview_top_title" style="font-size: <?php echo $topTitleSize; ?>px;"><?php echo htmlspecialchars($topTitle); ?></p>
                    <h3 class="preview-title" id="preview_main_title" style="font-size: <?php echo $mainTitleSize; ?>px;"><?php echo $mainTitle; ?></h3>
                    <p class="preview-description mb-0" id="preview_description" style="font-size: <?php echo $descriptionSize; ?>px;"><?php echo $description; ?></p>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" name="update_hero">
                <i class="bi bi-save me-1"></i> Güncelle
            </button>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    const topTitleInput = document.getElementById('top_title');
    const mainTitleInput = document.getElementById('main_title');
    const descriptionInput = document.getElementById('description');
    const previewTopTitle = document.getElementById('preview_top_title');
    const previewMainTitle = document.getElementById('preview_main_title');
    const previewDescription = document.getElementById('preview_description');
    
    // Font size slider elementleri
    const topTitleSizeSlider = document.getElementById('top_title_size');
    const mainTitleSizeSlider = document.getElementById('main_title_size');
    const descriptionSizeSlider = document.getElementById('description_size');
    const topTitleSizeValue = document.getElementById('top_title_size_value');
    const mainTitleSizeValue = document.getElementById('main_title_size_value');
    const descriptionSizeValue = document.getElementById('description_size_value');
    
    // Başlangıçta önizlemeyi güncelle
    updatePreview();
    
    // Önizleme güncelleme fonksiyonu
    function updatePreview() {
        // Üst başlık önizlemesi
        previewTopTitle.textContent = topTitleInput.value;
        
        // Ana başlık önizlemesi
        let mainTitleContent = mainTitleInput.value;
        mainTitleContent = mainTitleContent.replace(/ - /g, '<br>');
        previewMainTitle.innerHTML = mainTitleContent;
        
        // Açıklama önizlemesi
        let descriptionContent = descriptionInput.value;
        descriptionContent = descriptionContent.replace(/ - /g, '<br class="d-none d-md-inline">');
        previewDescription.innerHTML = descriptionContent;
    }
    
    // Font boyutu güncelleme fonksiyonu
    function updateFontSizes() {
        previewTopTitle.style.fontSize = topTitleSizeSlider.value + 'px';
        previewMainTitle.style.fontSize = mainTitleSizeSlider.value + 'px';
        previewDescription.style.fontSize = descriptionSizeSlider.value + 'px';
        
        topTitleSizeValue.textContent = topTitleSizeSlider.value + 'px';
        mainTitleSizeValue.textContent = mainTitleSizeSlider.value + 'px';
        descriptionSizeValue.textContent = descriptionSizeSlider.value + 'px';
    }
    
    // Input alanları değişince önizlemeyi güncelle
    $(topTitleInput).on('input', updatePreview);
    $(mainTitleInput).on('input', updatePreview);
    $(descriptionInput).on('input', updatePreview);
    
    // Font boyutu ayarları değişince önizlemeyi güncelle
    $(topTitleSizeSlider).on('input', updateFontSizes);
    $(mainTitleSizeSlider).on('input', updateFontSizes);
    $(descriptionSizeSlider).on('input', updateFontSizes);
    
    // Form gönderim işlemi
    $('#heroForm').on('submit', function(e) {
        e.preventDefault();
        
        // Yükleniyor göstergesi
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Güncelleniyor...');
        submitBtn.prop('disabled', true);
        
        // Orta tireleri uygun HTML kodlarına dönüştür
        let mainTitle = mainTitleInput.value.replace(/ - /g, '<br>');
        let description = descriptionInput.value.replace(/ - /g, '<br class="d-none d-md-inline">');
        
        // Form verilerini hazırla
        const formData = {
            top_title: $('#top_title').val(),
            main_title: mainTitle,
            description: description,
            top_title_size: $('#top_title_size').val(),
            main_title_size: $('#main_title_size').val(),
            description_size: $('#description_size').val(),
            update_hero: true
        };
        
        // AJAX isteği
        $.ajax({
            url: 'hero.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                // Form düğmesini eski haline getir
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
                
                if (response.success) {
                    // Başarı mesajı göster
                    const successAlert = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i> ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    
                    // Mevcut uyarıları kaldır ve yeni uyarı ekle
                    $('.alert').remove();
                    $('.card').before(successAlert);
                } else {
                    // Hata mesajı göster
                    const errorAlert = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i> ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    
                    // Mevcut uyarıları kaldır ve yeni uyarı ekle
                    $('.alert').remove();
                    $('.card').before(errorAlert);
                }
            },
            error: function(xhr, status, error) {
                // Form düğmesini eski haline getir
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
                
                // Hata mesajı göster
                const errorAlert = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> Bağlantı hatası: ${error}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                
                // Mevcut uyarıları kaldır ve yeni uyarı ekle
                $('.alert').remove();
                $('.card').before(errorAlert);
            }
        });
    });
});
</script> 