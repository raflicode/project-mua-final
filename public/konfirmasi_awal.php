<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$_SESSION['error_message'] = 'Booking dikirim lewat halaman isi data. Silakan cek histori untuk status dan link pembayaran dari admin.';
header('Location: riwayat_pesanan.php');
exit;
?>
