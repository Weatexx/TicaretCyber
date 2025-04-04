<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$id = $_POST['id'];

// Öncelikle, silinecek eğitimin fotoğraf yolunu al
$query = "SELECT photo FROM trainings WHERE id = $id"; // Eğitim verisini çek
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Eğer fotoğraf varsa, dosyayı sil
if ($row && file_exists($row['photo'])) {
    unlink($row['photo']); // Fotoğraf dosyasını sil
}

// Eğitim silme sorgusu
$query = "DELETE FROM trainings WHERE id = $id"; // Eğitim silme sorgusu
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<h4 class='text-center text-success'>Eğitim başarıyla silindi.</h4>";
    include 'trainings.php'; // Eğitimler listesini tekrar yükle
} else {
    echo "<h4 class='text-center text-danger'>Silme işlemi başarısız: " . mysqli_error($conn) . "</h4>";
}
?> 