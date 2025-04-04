<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$name = $_POST['name'];
$expertise = $_POST['expertise'];
$profile_url = $_POST['profile_url'];

// Fotoğraf yükleme işlemi
$targetDir = "uploads/"; // Yükleme dizini
$targetFile = $targetDir . basename($_FILES["photo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Resim kontrolü
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<h4 class='text-center text-danger'>Dosya bir resim değil.</h4>";
        $uploadOk = 0;
    }
}

// Dosya zaten varsa kontrol et
if (file_exists($targetFile)) {
    echo "<h4 class='text-center text-danger'>Üzgünüm, dosya zaten var.</h4>";
    $uploadOk = 0;
}

// Dosya boyutunu kontrol et
if ($_FILES["photo"]["size"] > 500000) {
    echo "<h4 class='text-center text-danger'>Üzgünüm, dosya çok büyük.</h4>";
    $uploadOk = 0;
}

// Sadece belirli dosya formatlarına izin ver
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "<h4 class='text-center text-danger'>Üzgünüm, yalnızca JPG, JPEG, PNG ve GIF dosyalarına izin verilmektedir.</h4>";
    $uploadOk = 0;
}

// Yükleme işlemini gerçekleştir
if ($uploadOk == 0) {
    echo "<h4 class='text-center text-danger'>Üzgünüm, dosya yüklenemedi.</h4>";
} else {
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        // Eğitmeni veritabanına ekle
        $query = "INSERT INTO instructors (name, expertise, profile_url, photo) VALUES ('$name', '$expertise', '$profile_url', '$targetFile')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<h4 class='text-center text-success'>Eğitmen başarıyla eklendi.</h4>";
            // Eğitmenler listesini tekrar yükle
            include 'instructors.php';
        } else {
            echo "<h4 class='text-center text-danger'>Eğitmen ekleme işlemi başarısız: " . mysqli_error($conn) . "</h4>";
        }
    } else {
        echo "<h4 class='text-center text-danger'>Üzgünüm, dosya yüklenemedi.</h4>";
    }
}
?> 