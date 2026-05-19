<?php
session_start();

$errors = [];
if (isset($_GET['error']) && $_GET['error'] !== '') {
    $errors[] = $_GET['error'];
} elseif (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
}

$success = $_GET['success'] ?? ($_SESSION['success'] ?? '');
$email = $_SESSION['otp_email'] ?? '';

unset($_SESSION['errors'], $_SESSION['form_data'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kata Sandi Baru</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-light" style="font-family: 'Poppins', sans-serif; min-height:100vh;">

<div class="container-fluid px-4 py-3" style="max-width:430px; min-height:100vh;">
    <div class="mb-5">
        <a href="otp_verifikasi.php" class="text-dark text-decoration-none">
            <i class="bi bi-chevron-left fs-2 fw-bold"></i>
        </a>
    </div>

    <div class="d-flex flex-column justify-content-center align-items-center text-center" style="margin-top:80px;">
        <div class="mb-4">
            <i class="bi bi-shield-lock-fill text-primary" style="font-size:110px;"></i>
        </div>

        <h1 class="fw-bold text-dark mb-2" style="font-size:28px;">
            Kata Sandi Baru
        </h1>

        <p class="text-secondary mb-5" style="font-size:14px; letter-spacing:1px;">
            Silakan buat password Anda
        </p>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show w-100 mb-4" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show w-100 mb-4" role="alert">
                <?php foreach ($errors as $error): ?>
                    <div>&bull; <?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="../actions/proses_reset_password.php" method="POST" class="w-100">
            <div class="mb-4">
                <input
                    type="email"
                    name="email"
                    class="form-control rounded-pill py-3 px-4 border-secondary-subtle bg-light"
                    placeholder="Email Address"
                    value="<?= htmlspecialchars($email) ?>"
                    readonly
                    required
                >
            </div>

            <div class="mb-4">
                <input
                    type="password"
                    name="password"
                    class="form-control rounded-pill py-3 px-4 border-secondary-subtle bg-light"
                    placeholder="Password Baru"
                    required
                >
            </div>

            <div class="mb-5">
                <input
                    type="password"
                    name="confirm_password"
                    class="form-control rounded-pill py-3 px-4 border-secondary-subtle bg-light"
                    placeholder="Konfirmasi Password"
                    required
                >
            </div>

            <button
                type="submit"
                class="btn btn-primary w-100 rounded-pill py-3 fw-semibold border-0"
                style="background-color:#4A7CF3;"
            >
                Next
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
