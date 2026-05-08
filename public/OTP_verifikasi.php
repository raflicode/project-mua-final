<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #eaf0ff;
        }
        .card-custom {
            border-radius: 20px;
            padding: 30px 20px;
        }
        .icon-lock {
            font-size: 60px;
            color: #4a7cf3;
        }
        .otp-input {
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        .btn-custom {
            background: linear-gradient(90deg, #5a8dee, #3b6edc);
            border: none;
            border-radius: 30px;
        }
        .btn-custom:hover {
            background: linear-gradient(90deg, #3b6edc, #5a8dee);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
        
        <div class="card shadow card-custom text-center">

            <!-- Back -->
            <div class="text-start mb-3">
                <a href="forgot-password.php" class="text-dark">
                    <i class="bi bi-arrow-left fs-4"></i>
                </a>
            </div>

            <!-- Icon -->
            <div class="mb-3">
                <i class="bi bi-shield-lock icon-lock"></i>
            </div>

            <!-- Title -->
            <h4 class="fw-bold">Masukkan Kode OTP</h4>
            <p class="text-muted small mb-4">
                Silakan masukkan kode verifikasi Anda
            </p>

            <!-- Form -->
            <form method="POST">
                <div class="d-flex justify-content-center gap-2 mb-4">
                    <input type="text" name="otp1" maxlength="1" class="otp-input" required>
                    <input type="text" name="otp2" maxlength="1" class="otp-input" required>
                    <input type="text" name="otp3" maxlength="1" class="otp-input" required>
                    <input type="text" name="otp4" maxlength="1" class="otp-input" required>
                </div>

                <button type="submit" class="btn btn-custom text-white w-100 py-2">
                    Next
                </button>
            </form>

            <!-- Resend -->
            <p class="mt-3 small">
                Tidak menerima OTP? 
                <a href="" class="text-danger">Kirim ulang</a>
            </p>

            <!-- PHP -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'];

                echo "<div class='alert alert-success mt-3'>
                        OTP yang dimasukkan: <b>$otp</b>
                      </div>";
            }
            ?>

        </div>
    </div>
</div>

<!-- Auto pindah input -->
<script>
    const inputs = document.querySelectorAll('.otp-input');

    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && input.value === "" && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
</script>

</body>
</html>