<?php
// Eğer URL '/admin' ise, admin giriş sayfasına yönlendir
if (strpos($_SERVER['REQUEST_URI'], '/admin') !== false) {
    header('Location: login.php');
    exit;
}

include 'db.php'; // Veritabanı bağlantısını dahil et

$query = "SELECT * FROM instructors"; // Eğitmenler tablosundan tüm verileri çek
$result = mysqli_query($conn, $query);

// Hakkımızda bilgilerini veritabanından çek
$query = "SELECT * FROM about_us WHERE id = 1"; // İlk kaydı çek
$result = mysqli_query($conn, $query);
$about = mysqli_fetch_assoc($result);

// Başvuru ve İletişim URL'lerini veritabanından çek
$query = "SELECT button_url, contact_url FROM apply WHERE id = 1";
$result = mysqli_query($conn, $query);
$apply = mysqli_fetch_assoc($result);
$applyUrl = $apply['button_url'] ?? '#';
$contactUrl = $apply['contact_url'] ?? '#';

// Hero Section içeriğini veritabanından çek
$query = "SELECT * FROM hero_content WHERE id = 1"; 
$result = mysqli_query($conn, $query);

// Eğer hero_content tablosu varsa verilerini çek, yoksa varsayılan değerleri kullan
if ($result && mysqli_num_rows($result) > 0) {
    $hero = mysqli_fetch_assoc($result);
    $heroTopTitle = $hero['top_title'];
    $heroMainTitle = $hero['main_title'];
    $heroDescription = $hero['description'];
} else {
    // Varsayılan değerler
    $heroTopTitle = 'İ s t a n b u l &nbsp T i c a r e t &nbsp Ü n i v e r s i t e s i';
    $heroMainTitle = 'IoT Zirvesi <br>ve Eğitimleri';
    $heroDescription = 'Temel amacımız siber güvenlik alanında eğitimler, <br class="d-none d-md-inline"> seminerler ve tanıtım içerikleri üreterek bu alana ilgisi olan kişileri <br class="d-none d-md-inline"> geliştirmektir.';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="root/css/bootstrap.css">
    <link rel="stylesheet" href="root/css/style.css">
    <style>
    .apply-button:hover {
        background-color: #ff9500 !important; /* Daha koyu turuncu renk */
        box-shadow: 0 0 15px rgba(253, 196, 0, 0.7) !important; /* Sarı parıltı efekti */
        transform: translateY(-3px) !important; /* Hafifçe yukarı kalkma efekti */
        color: #000 !important; /* Daha koyu metin rengi */
    }

    /* Bize Ulaşın butonu için de benzer bir hover efekti ekleyelim */
    .navbar-nav .nav-item button.nav-link:hover, .contact-button:hover {
        color: #FDC400 !important; /* Sarı renk vurgusu */
        text-shadow: 0 0 8px rgba(253, 196, 0, 0.5); /* Hafif parıltı efekti */
    }

    footer {
        padding: 20px 0;
    }

    footer a:hover {
        color: #ff9500 !important;
        text-decoration: none;
    }

    /* Sayfa içi hedefler için css ekliyorum */
    html {
        scroll-behavior: auto;
    }

    section[id] {
        scroll-margin-top: 80px; /* NavBar yüksekliğine göre ayarlanmalıdır */
    }
    
    /* Genel responsive tasarım için - başlıklar ve yazılar */
    .gradient-heading {
        font-size: 4rem;
        background: linear-gradient(90deg, #ffffff, #000000);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
        margin-bottom: 1.5rem;
    }
    
    .subtitle-gradient {
        font-size: 3rem;
        background: linear-gradient(90deg, #ffdd03, #ff6c03);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
        margin-bottom: 1rem;
    }
    
    .subtitle-gradient-2 {
        font-size: 3rem;
        background: linear-gradient(90deg, #ffdd03, #d54000);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
        margin-bottom: 1.5rem;
    }
    
    /* Card tasarımları */
    .instructor-card, .training-card {
        background: rgba(0, 0, 0, 0.3); 
        backdrop-filter: blur(10px); 
        -webkit-backdrop-filter: blur(10px); 
        border-radius: 25px; 
        border: 1px solid rgba(255, 255, 255, 0.05); 
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .training-card {
        cursor: pointer;
    }
    
    /* Card içerikleri */
    .card-image-container {
        width: 90px; 
        height: 90px; 
        min-width: 90px;
        border-radius: 50%; 
        overflow: hidden;
        display: flex; 
        align-items: center; 
        justify-content: center;
    }
    
    .card-title {
        color: white; 
        font-weight: 600; 
        margin-bottom: 0; 
        font-size: 1.4rem;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    .card-text {
        color: rgba(255,255,255,0.9); 
        font-size: 1rem; 
        line-height: 1.6;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    /* Responsive Tasarım İçin Media Sorguları */
    
    /* Genel responsive ayarlar */
    body {
        overflow-x: hidden;
    }
    
    img {
        max-width: 100%;
        height: auto;
    }
    
    /* Mobil cihazlar için (576px'e kadar) */
    @media (max-width: 576px) {
        .navbar img.text-center {
            width: 8% !important;
        }
        
        .navbar .nav-link {
            text-align: center;
            margin: 5px 0;
        }
        
        .navbar .ms-auto {
            margin: 10px auto !important;
        }
        
        .hero h1 {
            font-size: 2.5rem !important;
            text-align: center;
        }
        
        .hero p {
            text-align: center;
            font-size: 0.9rem !important;
        }
        
        .hero-container {
            padding-top: 60px;
        }
        
        .hero button.apply-button {
            margin: 15px auto !important;
            display: block !important;
        }
        
        .gradient-heading {
            font-size: 2.5rem !important;
        }
        
        .subtitle-gradient, .subtitle-gradient-2 {
            font-size: 2rem !important;
        }
        
        .card-body {
            padding: 1.25rem !important;
        }
        
        .card-image-container {
            width: 70px;
            height: 70px;
            min-width: 70px;
        }
        
        .card-title {
            font-size: 1.2rem;
        }
        
        .card-text {
            font-size: 0.9rem;
        }
        
        footer .container {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        /* Modal düzenlemeleri */
        .modal-dialog {
            margin: 0.5rem;
        }
        
        .modal-title {
            font-size: 1.4rem !important;
        }
    }
    
    /* Tabletler için (768px'e kadar) */
    @media (max-width: 768px) {
        .navbar img.text-center {
            width: 5% !important;
        }
        
        .hero h1 {
            font-size: 3rem !important;
        }
        
        .gradient-heading {
            font-size: 3rem !important;
        }
        
        .subtitle-gradient, .subtitle-gradient-2 {
            font-size: 2.5rem !important;
        }
        
        .card-flex-column {
            flex-direction: column !important;
        }
        
        .card-image-container {
            margin-bottom: 1rem;
        }
        
        .egitimlerimiz .aciklama br {
            display: none; /* Mobil görünümde satır sonlarını kaldır */
        }
    }
    
    /* Orta boyutlu ekranlar için (992px'e kadar) */
    @media (max-width: 992px) {
        .navbar .navbar-collapse {
            background-color: rgba(17, 17, 17, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
        }
        
        .hero-container {
            padding-top: 100px;
        }
        
        .navbar-nav {
            margin-bottom: 15px;
            text-align: center;
        }
        
        .navbar .nav-item.ms-auto {
            margin-left: 0 !important;
            display: flex;
            justify-content: center;
        }
        
        .navbar-toggler {
            border: none;
            color: white;
            padding: 0.25rem 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        .contact-button {
            display: inline-block;
            margin: 0 auto;
        }
    }

    /* Hamburger menü ikonu için basit stil düzeltmesi */
    .navbar-toggler {
        border: none;
        padding: 0.25rem;
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
    }
    
    /* Hamburger menü ikonunun rengini değiştir */
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.75)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
    }
    
    /* Bize Ulaşın butonu için özel stil ekleyelim */
    .contact-button {
        background: none;
        border: none;
        color: rgba(255,255,255,0.75);
        font-size: .9rem;
        cursor: pointer;
        padding: 8px;
        margin: 0 auto;
        display: block;
        text-align: center;
        width: 100%;
        transition: all 0.3s ease;
    }

    /* Scrollbar stil düzenlemeleri */
    /* Webkit (Chrome, Safari, yeni Opera) için */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(253, 196, 0, 0.5);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(253, 196, 0, 0.8);
    }

    /* Modal kapatma butonu hover efekti */
    .close-modal-btn:hover {
        background-color: #ff9500 !important;
        box-shadow: 0 0 15px rgba(253, 196, 0, 0.7) !important;
        transform: translateY(-3px) !important;
    }

    /* Eğitim kartları geçiş efekti */
    .training-card {
        transition: all 0.3s ease !important;
    }

    /* Modal geçiş efekti */
    .modal-content {
        transition: all 0.3s ease;
    }

    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
        transform: scale(0.95);
    }

    .modal.show .modal-dialog {
        transform: scale(1);
    }
    </style>
</head>
<body>

<!-- Header Wrapper (Sadece navbar için) -->
<div class="header-wrapper">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <img src="root/img/ticaret.png" class="text-center m-auto mx-2" style="width: 2%" alt="Ticaret Logo">
            <span class="nav-link d-none d-sm-inline" style="color: rgba(255,255,255,0.75); font-size: .9rem">Ticaret Cyber &nbsp |</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Menüyü aç/kapat">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav text-center">
                    <li class="nav-item">
                        <a href="#hero-section" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Anasayfa</a>
                    </li>
                    <li class="nav-item">
                        <a href="#bizkimiz" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Hakkımızda</a>
                    </li>
                    <li class="nav-item">
                        <a href="#egitmenler" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Eğitmenler</a>
                    </li>
                    <li class="nav-item">
                        <a href="#egitimlerimiz" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Eğitimler</a>
                    </li>
                    <li class="nav-item text-center">
                        <button onclick="window.open('<?php echo htmlspecialchars($contactUrl); ?>', '_blank')" class="contact-button">Bize Ulaşın</button>
                    </li>
                </ul>
                <div class="ms-auto d-flex justify-content-center justify-content-lg-end">
                    <button onclick="window.open('<?php echo htmlspecialchars($applyUrl); ?>', '_blank')" class="btn apply-button" style="background-color: #FDC400; border: none; border-radius: 50px; width: 120px; height: 35px; transition: all 0.3s ease;">Başvuru Yap</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Grid ve hüzme efektleri sadece burada -->
    <div class="container hero-container" id="anasayfa">
        <!-- Grid arkaplan ekleme -->
        <div class="grid-background"></div>
        <!-- Gradient overlay -->
        <div class="hero-overlay"></div>
        <!-- Sarı hüzme efekti -->
        <div class="light-beam-container">
            <div class="light-beam-left"></div>
            <div class="light-beam-right"></div>
        </div>
        
        <section class="hero" id="hero-section">
            <div class="row gy-4">
                <div class="col-md-6 col-sm-12 text-light d-flex flex-column align-items-center align-items-md-start">
                    <p style="color: rgba(255,255,255,0.61)"><?php echo htmlspecialchars($heroTopTitle); ?></p>
                    <h1 style="color: white; font-size: 4rem"><?php echo $heroMainTitle; ?></h1>
                    <p style="color: rgba(255,255,255,0.61)"><?php echo $heroDescription; ?></p>
                    <button onclick="window.open('<?php echo htmlspecialchars($applyUrl); ?>', '_blank')" class="mt-3 mb-5 apply-button" style="background-color: #FDC400; border: none; border-radius: 50px; width: 120px; height: 35px; display: inline-block; text-align: center; line-height: 35px; text-decoration: none; color: #333; cursor: pointer; transition: all 0.3s ease;">Başvuru Yap</button>
                </div>
                <div class="text-center col-md-6 col-sm-12">
                    <img src="root/img/heroimg.png" width="60%" class="img-fluid" alt="">
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Diğer bölümler header-wrapper dışında -->
<div class="container mt-5">
    <section class="bizkimiz" id="bizkimiz">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center gradient-heading"><?php echo htmlspecialchars($about['title']); ?></h1>
                
                <?php if (isset($about['subtitle']) && $about['subtitle'] !== '') { 
                    // Alt başlığı tamamen veritabanından yönetmek için
                    // Eğer tire işaretiyle ayrılmış ise iki parçaya böl
                    if (strpos($about['subtitle'], ' - ') !== false) {
                        $subtitleParts = explode(' - ', $about['subtitle']);
                        $part1 = $subtitleParts[0];
                        $part2 = $subtitleParts[1];
                ?>
                <h1 class="text-center subtitle-gradient"><?php echo htmlspecialchars($part1); ?></h1>
                <h1 class="text-center subtitle-gradient-2"><?php echo htmlspecialchars($part2); ?></h1>
                <?php } else { // Tire işareti yoksa tek satır göster ?>
                <h1 class="text-center subtitle-gradient-2"><?php echo htmlspecialchars($about['subtitle']); ?></h1>
                <?php } 
                } else { // Subtitle boşsa varsayılan değerleri göster ?>
                <h1 class="text-center subtitle-gradient">İstanbul Ticaret Üniversitesi</h1>
                <h1 class="text-center subtitle-gradient-2">Siber Güvenlik Topluluğu</h1>
                <?php } ?>
                <p class="text-center px-3" style="color: rgba(255,255,255,0.61) ">
                    <?php echo nl2br(htmlspecialchars($about['content'])); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Eğitmenler Bölümü -->
    <section class="egitmenler" id="egitmenler">
        <div class="row mt-5">
            <div class="col-12">
                <h1 class="text-center gradient-heading">Eğitmenlerimiz</h1>
            </div>
        </div>
        <div class="row mt-4">
            <?php
            // Eğitmenleri veritabanından çek
            $query = "SELECT * FROM instructors"; // Eğitmenleri çek
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { 
                    // Fotoğraf yolunu kontrol et
                    $photoPath = $row['photo'];
                    if (!empty($photoPath)) {
                        // Eğer fotoğraf yolu admin/ ile başlıyorsa, doğru yolu oluştur
                        if (strpos($photoPath, 'admin/') === 0) {
                            $photoPath = $photoPath; // Zaten doğru formatta
                        } else {
                            $photoPath = 'admin/' . $photoPath; // admin/ ekle
                        }
                    } else {
                        $photoPath = 'root/img/default-user.png'; // Varsayılan fotoğraf
                    }
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 instructor-card">
                        <div class="card-body d-flex flex-column" style="padding: 2rem;">
                            <div class="d-flex align-items-center card-flex-column">
                                <div class="me-4 card-image-container">
                                    <?php if (file_exists($photoPath)) { ?>
                                        <img src="<?php echo htmlspecialchars($photoPath); ?>" class="rounded-circle" alt="Eğitmen <?php echo htmlspecialchars($row['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php } else { ?>
                                        <div style="width: 100%; height: 100%; background-color: #FDC400; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user" style="font-size: 35px; color: #333;"></i>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div>
                                    <h4 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h4>
                                </div>
                            </div>
                            <div class="mt-3 ps-2">
                                <p class="card-text" style="margin-bottom: 0; text-align: left;">
                                    <span style="color: #FDC400; font-weight: 500;">Uzmanlık Alanı:</span>
                                    <?php echo htmlspecialchars($row['expertise']); ?>
                                </p>
                            </div>
                            <div class="mt-auto mt-4">
                                <button onclick="window.open('<?php echo htmlspecialchars($row['profile_url'] ?? '#'); ?>', '_blank')" class="btn w-100" style="background-color: #FDC400; color: #333; border-radius: 15px; padding: 12px 20px; font-weight: 500; font-size: 1rem; height: 48px; border: none; transition: all 0.3s ease;">Profili Görüntüle</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } 
            } else { ?>
                <div class="col-12 text-center">
                    <p style="color: rgba(255,255,255,0.61);">Henüz eğitmen bulunmamaktadır.</p>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="egitimlerimiz" id="egitimlerimiz">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center gradient-heading">Eğitimlerimiz</h1>
                <p class="aciklama" style="text-align: center; color: rgba(255,255,255,0.61); padding: 0 15px;">
                    Siber güvenlik eğitimlerimiz, temel bilgilerden ileri seviye tekniklere kadar geniş bir <br class="d-none d-md-inline"> yelpazede, bireyleri ve kurumları dijital tehditlere karşı koruma becerileriyle donatmayı
                    <br class="d-none d-md-inline"> amaçlamaktadır.
                </p>
            </div>
        </div>

        <div class="row mt-4">
            <?php
            // Eğitimleri veritabanından çek
            $query = "SELECT * FROM trainings"; // Eğitimleri çek
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { 
                    // Fotoğraf yolunu kontrol et
                    $photoPath = $row['photo'];
                    if (!empty($photoPath)) {
                        // Eğer fotoğraf yolu admin/ ile başlıyorsa, doğru yolu oluştur
                        if (strpos($photoPath, 'admin/') === 0) {
                            $photoPath = $photoPath; // Zaten doğru formatta
                        } else {
                            $photoPath = 'admin/' . $photoPath; // admin/ ekle
                        }
                    } else {
                        $photoPath = ''; // Boş bırak, aşağıda kontrol edilecek
                    }
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 training-card" 
                            data-bs-toggle="modal" 
                            data-bs-target="#trainingModal-<?php echo $row['id']; ?>"
                            data-training-id="<?php echo $row['id']; ?>"
                            data-training-title="<?php echo htmlspecialchars($row['title']); ?>"
                            data-training-description="<?php echo htmlspecialchars($row['description']); ?>"
                            data-training-photo="<?php echo htmlspecialchars($photoPath); ?>"
                            data-training-date="<?php echo date('d.m.Y', strtotime($row['date'])); ?>">
                            <div class="card-body d-flex flex-column" style="padding: 2rem;">
                                <div class="d-flex align-items-center card-flex-column">
                                    <div class="me-4 card-image-container">
                                        <?php if (!empty($photoPath) && file_exists($photoPath)) { ?>
                                            <img src="<?php echo htmlspecialchars($photoPath); ?>" class="rounded-circle" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php } else { ?>
                                            <div style="width: 100%; height: 100%; background-color: #FDC400; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-laptop-code" style="font-size: 35px; color: #333;"></i>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div style="display: flex; align-items: center; min-height: 90px;">
                                        <h4 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h4>
                                    </div>
                                </div>
                                <div style="margin-top: 1rem;">
                                    <p class="card-text">
                                        <?php 
                                        $description = htmlspecialchars($row['description']);
                                        echo (strlen($description) > 100) ? substr($description, 0, 100) . '...' : $description; 
                                        ?>
                                    </p>
                                </div>
                                <div class="mt-auto ps-2">
                                    <p style="color: #FDC400; font-size: 0.95rem; margin-bottom: 0; text-align: left;">
                                        <i class="far fa-calendar-alt me-2"></i> <?php echo date('d.m.Y', strtotime($row['date'])); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="col-12 text-center mt-4">
                    <p style="color: rgba(255,255,255,0.61);">Henüz eğitim bulunmamaktadır.</p>
                </div>
            <?php } ?>
        </div>
       
    </section>
</div>

<!-- Eğitim Detayları için Modal Yapısı -->
<?php
// Modal'ları veritabanından tekrar çek
$query = "SELECT * FROM trainings";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Fotoğraf yolunu kontrol et
        $photoPath = $row['photo'];
        if (!empty($photoPath)) {
            if (strpos($photoPath, 'admin/') === 0) {
                $photoPath = $photoPath;
            } else {
                $photoPath = 'admin/' . $photoPath;
            }
        } else {
            $photoPath = '';
        }
?>
<!-- Eğitim Modal -->
<div class="modal fade" id="trainingModal-<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="trainingModalLabel-<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(17, 17, 17, 0.9); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 25px; border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5); color: white;">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="trainingModalLabel-<?php echo $row['id']; ?>" style="color: #FDC400; font-weight: 600; font-size: 1.8rem; word-wrap: break-word; overflow-wrap: break-word;"><?php echo htmlspecialchars($row['title']); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-5 text-center mb-4 mb-md-0">
                        <?php if (!empty($photoPath) && file_exists($photoPath)) { ?>
                            <div class="modal-image-container" style="width: 100%; max-height: 250px; border-radius: 15px; border: 2px solid rgba(253, 196, 0, 0.3); box-shadow: 0 5px 15px rgba(0,0,0,0.3); overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: rgba(0, 0, 0, 0.2);">
                                <img src="<?php echo htmlspecialchars($photoPath); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width: 100%; height: auto; max-height: 250px; object-fit: cover; display: block;">
                            </div>
                        <?php } else { ?>
                            <div class="modal-image-container" style="width: 100%; height: 250px; background-color: rgba(253, 196, 0, 0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(253, 196, 0, 0.1); box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                                <i class="fas fa-laptop-code" style="font-size: 80px; color: #FDC400;"></i>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-7">
                        <h4 style="color: white; font-weight: 500; margin-bottom: 15px; font-size: 1.4rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 10px;">Eğitim Detayları</h4>
                        <div class="modal-description" style="max-height: 250px; overflow-y: auto; padding-right: 10px; scrollbar-width: thin; scrollbar-color: #FDC400 rgba(0,0,0,0.2);">
                            <p style="color: rgba(255,255,255,0.9); font-size: 1rem; line-height: 1.7; margin-bottom: 20px; text-align: justify; word-wrap: break-word; overflow-wrap: break-word;">
                                <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                            </p>
                        </div>
                        <div class="d-flex align-items-center mb-3 mt-3">
                            <i class="far fa-calendar-alt me-2" style="color: #FDC400;"></i>
                            <span style="color: rgba(255,255,255,0.9);">Tarih: <?php echo date('d.m.Y', strtotime($row['date'])); ?></span>
                        </div>
                        <?php if (!empty($row['instructor_id'])) { 
                            // Eğitmenin bilgilerini çek
                            $instructor_query = "SELECT name, expertise FROM instructors WHERE id = " . (int)$row['instructor_id'];
                            $instructor_result = mysqli_query($conn, $instructor_query);
                            if ($instructor_result && mysqli_num_rows($instructor_result) > 0) {
                                $instructor = mysqli_fetch_assoc($instructor_result);
                        ?>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-tie me-2" style="color: #FDC400;"></i>
                            <span style="color: rgba(255,255,255,0.9); word-wrap: break-word; overflow-wrap: break-word;">Eğitmen: <?php echo htmlspecialchars($instructor['name']); ?> - <?php echo htmlspecialchars($instructor['expertise']); ?></span>
                        </div>
                        <?php } } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn close-modal-btn" style="background-color: #FDC400; color: #333; border-radius: 50px; padding: 10px 25px; font-weight: 500; border: none; transition: all 0.3s ease;" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
<?php
    }
}
?>

<!-- Footer -->
<footer>
    <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center">
        <div class="text-center text-sm-start mb-3 mb-sm-0">
            İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu
        </div>
        <div class="text-center text-sm-end">
            Made by <a href="https://www.linkedin.com/in/arda-koray-kartal-22334626a/" class="text-decoration-none" style="color: #FDC400;">Arda Koray Kartal</a>
        </div>
    </div>
</footer>

<!-- Footer üstünde -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Navbar arka plan efekti
    function updateNavbar() {
        if($(window).scrollTop() > 50) {
            $('.navbar').css({
                'background': 'rgba(17, 17, 17, 0.85)',
                'backdrop-filter': 'blur(10px)',
                'box-shadow': '0 4px 20px rgba(0,0,0,0.2)'
            });
        } else {
            $('.navbar').css({
                'background': 'rgba(17, 17, 17, 0.5)',
                'backdrop-filter': 'blur(5px)',
                'box-shadow': 'none'
            });
        }
    }
    
    // İlk yükleme ve scroll
    updateNavbar();
    $(window).on('scroll', updateNavbar);
    
    // Mobil menü kapatma
    $('.navbar-nav .nav-link').on('click', function() {
        if ($('.navbar-collapse').hasClass('show')) {
            $('.navbar-toggler').click();
        }
    });
    
    // Eğitim kartları için hover efekti
    $('.training-card').hover(
        function() {
            $(this).css({
                'transform': 'translateY(-5px)',
                'box-shadow': '0 12px 40px rgba(0, 0, 0, 0.5), 0 0 15px rgba(253, 196, 0, 0.3)',
                'border': '1px solid rgba(253, 196, 0, 0.2)'
            });
        },
        function() {
            $(this).css({
                'transform': 'translateY(0)',
                'box-shadow': '0 8px 32px rgba(0, 0, 0, 0.3)',
                'border': '1px solid rgba(255, 255, 255, 0.05)'
            });
        }
    );
    
    // Eğitim kartlarına tıklandığında modal açma (zaten data-bs-toggle ile çalışıyor)
    $('.training-card').css('transition', 'all 0.3s ease');
});
</script>
</body>
</html>