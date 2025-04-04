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

    <link rel="stylesheet" href="../AdminLTE/dist/css/adminlte.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
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
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="dashboard.php" class="brand-link">
            <img src="../AdminLTE/dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">Admin Paneli</span>
          </a>
        </div>
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="#" class="nav-link" onclick="loadContent('instructors')">
                  <i class="nav-icon bi bi-person"></i>
                  <p>Eğitmenler</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" onclick="loadContent('trainings')">
                  <i class="nav-icon bi bi-book"></i>
                  <p>Eğitimler</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" onclick="loadContent('about')">
                  <i class="nav-icon bi bi-info-circle"></i>
                  <p>Hakkımızda</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" onclick="loadContent('apply')">
                  <i class="nav-icon bi bi-link"></i>
                  <p>Buton Ayarları</p>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="../AdminLTE/dist/js/adminlte.min.js"></script>

    <script>
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
        } else {
            $('#content-area').html('<h4 class="text-center text-danger">Bu bölümde içerik yüklenemez.</h4>');
            return;
        }

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
      }
    </script>
  </body>
  <!--end::Body-->
</html> 