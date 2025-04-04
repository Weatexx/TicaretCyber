<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$id = $_GET['id'];
$query = "SELECT * FROM trainings WHERE id = $id"; // Eğitim verisini çek
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<h4>Eğitimi Düzenle</h4>
<form id="editTrainingForm" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div class="mb-3">
        <label for="title" class="form-label">Başlık</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Açıklama</label>
        <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Tarih</label>
        <input type="date" class="form-control" id="date" name="date" value="<?php echo $row['date']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="header" class="form-label">Header</label>
        <input type="text" class="form-control" id="header" name="header" value="<?php echo htmlspecialchars($row['header']); ?>">
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label">Yeni Fotoğraf Yükle</label>
        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        <small class="form-text text-muted">Mevcut fotoğraf: <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Eğitim Fotoğrafı" style="width: 50px; height: auto;"></small>
    </div>
    <button type="submit" class="btn btn-primary">Güncelle</button>
    <button type="button" class="btn btn-secondary" onclick="loadContent('trainings')">İptal</button>
</form>

<script>
document.getElementById('editTrainingForm').onsubmit = function(event) {
    event.preventDefault(); // Varsayılan gönderimi engelle
    var formData = new FormData(this);
    $.ajax({
        url: 'update_training.php', // Eğitim güncelleme işlemi için dosya
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#content-area').html(response); // İçeriği güncelle
        },
        error: function() {
            $('#content-area').html('<h4 class="text-center text-danger">Eğitim güncelleme işlemi gerçekleştirilemedi.</h4>');
        }
    });
};
</script> 