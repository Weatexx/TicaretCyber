<?php
session_start();
include '../db.php'; // Veritabanı bağlantısını dahil et

// Basit bir oturum kontrolü
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Eğitmeni sil
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM instructors WHERE id = $id";
    mysqli_query($conn, $query);
    header('Location: edit_instructors.php');
    exit;
}
?> 