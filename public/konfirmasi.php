<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$_SESSION['error_message'] = 'Pembayaran hanya bisa dilakukan lewat link di histori setelah admin mengonfirmasi booking Anda.';
header('Location: riwayat_pesanan.php');
exit;
?>
