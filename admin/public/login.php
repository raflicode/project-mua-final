<?php
require_once __DIR__ . '/../../config/auth.php';

if (isset($_SESSION['id_user'])) {
    redirect_to_role_home($_SESSION['role'] ?? 'client');
}

header('Location: ' . app_url('public/login.php'));
exit;
