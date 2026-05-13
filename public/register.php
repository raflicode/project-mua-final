<?php
ini_set('session.cookie_path', '/');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Project MUA</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins',sans-serif;

            background:
            linear-gradient(
            135deg,
            #8a9e8e,
            #748678
            );
        }

        a{
            text-decoration:none;
        }

        
        /* =====================================================
           INPUT
        ===================================================== */
        .field-label{
            display:block;

            margin-bottom:6px;

            font-size:.74rem;
            font-weight:500;

            color:#666;
        }

        .field-input{
            width:100%;
            height:40px;

            border:none;
            outline:none;

            border-radius:12px;

            background:#ececec;

            border:1px solid #ddd;

            padding:0 14px;

            font-size:.82rem;

            transition:all .25s ease;
        }

        .field-input:focus{
            background:#fff;

            border-color:#a660c3;

            box-shadow:
            0 0 0 4px rgba(166,96,195,.12);
        }

        .field-input::placeholder{
            color:#bbb;
        }

        .mb-field{
            margin-bottom:14px;
        }

        .password-wrap{
            position:relative;
        }

        .password-wrap .field-input{
            padding-right:44px;
        }

        .toggle-password{
            position:absolute;
            top:50%;
            right:12px;
            transform:translateY(-50%);

            width:30px;
            height:30px;

            border:none;
            background:transparent;

            color:#777;
            cursor:pointer;
        }

        .toggle-password:hover{
            color:#a660c3;
        }

        /* =====================================================
           BUTTON REGISTER
        ===================================================== */
        .btn-submit{
            width:100%;
            height:44px;

            border:none;
            border-radius:999px;

            background:
            linear-gradient(
            135deg,
            #9d5bd2,
            #c85ab0
            );

            color:#fff;

            font-size:.86rem;
            font-weight:600;

            letter-spacing:.04em;

            cursor:pointer;

            box-shadow:
            0 10px 22px rgba(157,91,210,.35);

            transition:all .25s ease;
        }

        .btn-submit:hover{
            transform:translateY(-2px);

            box-shadow:
            0 14px 30px rgba(157,91,210,.45);
        }

        /* =====================================================
           FOOTER
        ===================================================== */
        .footer-txt{
            margin-top:18px;

            text-align:center;

            font-size:.74rem;

            color:#888;
        }

        .footer-txt a{
            color:#9d5bd2;
            font-weight:600;
        }

        .footer-txt a:hover{
            text-decoration:underline;
        }

       /* =====================================================
   MOBILE
===================================================== */
@media (max-width:767px){

    body{
        display:flex;
        justify-content:center;
        align-items:flex-start;

        padding:24px 16px 40px;
    }

    .login-card{
        width:100%;
        max-width:400px;

        border-radius:34px;

        background:#fff;

        overflow:hidden;

        box-shadow:
        0 20px 60px rgba(0,0,0,.22);
    }

   /* HERO */
.hero-section{
    position:relative;

    /* FOTO PANJANG */
    height:560px;

    overflow:hidden;

    border-radius:
    30px
    30px
    100px
    100px;
}

    .hero-bg{
        width:100%;
        height:100%;

        background:
        url('../assets/foto_profile.jpeg')
        center top / cover no-repeat;

        filter:
        grayscale(100%)
        brightness(.92);

        transform:scale(1.02);
    }

    .hero-section::after{
        content:'';

        position:absolute;
        inset:0;

        background:
        linear-gradient(
        to bottom,
        rgba(0,0,0,.08),
        rgba(0,0,0,.58)
        );
    }

    .hero-text{
    position:absolute;
    inset:0;

    z-index:2;

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;

    text-align:center;

    padding:20px;

    /* NAIKIN TEXT */
    transform:translateY(-150px);
}

    .hero-text h1{
        color:#fff;

        font-size:2.2rem;
        font-weight:700;

        margin-bottom:2px;
    }

    .hero-text p{
        color:rgba(255,255,255,.86);

        font-size:.82rem;
    }

    /* SPACE PUTIH */
    .hero-space{
        height:38px;
        background:#fff;
    }

    /* FORM FLOATING */
   .form-card{
    position:relative;
    z-index:20;

    width:72%;

    /* FORM DINAIKIN */
    margin:-310px auto 30px;

        padding:22px 18px 20px;

        border-radius:28px;

        background:
        rgba(255,255,255,.84);

        backdrop-filter:blur(22px);
        -webkit-backdrop-filter:blur(22px);

        border:1px solid rgba(255,255,255,.5);

        box-shadow:
        0 25px 50px rgba(0,0,0,.12);
    }

    /* BUTTON SOSMED */
    .btn-social{
        height:36px;
        border-radius:11px;
        font-size:.82rem;
    }

    /* INPUT */
    .field-input{
        height:38px;
        font-size:.8rem;
        border-radius:10px;
    }

    /* BUTTON LOGIN / REGISTER */
    .btn-submit{
        height:40px;
        font-size:.82rem;
    }

    .desktop-only{
        display:none !important;
    }
}

        /* =====================================================
           TABLET & LAPTOP
        ===================================================== */
        @media (min-width:768px){

            body{
                min-height:100vh;
                background:#fff;
            }

            .login-card{
                display:flex;
                width:100%;
                min-height:100vh;
            }

            /* FORM AREA */
            .form-col{
                flex:1;

                background:#fff;

                display:flex;
                align-items:center;
                justify-content:center;

                padding:60px 40px;
            }

            .desktop-wrapper{
                width:100%;
                max-width:430px;
            }

            /* TITLE */
            .desktop-title{
                margin-bottom:24px;
            }

            .desktop-title h1{
                color:#222;

                font-size:2.4rem;
                font-weight:700;

                margin-bottom:8px;
            }

            .desktop-title p{
                color:#777;
                font-size:.9rem;
            }

            /* CARD */
            .form-card{
                width:100%;

                background:#f3f3f3;

                padding:28px 24px;

                border-radius:30px;

                border:1px solid #e7e7e7;

                box-shadow:
                0 15px 35px rgba(0,0,0,.06);
            }

            /* INPUT */
            .field-input{
                background:#e7e7e7;

                border:1px solid #dcdcdc;

                color:#333;
            }

            .field-input:focus{
                background:#fff;
            }

            .field-label{
                color:#666;
            }

            /* FOTO */
            .photo-col{
                flex:1;

                background:
                url('../assets/foto_profile.jpeg')
                center/cover no-repeat;

                filter:grayscale(100%);

                position:relative;
            }

            .photo-col::after{
                content:'';

                position:absolute;
                inset:0;

                background:
                linear-gradient(
                to bottom,
                rgba(0,0,0,.08),
                rgba(0,0,0,.35)
                );
            }

            /* HIDE MOBILE */
            .hero-section,
            .hero-space{
                display:none;
            }
        }

    </style>
</head>

<body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ✅ NOTIF ERROR -->
<?php if (isset($_GET['error'])): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '<?php echo htmlspecialchars($_GET['error']); ?>'
});
</script>
<?php endif; ?>

<!-- ✅ NOTIF SUCCESS -->
<?php if (isset($_GET['success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '<?php echo htmlspecialchars($_GET['success']); ?>',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php endif; ?>

<script>
if (window.history.replaceState) {
    window.history.replaceState({}, document.title, window.location.pathname);
}
</script>
<div class="login-card">

    <!-- FORM -->
    <div class="form-col">

        <div class="desktop-wrapper">

            <!-- TITLE DESKTOP -->
            <div class="desktop-title desktop-only">
                <h1>Create Account</h1>
                <p>please fill your details</p>

            </div>

            <!-- HERO MOBILE -->
            <div class="hero-section">

                <div class="hero-bg"></div>

                <div class="hero-text">
                    <h1>Register</h1>
                    <p>join with us today</p>
                </div>

            </div>

            <div class="hero-space"></div>

            <!-- FORM CARD -->
            <div class="form-card">

        

                <!-- FORM -->
                <form action="../actions/proses_register.php" method="POST">

                    <div class="mb-field">

                        <label class="field-label">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="full_name"
                            class="field-input"
                            placeholder="Masukkan nama lengkap"
                            value="<?php echo isset($_GET['old_full_name']) ? htmlspecialchars($_GET['old_full_name']) : ''; ?>"
                            required
                        >

                    </div>

                    <div class="mb-field">

                        <label class="field-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="field-input"
                            placeholder="Masukkan email"
                            value="<?php echo isset($_GET['old_email']) ? htmlspecialchars($_GET['old_email']) : ''; ?>"
                            required
                        >

                    </div>

                    <div class="mb-field">

                        <label class="field-label">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            class="field-input"
                            placeholder="Masukkan username"
                            value="<?php echo isset($_GET['old_username']) ? htmlspecialchars($_GET['old_username']) : ''; ?>"
                            required
                        >

                    </div>

                    <div class="mb-field">

                        <label class="field-label">
                            Password
                        </label>

                        <div class="password-wrap">
                        <input
                            type="password"
                            name="password"
                            id="registerPassword"
                            class="field-input"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="toggle-password" data-toggle-password="registerPassword" aria-label="Lihat password">
                            <i class="bi bi-eye"></i>
                        </button>
                        </div>

                    </div>

                    <button type="submit" class="btn-submit">
                        Register
                    </button>

                </form>

                <div class="footer-txt">

                    Sudah punya akun?

                    <a href="login.php">
                        Login
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- FOTO -->
    <div class="photo-col desktop-only"></div>

</div>

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
</body>
</html>
