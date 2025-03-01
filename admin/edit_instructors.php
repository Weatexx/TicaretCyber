<?php
session_start();
include '../db.php'; // Veritabanı bağlantısını dahil et

// Basit bir oturum kontrolü
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Eğitmenleri veritabanından çek
$query = "SELECT * FROM instructors";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eğitmenleri Düzenle</title>
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
                <h1 class="m-0">Eğitmenleri Düzenle</h1>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>İsim</th>
                            <th>Uzmanlık</th>
                            <th>Fotoğraf</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['expertise']; ?></td>
                                <td><img src="<?php echo $row['photo']; ?>" alt="Eğitmen Fotoğrafı" style="width: 50px; height: auto;"></td>
                                <td>
                                    <a href="edit_instructor.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Düzenle</a>
                                    <a href="delete_instructor.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Sil</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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