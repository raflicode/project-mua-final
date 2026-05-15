
<?php
session_start();

// Get errors and form data from session
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';

// Clear session after displaying
if (!empty($errors) || !empty($success)) {
    unset($_SESSION['errors']);
    unset($_SESSION['form_data']);
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kata Sandi Baru</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-light" style="font-family: 'Poppins', sans-serif; min-height:100vh;">

<div class="container-fluid px-4 py-3" style="max-width:430px; min-height:100vh;">

    <!-- Back Button -->
    <div class="mb-5">
        <a href="login.php" class="text-dark text-decoration-none">
            <i class="bi bi-chevron-left fs-2 fw-bold"></i>
        </a>
    </div>

    <!-- Content -->
    <div class="d-flex flex-column justify-content-center align-items-center text-center" style="margin-top:80px;">

        <!-- Icon -->
        <div class="mb-4">
            <i class="bi bi-shield-lock-fill text-primary" style="font-size:110px;"></i>
        </div>

        <!-- Title -->
        <h1 class="fw-bold text-dark mb-2" style="font-size:28px;">
            Kata Sandi Baru
        </h1>

        <p class="text-secondary mb-5" style="font-size:14px; letter-spacing:1px;">
            Silakan buat password Anda
        </p>

        <!-- Success Message -->
        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show w-100 mb-4" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show w-100 mb-4" role="alert">
                <?php foreach ($errors as $error): ?>
                    <div>• <?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Form -->
       <form action="../actions/proses_reset_password.php" method="POST">

            <!-- Email -->
            <div class="mb-4">
                <input
                    type="email"
                    name="email"
                    class="form-control rounded-pill py-3 px-4 border-secondary-subtle bg-light"
                    placeholder="Email Address"
                    required
                >
            </div>

            <!-- Password Baru -->
            <div class="mb-4">
                <input
                    type="password"
                    name="password"
                    class="form-control rounded-pill py-3 px-4 border-secondary-subtle bg-light"
                    placeholder="Password Baru"
                    required
                >
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-5">
                <input
                    type="password"
                    name="confirm_password"
                    class="form-control rounded-pill py-3 px-4 border-secondary-subtle bg-light"
                    placeholder="Konfirmasi Password"
                    required
                >
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="btn btn-primary w-100 rounded-pill py-3 fw-semibold border
```
<button
    type="submit"
    class="btn btn-primary w-100 rounded-pill py-3 fw-semibold border-0"
    style="background-color:#4A7CF3;"
>
    Next
</button>