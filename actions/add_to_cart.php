<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/db_helpers.php';

ensure_dynamic_booking_schema($pdo);

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

$id_user = intval($_SESSION['id_user'] ?? 0);
if ($id_user <= 0) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Sesi pengguna tidak valid. Silakan login ulang.'
    ]);
    exit();
}

// Cek apakah user benar-benar ada di database
$stmt_user = $pdo->prepare('SELECT 1 FROM `user` WHERE id_user = ? LIMIT 1');
$stmt_user->execute([$id_user]);
if (!$stmt_user->fetchColumn()) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Data pengguna tidak ditemukan. Silakan login ulang.'
    ]);
    exit();
}

// Ambil data dari POST
$nama_layanan = trim($_POST['nama_layanan'] ?? '');
$tipe_layanan = trim($_POST['tipe_layanan'] ?? '');
$id_layanan = intval($_POST['id_layanan'] ?? 0);
$harga = intval($_POST['harga'] ?? 0);
$kuantitas = intval($_POST['kuantitas'] ?? 1);
$foto = trim($_POST['foto'] ?? '');

// Validasi input
if (empty($nama_layanan) || empty($tipe_layanan) || $harga <= 0 || $kuantitas <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak valid'
    ]);
    exit();
}

// Validasi tipe layanan
$valid_types = ['makeup', 'dekor', 'kostum', 'paket'];
if (!in_array($tipe_layanan, $valid_types)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Tipe layanan tidak valid'
    ]);
    exit();
}

try {
    // Cek apakah item sudah ada di keranjang user
    $stmt_check = $pdo->prepare("
        SELECT id_keranjang, kuantitas FROM keranjang 
        WHERE id_user = ? AND nama_layanan = ? AND tipe_layanan = ?
    ");
    $stmt_check->execute([$id_user, $nama_layanan, $tipe_layanan]);
    $existing_item = $stmt_check->fetch();

    if ($existing_item) {
        // Update kuantitas jika sudah ada
        $new_qty = $existing_item['kuantitas'] + $kuantitas;
        $stmt_update = $pdo->prepare("
            UPDATE keranjang 
            SET kuantitas = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id_keranjang = ?
        ");
        $stmt_update->execute([$new_qty, $existing_item['id_keranjang']]);
    } else {
        // Insert item baru (simpan path foto jika tersedia)
        try {
            $stmt_insert = $pdo->prepare("
                INSERT INTO keranjang (id_user, id_layanan, nama_layanan, tipe_layanan, foto, harga, kuantitas)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt_insert->execute([$id_user, $id_layanan > 0 ? $id_layanan : null, $nama_layanan, $tipe_layanan, $foto, $harga, $kuantitas]);
        } catch (PDOException $e) {
            // Jika kolom foto belum ada di DB, fallback ke insert tanpa kolom foto
            $stmt_insert = $pdo->prepare("
                INSERT INTO keranjang (id_user, id_layanan, nama_layanan, tipe_layanan, harga, kuantitas)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt_insert->execute([$id_user, $id_layanan > 0 ? $id_layanan : null, $nama_layanan, $tipe_layanan, $harga, $kuantitas]);
        }
    }

    // Get total cart count
    $stmt_count = $pdo->prepare("SELECT SUM(kuantitas) as total FROM keranjang WHERE id_user = ?");
    $stmt_count->execute([$id_user]);
    $cart_count = $stmt_count->fetch()['total'] ?? 0;

    echo json_encode([
        'success' => true,
        'message' => $existing_item ? 'Item di keranjang ditambah' : 'Item ditambahkan ke keranjang',
        'action' => $existing_item ? 'updated' : 'added',
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
