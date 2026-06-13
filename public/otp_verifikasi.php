<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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

        a {
            text-decoration: none;
        }

        .auth-shell {
            width: min(1040px, calc(100% - 32px));
            min-height: 620px;
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            overflow: hidden;
            border: 1px solid rgba(181, 131, 90, .18);
            border-radius: 30px;
            background: rgba(255, 255, 255, .9);
            box-shadow: 0 28px 80px rgba(86, 65, 45, .18);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .auth-visual {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            min-height: 100%;
            padding: 34px;
            color: #fff;
            background: url('../assets/foto_profile.jpeg') center/cover no-repeat;
        }

        .auth-visual::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(48, 34, 24, .18), rgba(48, 34, 24, .72));
        }

        .visual-content {
            position: relative;
            z-index: 1;
        }

        .visual-content h1 {
            max-width: 420px;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            line-height: 1.12;
            margin-bottom: 12px;
        }

        .visual-content p {
            max-width: 430px;
            margin: 0;
            color: rgba(255, 255, 255, .84);
            line-height: 1.7;
            font-size: .94rem;
        }

        .auth-panel {
            display: flex;
            align-items: center;
            padding: clamp(28px, 5vw, 58px);
        }

        .form-wrap {
            width: 100%;
            max-width: 470px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 34px;
            color: #7b5d3f;
            font-size: .86rem;
            font-weight: 600;
        }

        .back-link i {
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f7efe6;
        }

        .eyebrow {
            color: #9a7550;
            font-size: .76rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
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

        .icon-lock {
            font-size: 38px;
        }

        .form-title {
            margin: 8px 0 12px;
            font-size: clamp(1.8rem, 4vw, 2.45rem);
            font-weight: 700;
            color: #2b2520;
        }

        .otp-copy {
            max-width: 430px;
            line-height: 1.7;
        }

        .otp-group {
            gap: 12px;
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

        @media (max-width: 820px) {
            .auth-shell {
                width: min(520px, calc(100% - 28px));
                min-height: auto;
                grid-template-columns: 1fr;
            }

            .auth-visual {
                min-height: 220px;
                padding: 26px;
            }

            .visual-content h1 {
                font-size: 2rem;
            }

            .auth-panel {
                padding: 28px 22px 32px;
            }

            .back-link {
                margin-bottom: 26px;
            }
        }

        @media (max-width: 380px) {
            .otp-group {
                gap: 8px;
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

<main class="min-vh-100 d-flex align-items-center justify-content-center py-4">
    <section class="auth-shell">
        <div class="auth-visual">
            <div class="visual-content">
                <h1>Cek email Anda untuk kode OTP.</h1>
                <p>Masukkan 4 digit kode verifikasi yang baru saja dikirim. Sistem akan membaca kode otomatis saat lengkap.</p>
            </div>
        </div>

        <div class="auth-panel">
            <div class="form-wrap">
                <a href="forgot.php" class="back-link">
                    <i class="bi bi-arrow-left"></i>
                    Ubah email
                </a>

                <div class="otp-badge">
                    <i class="bi bi-shield-lock icon-lock"></i>
                </div>

                <div class="eyebrow">Verifikasi keamanan</div>
                <h2 class="form-title">Masukkan kode OTP</h2>
                <p class="text-muted small mb-4 otp-copy">
                    Ketik atau paste kode OTP 4 digit dari email Anda. Setelah lengkap, verifikasi berjalan otomatis.
                </p>

                <form id="otpForm" method="POST" action="../actions/OTP_verifikasi.php">
                    <div class="d-flex otp-group mb-3">
                        <input type="text" name="otp1" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" aria-label="Digit OTP 1" required>
                        <input type="text" name="otp2" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" aria-label="Digit OTP 2" required>
                        <input type="text" name="otp3" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" aria-label="Digit OTP 3" required>
                        <input type="text" name="otp4" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" aria-label="Digit OTP 4" required>
                    </div>
                    <p id="otpStatus" class="helper-text small mb-4">Kode akan dicek otomatis.</p>

                    <button id="otpButton" type="submit" class="btn btn-custom text-white w-100 py-3">
                        Verifikasi Kode
                    </button>
                </form>

                <p class="mt-3 small">
                    Tidak menerima OTP?
                    <a href="forgot.php" class="resend-link">Kirim ulang</a>
                </p>
            </div>
        </div>
    </section>
</main>

<!-- Auto pindah input -->
<script>
    const otpForm = document.getElementById('otpForm');
    const otpButton = document.getElementById('otpButton');
    const otpStatus = document.getElementById('otpStatus');
    const inputs = Array.from(document.querySelectorAll('.otp-input'));
    let isSubmitting = false;

    function getOtpCode() {
        return inputs.map((input) => input.value).join('');
    }

    function submitWhenComplete() {
        if (isSubmitting || getOtpCode().length !== inputs.length) return;

        isSubmitting = true;
        otpStatus.textContent = 'Kode lengkap, sedang memverifikasi...';
        otpButton.disabled = true;
        otpButton.textContent = 'Memverifikasi...';
        otpForm.submit();
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
            if (e.key === "Backspace" && input.value === "" && index > 0) {
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

    otpForm.addEventListener('submit', () => {
        isSubmitting = true;
        otpStatus.textContent = 'Sedang memverifikasi...';
        otpButton.disabled = true;
        otpButton.textContent = 'Memverifikasi...';
    });
</script>

</body>
</html>
