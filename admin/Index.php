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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../AdminLTE/dist/css/adminlte.min.css">
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
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
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
          <a href="index.php" class="brand-link">
            <img src="../AdminLTE/dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">Admin Paneli</span>
          </a>
        </div>
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="index.php" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="edit_instructors.php" class="nav-link">
                  <i class="nav-icon bi bi-person"></i>
                  <p>Eğitmenleri Düzenle</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="edit_trainings.php" class="nav-link">
                  <i class="nav-icon bi bi-book"></i>
                  <p>Eğitimleri Düzenle</p>
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
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-3 col-6">
                <div class="small-box text-bg-primary">
                  <div class="inner">
                    <h3>150</h3>
                    <p>Yeni Siparişler</p>
                  </div>
                  <div class="icon">
                    <i class="bi bi-cart"></i>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box text-bg-success">
                  <div class="inner">
                    <h3>53</h3>
                    <p>Yeni Kullanıcılar</p>
                  </div>
                  <div class="icon">
                    <i class="bi bi-person-plus"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <!--end::App Main-->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <strong>Copyright &copy; 2024 <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.</strong> All rights reserved.
      </footer>
    </div>
    <!--end::App Wrapper-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="../AdminLTE/dist/js/adminlte.min.js"></script>
  </body>
  <!--end::Body-->
</html> 