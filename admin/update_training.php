<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$date = $_POST['date'];
$header = $_POST['header'];

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
            // Eğitimi veritabanına güncelle
            $query = "UPDATE trainings SET title='$title', description='$description', date='$date', header='$header', photo='$targetFile' WHERE id=$id"; // Eğitimi güncelle
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<h4 class='text-center text-success'>Eğitim başarıyla güncellendi.</h4>";
                include 'trainings.php'; // Eğitimler listesini tekrar yükle
            } else {
                echo "<h4 class='text-center text-danger'>Güncelleme işlemi başarısız: " . mysqli_error($conn) . "</h4>";
            }
        } else {
            echo "<h4 class='text-center text-danger'>Üzgünüm, dosya yüklenemedi.</h4>";
        }
    }
} else {
    // Eğer fotoğraf yüklenmemişse, sadece diğer bilgileri güncelle
    $query = "UPDATE trainings SET title='$title', description='$description', date='$date', header='$header' WHERE id=$id"; // Eğitimi güncelle
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<h4 class='text-center text-success'>Eğitim başarıyla güncellendi.</h4>";
        include 'trainings.php'; // Eğitimler listesini tekrar yükle
    } else {
        echo "<h4 class='text-center text-danger'>Güncelleme işlemi başarısız: " . mysqli_error($conn) . "</h4>";
    }
}
?> 