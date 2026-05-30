<?php
session_start();

require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/email_helper.php';

// Ambil email dari parameter GET atau POST
$email_tujuan = isset($_GET['email']) ? $_GET['email'] : (isset($_POST['email']) ? $_POST['email'] : '');

if (empty($email_tujuan)) {
    echo "Email tujuan tidak diberikan";
    exit;
}

// Validasi format email
if (!filter_var($email_tujuan, FILTER_VALIDATE_EMAIL)) {
    echo "Format email tidak valid";
    exit;
}

// Cek apakah email ada di database
$stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
$stmt->execute([$email_tujuan]);
$user = $stmt->fetch();

if (!$user) {
    echo "Email tidak terdaftar di sistem";
    exit;
}


// Generate OTP 4 digit
$otp = rand(1000, 9999);

// Simpan OTP di session untuk verifikasi nanti
$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $email_tujuan;

// Ambil template email OTP
$htmlBody = getOtpEmailTemplate($otp, 10);
$plainBody = getOtpPlainText($otp, 10);

// Kirim email menggunakan helper function
$result = sendEmail(
    $email_tujuan,
    'Kode OTP - Verifikasi Akun Project MUA',
    $htmlBody,
    $plainBody
);

if ($result['success']) {
    // Email berhasil dikirim, redirect ke halaman verifikasi OTP
    header('Location: ../public/otp_verifikasi.php');
    exit();
} else {
    // Email gagal dikirim
    echo "Gagal kirim OTP: " . $result['error'];
    exit();
}