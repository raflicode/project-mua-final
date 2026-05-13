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
            <form id="resetPasswordForm" action="../actions/proses_reset_password.php" method="POST">
                <div class="mb-3">
                    <input id="password" type="password" name="password" class="form-control" placeholder="Password Baru" required>
                </div>
                <div class="mb-3">
                    <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password" required>
                </div>
                <div class="form-check text-start mb-3">
                    <input class="form-check-input" type="checkbox" id="showPasswordCheckbox">
                    <label class="form-check-label" for="showPasswordCheckbox">Tampilkan password</label>
                </div>

                <button id="resetPasswordButton" type="submit" class="btn btn-custom text-white w-100 py-2">
                    Reset Password
                </button>
            </form>

                </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm_password');
    const showCheckbox = document.getElementById('showPasswordCheckbox');
    const form = document.getElementById('resetPasswordForm');
    const submitButton = document.getElementById('resetPasswordButton');

    if (showCheckbox) {
        showCheckbox.addEventListener('change', function() {
            const type = this.checked ? 'text' : 'password';
            if (passwordField) passwordField.type = type;
            if (confirmPasswordField) confirmPasswordField.type = type;
        });
    }

    if (form && submitButton) {
        form.addEventListener('submit', function(event) {
            const passwordValue = passwordField ? passwordField.value.trim() : '';
            if (passwordValue.length < 8) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password terlalu pendek',
                    text: 'Password harus minimal 8 karakter.',
                });
                return;
            }

            submitButton.disabled = true;
            submitButton.textContent = 'Mengirim...';
        });
    }
});
</script>

</body>
</html>