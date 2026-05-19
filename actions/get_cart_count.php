<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_user'])) {
    echo json_encode(['cart_count' => 0]);
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT SUM(kuantitas) as total FROM keranjang WHERE id_user = ?");
    $stmt->execute([$_SESSION['id_user']]);
    $result = $stmt->fetch();
    $cart_count = $result['total'] ?? 0;

    echo json_encode(['cart_count' => (int)$cart_count]);
} catch (Exception $e) {
    echo json_encode(['cart_count' => 0]);
}
?>