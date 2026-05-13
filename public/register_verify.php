<?php
session_start();
if (!isset($_SESSION['reg_email'])) {
    header('Location: register.php?error=Silakan daftar terlebih dahulu');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { background-color: #eaf0ff; }
        .card-custom { border-radius: 20px; padding: 30px 20px; }
        .otp-input { width: 60px; height: 60px; text-align: center; font-size: 24px; border-radius: 10px; border: 1px solid #ccc; }
        .btn-custom { background: linear-gradient(90deg, #5a8dee, #3b6edc); border: none; border-radius: 30px; }
        .btn-custom:hover { background: linear-gradient(90deg, #3b6edc, #5a8dee); }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
        <div class="card card-custom shadow text-center">
            <div class="text-start mb-3">
                <a href="register.php" class="text-dark">
                    <i class="bi bi-arrow-left fs-4"></i>
                </a>
            </div>

            <div class="mb-3">
                <i class="bi bi-envelope-check" style="font-size: 60px; color: #4a7cf3;"></i>
            </div>

            <h4 class="fw-bold">Verifikasi Email</h4>
            <p class="text-muted small mb-4">
                Kode OTP sudah dikirim ke <strong><?php echo htmlspecialchars($_SESSION['reg_email']); ?></strong>.
            </p>

            <form id="verifyForm" action="../actions/proses_register_verify.php" method="POST">
                <div class="d-flex justify-content-center gap-2 mb-4">
                    <input type="text" name="otp1" maxlength="1" class="otp-input" required>
                    <input type="text" name="otp2" maxlength="1" class="otp-input" required>
                    <input type="text" name="otp3" maxlength="1" class="otp-input" required>
                    <input type="text" name="otp4" maxlength="1" class="otp-input" required>
                </div>

                <button id="verifyButton" type="submit" class="btn btn-custom text-white w-100 py-2">Verifikasi</button>
            </form>

            <p class="mt-3 small">
                Belum menerima email? <a href="register.php" class="text-danger">Daftar ulang</a>
            </p>
        </div>
    </div>
</div>

<?php if (isset($_GET['error'])): ?>
<script>
Swal.fire({ icon: 'error', title: 'Gagal', text: '<?php echo htmlspecialchars($_GET['error']); ?>' });
</script>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
<script>
Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?php echo htmlspecialchars($_GET['success']); ?>', timer: 2000, showConfirmButton: false });
</script>
<?php endif; ?>

<script>
const inputs = document.querySelectorAll('.otp-input');
inputs.forEach((input, index) => {
    input.addEventListener('input', () => {
        if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && input.value === '' && index > 0) {
            inputs[index - 1].focus();
        }
    });
});

const verifyForm = document.getElementById('verifyForm');
const verifyButton = document.getElementById('verifyButton');
if (verifyForm && verifyButton) {
    verifyForm.addEventListener('submit', function() {
        verifyButton.disabled = true;
        verifyButton.textContent = 'Mengirim...';
    });
}
</script>
</body>
</html>