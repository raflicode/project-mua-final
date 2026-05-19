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
$kuantitas = intval($_POST['kuantitas'] ?? 1);

// Validasi input
if ($id_keranjang <= 0 || $kuantitas <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak valid'
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

    // Update kuantitas
    $stmt_update = $pdo->prepare("
        UPDATE keranjang 
        SET kuantitas = ?, updated_at = CURRENT_TIMESTAMP
        WHERE id_keranjang = ?
    ");
    $stmt_update->execute([$kuantitas, $id_keranjang]);

    echo json_encode([
        'success' => true,
        'message' => 'Kuantitas diperbarui'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>
