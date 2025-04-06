<?php
session_start();
include '../db.php'; // Veritabanı bağlantısını dahil et

// Oturum açılmışsa, doğrudan dashboard.php'ye yönlendir
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: dashboard.php');
    exit;
}

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
            header('Location: dashboard.php'); // Giriş başarılıysa admin paneline yönlendir
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
    <style>
        /* Responsive düzenlemeler */
        body {
            background: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 15px;
        }
        
        .login-box {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .login-logo {
            margin-bottom: 20px;
            text-align: center;
        }
        
        .login-logo a {
            font-size: 2rem;
            text-decoration: none;
            color: #343a40;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
            overflow: hidden;
        }
        
        .login-card-body {
            padding: 30px;
        }
        
        .login-box-msg {
            margin-bottom: 20px;
            font-size: 1.1rem;
            color: #3d3d3d;
            text-align: center;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
        }
        
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 500;
            padding: 10px 0;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .text-danger {
            margin-top: 15px;
            text-align: center;
        }
        
        @media (max-width: 576px) {
            .login-box {
                max-width: 100%;
            }
            
            .login-logo a {
                font-size: 1.7rem;
            }
            
            .login-card-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b> Panel</a>
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