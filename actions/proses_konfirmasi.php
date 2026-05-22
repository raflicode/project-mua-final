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
$canCreateBooking = true;
if (empty($draft['id_jadwal'])) {
    $canCreateBooking = false;
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
$id_jadwal = $draft['id_jadwal'] ?? null;
$isCartCheckout = isset($draft['source']) && $draft['source'] === 'cart';
$primaryLayananId = intval($draft['id_layanan'] ?? ($draft['items'][0]['id_layanan'] ?? 0));
$total_harga = floatval($draft['total'] ?? $draft['harga'] ?? 0) + 10000;
$catatan = trim($pembayaran['alamat'] ?? '');

function normalizePaymentMethod(string $method): string
{
    $method = strtolower(trim($method));

    if (in_array($method, ['cod', 'cash', 'bayar di tempat'], true)) {
        return 'cash';
    }

    if (in_array($method, ['dana', 'ovo', 'gopay', 'ewallet', 'e-wallet'], true)) {
        return 'ewallet';
    }

    return 'transfer';
}

function tableColumns(PDO $pdo, string $table): array
{
    static $cache = [];
    if (isset($cache[$table])) {
        return $cache[$table];
    }

    $columns = [];
    $stmt = $pdo->query("SHOW COLUMNS FROM {$table}");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $columns[$row['Field']] = true;
    }

    $cache[$table] = $columns;
    return $columns;
}

function tableHasColumn(PDO $pdo, string $table, string $column): bool
{
    $columns = tableColumns($pdo, $table);
    return isset($columns[$column]);
}

function findOrCreateLayanan(PDO $pdo, string $nama, float $harga, string $foto = ''): int
{
    $nama = trim($nama);
    if ($nama === '') {
        $nama = 'Layanan Booking';
    }

    $stmt = $pdo->prepare('SELECT id_layanan FROM layanan WHERE nama_layanan = ? LIMIT 1');
    $stmt->execute([$nama]);
    $id = $stmt->fetchColumn();
    if ($id) {
        return (int) $id;
    }

    $stmt = $pdo->prepare('
        INSERT INTO layanan (nama_layanan, deskripsi, harga_dasar, foto_layanan, is_active)
        VALUES (?, ?, ?, ?, 1)
    ');
    $stmt->execute([$nama, 'Dibuat otomatis dari proses booking.', $harga, $foto ?: null]);

    return (int) $pdo->lastInsertId();
}

function insertBooking(PDO $pdo, int $idUser, int $idJadwal, int $idLayanan, float $totalHarga, string $catatan): int
{
    $columns = ['id_user', 'id_jadwal', 'total_harga', 'status_booking', 'catatan'];
    $values = [$idUser, $idJadwal, $totalHarga, 'pending', $catatan];

    if (tableHasColumn($pdo, 'booking', 'id_layanan')) {
        array_splice($columns, 2, 0, 'id_layanan');
        array_splice($values, 2, 0, $idLayanan);
    }

    $placeholders = implode(', ', array_fill(0, count($columns), '?'));
    $query = 'INSERT INTO booking (' . implode(', ', $columns) . ') VALUES (' . $placeholders . ')';
    $stmt = $pdo->prepare($query);
    $stmt->execute($values);

    return (int) $pdo->lastInsertId();
}

function insertBookingDetail(PDO $pdo, int $idBooking, int $idLayanan, int $qty, float $harga, float $subtotal, ?string $catatan = null): void
{
    if (tableHasColumn($pdo, 'booking_detail', 'qty')) {
        $query = 'INSERT INTO booking_detail (id_booking, id_layanan, qty, harga, subtotal, catatan_item) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$idBooking, $idLayanan, $qty, $harga, $subtotal, $catatan]);
        return;
    }

    $query = 'INSERT INTO booking_detail (id_booking, id_layanan, harga_transaksi, catatan_item) VALUES (?, ?, ?, ?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$idBooking, $idLayanan, $subtotal, $catatan]);
}

function insertPembayaran(PDO $pdo, int $idBooking, int $idUser, array $pembayaran, float $totalHarga, string $fileName, string $status): void
{
    if (tableHasColumn($pdo, 'pembayaran', 'id_booking')) {
        $query = 'INSERT INTO pembayaran (id_booking, jumlah_bayar, metode_bayar, bukti_transfer, status_verifikasi) VALUES (?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$idBooking, $totalHarga, normalizePaymentMethod($pembayaran['metode'] ?? ''), $fileName, $status]);
        return;
    }

    $query = 'INSERT INTO pembayaran (id_user, nama, hp, metode, alamat, bukti_pembayaran, status) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        $idUser,
        $pembayaran['nama'] ?? '',
        $pembayaran['hp'] ?? '',
        $pembayaran['metode'] ?? '',
        $pembayaran['alamat'] ?? '',
        $fileName,
        $status
    ]);
}

try {
    $pdo->beginTransaction();

    // If we can create booking, verify jadwal is available and create booking + details
    $id_booking = null;
    if ($canCreateBooking) {
        // Pastikan jadwal masih tersedia
        $jadwalStmt = $pdo->prepare('SELECT kapasitas_max FROM jadwal_kerja WHERE id_jadwal = ? AND status_slot = ? LIMIT 1');
        $jadwalStmt->execute([$id_jadwal, 'tersedia']);
        $jadwalData = $jadwalStmt->fetch(PDO::FETCH_ASSOC);
        if (!$jadwalData) {
            throw new Exception('Jadwal tidak tersedia lagi. Silakan pilih jadwal lain.');
        }

        if ($primaryLayananId <= 0) {
            $primaryLayananId = findOrCreateLayanan(
                $pdo,
                $draft['nama_layanan'] ?? 'Layanan Booking',
                floatval($draft['harga'] ?? $draft['total'] ?? 0),
                $draft['foto'] ?? ''
            );
        }

        $id_booking = insertBooking($pdo, (int) $id_user, (int) $id_jadwal, $primaryLayananId, $total_harga, $catatan);

        if ($isCartCheckout && !empty($draft['items']) && is_array($draft['items'])) {
            foreach ($draft['items'] as $item) {
                $qty = max(1, intval($item['kuantitas'] ?? $item['qty'] ?? 1));
                $hargaItem = floatval($item['harga'] ?? 0);
                $subtotal = floatval($item['item_total'] ?? ($hargaItem * $qty));
                $itemLayananId = intval($item['id_layanan'] ?? 0);

                if ($itemLayananId <= 0) {
                    $itemLayananId = findOrCreateLayanan(
                        $pdo,
                        $item['nama_layanan'] ?? 'Layanan Booking',
                        $hargaItem,
                        $item['foto'] ?? ''
                    );
                }

                insertBookingDetail($pdo, $id_booking, $itemLayananId, $qty, $hargaItem, $subtotal);
            }
        } else {
            $hargaItem = floatval($draft['harga'] ?? 0);
            insertBookingDetail($pdo, $id_booking, $primaryLayananId, 1, $hargaItem, $hargaItem);
        }
    }

    if (!$id_booking) {
        throw new Exception('Booking belum lengkap. Silakan pilih layanan dan jadwal terlebih dahulu.');
    }

    // Insert pembayaran record sesuai schema aktif
    insertPembayaran($pdo, (int) $id_booking, (int) $id_user, $pembayaran, $total_harga, $fileName, $status);

    if ($isCartCheckout && !empty($draft['cart_item_ids']) && is_array($draft['cart_item_ids'])) {
        $cartIds = array_map('intval', $draft['cart_item_ids']);
        $cartIds = array_values(array_filter($cartIds, fn($id) => $id > 0));
        if (!empty($cartIds)) {
            $placeholders = implode(',', array_fill(0, count($cartIds), '?'));
            $deleteStmt = $pdo->prepare("DELETE FROM keranjang WHERE id_user = ? AND id_keranjang IN ($placeholders)");
            $deleteStmt->execute(array_merge([$id_user], $cartIds));
        }
    }

    // Update status jadwal jika kapasitas penuh (hanya jika booking dibuat)
    if ($canCreateBooking) {
        $countStmt = $pdo->prepare('SELECT COUNT(*) AS booked FROM booking WHERE id_jadwal = ? AND status_booking != ?');
        $countStmt->execute([$id_jadwal, 'dibatalkan']);
        $bookedCount = intval($countStmt->fetchColumn());
        if ($bookedCount >= intval($jadwalData['kapasitas_max'])) {
            $updateJadwal = $pdo->prepare('UPDATE jadwal_kerja SET status_slot = ? WHERE id_jadwal = ?');
            $updateJadwal->execute(['penuh', $id_jadwal]);
        }
    }

    $pdo->commit();

    // Clear draft booking only if booking was created
    unset($_SESSION['pembayaran']);
    if ($canCreateBooking) {
        unset($_SESSION['draft_booking']);
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $projectBase = preg_replace('#/actions$#', '', $scriptDir);
    $buktiUrl = $scheme . '://' . $host . $projectBase . '/assets/bukti_pembayaran/' . rawurlencode($fileName);

    $pesan = "Halo Admin, saya ingin konfirmasi pembayaran booking makeup.\n\n"
        . "Nama: {$pembayaran['nama']}\n"
        . "No HP: {$pembayaran['hp']}\n"
        . "Metode Pembayaran: {$pembayaran['metode']}\n"
        . "Link Bukti Pembayaran: {$buktiUrl}\n\n";

    if ($canCreateBooking) {
        $pesan .= "Booking berhasil dibuat dan menunggu verifikasi.\n";
    } else {
        $pesan .= "Catatan: Booking belum lengkap (tanggal/jam atau layanan belum dipilih). Mohon bantu verifikasi dan hubungi pemesan.\n";
    }

    $pesan .= "Saya sudah transfer dan mengirim bukti pembayaran.";

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
