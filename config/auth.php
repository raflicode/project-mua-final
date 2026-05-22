<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('app_base_path')) {
    function app_base_path(): string {
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        foreach (['/admin/', '/public/', '/actions/', '/config/'] as $segment) {
            $pos = strpos($script, $segment);
            if ($pos !== false) {
                return rtrim(substr($script, 0, $pos), '/');
            }
        }

        $dir = str_replace('\\', '/', dirname($script));
        return $dir === '/' ? '' : rtrim($dir, '/');
    }
}

if (!function_exists('app_url')) {
    function app_url(string $path): string {
        return app_base_path() . '/' . ltrim($path, '/');
    }
}

if (!function_exists('normalize_role')) {
    function normalize_role(?string $role): string {
        return strtolower(trim((string) $role));
    }
}

if (!function_exists('dashboard_path_for_role')) {
    function dashboard_path_for_role(?string $role): string {
        return normalize_role($role) === 'admin'
            ? 'admin/public/dashboard.php'
            : 'index.php';
    }
}

if (!function_exists('redirect_to_role_home')) {
    function redirect_to_role_home(?string $role, string $message = ''): void {
        $target = app_url(dashboard_path_for_role($role));
        if ($message !== '') {
            $target .= '?success=' . urlencode($message);
        }

        header('Location: ' . $target);
        exit;
    }
}

if (!function_exists('require_login')) {
    function require_login(array $allowedRoles = []): void {
        if (empty($_SESSION['id_user'])) {
            header('Location: ' . app_url('public/login.php?error=' . urlencode('Silakan login terlebih dahulu')));
            exit;
        }

        if ($allowedRoles === []) {
            return;
        }

        $role = normalize_role($_SESSION['role'] ?? '');
        $allowedRoles = array_map('normalize_role', $allowedRoles);

        if (!in_array($role, $allowedRoles, true)) {
            redirect_to_role_home($role, 'Akses disesuaikan dengan role akun Anda');
        }
    }
}

if (!function_exists('logout_user')) {
    function logout_user(string $redirectPath = 'public/login.php'): void {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        setcookie('remember_me', '', time() - 3600, '/', '', false, true);
        session_destroy();

        header('Location: ' . app_url($redirectPath));
        exit;
    }
}
