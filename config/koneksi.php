<?php
// Konfigurasi Database
$host     = 'localhost';
$db_name  = 'db_mua'; // Ganti dengan nama database kamu
$username = 'root';             // Default XAMPP biasanya root
$password = '';                 // Default XAMPP biasanya kosong

try {
    // Membuat koneksi menggunakan PDO
    // Mengatur charset ke utf8mb4 agar support karakter khusus/emoticon
    $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
    
    // Opsi tambahan untuk keamanan dan error handling
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Menampilkan error sebagai Exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Hasil fetch otomatis jadi array asosiatif
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Mematikan emulasi agar benar-benar pakai prepared statements asli
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    // Variabel $pdo ini yang bakal dipanggil di file action kamu nanti

} catch (PDOException $e) {
    // Jika koneksi gagal, hentikan proses dan tampilkan pesan error
    // Di tahap produksi (online), sebaiknya jangan tampilkan $e->getMessage() secara detail ke user
    die("Koneksi database gagal: " . $e->getMessage());
}
?>