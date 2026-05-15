<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_user'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Silakan login terlebih dahulu'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
    exit;
}

$cartIds = $_POST['id_keranjang'] ?? [];
if (!is_array($cartIds) || empty($cartIds)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Item keranjang tidak valid'
    ]);
    exit;
}

$cartIds = array_map('intval', $cartIds);
$cartIds = array_values(array_filter($cartIds, fn($id) => $id > 0));
if (empty($cartIds)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Item keranjang tidak valid'
    ]);
    exit;
}

$id_user = $_SESSION['id_user'];
$placeholders = implode(',', array_fill(0, count($cartIds), '?'));

try {
    $stmt = $pdo->prepare("SELECT * FROM keranjang WHERE id_user = ? AND id_keranjang IN ($placeholders)");
    $stmt->execute(array_merge([$id_user], $cartIds));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) !== count($cartIds)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Beberapa item tidak ditemukan atau bukan milik Anda'
        ]);
        exit;
    }

    $checkoutItems = [];
    $totalPrice = 0;

    foreach ($rows as $row) {
        $serviceId = null;
        $serviceStmt = $pdo->prepare('SELECT id_layanan FROM layanan WHERE nama_layanan = ? LIMIT 1');
        $serviceStmt->execute([$row['nama_layanan']]);
        $service = $serviceStmt->fetch(PDO::FETCH_ASSOC);
        if ($service) {
            $serviceId = $service['id_layanan'];
        }

        $itemTotal = floatval($row['harga']) * intval($row['kuantitas']);
        $totalPrice += $itemTotal;

        $checkoutItems[] = [
            'id_keranjang' => intval($row['id_keranjang']),
            'nama_layanan' => $row['nama_layanan'],
            'tipe_layanan' => $row['tipe_layanan'],
            'harga' => floatval($row['harga']),
            'kuantitas' => intval($row['kuantitas']),
            'item_total' => $itemTotal,
            'id_layanan' => $serviceId,
        ];
    }

    $_SESSION['checkout_booking'] = [
        'items' => $checkoutItems,
        'total_price' => $totalPrice,
        'cart_item_ids' => $cartIds,
    ];

    echo json_encode([
        'success' => true,
        'message' => 'Checkout berhasil',
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
    exit;
}
