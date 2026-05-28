<?php
// Handle register logic here
$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']      ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Semua field wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } else {
        // TODO: simpan ke database di sini
        $success = 'Akun berhasil dibuat! Silakan <a href="login.php">masuk</a>.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Started Now — Register</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brown-deep:   #3b1f0e;
            --brown-dark:   #5c2d0e;
            --brown-mid:    #8b4513;
            --brown-warm:   #a0522d;
            --brown-light:  #c8905a;
            --brown-pale:   #f5ede4;
            --brown-cream:  #fdf6ee;
            --brown-border: #d4a87a;
            --text-dark:    #2c1a0e;
            --text-muted:   #9b7b5e;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Lato', sans-serif;
            background: var(--brown-cream);
        }

        /* ── WRAPPER ── */
        .register-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 4rem;
            background: var(--brown-cream);
            position: relative;
            overflow: hidden;
        }

        /* Decorative blobs */
        .left-panel::before {
            content: '';
            position: absolute;
            top: -130px; left: -130px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(168,90,30,.07) 0%, transparent 70%);
            pointer-events: none;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -90px; right: -90px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(168,90,30,.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .form-card {
            width: 100%;
            max-width: 400px;
            z-index: 1;
        }

        /* Heading */
        .form-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -.5px;
            margin-bottom: 2.2rem;
        }

        /* Social buttons */
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: .65rem 1rem;
            border: 1.5px solid var(--brown-border);
            border-radius: 10px;
            background: #fff;
            cursor: pointer;
            font-size: 1.25rem;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .social-btn:hover {
            border-color: var(--brown-mid);
            background: var(--brown-pale);
            box-shadow: 0 2px 12px rgba(139,69,19,.12);
        }
        .social-btn .bi-google    { color: #DB4437; }
        .social-btn .bi-facebook  { color: #1877F2; }
        .social-btn .bi-apple     { color: var(--text-dark); }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: var(--text-muted);
            font-size: .85rem;
            margin: 1.5rem 0;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--brown-border);
            opacity: .6;
        }

        /* Input group */
        .input-group-custom {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--brown-border);
            border-radius: 10px;
            background: #fff;
            padding: .65rem 1rem;
            gap: .75rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-group-custom:focus-within {
            border-color: var(--brown-mid);
            box-shadow: 0 0 0 3px rgba(139,69,19,.13);
        }
        .input-group-custom .bi {
            color: var(--text-muted);
            font-size: 1rem;
            flex-shrink: 0;
        }
        .input-group-custom input {
            border: none;
            outline: none;
            flex: 1;
            font-size: .95rem;
            background: transparent;
            color: var(--text-dark);
            font-family: 'Lato', sans-serif;
        }
        .input-group-custom input::placeholder { color: #bda58d; }

        /* Toggle password */
        .toggle-pw {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 0;
            line-height: 1;
            transition: color .2s;
        }
        .toggle-pw:hover { color: var(--brown-mid); }

        /* Sign Up button */
        .btn-signup {
            width: 100%;
            padding: .85rem;
            border-radius: 50px;
            border: none;
            background: linear-gradient(135deg, var(--brown-dark) 0%, var(--brown-mid) 60%, var(--brown-light) 100%);
            color: #fff;
            font-family: 'Lato', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: .5px;
            cursor: pointer;
            transition: opacity .2s, box-shadow .2s, transform .1s;
            box-shadow: 0 4px 18px rgba(92,45,14,.30);
        }
        .btn-signup:hover {
            opacity: .93;
            box-shadow: 0 6px 24px rgba(92,45,14,.38);
            transform: translateY(-1px);
        }
        .btn-signup:active { transform: translateY(0); }

        /* Sign In link */
        .signin-text {
            font-size: .88rem;
            color: var(--text-muted);
        }
        .signin-text a {
            color: var(--brown-mid);
            font-weight: 700;
            text-decoration: none;
            transition: color .2s;
        }
        .signin-text a:hover { color: var(--brown-dark); }

        /* Alerts */
        .alert-brown-error {
            background: #fdf0e8;
            border: 1px solid #e8a87c;
            color: #7a3310;
            border-radius: 10px;
            padding: .65rem 1rem;
            font-size: .88rem;
        }
        .alert-brown-success {
            background: #eef7ee;
            border: 1px solid #7ec87e;
            color: #1e5c1e;
            border-radius: 10px;
            padding: .65rem 1rem;
            font-size: .88rem;
        }

        /* Password strength bar */
        .strength-bar-wrap {
            height: 4px;
            border-radius: 4px;
            background: #e8d5c0;
            margin-top: .4rem;
            overflow: hidden;
        }
        .strength-bar {
            height: 100%;
            border-radius: 4px;
            width: 0;
            transition: width .35s, background .35s;
        }
        .strength-label {
            font-size: .75rem;
            color: var(--text-muted);
            margin-top: .2rem;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            width: 50%;
            position: relative;
            overflow: hidden;
        }
        .right-panel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            filter: sepia(40%) contrast(1.05);
            transition: transform 8s ease;
        }
        .right-panel:hover img { transform: scale(1.04); }
        .right-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(59,31,14,.18) 0%, transparent 40%);
            pointer-events: none;
        }
        .brand-badge {
            position: absolute;
            bottom: 2rem; right: 2rem;
            background: rgba(59,31,14,.65);
            backdrop-filter: blur(8px);
            color: #f5ede4;
            padding: .5rem 1rem;
            border-radius: 50px;
            font-family: 'Playfair Display', serif;
            font-size: .85rem;
            letter-spacing: 1px;
            z-index: 2;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .right-panel { display: none; }
            .left-panel  { width: 100%; padding: 2rem 1.5rem; }
        }

        /* Fade-in animation */
        .form-card {
            animation: fadeUp .5s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="register-wrapper">

    <!-- ═══════════════ LEFT: FORM ═══════════════ -->
    <div class="left-panel">
        <div class="form-card">

            <h1>Get&nbsp;&nbsp;Started&nbsp;&nbsp;Now</h1>

            <!-- Alerts -->
            <?php if ($error): ?>
                <div class="alert-brown-error mb-3">
                    <i class="bi bi-exclamation-circle me-1"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert-brown-success mb-3">
                    <i class="bi bi-check-circle me-1"></i><?= $success ?>
                </div>
            <?php endif; ?>

            <!-- Social Login -->
            <div class="row g-2 mb-1">
                <div class="col-4">
                    <button type="button" class="social-btn" title="Daftar dengan Google">
                        <i class="bi bi-google"></i>
                    </button>
                </div>
                <div class="col-4">
                    <button type="button" class="social-btn" title="Daftar dengan Facebook">
                        <i class="bi bi-facebook"></i>
                    </button>
                </div>
                <div class="col-4">
                    <button type="button" class="social-btn" title="Daftar dengan Apple">
                        <i class="bi bi-apple"></i>
                    </button>
                </div>
            </div>

            <div class="divider">or</div>

            <!-- Form -->
            <form method="POST" action="">

                <!-- Username -->
                <div class="input-group-custom mb-3">
                    <i class="bi bi-person"></i>
                    <input
                        type="text"
                        name="username"
                        placeholder="User"
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                        autocomplete="username"
                        required
                    >
                </div>

                <!-- Email -->
                <div class="input-group-custom mb-3">
                    <i class="bi bi-envelope"></i>
                    <input
                        type="email"
                        name="email"
                        placeholder="Email"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        autocomplete="email"
                        required
                    >
                </div>

                <!-- Password -->
                <div class="input-group-custom mb-1" id="pwGroup">
                    <i class="bi bi-lock"></i>
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        placeholder="Password"
                        autocomplete="new-password"
                        oninput="checkStrength(this.value)"
                        required
                    >
                    <button type="button" class="toggle-pw" onclick="togglePassword()" title="Show/hide password">
                        <i class="bi bi-eye-slash" id="pwIcon"></i>
                    </button>
                </div>

                <!-- Password strength -->
                <div class="strength-bar-wrap mb-1">
                    <div class="strength-bar" id="strengthBar"></div>
                </div>
                <p class="strength-label mb-4" id="strengthLabel">&nbsp;</p>

                <!-- Submit -->
                <button type="submit" class="btn-signup mb-4">
                    Sign Up
                </button>

                <!-- Sign In -->
                <p class="text-center signin-text mb-0">
                    Already Account&nbsp;
                    <a href="login.php">Sign In</a>
                </p>

            </form>

        </div><!-- /.form-card -->
    </div><!-- /.left-panel -->

    <!-- ═══════════════ RIGHT: PHOTO ═══════════════ -->
    <div class="right-panel">
        <!--
            Ganti src dengan path foto lokal Anda.
            Contoh: src="assets/images/bridal.jpg"
        -->
        <img
           src="<?= '/project-mua-final/assets/foto_profile.jpeg' ?>"
    alt="Bridal makeup"
>
        <span class="brand-badge">✦ Beauty Studio</span>
    </div>

</div><!-- /.register-wrapper -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    /* ── Toggle password visibility ── */
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon  = document.getElementById('pwIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    }

    /* ── Password strength checker ── */
    function checkStrength(val) {
        const bar   = document.getElementById('strengthBar');
        const label = document.getElementById('strengthLabel');
        let score = 0;
        if (val.length >= 6)                          score++;
        if (val.length >= 10)                         score++;
        if (/[A-Z]/.test(val) && /[a-z]/.test(val))  score++;
        if (/[0-9]/.test(val))                        score++;
        if (/[^A-Za-z0-9]/.test(val))                 score++;

        const levels = [
            { width: '0%',   color: 'transparent',  text: '' },
            { width: '25%',  color: '#e74c3c',       text: 'Lemah' },
            { width: '50%',  color: '#e67e22',       text: 'Sedang' },
            { width: '75%',  color: '#f1c40f',       text: 'Kuat' },
            { width: '90%',  color: '#27ae60',       text: 'Sangat Kuat' },
            { width: '100%', color: '#1e8449',       text: 'Sempurna 🎉' },
        ];
        const lvl = val.length === 0 ? levels[0] : levels[Math.min(score, 5)];
        bar.style.width      = lvl.width;
        bar.style.background = lvl.color;
        label.textContent    = lvl.text;
    }
</script>

</body>
</html>