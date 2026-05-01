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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #000; color: #fff; height: 100vh; }
        .login-container { height: 100vh; }
        .login-form { padding: 10%; }
        .btn-purple { background-color: #a660c3; color: white; border-radius: 20px; }
        .btn-purple:hover { background-color: #8e4fa8; color: white; }
        .form-control { background-color: #1a1a1a; border: none; color: #fff; height: 45px; }
        .form-control:focus { background-color: #252525; color: #fff; box-shadow: none; border: 1px solid #a660c3; }
        .side-img { 
            background: url('../assets/bg_log.jpeg') center/cover no-repeat; 
            height: 100vh; 
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row login-container">
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="login-form w-75">
                <h1 class="fw-bold mb-1">Welcome</h1>
                <p class="text-secondary mb-4">please enter your details</p>
                
                <form action=" /project-mua-final/dasboard.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password</label>
                        <input type="password" name="pass" class="form-control" required>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label small" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="text-decoration-none text-secondary small">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-purple w-100 py-2 fw-bold">Login</button>
                </form>
                
                <p class="text-center mt-4 small text-secondary">
                    Don't have an account? <a href="register.php" class="text-purple text-decoration-none">Sign Up</a>
                </p>
            </div>
        </div>
        
        <div class="col-md-6 d-none d-md-block side-img">
            </div>
    </div>
</div>

</body>
</html>