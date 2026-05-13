
<?php
session_start();
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

        <!-- Form -->
       <form action="login.php" method="POST">

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
                    name="password_baru"
                    class="form-control rounded-pill py-3 px-4 border-secondary-subtle bg-light"
                    placeholder="Password Baru"
                    required
                >
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-5">
                <input
                    type="password"
                    name="konfirmasi_password"
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