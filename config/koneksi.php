<?php
// Tentukan Base Path secara dinamis agar tidak bergantung pada nama folder lokal.
if (!defined('BASE_PATH')) {
    if (!function_exists('app_base_path')) {
        function app_base_path(): string
        {
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

    define('BASE_PATH', app_base_path());
}

// Konfigurasi Database
$host = 'localhost';
$db_name = 'db_mua'; // Ganti dengan nama database kamu
$username = 'root';             // Default XAMPP biasanya root
$password = 'root';        // Default XAMPP biasanya kosong

try {
    // Membuat koneksi menggunakan PDO
    // Mengatur charset ke utf8mb4 agar support karakter khusus/emoticon
    $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";

    // Opsi tambahan untuk keamanan dan error handling
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Menampilkan error sebagai Exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Hasil fetch otomatis jadi array asosiatif
        PDO::ATTR_EMULATE_PREPARES => false,                  // Mematikan emulasi agar benar-benar pakai prepared statements asli
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    if (!defined('AUTH_REMEMBER_SECRET')) {
        define('AUTH_REMEMBER_SECRET', 'mua-remember-secret-2026');
    }

    if (!function_exists('buildRememberToken')) {
        function buildRememberToken($userId, $passwordHash)
        {
            return hash_hmac('sha256', $userId . ':' . $passwordHash, AUTH_REMEMBER_SECRET);
        }
    }

    // Variabel $pdo ini yang bakal dipanggil di file action kamu nanti

} catch (PDOException $e) {
    // Jika koneksi gagal, hentikan proses dan tampilkan pesan error
    // Di tahap produksi (online), sebaiknya jangan tampilkan $e->getMessage() secara detail ke user
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
