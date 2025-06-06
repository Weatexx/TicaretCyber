<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$id = $_POST['id'];

// Öncelikle, silinecek eğitmenin fotoğraf yolunu al
$query = "SELECT photo FROM instructors WHERE id = $id"; // Eğitmen verisini çek
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Eğer fotoğraf varsa, dosyayı sil
if ($row && file_exists($row['photo'])) {
    unlink($row['photo']); // Fotoğraf dosyasını sil
}

// Eğitmen silme sorgusu
$query = "DELETE FROM instructors WHERE id = $id"; // Eğitmen silme sorgusu
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<h4 class='text-center text-success'>Eğitmen başarıyla silindi.</h4>";
    // Eğitmenler listesini tekrar yükle
    include 'instructors.php';
} else {
    echo "<h4 class='text-center text-danger'>Silme işlemi başarısız: " . mysqli_error($conn) . "</h4>";
}
?> 