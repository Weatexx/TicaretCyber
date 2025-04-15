<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eğitmenlerimiz - TicaretCyber</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #111;
            color: white;
            overflow-x: hidden;
        }
        
        .navbar {
            background-color: rgba(17, 17, 17, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: #FDC400 !important;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: #FDC400 !important;
        }
        
        .navbar-toggler {
            border: none;
            outline: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        header {
            position: relative;
            padding: 120px 0 80px;
            text-align: center;
            background: linear-gradient(120deg, #111 20%, #333 100%);
        }
        
        .page-heading {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            background: linear-gradient(90deg, #FDC400, #FF9D00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
        }
        
        .subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 700px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }
        
        .instructor-section {
            padding: 80px 0;
            background-color: #111;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            background: linear-gradient(90deg, #FDC400, #FF9D00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            position: relative;
            margin-bottom: 50px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 5px;
            background: linear-gradient(90deg, #FDC400, #FF9D00);
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 5px;
        }
        
        .instructor-card {
            background: rgba(30, 30, 30, 0.8);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 25px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .instructor-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(253, 196, 0, 0.3);
        }
        
        .instructor-img-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 3px solid #FDC400;
            position: relative;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }
        
        .instructor-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }
        
        .instructor-card:hover .instructor-img {
            transform: scale(1.1);
        }
        
        .instructor-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #FDC400;
            text-align: center;
            margin-bottom: 10px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .instructor-title {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            margin-bottom: 15px;
            font-style: italic;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .instructor-bio {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            line-height: 1.7;
            text-align: center;
            margin-bottom: 20px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 10px;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            margin: 0 5px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-link:hover {
            background: #FDC400;
            color: #111;
            transform: translateY(-5px);
        }
        
        footer {
            background-color: #111;
            padding: 50px 0 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-logo {
            font-size: 2rem;
            font-weight: 700;
            color: #FDC400;
            margin-bottom: 15px;
            display: inline-block;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        
        .footer-heading {
            font-size: 1.2rem;
            color: #FDC400;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #FDC400;
            padding-left: 5px;
        }
        
        .footer-links a i {
            margin-right: 8px;
            color: #FDC400;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 50px;
        }
        
        .footer-bottom p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }
        
        .modal-content {
            background: rgba(17, 17, 17, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .modal-title {
            color: #FDC400;
            font-weight: 600;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .more-info-btn {
            background-color: #FDC400;
            color: #111;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: block;
            margin: 0 auto;
            box-shadow: 0 5px 15px rgba(253, 196, 0, 0.3);
        }
        
        .more-info-btn:hover {
            background-color: #FFB000;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(253, 196, 0, 0.4);
        }
        
        .close-modal-btn {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .close-modal-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .modal-instructor-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #FDC400;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .page-heading {
                font-size: 3rem;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .instructor-card {
                margin-bottom: 30px;
            }
            
            .footer-content {
                margin-bottom: 30px;
            }
        }
        
        @media (max-width: 768px) {
            .page-heading {
                font-size: 2.5rem;
            }
            
            .subtitle {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            header {
                padding: 100px 0 60px;
            }
            
            .instructor-section {
                padding: 60px 0;
            }
            
            .instructor-card {
                padding: 20px;
            }
            
            .instructor-name {
                font-size: 1.3rem;
            }
            
            .instructor-img-container {
                width: 120px;
                height: 120px;
            }
        }
        
        @media (max-width: 576px) {
            .page-heading {
                font-size: 2rem;
            }
            
            .subtitle {
                font-size: 0.9rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            header {
                padding: 80px 0 50px;
            }
            
            .instructor-card {
                padding: 15px;
            }
            
            .instructor-name {
                font-size: 1.2rem;
            }
            
            .instructor-title {
                font-size: 0.9rem;
            }
            
            .instructor-bio {
                font-size: 0.85rem;
            }
            
            .instructor-img-container {
                width: 100px;
                height: 100px;
            }
            
            .social-link {
                width: 35px;
                height: 35px;
            }
            
            .footer-logo {
                font-size: 1.8rem;
            }
            
            .footer-heading {
                font-size: 1.1rem;
                margin-top: 20px;
            }
            
            .modal-instructor-img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">TicaretCyber</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="instructors.php">Eğitmenlerimiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trainings.php">Eğitimlerimiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">İletişim</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <h1 class="page-heading">Eğitmenlerimiz</h1>
            <p class="subtitle">Siber güvenlik alanında uzman eğitmenlerimiz ile tanışın. Sektörün önde gelen isimlerinden oluşan ekibimiz, sizlere en güncel ve kapsamlı eğitimleri sunmak için hazır.</p>
        </div>
    </header>

    <!-- Instructors Section -->
    <section class="instructor-section">
        <div class="container">
            <div class="row">
                <?php
                // Veritabanı bağlantısı
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "ticaretcyber";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Bağlantı kontrolü
                if ($conn->connect_error) {
                    die("Bağlantı hatası: " . $conn->connect_error);
                }

                // Eğitmenleri getir
                $sql = "SELECT * FROM instructors ORDER BY id DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $photoPath = "admin/uploads/instructors/" . $row['photo'];
                ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="instructor-card">
                        <div class="instructor-img-container">
                            <?php if (!empty($row['photo']) && file_exists($photoPath)) { ?>
                                <img src="<?php echo $photoPath; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="instructor-img">
                            <?php } else { ?>
                                <img src="assets/img/default-instructor.jpg" alt="Default Instructor" class="instructor-img">
                            <?php } ?>
                        </div>
                        <h3 class="instructor-name"><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p class="instructor-title"><?php echo htmlspecialchars($row['expertise']); ?></p>
                        <p class="instructor-bio">
                            <?php 
                            $bio = htmlspecialchars($row['bio']);
                            echo (strlen($bio) > 150) ? substr($bio, 0, 150) . '...' : $bio; 
                            ?>
                        </p>
                        <div class="social-links">
                            <?php if (!empty($row['linkedin'])) { ?>
                                <a href="<?php echo htmlspecialchars($row['linkedin']); ?>" class="social-link" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <?php } ?>
                            <?php if (!empty($row['twitter'])) { ?>
                                <a href="<?php echo htmlspecialchars($row['twitter']); ?>" class="social-link" target="_blank"><i class="fab fa-twitter"></i></a>
                            <?php } ?>
                            <?php if (!empty($row['github'])) { ?>
                                <a href="<?php echo htmlspecialchars($row['github']); ?>" class="social-link" target="_blank"><i class="fab fa-github"></i></a>
                            <?php } ?>
                        </div>
                        <button class="btn more-info-btn mt-3" data-bs-toggle="modal" data-bs-target="#instructorModal-<?php echo $row['id']; ?>">Detaylı Bilgi</button>
                    </div>
                </div>

                <!-- Instructor Modal -->
                <div class="modal fade" id="instructorModal-<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="instructorModalLabel-<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="instructorModalLabel-<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="mb-4">
                                    <?php if (!empty($row['photo']) && file_exists($photoPath)) { ?>
                                        <img src="<?php echo $photoPath; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="modal-instructor-img">
                                    <?php } else { ?>
                                        <img src="assets/img/default-instructor.jpg" alt="Default Instructor" class="modal-instructor-img">
                                    <?php } ?>
                                </div>
                                <h4 style="color: #FDC400; font-size: 1.4rem; margin-bottom: 5px;"><?php echo htmlspecialchars($row['name']); ?></h4>
                                <p style="color: rgba(255,255,255,0.7); font-style: italic; margin-bottom: 20px;"><?php echo htmlspecialchars($row['expertise']); ?></p>
                                <div style="text-align: left; margin-bottom: 20px; max-height: 200px; overflow-y: auto; padding-right: 10px;">
                                    <h5 style="color: #FDC400; font-size: 1.1rem; margin-bottom: 10px;">Biyografi</h5>
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem; line-height: 1.7; text-align: justify; word-wrap: break-word; overflow-wrap: break-word;">
                                        <?php echo nl2br(htmlspecialchars($row['bio'])); ?>
                                    </p>
                                    <?php if (!empty($row['certifications'])) { ?>
                                        <h5 style="color: #FDC400; font-size: 1.1rem; margin: 15px 0 10px;">Sertifikalar</h5>
                                        <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem; line-height: 1.7; text-align: justify; word-wrap: break-word; overflow-wrap: break-word;">
                                            <?php echo nl2br(htmlspecialchars($row['certifications'])); ?>
                                        </p>
                                    <?php } ?>
                                </div>
                                <div class="social-links justify-content-center mt-4">
                                    <?php if (!empty($row['linkedin'])) { ?>
                                        <a href="<?php echo htmlspecialchars($row['linkedin']); ?>" class="social-link" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    <?php } ?>
                                    <?php if (!empty($row['twitter'])) { ?>
                                        <a href="<?php echo htmlspecialchars($row['twitter']); ?>" class="social-link" target="_blank"><i class="fab fa-twitter"></i></a>
                                    <?php } ?>
                                    <?php if (!empty($row['github'])) { ?>
                                        <a href="<?php echo htmlspecialchars($row['github']); ?>" class="social-link" target="_blank"><i class="fab fa-github"></i></a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn close-modal-btn" data-bs-dismiss="modal">Kapat</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<div class='col-12 text-center'><p>Henüz eğitmen eklenmemiş.</p></div>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-content">
                        <a href="index.php" class="footer-logo">TicaretCyber</a>
                        <p class="footer-text">Siber güvenlik eğitimlerinde öncü kuruluş. Profesyonel eğitmenler eşliğinde teorik ve uygulamalı siber güvenlik eğitimleri sunuyoruz.</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Hızlı Erişim</h5>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="fas fa-angle-right"></i> Ana Sayfa</a></li>
                        <li><a href="instructors.php"><i class="fas fa-angle-right"></i> Eğitmenlerimiz</a></li>
                        <li><a href="trainings.php"><i class="fas fa-angle-right"></i> Eğitimlerimiz</a></li>
                        <li><a href="contact.php"><i class="fas fa-angle-right"></i> İletişim</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">İletişim</h5>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Ankara, Türkiye</a></li>
                        <li><a href="mailto:info@ticaretcyber.com"><i class="fas fa-envelope"></i> info@ticaretcyber.com</a></li>
                        <li><a href="tel:+903120000000"><i class="fas fa-phone"></i> +90 312 000 00 00</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Sosyal Medya</h5>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i> LinkedIn</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 TicaretCyber. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar'ı kaydırma işlemi sırasında arkaplan değiştirme
        window.addEventListener('scroll', function () {
            var navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.padding = '10px 0';
                navbar.style.backgroundColor = 'rgba(17, 17, 17, 0.98) !important';
            } else {
                navbar.style.padding = '15px 0';
                navbar.style.backgroundColor = 'rgba(17, 17, 17, 0.95) !important';
            }
        });
    </script>
</body>
</html> 