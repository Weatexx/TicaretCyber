<?php
session_start();
include '../db.php';

// Oturum kontrolü
if (!isset($_SESSION['loggedin'])) {
    exit('Yetkisiz erişim');
}

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    $update_sql = "UPDATE about_us SET 
                  title = '$title',
                  subtitle = '$subtitle',
                  content = '$content'
                  WHERE id = 1";
                  
    if (mysqli_query($conn, $update_sql)) {
        // AJAX isteği için basit bir başarı mesajı döndür
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['success' => true, 'message' => 'Hakkımızda bilgileri başarıyla güncellendi!']);
            exit;
        } else {
            // Normal form gönderimi için yönlendirme
            echo "<script>
                alert('Hakkımızda bilgileri başarıyla güncellendi!');
                window.location.href = 'about.php';
            </script>";
            exit;
        }
    } else {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['success' => false, 'message' => 'Güncelleme hatası: ' . mysqli_error($conn)]);
            exit;
        } else {
            echo "<div class='alert alert-danger'>Güncelleme hatası: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Hakkımızda bilgilerini çek
$sql = "SELECT * FROM about_us WHERE id = 1";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "<div class='alert alert-danger'>Veritabanı hatası: " . mysqli_error($conn) . "</div>";
}

$about = mysqli_fetch_assoc($result);

// URL'den başarı mesajı kontrolü
$success_message = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = "Hakkımızda bilgileri başarıyla güncellendi!";
}
?>

<style>
    /* Responsive stillemeler */
    .about-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .about-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,0.125);
        padding: 15px 20px;
    }
    
    .about-card .card-body {
        padding: 20px;
    }
    
    .about-content {
        white-space: pre-line;
        line-height: 1.6;
    }
    
    .edit-form-container {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-top: 20px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .edit-form-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,0.125);
        padding: 15px 20px;
    }
    
    .edit-form-body {
        padding: 20px;
    }
    
    .form-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    @media (max-width: 768px) {
        .about-card .card-header {
            padding: 12px 15px;
        }
        
        .about-card .card-body {
            padding: 15px;
        }
        
        .form-buttons {
            flex-direction: column;
        }
        
        .form-buttons .btn {
            margin-bottom: 10px;
            width: 100%;
        }
        
        textarea.form-control {
            min-height: 150px;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Hakkımızda Bilgileri</h4>
</div>

<?php if (!empty($success_message)): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $success_message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if ($about) { ?>
    <div class="card mb-4 about-card">
        <div class="card-header">
            <div>
                <h5 class="mb-0"><?php echo htmlspecialchars($about['title']); ?></h5>
                <?php if (!empty($about['subtitle'])) { ?>
                    <small class="text-muted"><?php echo htmlspecialchars($about['subtitle']); ?></small>
                <?php } ?>
            </div>
        </div>
        <div class="card-body">
            <div class="about-content"><?php echo nl2br(htmlspecialchars($about['content'])); ?></div>
            <p class="text-muted small mt-3">Son Güncelleme: <?php echo date('d.m.Y H:i', strtotime($about['updated_at'])); ?></p>
            
            <!-- Düzenle butonu bilgilerin altına taşındı -->
            <div class="text-end mt-3">
                <button class="btn btn-primary" onclick="showEditForm()">
                    <i class="bi bi-pencil-square me-1"></i> Düzenle
                </button>
            </div>
        </div>
    </div>

    <!-- Düzenleme Formu (başlangıçta gizli) -->
    <div id="editForm" style="display: none;" class="edit-form-container">
        <div class="edit-form-header">
            <h5 class="mb-0">Hakkımızda Bilgilerini Düzenle</h5>
        </div>
        <div class="edit-form-body">
            <form method="POST" id="aboutForm">
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($about['title'] ?? ''); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="subtitle" class="form-label">Alt Başlık</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($about['subtitle'] ?? ''); ?>">
                    <small class="form-text text-muted">Alt başlık isteğe bağlıdır. İki farklı satır olarak göstermek için tire (-) işareti ile ayırabilirsiniz. Örnek: "İstanbul Ticaret Üniversitesi - Siber Güvenlik Topluluğu"</small>
                </div>
                <div class="form-group mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($about['content'] ?? ''); ?></textarea>
                    <small class="form-text text-muted">Hakkımızda bölümünün içeriğini giriniz. Paragraflar otomatik olarak korunacaktır.</small>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Kaydet
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="hideEditForm()">
                        <i class="bi bi-x-circle me-1"></i> İptal
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-info">
        <h5 class="alert-heading">Hakkımızda bilgisi bulunamadı</h5>
        <p>Veritabanında "about_us" tablosunu oluşturun ve içeriği ekleyin.</p>
        <hr>
        <div class="code-container p-3 bg-light rounded">
            <pre class="mb-0"><code>CREATE TABLE about_us (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO about_us (title, subtitle, content) VALUES (
    'Biz Kimiz?',
    'İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu',
    'İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu, teknolojiye ve bilgi güvenliğine ilgi duyan öğrencilerin bir araya geldiği bir platformdur. Topluluk, siber güvenlik alanında farkındalık yaratmak, üyelerinin bilgi ve becerilerini geliştirmek ve kariyer hedeflerine katkı sağlamak amacıyla çeşitli etkinlikler ve eğitimler düzenlemektedir. Etik hacking, ağ güvenliği, yazılım güvenliği, tersine mühendislik ve siber tehdit analizi gibi konular topluluğun temel çalışma alanları arasında yer alır.'
);</code></pre>
        </div>
    </div>
<?php } ?>

<script>
function showEditForm() {
    document.getElementById('editForm').style.display = 'block';
    // Düzenle formuna otomatik kaydır
    document.getElementById('editForm').scrollIntoView({behavior: 'smooth'});
}

function hideEditForm() {
    document.getElementById('editForm').style.display = 'none';
}

$(document).ready(function() {
    $('#aboutForm').on('submit', function(e) {
        e.preventDefault();
        
        // Yükleniyor göstergesi
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Kaydediliyor...');
        submitBtn.prop('disabled', true);
        
        $.ajax({
            type: 'POST',
            url: 'about.php',
            data: $(this).serialize(),
            success: function(response) {
                // Form düğmesini eski haline getir
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
                
                // AJAX isteği başarılı olduktan sonra
                alert('Hakkımızda bilgileri başarıyla güncellendi!');
                
                // Sayfayı yenilemek yerine, içeriği tekrar yükle
                loadContent('about');
            },
            error: function(xhr, status, error) {
                // Form düğmesini eski haline getir
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
                
                alert('Hata oluştu: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

