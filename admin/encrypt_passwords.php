<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

// Şifreleme anahtarınızı belirleyin
$key = 'your_secret_key'; // Bu anahtarı güvenli bir yerde saklayın

$query = "SELECT * FROM admins";
$result = mysqli_query($conn, $query);

while ($admin = mysqli_fetch_assoc($result)) {
    $encryptedPassword = encrypt($admin['password'], $key);
    $updateQuery = "UPDATE admins SET password='$encryptedPassword' WHERE id=" . $admin['id'];
    mysqli_query($conn, $updateQuery);
}

echo "Şifreler başarıyla güncellendi.";
?> 