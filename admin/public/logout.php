<?php
require_once __DIR__ . '/../../config/auth.php';

logout_user('public/login.php?success=' . urlencode('Logout berhasil'));
