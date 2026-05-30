<?php
// Tentukan Base Path secara Dinamis
if (!defined('BASE_PATH')) {
    if (strpos($_SERVER['SCRIPT_NAME'], '/project-mua-final/') !== false) {
        define('BASE_PATH', '/project-mua-final');
    } else {
        define('BASE_PATH', '');
    }
}

// Konfigurasi Database
$host = 'mif.myhost.id';
$db_name = 'mifmyho2_D5'; // Ganti dengan nama database kamu
$username = 'mifmyho2_D5';             // Default XAMPP biasanya root
$password = '@MIF2025';        // Default XAMPP biasanya kosong

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