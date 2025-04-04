<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

// Form verilerini al
$id = isset($_POST['instructor_id']) ? (int)$_POST['instructor_id'] : 0;
$name = mysqli_real_escape_string($conn, $_POST['name']);
$expertise = mysqli_real_escape_string($conn, $_POST['expertise']);
$profile_url = mysqli_real_escape_string($conn, $_POST['profile_url']);

// ID kontrolü
if ($id <= 0) {
    echo "<div class='alert alert-danger'>Geçersiz eğitmen ID'si.</div>";
    exit;
}

// Güncelleme sorgusu
$update_sql = "UPDATE instructors SET 
              name = '$name',
              expertise = '$expertise',
              profile_url = '$profile_url'";

// Eğer yeni bir fotoğraf yüklenmişse
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $targetDir = "uploads/"; // Yükleme dizini
    
    // Klasör yoksa oluştur
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    // Benzersiz dosya adı oluştur
    $fileName = time() . '_' . basename($_FILES["photo"]["name"]);
    $targetFile = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;
    
    // Resim kontrolü
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check === false) {
        echo "<div class='alert alert-danger'>Dosya bir resim değil.</div>";
        $uploadOk = 0;
    }
    
    // Dosya boyutunu kontrol et
    if ($_FILES["photo"]["size"] > 5000000) { // 5MB
        echo "<div class='alert alert-danger'>Üzgünüm, dosya çok büyük (max: 5MB).</div>";
        $uploadOk = 0;
    }
    
    // Sadece belirli dosya formatlarına izin ver
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<div class='alert alert-danger'>Üzgünüm, yalnızca JPG, JPEG, PNG ve GIF dosyalarına izin verilmektedir.</div>";
        $uploadOk = 0;
    }
    
    // Yükleme işlemini gerçekleştir
    if ($uploadOk != 0 && move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        $photo_path = mysqli_real_escape_string($conn, $targetFile);
        $update_sql .= ", photo = '$photo_path'";
    } else if ($uploadOk != 0) {
        echo "<div class='alert alert-danger'>Üzgünüm, dosya yüklenemedi.</div>";
    }
}

// SQL sorgusunu tamamla
$update_sql .= " WHERE id = $id";

// Güncelleme sorgusunu çalıştır
if (mysqli_query($conn, $update_sql)) {
    echo "<div class='alert alert-success'>Eğitmen başarıyla güncellendi.</div>";
    echo "<script>setTimeout(function() { loadContent('instructors'); }, 1500);</script>";
} else {
    echo "<div class='alert alert-danger'>Güncelleme hatası: " . mysqli_error($conn) . "</div>";
}
?> 