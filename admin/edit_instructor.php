<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$id = $_GET['id'];
$query = "SELECT * FROM instructors WHERE id = $id"; // Eğitmeni veritabanından çek
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<h4>Düzenle Eğitmen</h4>
<form id="editInstructorForm" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div class="mb-3">
        <label for="name" class="form-label">İsim</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="expertise" class="form-label">Uzmanlık</label>
        <input type="text" class="form-control" id="expertise" name="expertise" value="<?php echo htmlspecialchars($row['expertise']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label">Fotoğraf Yükle</label>
        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        <small class="form-text text-muted">Mevcut fotoğraf: <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Eğitmen Fotoğrafı" style="width: 50px; height: auto;"></small>
    </div>
    <button type="submit" class="btn btn-primary">Kaydet</button>
</form>

<script>
document.getElementById('editInstructorForm').onsubmit = function(event) {
    event.preventDefault(); // Formun varsayılan gönderimini engelle
    var formData = new FormData(this);
    $.ajax({
        url: 'admin/update_instructor.php', // Güncelleme işlemi için dosya
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