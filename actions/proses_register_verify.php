<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

function getRegisterVerifyEmail() {
    return isset($_SESSION['reg_email']) ? htmlspecialchars($_SESSION['reg_email'], ENT_QUOTES, 'UTF-8') : '';
}

function userPasswordColumn(PDO $pdo): string {
    static $column = null;
    if ($column !== null) {
        return $column;
    }

    $stmt = $pdo->query("SHOW COLUMNS FROM user LIKE 'password_hash'");
    $column = $stmt->fetchColumn() ? 'password_hash' : 'pass';
    return $column;
}

if (!isset($_SESSION['reg_email'])) {
    header('Location: ' . BASE_PATH . '/public/register.php?error=' . urlencode('Silakan daftar terlebih dahulu'));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/koneksi.php';

    $otp_input = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'];

    if (!isset($_SESSION['reg_otp']) || !isset($_SESSION['reg_email']) || !isset($_SESSION['reg_password_hash'])) {
        header('Location: ' . BASE_PATH . '/public/register.php?error=' . urlencode('Session pendaftaran tidak valid'));
        exit();
    }

    if ($otp_input != $_SESSION['reg_otp']) {
        header('Location: ' . BASE_PATH . '/public/register_verify.php?error=' . urlencode('Kode OTP salah'));
        exit();
    }

    $full_name = $_SESSION['reg_full_name'];
    $username = $_SESSION['reg_username'];
    $email = $_SESSION['reg_email'];
    $password_hash = $_SESSION['reg_password_hash'];

    try {
        $passwordColumn = userPasswordColumn($pdo);
        $stmt = $pdo->prepare("INSERT INTO user (full_name, username, email, {$passwordColumn}, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $username, $email, $password_hash, 'client']);

        unset($_SESSION['reg_full_name']);
        unset($_SESSION['reg_username']);
        unset($_SESSION['reg_email']);
        unset($_SESSION['reg_password_hash']);
        unset($_SESSION['reg_otp']);
        unset($_SESSION['reg_otp_time']);

        header('Location: ' . BASE_PATH . '/public/login.php?success=' . urlencode('Registrasi berhasil. Silakan login.'));
        exit();
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'UNIQUE constraint failed') !== false) {
            if (strpos($e->getMessage(), 'email') !== false) {
                header('Location: ' . BASE_PATH . '/public/register_verify.php?error=' . urlencode('Email sudah dipakai'));
            } elseif (strpos($e->getMessage(), 'username') !== false) {
                header('Location: ' . BASE_PATH . '/public/register_verify.php?error=' . urlencode('Username sudah dipakai'));
            } else {
                header('Location: ' . BASE_PATH . '/public/register_verify.php?error=' . urlencode('Data sudah terdaftar'));
            }
        } else {
            header('Location: ' . BASE_PATH . '/public/register_verify.php?error=' . urlencode('Gagal menyimpan data: ' . $e->getMessage()));
        }
        exit();
    }
}
