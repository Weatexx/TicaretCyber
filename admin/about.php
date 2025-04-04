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

<h4>Hakkımızda Bilgileri</h4>

<?php if (!empty($success_message)): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $success_message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if ($about) { ?>
    <div class="card mb-4">
        <div class="card-header">
            <div>
                <h5 class="mb-0"><?php echo htmlspecialchars($about['title']); ?></h5>
                <?php if (!empty($about['subtitle'])) { ?>
                    <small class="text-muted"><?php echo htmlspecialchars($about['subtitle']); ?></small>
                <?php } ?>
            </div>
        </div>
        <div class="card-body">
            <p><?php echo nl2br(htmlspecialchars($about['content'])); ?></p>
            <p class="text-muted small">Son Güncelleme: <?php echo date('d.m.Y H:i', strtotime($about['updated_at'])); ?></p>
            
            <!-- Düzenle butonu bilgilerin altına taşındı -->
            <div class="text-end mt-3">
                <button class="btn btn-primary btn-sm" onclick="showEditForm()">
                    <i class="fas fa-edit"></i> Düzenle
                </button>
            </div>
        </div>
    </div>

    <!-- Düzenleme Formu (başlangıçta gizli) -->
    <div id="editForm" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Hakkımızda Bilgilerini Düzenle</h5>
            </div>
            <div class="card-body">
                <form method="POST" id="aboutForm">
                    <div class="form-group mb-3">
                        <label for="title">Başlık</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($about['title'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="subtitle">Alt Başlık</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($about['subtitle'] ?? ''); ?>">
                        <small class="form-text text-muted">Alt başlık isteğe bağlıdır.</small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="content">İçerik</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($about['content'] ?? ''); ?></textarea>
                        <small class="form-text text-muted">Hakkımızda bölümünün içeriğini giriniz. Paragraflar otomatik olarak korunacaktır.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-info">
        Hakkımızda bilgisi bulunamadı. Veritabanında "about_us" tablosunu oluşturun ve içeriği ekleyin.
        <pre>
CREATE TABLE about_us (
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
);
        </pre>
    </div>
<?php } ?>

<script>
function showEditForm() {
    document.getElementById('editForm').style.display = 'block';
}

function hideEditForm() {
    document.getElementById('editForm').style.display = 'none';
}

$(document).ready(function() {
    $('#aboutForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: 'about.php',
            data: $(this).serialize(),
            success: function(response) {
                // AJAX isteği başarılı olduktan sonra
                alert('Hakkımızda bilgileri başarıyla güncellendi!');
                
                // Sayfayı yenilemek yerine, içeriği tekrar yükle
                loadContent('about');
            },
            error: function(xhr, status, error) {
                alert('Hata oluştu: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

