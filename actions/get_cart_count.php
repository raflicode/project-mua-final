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
    $name = strtolower($item['nama_layanan'] ?? '');
    $type = strtolower($item['tipe_layanan'] ?? '');

    if ($type === 'paket' || str_contains($name, 'paket')) {
        return '';
    }

    if (!empty($item['foto'])) {
        return $item['foto'];
    }

    $hasName = function (string $needle) use ($name): bool {
        return strpos($name, $needle) !== false;
    };

    if ($type === 'kostum') {
        if ($hasName('graduation')) {
            return '../assets/fotograduation.jpeg';
        }
        if ($hasName('pahlawan')) {
            return '../assets/fotopahlawan.jpeg';
        }
        if ($hasName('wedding')) {
            return '../assets/gallery_kostum/foto_resepsi.jpeg';
        }
        if ($hasName('baju adat jawa')) {
            return '../assets/gallery_kostum/kostum_4.jpeg';
        }
        if ($hasName('baju adat sunda')) {
            return '../assets/adatjawa.jpeg';
        }
        if ($hasName('baju adat bali')) {
            return '../assets/gallery_kostum/kostum_5.jpeg';
        }
        if ($hasName('baju adat madura')) {
            return '../assets/adatmadura.jpeg';
        }
        if ($hasName('baju adat') || $hasName('kostum')) {
            return '../assets/gallery_kostum/foto_carnaval.jpeg';
        }
    }

    if ($type === 'makeup') {
        return '../assets/foto_makeup.jpeg';
    }

    if ($type === 'dekor') {
        return '../assets/foto_dekor.jpeg';
    }

    return '../assets/gallery_kostum/kostum_4.jpeg';
}

function tableHasColumn(PDO $pdo, string $table, string $column): bool
{
    $stmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = ?
          AND COLUMN_NAME = ?
    ");
    $stmt->execute([$table, $column]);
    return (int) $stmt->fetchColumn() > 0;
}

try {
    $stmt = $pdo->prepare("SELECT SUM(kuantitas) as total FROM keranjang WHERE id_user = ?");
    $stmt->execute([$_SESSION['id_user']]);
    $result = $stmt->fetch();
    $cart_count = $result['total'] ?? 0;

    $fotoSelect = tableHasColumn($pdo, 'keranjang', 'foto') ? 'foto' : "NULL AS foto";
    $itemStmt = $pdo->prepare("
        SELECT id_keranjang, nama_layanan, tipe_layanan, {$fotoSelect}, harga, kuantitas
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
