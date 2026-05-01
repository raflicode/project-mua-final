<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Yayuk Makeover</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #e9e9e9;
        }

        .login-container {
            min-height: 100vh;
        }

        .left-panel {
            background: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .social-btn {
            width: 70px;
            border-radius: 6px;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ccc;
        }

        .divider:not(:empty)::before {
            margin-right: .75em;
        }

        .divider:not(:empty)::after {
            margin-left: .75em;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-login {
            background: #0d4c7d;
            color: white;
            border-radius: 25px;
            padding: 10px;
        }

        .btn-login:hover {
            background: #0b3d64;
        }

        .right-panel {
            background: url('wedding.jpeg.jpeg') center center / cover no-repeat;
            min-height: 100vh;
            filter: grayscale(100%);
        }

        @media (max-width: 768px) {
            .right-panel {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row login-container">

        <!-- LEFT -->
        <div class="col-md-6 left-panel">
            <div class="login-box text-center">

                <h2 class="mb-5">Get Started Now</h2>

                <!-- Social Login -->
                <div class="d-flex justify-content-between mb-3">
                    <button class="btn btn-light social-btn">
                        <i class="fab fa-google text-danger"></i>
                    </button>
                    <button class="btn btn-light social-btn">
                        <i class="fab fa-facebook-f text-primary"></i>
                    </button>
                    <button class="btn btn-light social-btn">
                        <i class="fab fa-apple"></i>
                    </button>
                </div>

                <!-- Divider -->
                <div class="divider">or</div>

                <!-- Form -->
                <form method="POST">
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Admin" required>
                    </div>

                    <div class="mb-2 input-group">
                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <span class="input-group-text"><i class="fa fa-eye-slash"></i></span>
                    </div>

                    <div class="text-start mb-3">
                        <small><a href="#" class="text-muted">Forgot Password?</a></small>
                    </div>

                    <button type="submit" class="btn btn-login w-100">Log in</button>
                </form>

                <p class="mt-3">
                    Don’t have an account?
                    <a href="#">Sign Up</a>
                </p>

                <?php
                // Contoh login sederhana
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $user = $_POST['username'];
                    $pass = $_POST['password'];

                    if ($user == "admin" && $pass == "123") {
                        echo "<div class='alert alert-success mt-3'>Login berhasil!</div>";
                    } else {
                        echo "<div class='alert alert-danger mt-3'>Username / Password salah!</div>";
                    }
                }
                ?>

            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-md-6 right-panel"></div>

    </div>
</div>

</body>
</html>