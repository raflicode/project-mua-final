<?php

ini_set('session.cookie_path', '/');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Project MUA</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

        /* =====================================================
           REMEMBER
        ===================================================== */
        .row-bottom{
            display:flex;
            justify-content:space-between;
            align-items:center;

            margin:14px 0 22px;
        }

        .chk-wrap{
            display:flex;
            align-items:center;
            gap:7px;
        }

        .chk-wrap input{
            accent-color:#a660c3;
            cursor:pointer;
        }

        .chk-wrap label{
            font-size:.74rem;
            color:#777;
            cursor:pointer;
        }

        .forgot{
            font-size:.74rem;
            color:#a660c3;
        }

        .forgot:hover{
            text-decoration:underline;
        }

        /* =====================================================
           BUTTON LOGIN
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

                height:440px;

                overflow:hidden;

                border-radius:
                30px
                30px
                90px
                90px;
                
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

                transform:scale(1);
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
                transform:translateY(-120px);
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
                height:36px;
                background:#fff;
            }

            /* FORM FLOATING */
            .form-card{
                position:relative;
                z-index:20;

                width:76%;

                margin:-90px auto 30px;

                padding:26px 20px;


                border-radius:28px;

                background:
                rgba(255,255,255,.84);

                backdrop-filter:blur(22px);
                -webkit-backdrop-filter:blur(22px);

                border:1px solid rgba(255,255,255,.5);

                box-shadow:
                0 25px 50px rgba(0,0,0,.12);
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

                padding:75px 24px;
                

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

            /* DIVIDER */
            .divider-or{
                color:#999;
            }

            .divider-or::before,
            .divider-or::after{
                background:#ddd;
            }

            /* REMEMBER */
            .chk-wrap label{
                color:#777;
            }

            /* FOOTER */
            .footer-txt{
                color:#777;
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

        /* =====================================================
           TABLET
        ===================================================== */
        @media (min-width:768px) and (max-width:991px){

            .form-col{
                padding:40px 28px;
            }

            .desktop-wrapper{
                max-width:390px;
            }

            .desktop-title h1{
                font-size:2rem;
            }

            .form-card{
                padding:24px 20px;
            }
        }

    </style>
</head>

<body>

<!-- ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_GET['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?php echo htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8'); ?>',
                timer: 2000,
                showConfirmButton: false,
                didOpen: () => {
                    if (window.history.replaceState) {
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                }
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '<?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>'
            });
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>


<div class="login-card">

    <!-- FORM -->
    <div class="form-col">

        <div class="desktop-wrapper">

            <!-- TITLE DESKTOP -->
            <div class="desktop-title desktop-only">
                <h1>Welcome</h1>
                <p>please enter your details</p>
            </div>

            <!-- HERO MOBILE -->
            <div class="hero-section">

                <div class="hero-bg"></div>

                <div class="hero-text">
                    <h1>Welcome</h1>
                    <p>get best experience now</p>
                </div>

            </div>

            <div class="hero-space"></div>

            <!-- FORM CARD -->
            <div class="form-card">


                <!-- FORM -->
                <form action="../actions/proses_login.php" method="POST" id="loginForm">

                    <div class="mb-field">

                        <label class="field-label">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            class="field-input"
                            placeholder="Masukkan username"
                            required
                        >

                    </div>

                    <div class="mb-field">

                        <label class="field-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="pass"
                            id="password"
                            class="field-input"
                            placeholder="••••••••"
                            required
                        >

                    </div>

                    <div class="row-bottom">

                        <div class="chk-wrap">

                            <input type="checkbox" id="remember">

                            <label for="remember">
                                Remember me
                            </label>

                        </div>

                        <a href="forgot.php" class="forgot">
                            Lupa kata sandi?
                        </a>

                    </div>

                    <button type="submit" class="btn-submit">
                        Login
                    </button>

                </form>

                <div class="footer-txt">

                    Belum punya akun?

                    <a href="register.php">
                        Sign Up
                    </a>

                </div>

            </div>

        </div>

    </div>


    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            if (password.length < 8) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Tidak Valid',
                    text: 'Password minimal 8 karakter.'
                });
            }
        });
    </script>
    
</body>
    <!-- FOTO DESKTOP -->
    <div class="photo-col desktop-only"></div>

</body>
</html>