<?php
session_start();


// Hapus semua data session
$_SESSION = [];

// Hancurkan session
session_destroy();

// (Opsional tapi bagus) hapus cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect ke login / dashboard
header("Location: ../index.php");
exit;