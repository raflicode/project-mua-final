<?php
session_start();

function getLoginAlertScript() {
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
                showConfirmButton: false,
                didOpen: () => {
                    if (window.history.replaceState) {
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                }
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
                title: 'Login Gagal',
                text: '{$errorMessage}'
            });
        </script>
        ";
    }

    if (isset($_SESSION['error'])) {
        $errorMessage = htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
        unset($_SESSION['error']);
        $script = "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{$errorMessage}'
            });
        </script>
        ";
    }

    return $script;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/koneksi.php';

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
