<?php
// Eğer URL '/admin' ise, admin giriş sayfasına yönlendir
if (strpos($_SERVER['REQUEST_URI'], '/admin') !== false) {
    header('Location: login.php');
    exit;
}

include 'db.php'; // Veritabanı bağlantısını dahil et

$query = "SELECT * FROM instructors"; // Eğitmenler tablosundan tüm verileri çek
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siber Güvenlik Eğitimleri</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="root/css/bootstrap.css">
    <link rel="stylesheet" href="root/css/style.css">
</head>
<body>

<!-- Header Wrapper (Grid arka plan için) -->
<div class="header-wrapper">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <img src="root/img/ticaret.png" class="text-center m-auto mx-2" style="width: 2%" alt="">
            <a href="index.php" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Ticaret Cyber &nbsp |</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="#anasayfa" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Anasayfa</a></li>
                    <li class="nav-item"><a href="#bizkimiz" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Hakkımızda</a></li>
                    <li class="nav-item"><a href="#egitmenler" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Eğitmenler</a></li>
                    <li class="nav-item"><a href="#egitimlerimiz" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Eğitimler</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link" style="color: rgba(255,255,255,0.75); font-size: .9rem">Bize Ulaşın</a></li>
                </ul>
                <li class="nav-item ms-auto">
                    <button href="#" style="background-color: #FDC400; border: none; border-radius: 50px; width: 100px; height: 35px">Kayıt Ol</button>
                </li>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container" id="anasayfa">
        <section class="hero">
            <div class="row mt-5">
                <div class="col-md-6 col-sm-12 text-light">
                    <p style="color: rgba(255,255,255,0.61)">İ s t a n b u l &nbsp T i c a r e t &nbsp Ü n i v e r s i t e s i</p>
                    <h1 style="color: white; font-size: 4rem">Siber Güvenlik <br> Eğitimleri</h1>
                    <p style="color: rgba(255,255,255,0.61)">Temel amacımız siber güvenlik alanında eğitimler, <br> seminerler ve tanıtım içerikleri üreterek bu alana ilgisi olan kişileri
                        <br> geliştirmektir.</p>
                    <button href="#" class="mt-3 mb-5" style="background-color: #FDC400; border: none; border-radius: 50px; width: 100px; height: 35px">Kayıt Ol</button>
                </div>
                <div class="text-center col-md-6 col-sm-12">
                    <img src="root/img/heroimg.png" width="60%" class="img-fluid" alt="">
                </div>
            </div>
        </section>
    </div>

    <div class="container mt-5">
        <section class="bizkimiz" id="bizkimiz">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center" style="
                    font-size: 4rem;
                    background: linear-gradient(90deg, #ffffff, #000000);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;">Biz Kimiz?</h1>
                    <h1 class="text-center" style="
                    font-size: 3rem;
                    background: linear-gradient(90deg, #ffdd03, #ff6c03);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;">İstanbul Ticaret Üniversitesi</h1>
                    <h1 class="text-center" style="
                    font-size: 3rem;
                    background: linear-gradient(90deg, #ffdd03, #d54000);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;">Siber Güvenlik Topluluğu</h1>
                    <p class="text-center" style="flex-wrap: nowrap; color: rgba(255,255,255,0.61) ">
                        İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu, teknolojiye ve bilgi güvenliğine ilgi duyan öğrencilerin bir araya geldiği
                        <br> bir platformdur. Topluluk, siber güvenlik alanında farkındalık yaratmak, üyelerinin bilgi ve becerilerini geliştirmek ve kariyer
                        <br> hedeflerine katkı sağlamak amacıyla çeşitli etkinlikler ve eğitimler düzenlemektedir. Etik hacking, ağ güvenliği, yazılım
                        <br> güvenliği, tersine mühendislik ve siber tehdit analizi gibi konular topluluğun temel çalışma alanları arasında yer
                        <br> alır.Topluluğumuz, sektördeki profesyonellerle öğrenciler arasında bir köprü kurarak, alanında uzman isimlerin katıldığı
                        <br> seminerler, sertifikalı eğitimler ve uygulamalı atölyeler organize etmektedir. Bu etkinlikler, üyelerin teorik bilgilerini pratiğe
                        <br> dökmelerine olanak tanırken, aynı zamanda ekip çalışması ve problem çözme becerilerini de geliştirmektedir.
                        <br> Ayrıca düzenlediğimiz yarışmalar ve projeler, üyelerimizin gerçek dünya problemlerine yönelik çözümler geliştirme yeteneğini
                        <br> artırmayı hedeflemektedir.İstanbul Ticaret Üniversitesi Siber Güvenlik Topluluğu, sadece bir öğrenci grubu değil, aynı zamanda
                        <br> güvenli bir dijital geleceği inşa etmek için bir araya gelen bireylerin oluşturduğu güçlü bir ağdır. Topluluğumuz, teknolojinin
                        <br> hızla değiştiği ve siber tehditlerin arttığı bu dönemde, bilinçli ve yetkin bireyler yetiştirerek, güvenlik sektöründe fark yaratmayı
                        <br> misyon edinmiştir. Amacımız, bilgi güvenliği konusundaki farkındalığı artırmak, üyelerimizi donanımlı bir şekilde mezun etmek
                        <br> ve siber güvenlik dünyasında kalıcı bir etki bırakmaktır.
                    </p>
                </div>
            </div>
        </section>

        <!-- Eğitmenler Bölümü -->
        <section class="egitmenler" id="egitmenler">
            <div class="row mt-5">
                <div class="col-12">
                    <h1 class="text-center" style="font-size: 4rem; color: white;">Eğitmenlerimiz</h1>
                </div>
            </div>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-4 text-center">
                        <img src="<?php echo $row['photo']; ?>" class="img-fluid rounded-circle" alt="Eğitmen <?php echo $row['name']; ?>" style="width: 150px; height: 150px;">
                        <h3 style="color: white;"><?php echo $row['name']; ?></h3>
                        <p style="color: rgba(255,255,255,0.61);">Uzmanlık Alanı: <?php echo $row['expertise']; ?></p>
                    </div>
                <?php } ?>
            </div>
        </section>

        <section class="egitimlerimiz" id="egitimlerimiz">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center baslik" style="
                    font-size: 4rem;
                    background: linear-gradient(90deg, #ffffff, #000000);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;">Eğitimlerimiz</h1>
                    <p class="aciklama" style="flex-wrap: nowrap; text-align: center; color: rgba(255,255,255,0.61) ">
                        Siber güvenlik eğitimlerimiz, temel bilgilerden ileri seviye tekniklere kadar geniş bir <br> yelpazede, bireyleri ve kurumları dijital tehditlere karşı koruma becerileriyle donatmayı
                        <br> amaçlamaktadır.
                    </p>
                </div>
            </div>
            <div class="row" style="margin: 0 auto;">
                <div class="col-md-12 col-lg-4 mt-3 col-sm-12" style="margin: 0 auto;">
                    <div class="card" style="margin: 0 auto;">
                        <div class="card-head d-flex justify-content-between align-items-center mb-3">
                            <div class="icon-container mt-3" style="margin: 0 auto">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M432 448a15.92 15.92 0 0 1-11.31-4.69l-352-352a16 16 0 0 1 22.62-22.62l352 352A16 16 0 0 1 432 448zm-176.34-64c-41.49 0-81.5-12.28-118.92-36.5-34.07-22-64.74-53.51-88.7-91v-.08c19.94-28.57 41.78-52.73 65.24-72.21a2 2 0 0 0 .14-2.94L93.5 161.38a2 2 0 0 0-2.71-.12c-24.92 21-48.05 46.76-69.08 76.92a31.92 31.92 0 0 0-.64 35.54c26.41 41.33 60.4 76.14 98.28 100.65C162 402 207.9 416 255.66 416a239.13 239.13 0 0 0 75.8-12.58 2 2 0 0 0 .77-3.31l-21.58-21.58a4 4 0 0 0-3.83-1 204.8 204.8 0 0 1-51.16 6.47zm235.18-145.4c-26.46-40.92-60.79-75.68-99.27-100.53C349 110.55 302 96 255.66 96a227.34 227.34 0 0 0-74.89 12.83 2 2 0 0 0-.75 3.31l21.55 21.55a4 4 0 0 0 3.88 1 192.82 192.82 0 0 1 50.21-6.69c40.69 0 80.58 12.43 118.55 37 34.71 22.4 65.74 53.88 89.76 91a.13.13 0 0 1 0 .16 310.72 310.72 0 0 1-64.12 72.73 2 2 0 0 0-.15 2.95l19.9 19.89a2 2 0 0 0 2.7.13 343.49 343.49 0 0 0 68.64-78.48 32.2 32.2 0 0 0-.1-34.78z"></path><path d="M256 160a95.88 95.88 0 0 0-21.37 2.4 2 2 0 0 0-1 3.38l112.59 112.56a2 2 0 0 0 3.38-1A96 96 0 0 0 256 160zm-90.22 73.66a2 2 0 0 0-3.38 1 96 96 0 0 0 115 115 2 2 0 0 0 1-3.38z"></path></svg>
                            </div>
                            <h1 class="text-center mt-3" style="margin: 0 auto ; color: white; font-size: 1.2rem;">Uygulama Güvenliği</h1>
                        </div>
                        <div class="cardbody" style="width: 100%;border-top: 1px solid rgba(255, 255, 255, 0.1);">
                            <p class="mt-3 mb-3 px-2" style="margin:  0 auto;">Ağ sistemlerini güvence altına almak için kullanılan protokolleri, güvenlik duvarlarını ve VPN yapılandırmalarını keşfedin.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 mt-3 col-sm-12" style="margin: 0 auto;">
                    <div class="card" style="margin: 0 auto;">
                        <div class="card-head d-flex justify-content-between align-items-center mb-3">
                            <div class="icon-container mt-3" style="margin: 0 auto">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="200px" width="200px" xmlns="http://www.w3.org/2000/svg"><path d="M9 9h6v6H9z"></path><path d="M20 6c0-1.103-.897-2-2-2h-2V2h-2v2h-4V2H8v2H6c-1.103 0-2 .897-2 2v2H2v2h2v4H2v2h2v2c0 1.103.897 2 2 2h2v2h2v-2h4v2h2v-2h2c1.103 0 2-.897 2-2v-2h2v-2h-2v-4h2V8h-2V6zM6 18V6h12l.002 12H6z"></path></svg>
                            </div>
                            <h1 class="text-center mt-3" style="margin: 0 auto ; color: white; font-size: 1.2rem;">Temel Siber Güvenlik</h1>
                        </div>
                        <div class="cardbody" style="width: 100%;border-top: 1px solid rgba(255, 255, 255, 0.1);">
                            <p class="mt-3 mb-3 px-2" style="margin:  0 auto;">
                                Siber güvenliğin temellerini, internet güvenliğini ve kimlik avı gibi tehditlerden korunma yollarını öğrenin.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 mt-3 col-sm-12" style="margin: 0 auto;">
                    <div class="card" style="margin: 0 auto;">
                        <div class="card-head d-flex justify-content-between align-items-center mb-3">
                            <div class="icon-container mt-3" style="margin: 0 auto">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="200px" width="200px" xmlns="http://www.w3.org/2000/svg"><path d="M256 228.719c-22.879 0-41.597 18.529-41.597 41.18 0 22.652 18.718 41.182 41.597 41.182 22.878 0 41.597-18.529 41.597-41.182 0-22.651-18.719-41.18-41.597-41.18zm124.8 41.179c0-67.946-56.163-123.539-124.8-123.539s-124.8 55.593-124.8 123.539c0 45.303 24.961 85.447 62.396 107.072l20.807-36.032c-24.972-14.417-41.604-40.153-41.604-71.04 0-45.295 37.433-82.358 83.201-82.358 45.771 0 83.201 37.063 83.201 82.358 0 30.887-16.633 56.623-41.604 71.04l20.807 36.032c37.433-21.624 62.396-61.769 62.396-107.072zM256 64C141.597 64 48 156.654 48 269.898 48 346.085 89.592 411.968 152 448l20.799-36.032c-49.919-28.824-83.207-81.324-83.207-142.069 0-90.593 74.891-164.718 166.408-164.718 91.517 0 166.406 74.125 166.406 164.718 0 60.745-33.284 114.271-83.205 142.069L360 448c62.406-36.032 104-101.915 104-178.102C464 156.654 370.403 64 256 64z"></path></svg>
                            </div>
                            <h1 class="mt-3" style="margin: 0 auto; padding-right: 25%; color: white; font-size: 1.2rem;">Ağ Güvenliği</h1>
                        </div>
                        <div class="cardbody" style="width: 100%;border-top: 1px solid rgba(255, 255, 255, 0.1);">
                            <p class="mt-3 mb-3 px-2" style="margin:  0 auto;">Ağ sistemlerini güvence altına almak için kullanılan protokolleri, güvenlik duvarlarını ve VPN yapılandırmalarını keşfedin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<!-- Footer -->
<footer>
    <p>© 2024 Ticaret Cyber | Tüm Hakları Saklıdır</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>