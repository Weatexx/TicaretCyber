<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$title = $_POST['title'];
$description = $_POST['description'];
$date = $_POST['date'];
$header = isset($_POST['header']) ? $_POST['header'] : '';

// Uploads dizininin varlığını kontrol et, yoksa oluştur
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Fotoğraf yükleme işlemi
$fileName = basename($_FILES["photo"]["name"]);
$targetFile = $targetDir . $fileName;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Resim kontrolü
$check = getimagesize($_FILES["photo"]["tmp_name"]);
if ($check === false) {
    echo "<h4 class='text-center text-danger'>Dosya bir resim değil.</h4>";
    $uploadOk = 0;
}

// Dosya zaten varsa, benzersiz bir isim oluştur
if (file_exists($targetFile)) {
    $fileNameOnly = pathinfo($fileName, PATHINFO_FILENAME);
    $fileName = $fileNameOnly . "_" . time() . "." . $imageFileType;
    $targetFile = $targetDir . $fileName;
}

// Dosya boyutunu kontrol et
if ($_FILES["photo"]["size"] > 5000000) { // 5MB
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
        // Veritabanına kaydedilecek dosya yolu
        // Ana sayfada görüntülenebilmesi için tam yolu kaydedelim
        $photoPath = $targetFile; // Tam dosya yolu
        
        // Eğitimi veritabanına ekle
        $query = "INSERT INTO trainings (title, description, date, header, photo) VALUES ('$title', '$description', '$date', '$header', '$photoPath')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<h4 class='text-center text-success'>Eğitim başarıyla eklendi.</h4>";
            echo "<p class='text-center'>Yüklenen fotoğraf: <img src='$photoPath' alt='Eğitim Fotoğrafı' style='width: 100px; height: auto;'></p>";
            include 'trainings.php'; // Eğitimler listesini tekrar yükle
        } else {
            echo "<h4 class='text-center text-danger'>Eğitim ekleme işlemi başarısız: " . mysqli_error($conn) . "</h4>";
        }
    } else {
        echo "<h4 class='text-center text-danger'>Üzgünüm, dosya yüklenemedi. Hata: " . error_get_last()['message'] . "</h4>";
    }
}
?> 