<?php
session_start();
require_once '../config/koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $pass = $_POST['pass'];

    // Validasi panjang password
    if (strlen($pass) < 8) {
        $_SESSION['error'] = "Password minimal 8 karakter";
        header("Location: ../public/login.php");
        exit();
    }

    // Prepared Statement untuk menghindari SQL Injection
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Cek jika username tidak ditemukan
    if (!$user) {
        $_SESSION['error'] = "Username tidak ditemukan";
        header("Location: ../public/login.php");
        exit();
    }

    // Cek jika password salah
    if (!password_verify($pass, $user['pass'])) {
        $_SESSION['error'] = "Password salah";
        header("Location: ../public/login.php");
        exit();
    }

    // Login berhasil - hapus error message
    unset($_SESSION['error']);
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($_SESSION['role'] === 'admin') {
        header("Location: ../admin/dashboard.php?success=Login berhasil");
    } else {
        header("Location: ../index.php?success=Login berhasil");
    }
    exit();
}