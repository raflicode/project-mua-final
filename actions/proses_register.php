<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getRegisterAlertScript() {
    $script = '';

    if (isset($_GET['success'])) {
        $successMessage = htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8');
        $script = "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{$successMessage}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        ";
    }

    if (isset($_GET['error'])) {
        $errorMessage = htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8');
        $script = "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{$errorMessage}'
            });
        </script>
        ";
    }

    return $script;
}

function getOldRegisterValue($key) {
    return isset($_GET[$key]) ? htmlspecialchars($_GET[$key], ENT_QUOTES, 'UTF-8') : '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/koneksi.php';
    require_once __DIR__ . '/../vendor/autoload.php';

    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $queryData = [
        'old_full_name' => $full_name,
        'old_email' => $email,
        'old_username' => $username,
    ];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $queryData['error'] = 'Gunakan alamat email yang valid';
        header('Location: ' . BASE_PATH . '/public/register.php?' . http_build_query($queryData));
        exit();
    }

    $checkEmail = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $checkEmail->execute([$email]);

    if ($checkEmail->rowCount() > 0) {
        $queryData['error'] = 'Email sudah dipakai';
        header('Location: ' . BASE_PATH . '/public/register.php?' . http_build_query($queryData));
        exit();
    }

    $checkUsername = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $checkUsername->execute([$username]);

    if ($checkUsername->rowCount() > 0) {
        $queryData['error'] = 'Username sudah ada';
        header('Location: ' . BASE_PATH . '/public/register.php?' . http_build_query($queryData));
        exit();
    }

    if (strlen($password) < 8) {
        $queryData['error'] = 'Password minimal 8 karakter';
        header('Location: ' . BASE_PATH . '/public/register.php?' . http_build_query($queryData));
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $otp = rand(1000, 9999);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'zaind377@gmail.com';
        $mail->Password = 'djql ypoe rndc mnvi';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->SMTPAutoTLS = false;

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
    } catch (Exception $e) {
        // Fallback: gunakan mail() jika SMTP tidak bisa
        try {
            $mail = new PHPMailer(true);
            $mail->isMail();
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
        } catch (Exception $e2) {
            $queryData['error'] = 'Gagal mengirim OTP: ' . $e2->getMessage();
            header('Location: ' . BASE_PATH . '/public/register.php?' . http_build_query($queryData));
            exit();
        }
    }

    $_SESSION['reg_full_name'] = $full_name;
    $_SESSION['reg_username'] = $username;
    $_SESSION['reg_email'] = $email;
    $_SESSION['reg_password_hash'] = $hashedPassword;
    $_SESSION['reg_otp'] = $otp;
    $_SESSION['reg_otp_time'] = time();

    header('Location: ' . BASE_PATH . '/public/register_verify.php?success=Kode OTP dikirim ke ' . urlencode($email));
    exit();
}
