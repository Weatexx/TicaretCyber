<?php
session_start();
include '../db.php'; // Veritabanı bağlantısını dahil et

// Basit bir oturum kontrolü
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="tr">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Paneli | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      /* Responsive düzenlemeler */
      @media (max-width: 768px) {
        .app-sidebar {
          width: 100%;
          transform: translateX(-100%);
          transition: transform 0.3s ease;
          position: fixed;
          z-index: 1000;
          box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        
        .sidebar-open .app-sidebar {
          transform: translateX(0);
        }
        
        .app-main {
          margin-left: 0 !important;
          width: 100% !important;
        }
        
        .app-header {
          width: 100% !important;
          left: 0 !important;
        }
        
        .sidebar-open .app-main,
        .sidebar-open .app-header {
          margin-left: 0 !important;
        }
        
        .app-content-header h3 {
          font-size: 1.5rem;
        }
        
        .nav-sidebar .nav-link {
          padding: 0.75rem;
        }
        
        .app-footer {
          text-align: center;
        }
        
        .app-footer .float-end {
          float: none !important;
          display: block;
          margin-top: 10px;
        }
      }
      
      @media (max-width: 576px) {
        .app-content-header h3 {
          font-size: 1.25rem;
        }
        
        .table-responsive {
          font-size: 0.9rem;
        }
      }
      
      /* Genel düzenlemeler */
      .app-sidebar {
        width: 250px;
        height: 100%;
        position: fixed;
        left: 0;
        top: 0;
        background-color: #343a40;
        color: white;
        overflow-y: auto;
        transition: transform 0.3s ease;
        padding-top: 60px;
      }
      
      .app-main {
        margin-left: 250px;
        transition: margin-left 0.3s ease;
        min-height: calc(100vh - 56px);
        padding-top: 60px;
      }
      
      .app-header {
        position: fixed;
        top: 0;
        left: 250px;
        right: 0;
        z-index: 999;
        height: 56px;
        background-color: #fff;
        border-bottom: 1px solid #dee2e6;
        transition: left 0.3s ease;
      }
      
      .dropdown-menu {
        border-radius: 0.25rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
      }
      
      .brand-link {
        display: block;
        padding: 15px;
        color: #fff;
        text-decoration: none;
        font-size: 20px;
        font-weight: 300;
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
      }
      
      .brand-link img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
      }
      
      .nav-sidebar {
        padding: 0 15px;
      }
      
      .nav-sidebar .nav-link {
        color: rgba(255,255,255,0.7);
        padding: 12px 15px;
        margin-bottom: 5px;
        border-radius: 5px;
        transition: all 0.3s ease;
        font-size: 15px;
      }
      
      .nav-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
      }
      
      .nav-sidebar .nav-link i {
        margin-right: 10px;
      }
      
      .app-main-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
      }
      
      .sidebar-open .app-main-overlay {
        display: block;
      }
      
      .app-content {
        padding: 20px;
      }
      
      .app-content-header {
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 20px;
      }
      
      .app-footer {
        padding: 15px 20px;
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
        margin-top: 20px;
      }
    </style>
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body>
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <button id="sidebar-toggle" class="btn btn-link nav-link px-2">
                <i class="bi bi-list"></i>
              </button>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i> <?php echo $_SESSION['username']; ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="logout.php">Çıkış Yap</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <!--end::Header-->
      
      <!-- Overlay for mobile sidebar -->
      <div class="app-main-overlay"></div>
      
      <!--begin::Sidebar-->
      <aside class="app-sidebar">
        <div class="sidebar-brand">
          <a href="dashboard.php" class="brand-link">
            <span class="brand-text fw-light">Admin Panel</span>
          </a>
        </div>
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul class="nav nav-sidebar flex-column">
              <li class="nav-item">
                <a href="#" class="nav-link menu-link" data-page="instructors">
                  <i class="bi bi-person"></i>
                  <span>Eğitmenler</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link menu-link" data-page="trainings">
                  <i class="bi bi-book"></i>
                  <span>Eğitimler</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link menu-link" data-page="about">
                  <i class="bi bi-info-circle"></i>
                  <span>Hakkımızda</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link menu-link" data-page="apply">
                  <i class="bi bi-link"></i>
                  <span>Buton Ayarları</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link menu-link" data-page="hero">
                  <i class="bi bi-image"></i>
                  <span>Hero İçeriği</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="app-content">
          <div class="container-fluid" id="content-area">
            <!-- Burada içerik yüklenecek -->
            <h4 class="text-center">Lütfen sol menüden bir seçenek seçin.</h4>
          </div>
        </div>
      </main>
      <!--end::App Main-->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">
          Made by <a href="https://www.linkedin.com/in/arda-koray-kartal-22334626a/" class="text-decoration-none developer-link">Arda Koray Kartal</a>
        </div>
        <strong>Copyright &copy; 2024 <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.</strong> All rights reserved.
      </footer>
    </div>
    <!--end::App Wrapper-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
      // İçerik yükleme fonksiyonu
      function loadContent(page) {
        let url = '';
        if (page === 'instructors') {
            url = 'instructors.php?from=instructors'; // Eğitmenler sayfası
        } else if (page === 'dashboard') {
            url = 'dashboard.php'; // Dashboard sayfası
        } else if (page === 'trainings') {
            url = 'trainings.php'; // Eğitimler sayfası
        } else if (page === 'about') {
            url = 'about.php'; // Hakkımızda sayfası
        } else if (page === 'apply') {
            url = 'apply.php'; // Başvuru butonu sayfası
        } else if (page === 'hero') {
            url = 'hero.php'; // Hero içeriği sayfası
        } else {
            $('#content-area').html('<h4 class="text-center text-danger">Bu bölümde içerik yüklenemez.</h4>');
            return;
        }

        // Önce sidebar'ı kapat, sonra içerik yükle
        if (window.innerWidth < 768) {
            document.body.classList.remove('sidebar-open');
        }

        // İçerik yükleme işlemi
        $('#content-area').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Yükleniyor...</span></div></div>');
        
        setTimeout(function() {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#content-area').html(data); // İçeriği güncelle
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Hata: " + textStatus + " - " + errorThrown);
                    $('#content-area').html('<h4 class="text-center text-danger">İçerik yüklenemedi.</h4>');
                }
            });
        }, 300); // 300ms gecikme
      }
      
      // Sayfa yüklendiğinde
      document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle fonksiyonu
        function toggleSidebar() {
          document.body.classList.toggle('sidebar-open');
        }
        
        // Sidebar toggle butonu
        const sidebarToggle = document.getElementById('sidebar-toggle');
        if (sidebarToggle) {
          sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleSidebar();
          });
        }
        
        // Tüm menü bağlantıları
        const menuLinks = document.querySelectorAll('.menu-link');
        menuLinks.forEach(function(link) {
          link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.getAttribute('data-page');
            if (page) {
              loadContent(page);
            }
          });
        });
        
        // Overlay'a tıklama
        const overlay = document.querySelector('.app-main-overlay');
        if (overlay) {
          overlay.addEventListener('click', function() {
            if (document.body.classList.contains('sidebar-open')) {
              toggleSidebar();
            }
          });
        }
        
        // Ekran boyutu değişikliği
        window.addEventListener('resize', function() {
          if (window.innerWidth >= 768 && document.body.classList.contains('sidebar-open')) {
            document.body.classList.remove('sidebar-open');
          }
        });
      });
    </script>
  </body>
  <!--end::Body-->
</html> 