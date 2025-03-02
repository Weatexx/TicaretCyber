<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$id = $_POST['id'];
$name = $_POST['name'];
$expertise = $_POST['expertise'];

// Fotoğraf yükleme işlemi
$targetDir = "uploads/"; // Yükleme dizini
$targetFile = $targetDir . basename($_FILES["photo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Eğer yeni bir fotoğraf yüklenmişse
if ($_FILES["photo"]["name"]) {
    // Resim kontrolü
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<h4 class='text-center text-danger'>Dosya bir resim değil.</h4>";
        $uploadOk = 0;
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
            // Eğitmeni veritabanına güncelle
            $query = "UPDATE instructors SET name='$name', expertise='$expertise', photo='$targetFile' WHERE id=$id"; // Eğitmeni güncelle
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<h4 class='text-center text-success'>Eğitmen başarıyla güncellendi.</h4>";
                // Eğitmenler listesini tekrar yükle
                include 'instructors.php';
            } else {
                echo "<h4 class='text-center text-danger'>Güncelleme işlemi başarısız: " . mysqli_error($conn) . "</h4>";
            }
        } else {
            echo "<h4 class='text-center text-danger'>Üzgünüm, dosya yüklenemedi.</h4>";
        }
    }
} else {
    // Eğer fotoğraf yüklenmemişse, sadece diğer bilgileri güncelle
    $query = "UPDATE instructors SET name='$name', expertise='$expertise' WHERE id=$id"; // Eğitmeni güncelle
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<h4 class='text-center text-success'>Eğitmen başarıyla güncellendi.</h4>";
        // Eğitmenler listesini tekrar yükle
        include 'instructors.php';
    } else {
        echo "<h4 class='text-center text-danger'>Güncelleme işlemi başarısız: " . mysqli_error($conn) . "</h4>";
    }
}
?> 