<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>

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
        .password-wrap {
            position: relative;
        }
        .password-wrap .form-control {
            padding-right: 48px;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #6c757d;
            padding: 4px;
            line-height: 1;
            cursor: pointer;
        }
        .toggle-password:hover {
            color: #4a7cf3;
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
                <i class="bi bi-key icon-lock" style="font-size: 60px; color: #4a7cf3;"></i>
            </div>

            <!-- Title -->
            <h4 class="fw-bold">Reset Password</h4>
            <p class="text-muted small mb-4">
                Masukkan password baru Anda.
            </p>

            <!-- Error Message -->
            <?php
            if (isset($_GET['error'])) {
                echo "<div class='alert alert-danger'>" . htmlspecialchars($_GET['error']) . "</div>";
            }
            ?>

            <!-- Form -->
            <form action="../actions/proses_reset_password.php" method="POST">
                <div class="mb-3">
                    <div class="password-wrap">
                        <input type="password" name="password" id="newPassword" class="form-control" placeholder="Password Baru" required>
                        <button type="button" class="toggle-password" data-toggle-password="newPassword" aria-label="Lihat password baru">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="password-wrap">
                        <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Konfirmasi Password" required>
                        <button type="button" class="toggle-password" data-toggle-password="confirmPassword" aria-label="Lihat konfirmasi password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom text-white w-100 py-2">
                    Reset Password
                </button>
            </form>

                </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('[data-toggle-password]').forEach(function(button) {
    button.addEventListener('click', function() {
        const input = document.getElementById(this.dataset.togglePassword);
        const icon = this.querySelector('i');

        if (!input) return;

        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !isHidden);
        icon.classList.toggle('bi-eye-slash', isHidden);
        this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Lihat password');
    });
});
</script>
<?php if (isset($_GET['success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '<?php echo htmlspecialchars($_GET['success']); ?>',
    timer: 2000,
    showConfirmButton: false,
    didClose: () => {
        window.location.href = 'login.php';
    }
});

setTimeout(() => {
    window.location.href = 'login.php';
}, 2200);
</script>
<?php endif; ?>

</body>
</html>
