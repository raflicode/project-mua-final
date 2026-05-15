<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

header('Content-Type: application/json');

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Silakan login terlebih dahulu'
    ]);
    exit();
}

// Validasi POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
    exit();
}

$id_user = $_SESSION['id_user'];
$id_keranjang = intval($_POST['id_keranjang'] ?? 0);

// Validasi input
if ($id_keranjang <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'ID keranjang tidak valid'
    ]);
    exit();
}

try {
    // Cek apakah item milik user yang login
    $stmt_check = $pdo->prepare("SELECT id_keranjang FROM keranjang WHERE id_keranjang = ? AND id_user = ?");
    $stmt_check->execute([$id_keranjang, $id_user]);
    $item = $stmt_check->fetch();

    if (!$item) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Item tidak ditemukan'
        ]);
        exit();
    }

    // Delete item
    $stmt_delete = $pdo->prepare("DELETE FROM keranjang WHERE id_keranjang = ?");
    $stmt_delete->execute([$id_keranjang]);

    // Get total cart count
    $stmt_count = $pdo->prepare("SELECT SUM(kuantitas) as total FROM keranjang WHERE id_user = ?");
    $stmt_count->execute([$id_user]);
    $cart_count = $stmt_count->fetch()['total'] ?? 0;

    echo json_encode([
        'success' => true,
        'message' => 'Item dihapus dari keranjang',
        'cart_count' => $cart_count
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>
