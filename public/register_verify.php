<?php
require_once __DIR__ . '/../config/koneksi.php';
include __DIR__ . '/../actions/proses_register_verify.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background:
                linear-gradient(135deg, rgba(248, 239, 224, .94), rgba(242, 229, 213, .96)),
                url('../assets/foto_profile.jpeg') center/cover no-repeat;
            color: #2b2520;
        }

        .card-custom {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(181, 131, 90, .18);
            border-radius: 28px;
            padding: 30px 24px;
            background: rgba(255, 255, 255, .9);
            box-shadow: 0 24px 70px rgba(86, 65, 45, .18);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #7b5d3f;
            background: #f7efe6;
            transition: all .2s ease;
        }

        .back-link:hover {
            color: #5e452f;
            background: #ead8c6;
        }

        .otp-badge {
            width: 74px;
            height: 74px;
            margin: 0 auto 18px;
            display: grid;
            place-items: center;
            border-radius: 24px;
            color: #7b5d3f;
            background: linear-gradient(145deg, #fff7ef, #ead8c6);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8), 0 16px 28px rgba(123, 93, 63, .18);
        }

        .otp-badge i {
            font-size: 38px;
        }

        .otp-copy {
            max-width: 320px;
            margin-inline: auto;
            line-height: 1.7;
        }

        .otp-copy strong {
            color: #7b5d3f;
            font-weight: 600;
        }

        .otp-group {
            gap: 10px;
        }

        .otp-input {
            width: 58px;
            height: 64px;
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            color: #2b2520;
            border-radius: 18px;
            border: 1px solid #dfcbb8;
            background: #fbf7f2;
            outline: none;
            transition: all .2s ease;
        }

        .otp-input:focus {
            border-color: #a58459;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(181, 131, 90, .18);
            transform: translateY(-1px);
        }

        .btn-custom {
            background: linear-gradient(135deg, #a58459, #7b5d3f);
            border: none;
            border-radius: 999px;
            font-weight: 600;
            box-shadow: 0 12px 24px rgba(123, 93, 63, .24);
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #94744d, #684d34);
        }

        .btn-custom:disabled {
            opacity: .75;
            box-shadow: none;
        }

        .helper-text {
            min-height: 20px;
            color: #8a7868;
        }

        .resend-link {
            color: #7b5d3f;
            font-weight: 600;
            text-decoration: none;
        }

        .resend-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 380px) {
            .card-custom {
                padding-inline: 18px;
            }

            .otp-input {
                width: 50px;
                height: 58px;
                font-size: 23px;
                border-radius: 16px;
            }
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
        <div class="card card-custom shadow text-center">
            <div class="text-start mb-3">
                <a href="<?= BASE_PATH; ?>/public/register.php" class="back-link" aria-label="Kembali">
                    <i class="bi bi-arrow-left fs-5"></i>
                </a>
            </div>

            <div class="otp-badge">
                <i class="bi bi-envelope-check"></i>
            </div>

            <h4 class="fw-bold">Verifikasi Email</h4>
            <p class="text-muted small mb-4 otp-copy">
                Kode OTP sudah dikirim ke <strong><?php echo getRegisterVerifyEmail(); ?></strong>. Verifikasi berjalan otomatis setelah kode lengkap.
            </p>

            <form id="verifyForm" action="<?= BASE_PATH; ?>/actions/proses_register_verify.php" method="POST">
                <div class="d-flex justify-content-center otp-group mb-3">
                    <input type="text" name="otp1" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" aria-label="Digit OTP 1" required>
                    <input type="text" name="otp2" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" aria-label="Digit OTP 2" required>
                    <input type="text" name="otp3" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" aria-label="Digit OTP 3" required>
                    <input type="text" name="otp4" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" aria-label="Digit OTP 4" required>
                </div>
                <p id="otpStatus" class="helper-text small mb-4">Kode akan dicek otomatis.</p>

                <button id="verifyButton" type="submit" class="btn btn-custom text-white w-100 py-2">Verifikasi</button>
            </form>

            <p class="mt-3 small">
                Belum menerima email? <a href="<?= BASE_PATH; ?>/public/register.php" class="resend-link">Daftar ulang</a>
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
const inputs = Array.from(document.querySelectorAll('.otp-input'));
const otpStatus = document.getElementById('otpStatus');
let isSubmitting = false;

function getOtpCode() {
    return inputs.map((input) => input.value).join('');
}

function submitWhenComplete() {
    if (isSubmitting || getOtpCode().length !== inputs.length) return;

    isSubmitting = true;
    otpStatus.textContent = 'Kode lengkap, sedang memverifikasi...';
    verifyButton.disabled = true;
    verifyButton.textContent = 'Memverifikasi...';
    verifyForm.submit();
}

inputs.forEach((input, index) => {
    input.addEventListener('focus', () => input.select());

    input.addEventListener('input', () => {
        input.value = input.value.replace(/\D/g, '').slice(0, 1);

        if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }

        submitWhenComplete();
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && input.value === '' && index > 0) {
            inputs[index - 1].focus();
        }
    });

    input.addEventListener('paste', (e) => {
        e.preventDefault();
        const pastedCode = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, inputs.length);

        pastedCode.split('').forEach((digit, digitIndex) => {
            inputs[digitIndex].value = digit;
        });

        const nextInput = inputs[Math.min(pastedCode.length, inputs.length - 1)];
        nextInput.focus();
        submitWhenComplete();
    });
});

const verifyForm = document.getElementById('verifyForm');
const verifyButton = document.getElementById('verifyButton');
if (verifyForm && verifyButton) {
    verifyForm.addEventListener('submit', function() {
        isSubmitting = true;
        otpStatus.textContent = 'Sedang memverifikasi...';
        verifyButton.disabled = true;
        verifyButton.textContent = 'Memverifikasi...';
    });
}
</script>
</body>
</html>
