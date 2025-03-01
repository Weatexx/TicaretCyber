<?php
$servername = "localhost";
$username = "root"; // XAMPP varsayılan kullanıcı adı
$password = ""; // XAMPP varsayılan şifre
$dbname = "ticaretcyber"; // Veritabanı adı

// Bağlantıyı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı başarısız: " . $conn->connect_error);
}
?> 