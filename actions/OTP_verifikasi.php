<?php
/**
 * Backend Logic untuk OTP Verifikasi
 * File ini menangani semua logika backend untuk halaman otp_verifikasi.php
 */

session_start();

// Proses OTP jika ada POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_input = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'];

    if (isset($_SESSION['otp']) && $otp_input == $_SESSION['otp']) {
        // OTP benar, redirect ke halaman reset password
        header('Location: ../public/reset_password.php?success=' . urlencode('OTP benar. Silakan atur ulang password Anda.'));
        exit();
    } else {
        // OTP salah, kembali ke halaman verifikasi OTP
        header('Location: ../public/otp_verifikasi.php?error=' . urlencode('OTP salah. Coba lagi.'));
        exit();
    }
}
