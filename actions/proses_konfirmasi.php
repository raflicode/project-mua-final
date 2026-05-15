<?php
session_start();
require_once '../config/koneksi.php';

// Check login
if (!isset($_SESSION['id_user'])) {
    header('Location: ../public/login.php');
    exit;
}

// Check jika ada data pembayaran
if (!isset($_SESSION['pembayaran'])) {
    header('Location: ../public/pembayaran.php');
    exit;
}

if (!isset($_SESSION['draft_booking'])) {
    header('Location: ../public/booking.php');
    exit;
}

$draft = $_SESSION['draft_booking'];
if (empty($draft['id_jadwal']) || empty($draft['id_layanan'])) {
    header('Location: ../public/booking.php');
    exit;
}

// Check method POST dan ada file
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['bukti_pembayaran'])) {
    header('Location: ../public/konfirmasi.php');
    exit;
}

$file = $_FILES['bukti_pembayaran'];
$errors = [];

// Validasi file
if ($file['error'] !== UPLOAD_ERR_OK) {
    $errors[] = 'Terjadi kesalahan saat upload file';
} else {
    // Validasi tipe file
    $allowedTypes = ['image/jpeg', 'image/png'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedTypes)) {
        $errors[] = 'Hanya file JPG/JPEG atau PNG yang diperbolehkan';
    }

    // Validasi ukuran file (max 5MB)
    if ($file['size'] > 5242880) {
        $errors[] = 'Ukuran file tidak boleh lebih dari 5MB';
    }
}

// Jika ada error
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../public/konfirmasi.php');
    exit;
}

// Create upload directory if not exists
$uploadDir = '../assets/bukti_pembayaran';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Generate unique filename
$extensionByMime = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
];
$ext = $extensionByMime[$mimeType] ?? strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$fileName = uniqid('bukti_') . '_' . $_SESSION['id_user'] . '.' . $ext;
$uploadPath = $uploadDir . '/' . $fileName;

// Move file
if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
    $_SESSION['errors'] = ['Gagal menyimpan file'];
    header('Location: ../public/konfirmasi.php');
    exit;
}

// Insert ke database
$pembayaran = $_SESSION['pembayaran'];
$id_user = $_SESSION['id_user'];
$status = 'pending';
$id_jadwal = $draft['id_jadwal'];
$isCartCheckout = isset($draft['source']) && $draft['source'] === 'cart';
$primaryLayananId = intval($draft['id_layanan'] ?? ($draft['items'][0]['id_layanan'] ?? 0));
$total_harga = floatval($draft['total'] ?? $draft['harga'] ?? 0) + 10000;
$catatan = trim($pembayaran['alamat'] ?? '');

try {
    $pdo->beginTransaction();

    // Pastikan jadwal masih tersedia
    $jadwalStmt = $pdo->prepare('SELECT kapasitas_max FROM jadwal_kerja WHERE id_jadwal = ? AND status_slot = ? LIMIT 1');
    $jadwalStmt->execute([$id_jadwal, 'tersedia']);
    $jadwalData = $jadwalStmt->fetch(PDO::FETCH_ASSOC);
    if (!$jadwalData) {
        throw new Exception('Jadwal tidak tersedia lagi. Silakan pilih jadwal lain.');
    }

    $bookingQuery = "INSERT INTO booking (id_user, id_layanan, id_jadwal, total_harga, status_booking, catatan) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($bookingQuery);
    $stmt->execute([$id_user, $primaryLayananId, $id_jadwal, $total_harga, 'pending', $catatan]);
    $id_booking = $pdo->lastInsertId();

    $detailQuery = "INSERT INTO booking_detail (id_booking, id_layanan, harga_transaksi, catatan_item) VALUES (?, ?, ?, ?)";
    $detailStmt = $pdo->prepare($detailQuery);

    if ($isCartCheckout && !empty($draft['items']) && is_array($draft['items'])) {
        foreach ($draft['items'] as $item) {
            $detailStmt->execute([
                $id_booking,
                intval($item['id_layanan'] ?? 0),
                floatval($item['item_total'] ?? (floatval($item['harga'] ?? 0) * intval($item['kuantitas'] ?? 1))),
                null
            ]);
        }
    } else {
        $detailStmt->execute([$id_booking, $primaryLayananId, floatval($draft['harga'] ?? 0), null]);
    }

    $query = "INSERT INTO pembayaran (id_user, nama, hp, metode, alamat, bukti_pembayaran, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_user, $pembayaran['nama'], $pembayaran['hp'], $pembayaran['metode'], $pembayaran['alamat'], $fileName, $status]);

    if ($isCartCheckout && !empty($draft['cart_item_ids']) && is_array($draft['cart_item_ids'])) {
        $cartIds = array_map('intval', $draft['cart_item_ids']);
        $cartIds = array_values(array_filter($cartIds, fn($id) => $id > 0));
        if (!empty($cartIds)) {
            $placeholders = implode(',', array_fill(0, count($cartIds), '?'));
            $deleteStmt = $pdo->prepare("DELETE FROM keranjang WHERE id_user = ? AND id_keranjang IN ($placeholders)");
            $deleteStmt->execute(array_merge([$id_user], $cartIds));
        }
    }

    // Update status jadwal jika kapasitas penuh
    $countStmt = $pdo->prepare('SELECT COUNT(*) AS booked FROM booking WHERE id_jadwal = ? AND status_booking != ?');
    $countStmt->execute([$id_jadwal, 'dibatalkan']);
    $bookedCount = intval($countStmt->fetchColumn());
    if ($bookedCount >= intval($jadwalData['kapasitas_max'])) {
        $updateJadwal = $pdo->prepare('UPDATE jadwal_kerja SET status_slot = ? WHERE id_jadwal = ?');
        $updateJadwal->execute(['penuh', $id_jadwal]);
    }

    $pdo->commit();

    unset($_SESSION['pembayaran']);
    unset($_SESSION['draft_booking']);

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $projectBase = preg_replace('#/actions$#', '', $scriptDir);
    $buktiUrl = $scheme . '://' . $host . $projectBase . '/assets/bukti_pembayaran/' . rawurlencode($fileName);

    $pesan = "Halo Admin, saya ingin konfirmasi pembayaran booking makeup.\n\n"
        . "Nama: {$pembayaran['nama']}\n"
        . "No HP: {$pembayaran['hp']}\n"
        . "Metode Pembayaran: {$pembayaran['metode']}\n"
        . "Link Bukti Pembayaran: {$buktiUrl}\n\n"
        . "Saya sudah transfer dan mengirim bukti pembayaran.";

    $wa_url = 'https://wa.me/6281217857682?' . http_build_query(['text' => $pesan]);

    header("Location: $wa_url");
    exit;

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    if (file_exists($uploadPath)) {
        @unlink($uploadPath);
    }
    $_SESSION['errors'] = ['Terjadi kesalahan saat menyimpan data ke database: ' . $e->getMessage()];
    header('Location: ../public/konfirmasi.php');
    exit;
}
?>
