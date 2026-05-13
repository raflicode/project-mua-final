<?php
session_start();
require_once '../config/koneksi.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $queryData = [
        'old_full_name' => $full_name,
        'old_email' => $email,
        'old_username' => $username,
    ];

    // 1. Validasi email Gmail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/i', $email)) {
        $queryData['error'] = 'Gunakan alamat Gmail yang valid';
        header("Location: ../public/register.php?" . http_build_query($queryData));
        exit();
    }

    // 2. Cek apakah username atau email sudah ada
    $check = $pdo->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
    $check->execute([$username, $email]);
    
    if ($check->rowCount() > 0) {
<<<<<<< HEAD
        header("Location: ../public/register.php?error=Username or email already exists");
=======
        $queryData['error'] = 'Username or email already exists';
        header("Location: ../public/register.php?" . http_build_query($queryData));
>>>>>>> 82211bea8e7750c82a22c3dda6af5aa913d9ae61
        exit();
    }

    // 3. Validasi password minimal 8 karakter
    if (strlen($password) < 8) {
        $queryData['error'] = 'Password minimal 8 karakter';
        header("Location: ../public/register.php?" . http_build_query($queryData));
        exit();
    }

    // 4. Hash Password (WAJIB, jangan simpan teks biasa!)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 5. Kirim OTP verifikasi email
    $otp = rand(1000, 9999);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'zaind377@gmail.com';
        $mail->Password = 'djql ypoe rndc mnvi';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('projectmua@gmail.com', 'Project MUA');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Email - Kode OTP';
        $mail->Body = "
            <h2>Verifikasi Email</h2>
            <p>Gunakan kode OTP berikut untuk menyelesaikan pendaftaran:</p>
            <h1>$otp</h1>
        ";

        $mail->send();

        $_SESSION['reg_full_name'] = $full_name;
        $_SESSION['reg_username'] = $username;
        $_SESSION['reg_email'] = $email;
        $_SESSION['reg_password_hash'] = $hashedPassword;
        $_SESSION['reg_otp'] = $otp;
        $_SESSION['reg_otp_time'] = time();

        header("Location: ../public/register_verify.php?success=Kode OTP dikirim ke $email");
        exit();
    } catch (Exception $e) {
        $queryData['error'] = 'Gagal mengirim OTP: ' . $mail->ErrorInfo;
        header("Location: ../public/register.php?" . http_build_query($queryData));
        exit();
    }
}
