<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/koneksi.php'; // Include koneksi database

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

$mail = new PHPMailer(true);

echo "phpmailer berhasil";

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // EMAIL PENGIRIM
    $mail->Username = 'zaind377@gmail.com';

    // APP PASSWORD DARI GOOGLE
    $mail->Password = 'djql ypoe rndc mnvi';

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('zaind377@gmail.com', 'Project MUA');

    // EMAIL TUJUAN (dinamis berdasarkan input)
    $mail->addAddress($email_tujuan);

    $mail->isHTML(true);

    $mail->Subject = 'Kode OTP';

    $otp = rand(1000, 9999); // OTP 4 digit

    // Simpan OTP di session untuk verifikasi nanti
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email_tujuan;

    $mail->Body = "
        <h2>Kode OTP</h2>
        <h1>$otp</h1>
    ";

    $mail->send();

    // Redirect ke halaman reset password untuk verifikasi OTP
    header('Location: ../public/otp_verifikasi.php');
    exit();

} catch (Exception $e) {

    echo "Gagal kirim OTP: " . $mail->ErrorInfo;
}