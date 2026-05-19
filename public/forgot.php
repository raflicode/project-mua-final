<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: rgb(234, 240, 255);
        }
        .card-custom {
            border-radius: 20px;
            padding: 30px 20px;
        }
        .icon-lock {
            font-size: 60px;
            color: #4a7cf3;
        }
        .btn-custom {
            background: linear-gradient(90deg, #5a8dee, #3b6edc);
            border: none;
            border-radius: 30px;
        }
        .btn-custom:hover {
            background: linear-gradient(90deg, #3b6edc, #5a8dee);
        }
        .form-control {
            border-radius: 30px;
            padding: 12px 20px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
        
        <div class="card card-custom shadow text-center">
            
            <!-- Back Button -->
            <div class="text-start mb-3">
                <a href="login.php" class="text-dark">
                    <i class="bi bi-arrow-left fs-4"></i>
                </a>
            </div>

            <!-- Icon -->
            <div class="mb-3">
                <i class="bi bi-lock icon-lock"></i>
            </div>

            <!-- Title -->
            <h4 class="fw-bold">Lupa Kata Sandi?</h4>
            <p class="text-muted small mb-4">
                Silakan masukkan alamat email Anda untuk mengatur ulang kata sandi Anda.
            </p>

            <!-- Form -->
            <form action="../actions/send_otp.php" method="POST">
                <input type="email" name="email" class="form-control mb-4" placeholder="Masukkan email Anda" required>
                <button type="submit" class="btn btn-custom text-white w-100 py-2">Kirim Kode OTP</button>
            </form>
            
            <?php
            // Dihapus karena sekarang form mengirim langsung ke send_otp.php
            ?>

        </div>
    </div>
</div>

</body>
</html>