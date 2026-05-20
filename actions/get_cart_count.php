<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_user'])) {
    echo json_encode(['cart_count' => 0, 'items' => []]);
    exit();
}

function getCartImagePath(array $item): string
{
    if (!empty($item['foto'])) {
        return $item['foto'];
    }

    $name = strtolower($item['nama_layanan'] ?? '');
    $type = strtolower($item['tipe_layanan'] ?? '');

    if ($type === 'kostum') {
        if (str_contains($name, 'graduation')) {
            return '../assets/fotograduation.jpeg';
        }
        if (str_contains($name, 'pahlawan')) {
            return '../assets/fotopahlawan.jpeg';
        }
        if (str_contains($name, 'wedding')) {
            return '../assets/fotokostum6.jpeg.png';
        }
        if (str_contains($name, 'baju adat jawa')) {
            return '../assets/fotokostum4.jpeg';
        }
        if (str_contains($name, 'baju adat sunda')) {
            return '../assets/adatjawa.jpeg';
        }
        if (str_contains($name, 'baju adat bali')) {
            return '../assets/fotokostum5.jpeg';
        }
        if (str_contains($name, 'baju adat madura')) {
            return '../assets/adatmadura.jpeg';
        }
        if (str_contains($name, 'baju adat') || str_contains($name, 'kostum')) {
            return '../assets/fotokostum3.jpeg.jpg';
        }
    }

    if ($type === 'makeup') {
        return '../assets/foto_makeup.jpeg';
    }

    if ($type === 'dekor') {
        return '../assets/foto_dekor.jpeg';
    }

    return '../assets/fotokostum1.jpeg';
}

try {
    $stmt = $pdo->prepare("SELECT SUM(kuantitas) as total FROM keranjang WHERE id_user = ?");
    $stmt->execute([$_SESSION['id_user']]);
    $result = $stmt->fetch();
    $cart_count = $result['total'] ?? 0;

    $itemStmt = $pdo->prepare("
        SELECT id_keranjang, nama_layanan, tipe_layanan, foto, harga, kuantitas
        FROM keranjang
        WHERE id_user = ?
        ORDER BY created_at DESC
        LIMIT 5
    ");
    $itemStmt->execute([$_SESSION['id_user']]);
    $items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($items as &$item) {
        $item['foto'] = getCartImagePath($item);
        $item['qty'] = (int) $item['kuantitas'];
        $item['harga'] = (float) $item['harga'];
    }
    unset($item);

    echo json_encode([
        'cart_count' => (int)$cart_count,
        'items' => $items
    ]);
} catch (Exception $e) {
    echo json_encode(['cart_count' => 0, 'items' => []]);
}
?>
