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

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Buton URL Ayarları</h3>
    </div>
    <div class="card-body">
        <form id="applyForm" method="POST">
            <div class="form-group mb-4">
                <label for="button_url">Başvuru Butonu URL'si</label>
                <input type="url" class="form-control" id="button_url" name="button_url" 
                       value="<?php echo htmlspecialchars($apply['button_url']); ?>" required>
                <small class="form-text text-muted">Başvuru butonuna tıklandığında yönlendirilecek URL'yi girin.</small>
            </div>
            
            <div class="form-group mb-4">
                <label for="contact_url">Bize Ulaşın Butonu URL'si</label>
                <input type="url" class="form-control" id="contact_url" name="contact_url" 
                       value="<?php echo htmlspecialchars($apply['contact_url']); ?>" required>
                <small class="form-text text-muted">Bize Ulaşın butonuna tıklandığında yönlendirilecek URL'yi girin.</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#applyForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'apply.php',
            data: $(this).serialize(),
            success: function() {
                alert('URL\'ler başarıyla güncellendi!');
            },
            error: function() {
                alert('Bir hata oluştu!');
            }
        });
    });
});
</script> 