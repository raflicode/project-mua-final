<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Yayuk Makeover</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #e9e9e9;
        }

        .left-panel {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-box {
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
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ccc;
        }

        .divider span {
            margin: 0 10px;
            color: #888;
            font-size: 12px;
        }

        .form-control {
            border-radius: 8px;
        }

        .input-group-text {
            background: #fff;
        }

        .btn-primary {
            border-radius: 25px;
            background: #0d4c7d;
            border: none;
        }

        .btn-primary:hover {
            background: #0b3d64;
        }

        .right-panel {
            background: url('wedding.jpeg.jpeg') center center / cover no-repeat;
            min-height: 100vh;
            filter: grayscale(100%);
        }

        @media(max-width: 768px) {
            .right-panel {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- LEFT -->
        <div class="col-md-6 left-panel">
            <div class="form-box text-center">

                <h2 class="mb-4">Get Started Now</h2>

                <!-- Social -->
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
                <div class="divider"><span>or</span></div>

                <!-- FORM -->
                <form method="POST">

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-user text-primary"></i></span>
                        <input type="text" name="user" class="form-control" placeholder="User" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-envelope text-primary"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa fa-key text-primary"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <span class="input-group-text"><i class="fa fa-eye-slash"></i></span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>

                <p class="mt-3">
                    Already Account
                    <a href="login.php">Sign In</a>
                </p>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $user = $_POST['user'];
                    $email = $_POST['email'];
                    $pass = $_POST['password'];

                    echo "<div class='alert alert-success mt-3'>
                            Data berhasil dikirim!<br>
                            User: $user<br>
                            Email: $email
                          </div>";
                }
                ?>

            </div>
        </div>

        <!-- RIGHT IMAGE -->
        <div class="col-md-6 right-panel"></div>

    </div>
</div>

</body>
</html>