<?php
session_start();
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp_input = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'];

    if (!isset($_SESSION['reg_otp']) || !isset($_SESSION['reg_email']) || !isset($_SESSION['reg_password_hash'])) {
        header('Location: ../public/register.php?error=Session pendaftaran tidak valid');
        exit();
    }

    if ($otp_input != $_SESSION['reg_otp']) {
        header('Location: ../public/register_verify.php?error=Kode OTP salah');
        exit();
    }

    $full_name = $_SESSION['reg_full_name'];
    $username = $_SESSION['reg_username'];
    $email = $_SESSION['reg_email'];
    $password_hash = $_SESSION['reg_password_hash'];

    try {
        $stmt = $pdo->prepare('INSERT INTO user (full_name, username, email, pass, role) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$full_name, $username, $email, $password_hash, 'client']);

        unset($_SESSION['reg_full_name']);
        unset($_SESSION['reg_username']);
        unset($_SESSION['reg_email']);
        unset($_SESSION['reg_password_hash']);
        unset($_SESSION['reg_otp']);
        unset($_SESSION['reg_otp_time']);

        header('Location: ../public/login.php?success=Registrasi berhasil. Silakan login.');
        exit();
    } catch (PDOException $e) {
        // Cek jika error adalah karena email atau username duplikat
        if (strpos($e->getMessage(), 'UNIQUE constraint failed') !== false) {
            if (strpos($e->getMessage(), 'email') !== false) {
                header('Location: ../public/register_verify.php?error=Email sudah dipakai');
            } elseif (strpos($e->getMessage(), 'username') !== false) {
                header('Location: ../public/register_verify.php?error=Username sudah dipakai');
            } else {
                header('Location: ../public/register_verify.php?error=Data sudah terdaftar');
            }
        } else {
            header('Location: ../public/register_verify.php?error=Gagal menyimpan data: ' . urlencode($e->getMessage()));
        }
        exit();
    }
} else {
    header('Location: ../public/register.php');
    exit();
}
