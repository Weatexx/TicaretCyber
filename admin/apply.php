<?php
session_start();
include '../db.php';

// Oturum kontrolü
if (!isset($_SESSION['loggedin'])) {
    exit('Yetkisiz erişim');
}

// POST isteği varsa URL'leri güncelle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['button_url'])) {
        $newUrl = mysqli_real_escape_string($conn, $_POST['button_url']);
        $updateQuery = "UPDATE apply SET button_url = '$newUrl' WHERE id = 1";
        mysqli_query($conn, $updateQuery);
    }
    
    if (isset($_POST['contact_url'])) {
        $newContactUrl = mysqli_real_escape_string($conn, $_POST['contact_url']);
        $updateQuery = "UPDATE apply SET contact_url = '$newContactUrl' WHERE id = 1";
        mysqli_query($conn, $updateQuery);
    }
}

// Mevcut URL'leri çek
$query = "SELECT button_url, contact_url FROM apply WHERE id = 1";
$result = mysqli_query($conn, $query);
$apply = mysqli_fetch_assoc($result);
?>

<style>
    /* Responsive stillemeler */
    .settings-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .settings-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,0.125);
        padding: 15px 20px;
    }
    
    .settings-card .card-body {
        padding: 20px;
    }
    
    .url-preview {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        padding: 6px 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
        font-size: 0.9rem;
        margin-top: 5px;
    }
    
    .form-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    @media (max-width: 768px) {
        .settings-card .card-header {
            padding: 12px 15px;
        }
        
        .settings-card .card-body {
            padding: 15px;
        }
        
        .url-preview {
            font-size: 0.8rem;
        }
        
        .form-buttons {
            flex-direction: column;
        }
        
        .form-buttons .btn {
            margin-bottom: 10px;
            width: 100%;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>URL Ayarları</h4>
</div>

<div class="card settings-card">
    <div class="card-header">
        <h5 class="mb-0">Buton URL Ayarları</h5>
    </div>
    <div class="card-body">
        <form id="applyForm" method="POST">
            <div class="form-group mb-4">
                <label for="button_url" class="form-label">Başvuru Butonu URL'si</label>
                <input type="url" class="form-control" id="button_url" name="button_url" 
                       value="<?php echo htmlspecialchars($apply['button_url']); ?>" required>
                <small class="form-text text-muted">Başvuru butonuna tıklandığında yönlendirilecek URL'yi girin.</small>
                <?php if (!empty($apply['button_url'])): ?>
                <div class="url-preview mt-2">
                    <i class="bi bi-link-45deg"></i> <?php echo htmlspecialchars($apply['button_url']); ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="form-group mb-4">
                <label for="contact_url" class="form-label">Bize Ulaşın Butonu URL'si</label>
                <input type="url" class="form-control" id="contact_url" name="contact_url" 
                       value="<?php echo htmlspecialchars($apply['contact_url']); ?>" required>
                <small class="form-text text-muted">Bize Ulaşın butonuna tıklandığında yönlendirilecek URL'yi girin.</small>
                <?php if (!empty($apply['contact_url'])): ?>
                <div class="url-preview mt-2">
                    <i class="bi bi-link-45deg"></i> <?php echo htmlspecialchars($apply['contact_url']); ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Kaydet
                </button>
                <button type="button" class="btn btn-secondary" id="testUrlsBtn">
                    <i class="bi bi-eye me-1"></i> Bağlantıları Test Et
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#applyForm').on('submit', function(e) {
        e.preventDefault();
        
        // Yükleniyor göstergesi
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Kaydediliyor...');
        submitBtn.prop('disabled', true);
        
        $.ajax({
            type: 'POST',
            url: 'apply.php',
            data: $(this).serialize(),
            success: function() {
                // Form düğmesini eski haline getir
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
                
                // Başarı mesajı göster
                const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-check-circle me-2"></i> URL'ler başarıyla güncellendi!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                
                // Mesajı formun üzerine ekle
                if ($('.alert-success').length === 0) {
                    $(successAlert).insertBefore('#applyForm');
                }
                
                // URL önizlemelerini güncelle
                updateUrlPreviews();
            },
            error: function() {
                // Form düğmesini eski haline getir
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
                
                // Hata mesajı göster
                alert('Bir hata oluştu!');
            }
        });
    });
    
    // Test butonuna tıklanınca
    $('#testUrlsBtn').on('click', function() {
        const buttonUrl = $('#button_url').val();
        const contactUrl = $('#contact_url').val();
        
        if (buttonUrl) {
            window.open(buttonUrl, '_blank');
        }
        
        if (contactUrl) {
            setTimeout(function() {
                window.open(contactUrl, '_blank');
            }, 500);
        }
    });
    
    // URL önizlemelerini güncelle
    function updateUrlPreviews() {
        const buttonUrl = $('#button_url').val();
        const contactUrl = $('#contact_url').val();
        
        if (buttonUrl) {
            $('input[name="button_url"]').next().next('.url-preview').html('<i class="bi bi-link-45deg"></i> ' + buttonUrl);
        }
        
        if (contactUrl) {
            $('input[name="contact_url"]').next().next('.url-preview').html('<i class="bi bi-link-45deg"></i> ' + contactUrl);
        }
    }
});
</script> 