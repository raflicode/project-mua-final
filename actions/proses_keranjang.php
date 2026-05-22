<?php
require_once __DIR__ . '/../config/koneksi.php';

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
            return '../assets/gallery_kostum/foto_resepsi.jpeg';
        }
        if (str_contains($name, 'baju adat jawa')) {
            return '../assets/gallery_kostum/kostum_4.jpeg';
        }
        if (str_contains($name, 'baju adat sunda')) {
            return '../assets/adatjawa.jpeg';
        }
        if (str_contains($name, 'baju adat bali')) {
            return '../assets/gallery_kostum/kostum_5.jpeg';
        }
        if (str_contains($name, 'baju adat madura')) {
            return '../assets/adatmadura.jpeg';
        }
        if (str_contains($name, 'baju adat') || str_contains($name, 'kostum')) {
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

function normalizeCartImagePath(?string $foto, array $item): string {
    $foto = trim((string) $foto);
    if ($foto === '') {
        return getCartImagePath($item);
    }

    $foto = str_replace('\\', '/', $foto);
    if (preg_match('#^(https?:)?//#', $foto) || str_starts_with($foto, '/')) {
        return $foto;
    }

    if (str_starts_with($foto, '../assets/')) {
        return $foto;
    }

    if (str_starts_with($foto, 'assets/')) {
        return '../' . $foto;
    }

    return '../assets/' . ltrim($foto, '/');
}

function loadCartItems(): array {
    if (!isset($_SESSION['id_user'])) {
        return [];
    }

    global $pdo;
    $id_user = $_SESSION['id_user'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM keranjang WHERE id_user = ? ORDER BY created_at DESC");
        $stmt->execute([$id_user]);
        $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cart_items as &$item) {
            $item['foto'] = normalizeCartImagePath($item['foto'] ?? '', $item);
            $item['harga'] = (float) ($item['harga'] ?? 0);
            $item['kuantitas'] = (int) ($item['kuantitas'] ?? 1);
            $item['id_keranjang'] = (int) ($item['id_keranjang'] ?? 0);
        }
        unset($item);

        return $cart_items;
    } catch (Exception $e) {
        return [];
    }
}
