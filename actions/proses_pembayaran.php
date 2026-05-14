<?php
session_start();
require_once '../config/koneksi.php';

// Redirect jika bukan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/pembayaran.php');
    exit;
}

// Check login
if (!isset($_SESSION['id_user'])) {
    header('Location: ../public/login.php');
    exit;
}

// Sanitize dan validasi input
$nama = trim(filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING));
$hp = trim(filter_input(INPUT_POST, 'hp', FILTER_SANITIZE_STRING));
$metode = trim(filter_input(INPUT_POST, 'metode', FILTER_SANITIZE_STRING));
$alamat = trim(filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING));

// Validasi data
$errors = [];

// Validasi nama - hanya huruf dan spasi
if (empty($nama)) {
    $errors[] = 'Nama lengkap harus diisi';
} elseif (!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
    $errors[] = 'Nama hanya boleh mengandung huruf dan spasi';
}

// Validasi HP
if (empty($hp)) {
    $errors[] = 'No Handphone harus diisi';
} elseif (!preg_match('/^[0-9]+$/', $hp)) {
    $errors[] = 'No Handphone hanya boleh mengandung angka';
} elseif (strlen($hp) < 10 || strlen($hp) > 12) {
    $errors[] = 'No Handphone harus 10-12 digit';
}

// Validasi metode
if (empty($metode)) {
    $errors[] = 'Metode pembayaran harus dipilih';
}

// Validasi alamat
if (empty($alamat)) {
    $errors[] = 'Alamat/Catatan harus diisi';
}

// Jika ada error, kembali ke pembayaran
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = [
        'nama' => $nama,
        'hp' => $hp,
        'metode' => $metode,
        'alamat' => $alamat
    ];
    header('Location: ../public/pembayaran.php');
    exit;
}

// Simpan data ke session untuk halaman konfirmasi
$_SESSION['pembayaran'] = [
    'nama' => $nama,
    'hp' => $hp,
    'metode' => $metode,
    'alamat' => $alamat
];

// Redirect ke halaman konfirmasi
header('Location: ../public/konfirmasi.php');
exit;
?>
