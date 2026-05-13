<?php
session_start();
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['pass'] ?? '';

    if (strlen($pass) < 8) {
        header("Location: ../public/login.php?error=" . urlencode("Password minimal 8 karakter"));
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        header("Location: ../public/login.php?error=" . urlencode("Email tidak ditemukan"));
        exit();
    }

    if (!password_verify($pass, $user['pass'])) {
        header("Location: ../public/login.php?error=" . urlencode("Password salah"));
        exit();
    }

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
?>
