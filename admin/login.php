<?php
session_start();
include '../db.php'; // Veritabanı bağlantısını dahil et

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcı doğrulama işlemi
    $query = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    
    // Sorgu hatası kontrolü
    if (!$result) {
        die("Sorgu hatası: " . mysqli_error($conn));
    }

    if ($result && mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        // Şifreyi kontrol et
        if ($password === $admin['password']) { // Şifre kontrolü
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header('Location: index.php'); // Giriş başarılıysa admin paneline yönlendir
            exit;
        } else {
            $error = "Kullanıcı adı veya şifre hatalı.";
        }
    } else {
        $error = "Kullanıcı adı veya şifre hatalı.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="../AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../AdminLTE/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../AdminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b> Paneli</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Giriş yapın</p>
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Kullanıcı Adı" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Şifre" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Giriş Yap</button>
                    </div>
                </div>
            </form>
            <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
        </div>
    </div>
</div>
<script src="../AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="../AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html> 