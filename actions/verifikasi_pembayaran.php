<?php
require_once __DIR__ . '/../config/auth.php';
require_login(['admin']);
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/db_helpers.php';

ensure_dynamic_booking_schema($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/public/dashboard.php#laporan-pembayaran');
    exit;
}

$idPembayaran = filter_input(INPUT_POST, 'id_pembayaran', FILTER_VALIDATE_INT);
$status = $_POST['status_verifikasi'] ?? '';
$allowedStatuses = ['diterima', 'ditolak'];

if (!$idPembayaran || !in_array($status, $allowedStatuses, true)) {
    header('Location: ../admin/public/dashboard.php?verify=invalid#laporan-pembayaran');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('
        SELECT p.id_booking, b.status_booking
        FROM pembayaran p
        INNER JOIN booking b ON b.id_booking = p.id_booking
        WHERE p.id_pembayaran = ?
        LIMIT 1
    ');
    $stmt->execute([$idPembayaran]);
    $payment = $stmt->fetch();

    if (!$payment) {
        throw new RuntimeException('Data pembayaran tidak ditemukan.');
    }

    $updatePayment = $pdo->prepare('UPDATE pembayaran SET status_verifikasi = ? WHERE id_pembayaran = ?');
    $updatePayment->execute([$status, $idPembayaran]);

    if ($status === 'diterima' && !in_array($payment['status_booking'], ['selesai', 'dibatalkan'], true)) {
        $updateBooking = $pdo->prepare('UPDATE booking SET status_booking = ? WHERE id_booking = ?');
        $updateBooking->execute(['selesai', $payment['id_booking']]);
    }

    $pdo->commit();

    $message = $status === 'diterima' ? 'accepted' : 'rejected';
    header('Location: ../admin/public/dashboard.php?verify=' . $message . '#laporan-pembayaran');
    exit;
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    header('Location: ../admin/public/dashboard.php?verify=failed#laporan-pembayaran');
    exit;
}
