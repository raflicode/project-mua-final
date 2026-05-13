<?php
session_start();
require_once '../config/koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];

    // 1. Prepared Statement untuk menghindari SQL Injection
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['pass'])) {

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];

        header("Location: ../index.php?success=Login berhasil");
        exit();

    } else {
        header("Location: ../public/login.php?error=" . urlencode("Email atau password salah"));
        exit();
    }
}
