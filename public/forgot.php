<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background:
                linear-gradient(135deg, rgba(248, 239, 224, .94), rgba(242, 229, 213, .98)),
                url('../assets/foto_profile.jpeg') center/cover no-repeat;
            color: #2b2520;
        }

        a { text-decoration: none; }

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
            max-width: 460px;
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

        .form-title {
            margin: 8px 0 12px;
            font-size: clamp(1.8rem, 4vw, 2.45rem);
            font-weight: 700;
            color: #2b2520;
        }

        .form-copy {
            max-width: 430px;
            margin-bottom: 30px;
            color: #766b62;
            font-size: .94rem;
            line-height: 1.7;
        }

        .field-label {
            display: block;
            margin-bottom: 8px;
            color: #66584c;
            font-size: .82rem;
            font-weight: 600;
        }

        .field-input {
            width: 100%;
            height: 52px;
            border: 1px solid #dfcbb8;
            border-radius: 16px;
            outline: none;
            background: #fbf7f2;
            color: #2b2520;
            padding: 0 16px;
            font-size: .92rem;
            transition: all .2s ease;
        }

        .field-input:focus {
            border-color: #a58459;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(181, 131, 90, .16);
        }

        .btn-submit {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 999px;
            background: linear-gradient(135deg, #a58459, #7b5d3f);
            color: #fff;
            font-weight: 700;
            box-shadow: 0 14px 28px rgba(123, 93, 63, .24);
            transition: all .2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(123, 93, 63, .3);
        }

        .helper-note {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            color: #7d7065;
            font-size: .82rem;
            line-height: 1.6;
        }

        .helper-note i {
            color: #9a7550;
            margin-top: 2px;
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
    </style>
</head>
<body>

<main class="min-vh-100 d-flex align-items-center justify-content-center py-4">
    <section class="auth-shell">
        <div class="auth-visual">
            <div class="visual-content">
                <h1>Reset akses akun dengan aman.</h1>
                <p>Kami akan mengirim kode verifikasi ke email terdaftar sebelum Anda membuat kata sandi baru.</p>
            </div>
        </div>

        <div class="auth-panel">
            <div class="form-wrap">
                <a href="login.php" class="back-link">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke login
                </a>

                <div class="eyebrow">Lupa password</div>
                <h2 class="form-title">Kirim kode OTP</h2>
                <p class="form-copy">
                    Masukkan email akun Anda. Jika email terdaftar, kode OTP akan dikirim untuk melanjutkan reset password.
                </p>

                <form action="../actions/send_otp.php" method="POST">
                    <div class="mb-4">
                        <label for="email" class="field-label">Email terdaftar</label>
                        <input id="email" type="email" name="email" class="field-input" placeholder="nama@email.com" autocomplete="email" required>
                    </div>

                    <button type="submit" class="btn-submit">
                        Kirim Kode OTP
                    </button>
                </form>

                <div class="helper-note">
                    <i class="bi bi-shield-check"></i>
                    <span>Kode hanya berlaku sementara. Jangan bagikan kode OTP kepada siapa pun.</span>
                </div>
            </div>
        </div>
    </section>
</main>

</body>
</html>
