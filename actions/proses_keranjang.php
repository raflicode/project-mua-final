<?php

function getCartImagePath(array $item): string {
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

function loadCartItems(): array {
    if (!isset($_SESSION['id_user'])) {
        return [];
    }

    require_once __DIR__ . '/../config/koneksi.php';
    $id_user = $_SESSION['id_user'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM keranjang WHERE id_user = ? ORDER BY created_at DESC");
        $stmt->execute([$id_user]);
        $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cart_items as &$item) {
            if (empty($item['foto'])) {
                $item['foto'] = getCartImagePath($item);
            }
        }
        unset($item);

        return $cart_items;
    } catch (Exception $e) {
        return [];
    }
}
