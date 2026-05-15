<?php
session_start();
require_once '../config/koneksi.php';

// Check login
if (!isset($_SESSION['id_user'])) {
    header('Location: ../public/login.php');
    exit;
}

// Check jika ada data pembayaran
if (!isset($_SESSION['pembayaran'])) {
    header('Location: ../public/pembayaran.php');
    exit;
}

// Check method POST dan ada file
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['bukti_pembayaran'])) {
    header('Location: ../public/konfirmasi.php');
    exit;
}

$file = $_FILES['bukti_pembayaran'];
$errors = [];

// Validasi file
if ($file['error'] !== UPLOAD_ERR_OK) {
    $errors[] = 'Terjadi kesalahan saat upload file';
} else {
    // Validasi tipe file
    $allowedTypes = ['image/jpeg', 'image/png'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedTypes)) {
        $errors[] = 'Hanya file JPG/JPEG atau PNG yang diperbolehkan';
    }

    // Validasi ukuran file (max 5MB)
    if ($file['size'] > 5242880) {
        $errors[] = 'Ukuran file tidak boleh lebih dari 5MB';
    }
}

// Jika ada error
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../public/konfirmasi.php');
    exit;
}

// Create upload directory if not exists
$uploadDir = '../assets/bukti_pembayaran';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Generate unique filename
$extensionByMime = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
];
$ext = $extensionByMime[$mimeType] ?? strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$fileName = uniqid('bukti_') . '_' . $_SESSION['id_user'] . '.' . $ext;
$uploadPath = $uploadDir . '/' . $fileName;

// Move file
if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
    $_SESSION['errors'] = ['Gagal menyimpan file'];
    header('Location: ../public/konfirmasi.php');
    exit;
}

// Insert ke database
$pembayaran = $_SESSION['pembayaran'];
$id_user = $_SESSION['id_user'];
$status = 'pending';

try {
    $query = "INSERT INTO pembayaran (id_user, nama, hp, metode, alamat, bukti_pembayaran, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_user, $pembayaran['nama'], $pembayaran['hp'], $pembayaran['metode'], $pembayaran['alamat'], $fileName, $status]);

    unset($_SESSION['pembayaran']);

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $projectBase = preg_replace('#/actions$#', '', $scriptDir);
    $buktiUrl = $scheme . '://' . $host . $projectBase . '/assets/bukti_pembayaran/' . rawurlencode($fileName);

    $pesan = "Halo Admin, saya ingin konfirmasi pembayaran booking makeup.\n\n"
        . "Nama: {$pembayaran['nama']}\n"
        . "No HP: {$pembayaran['hp']}\n"
        . "Metode Pembayaran: {$pembayaran['metode']}\n"
        . "Link Bukti Pembayaran: {$buktiUrl}\n\n"
        . "Saya sudah transfer dan mengirim bukti pembayaran.";

    $wa_url = 'https://wa.me/6281217857682?' . http_build_query(['text' => $pesan]);

    header("Location: $wa_url");
    exit;


} catch (PDOException $e) {
    $_SESSION['errors'] = ['Terjadi kesalahan saat menyimpan data ke database'];
    header('Location: ../public/konfirmasi.php');
    exit;
}
?>
