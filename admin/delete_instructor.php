<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$id = $_POST['id'];
$query = "DELETE FROM instructors WHERE id = $id"; // Eğitmeni sil
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<h4 class='text-center text-success'>Eğitmen başarıyla silindi.</h4>";
    // Eğitmenler listesini tekrar yükle
    include 'instructors.php';
} else {
    echo "<h4 class='text-center text-danger'>Silme işlemi başarısız: " . mysqli_error($conn) . "</h4>";
}
?> 