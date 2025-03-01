<?php
session_start();
include '../db.php'; // Veritabanı bağlantısını dahil et

// Basit bir oturum kontrolü
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Eğitmen bilgilerini al
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM instructors WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $instructor = mysqli_fetch_assoc($result);
}

// Eğitmen güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $expertise = $_POST['expertise'];
    $photo = $_POST['photo']; // Fotoğraf URL'si veya dosya yolu

    $updateQuery = "UPDATE instructors SET name='$name', expertise='$expertise', photo='$photo' WHERE id=$id";
    mysqli_query($conn, $updateQuery);
    header('Location: edit_instructors.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eğitmen Düzenle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../AdminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index.php" class="nav-link">Anasayfa</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">Admin Paneli</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Anasayfa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="edit_instructors.php" class="nav-link active">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>Eğitmenleri Düzenle</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="edit_trainings.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Eğitimleri Düzenle</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Çıkış Yap</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">Eğitmen Düzenle</h1>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">Eğitmen Adı</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $instructor['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="expertise">Uzmanlık Alanı</label>
                        <input type="text" name="expertise" class="form-control" value="<?php echo $instructor['expertise']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="photo">Fotoğraf URL'si</label>
                        <input type="text" name="photo" class="form-control" value="<?php echo $instructor['photo']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </form>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <strong>Copyright &copy; 2024 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<script src="../AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="../AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html> 