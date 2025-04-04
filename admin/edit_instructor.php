<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h4 class='text-center text-danger'>Geçersiz eğitmen ID'si.</h4>";
    exit;
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM instructors WHERE id = $id"; // Eğitmeni veritabanından çek
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<h4 class='text-center text-danger'>Eğitmen bulunamadı.</h4>";
    exit;
}

$instructor = mysqli_fetch_assoc($result);

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $expertise = mysqli_real_escape_string($conn, $_POST['expertise']);
    $profile_url = mysqli_real_escape_string($conn, $_POST['profile_url']);
    
    // Güncelleme sorgusu
    $update_sql = "UPDATE instructors SET 
                  name = '$name',
                  expertise = '$expertise',
                  profile_url = '$profile_url'";
    
    // Eğer yeni bir fotoğraf yüklenmişse
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Dosya işlemleri...
        // (Mevcut kodunuza göre düzenleyin)
        $update_sql .= ", photo = '$photo_path'";
    }
    
    $update_sql .= " WHERE id = $id";
    
    if (mysqli_query($conn, $update_sql)) {
        echo "<div class='alert alert-success'>Eğitmen başarıyla güncellendi.</div>";
        echo "<script>setTimeout(function() { loadContent('instructors'); }, 1500);</script>";
    } else {
        echo "<div class='alert alert-danger'>Güncelleme hatası: " . mysqli_error($conn) . "</div>";
    }
}
?>

<h4>Eğitmen Düzenle</h4>
<form id="editInstructorForm" enctype="multipart/form-data" method="post">
    <!-- Eğitmen ID'sini gizli input olarak ekleyin -->
    <input type="hidden" name="instructor_id" value="<?php echo $instructor['id']; ?>">
    
    <div class="mb-3">
        <label for="name" class="form-label">İsim</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($instructor['name']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="expertise" class="form-label">Uzmanlık</label>
        <input type="text" class="form-control" id="expertise" name="expertise" value="<?php echo htmlspecialchars($instructor['expertise']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="profile_url" class="form-label">Profil URL'si</label>
        <input type="url" class="form-control" id="profile_url" name="profile_url" value="<?php echo htmlspecialchars($instructor['profile_url'] ?? ''); ?>" placeholder="https://example.com/profile">
        <small class="form-text text-muted">"Profili Görüntüle" butonuna tıklandığında açılacak URL'yi girin.</small>
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label">Mevcut Fotoğraf</label>
        <div class="mb-2">
            <img src="<?php echo htmlspecialchars($instructor['photo']); ?>" alt="Eğitmen Fotoğrafı" style="width: 100px; height: auto;">
        </div>
        <label for="photo" class="form-label">Yeni Fotoğraf Yükle (Değiştirmek istemiyorsanız boş bırakın)</label>
        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Güncelle</button>
    <button type="button" class="btn btn-secondary" onclick="loadContent('instructors')">İptal</button>
</form>

<script>
document.getElementById('editInstructorForm').onsubmit = function(event) {
    event.preventDefault(); // Varsayılan gönderimi engelle
    var formData = new FormData(this);
    $.ajax({
        url: 'update_instructor.php', // Güncelleme işlemi için dosya
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#content-area').html(response); // İçeriği güncelle
        },
        error: function() {
            $('#content-area').html('<h4 class="text-center text-danger">Güncelleme işlemi gerçekleştirilemedi.</h4>');
        }
    });
};
</script> 