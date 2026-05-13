<?php
session_start();
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        header("Location: ../public/reset_password.php?error=" . urlencode("Password tidak cocok"));
        exit();
    }

    if (strlen($password) < 8) {
        header("Location: ../public/reset_password.php?error=" . urlencode("Password minimal 8 karakter"));
        exit();
    }

    // Ambil email dari session
    if (!isset($_SESSION['otp_email'])) {
        header("Location: ../public/login.php?error=" . urlencode("Sesi tidak valid"));
        exit();
    }

    $email = $_SESSION['otp_email'];

    // Hash password baru
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update password di database
    $stmt = $pdo->prepare("UPDATE user SET pass = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);

    // Hapus session
    unset($_SESSION['otp']);
    unset($_SESSION['otp_email']);

    header("Location: ../public/reset_password.php?success=Password berhasil direset");
    exit();
} else {
    header("Location: ../public/reset_password.php");
    exit();
}
?>
