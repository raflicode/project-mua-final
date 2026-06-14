<?php
session_start();
require_once '../config/koneksi.php';
require_once '../config/db_helpers.php';

ensure_dynamic_booking_schema($pdo);

// Redirect jika bukan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/pembayaran.php');
    exit;
}

// Ambil parameter from
$fromPage = filter_input(INPUT_GET, 'from', FILTER_SANITIZE_STRING);
$fromParam = $fromPage ? '?from=' . urlencode($fromPage) : '';

// Check login
if (!isset($_SESSION['id_user'])) {
    header('Location: ../public/login.php');
    exit;
}

// Pastikan draft booking sudah ada dan jadwal sudah dipilih
if (!isset($_SESSION['draft_booking'])) {
    header('Location: ../public/booking.php' . $fromParam);
    exit;
}

if (empty($_SESSION['draft_booking']['id_jadwal'])) {
    header('Location: ../public/penjadwalan.php' . $fromParam);
    exit;
}

// Sanitize dan validasi input
$nama = trim(filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING));
$hp = trim(filter_input(INPUT_POST, 'hp', FILTER_SANITIZE_STRING));
$alamat = trim(filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING));

// Validasi data
$errors = [];

// Validasi nama - hanya huruf dan spasi
if (empty($nama)) {
    $errors[] = 'Nama lengkap harus diisi';
} elseif (!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
    $errors[] = 'Nama hanya boleh mengandung huruf dan spasi';
}

// Validasi No HP
if (empty($hp)) {
    $errors[] = 'No HP harus diisi';
} elseif (!preg_match('/^[0-9]+$/', $hp)) {
    $errors[] = 'No HP hanya boleh mengandung angka';
} elseif (strlen($hp) < 10 || strlen($hp) > 12) {
    $errors[] = 'No Handphone harus 10-12 digit';
}

// Validasi alamat
if (empty($alamat)) {
    $errors[] = 'Alamat/Catatan harus diisi';
}

// Jika ada error, kembali ke pembayaran
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = [
        'nama' => $nama,
        'hp' => $hp,
        'alamat' => $alamat
    ];
    header('Location: ../public/pembayaran.php' . $fromParam);
    exit;
}

// Simpan data ke session untuk halaman konfirmasi
$_SESSION['pembayaran'] = [
    'nama' => $nama,
    'hp' => $hp,
    'alamat' => $alamat,
    'catatan' => trim(filter_input(INPUT_POST, 'catatan', FILTER_SANITIZE_STRING) ?? '')
];

function findOrCreateLayananAwal(PDO $pdo, string $nama, float $harga, string $foto = '', string $kategori = 'makeup'): int
{
    $haystack = strtolower($kategori . ' ' . $nama);
    if (str_contains($haystack, 'paket')) {
        $foto = '';
    }

    $stmt = $pdo->prepare('SELECT id_layanan FROM layanan WHERE nama_layanan = ? LIMIT 1');
    $stmt->execute([$nama]);
    $id = $stmt->fetchColumn();
    if ($id) {
        return (int) $id;
    }

    $stmt = $pdo->prepare('
        INSERT INTO layanan (kategori_layanan, nama_layanan, deskripsi, harga_dasar, foto_layanan, is_active)
        VALUES (?, ?, ?, ?, ?, 1)
    ');
    $stmt->execute([$kategori, $nama ?: 'Layanan Booking', 'Dibuat otomatis dari proses booking.', $harga, $foto ?: null]);

    return (int) $pdo->lastInsertId();
}

function insertBookingDetailAwal(PDO $pdo, int $idBooking, int $idLayanan, int $qty, float $harga, float $subtotal): void
{
    $stmt = $pdo->prepare('
        INSERT INTO booking_detail (id_booking, id_layanan, qty, harga, subtotal)
        VALUES (?, ?, ?, ?, ?)
    ');
    $stmt->execute([$idBooking, $idLayanan, $qty, $harga, $subtotal]);
}

try {
    $draft = $_SESSION['draft_booking'];
    $idUser = (int) $_SESSION['id_user'];
    if (empty($draft['id_booking'])) {
        $idJadwal = (int) $draft['id_jadwal'];
        $isCartCheckout = ($draft['source'] ?? '') === 'cart';
        $subtotal = (float) ($draft['total'] ?? $draft['harga'] ?? 0);
        $totalHarga = $subtotal;
        $primaryLayananId = (int) ($draft['id_layanan'] ?? ($draft['items'][0]['id_layanan'] ?? 0));

        if ($primaryLayananId <= 0) {
            $primaryLayananId = findOrCreateLayananAwal(
                $pdo,
                $draft['nama_layanan'] ?? 'Layanan Booking',
                (float) ($draft['harga'] ?? $draft['total'] ?? 0),
                $draft['foto'] ?? '',
                $draft['tipe_layanan'] ?? (($draft['source'] ?? '') === 'cart' ? 'paket' : 'makeup')
            );
        }

        $pdo->beginTransaction();

        $jadwalStmt = $pdo->prepare('SELECT kapasitas_max, status_slot FROM jadwal_kerja WHERE id_jadwal = ? LIMIT 1');
        $jadwalStmt->execute([$idJadwal]);
        $jadwalData = $jadwalStmt->fetch(PDO::FETCH_ASSOC);
        if (!$jadwalData || $jadwalData['status_slot'] !== 'tersedia') {
            throw new Exception('Jadwal ini tidak tersedia lagi. Silakan pilih jadwal lain.');
        }

        $kapasitasMax = max(1, (int) $jadwalData['kapasitas_max']);
        $checkStmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM booking
            WHERE id_jadwal = ?
              AND status_booking <> 'dibatalkan'
        ");
        $checkStmt->execute([$idJadwal]);
        if ((int) $checkStmt->fetchColumn() >= $kapasitasMax) {
            throw new Exception('Jadwal ini sudah penuh. Silakan pilih jadwal lain.');
        }

        $closedStmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM jadwal_tutup jt
            INNER JOIN jadwal_kerja jk ON jk.tanggal = jt.tanggal
            WHERE jk.id_jadwal = ?
        ");
        $closedStmt->execute([$idJadwal]);
        if ((int) $closedStmt->fetchColumn() > 0) {
            throw new Exception('Tanggal ini sedang ditutup oleh admin. Silakan pilih tanggal lain.');
        }

        $bookingColumns = ['id_user', 'id_jadwal', 'total_harga', 'status_booking', 'catatan'];
        $bookingParams = [$idUser, $idJadwal, $totalHarga, 'pending', $alamat];
        if (db_has_column($pdo, 'booking', 'no_telp')) {
            $bookingColumns[] = 'no_telp';
            $bookingParams[] = $hp;
        }

        $placeholders = implode(', ', array_fill(0, count($bookingColumns), '?'));
        $stmt = $pdo->prepare('INSERT INTO booking (' . implode(', ', $bookingColumns) . ') VALUES (' . $placeholders . ')');
        $stmt->execute($bookingParams);
        $idBooking = (int) $pdo->lastInsertId();

        if ($isCartCheckout && !empty($draft['items']) && is_array($draft['items'])) {
            foreach ($draft['items'] as $item) {
                $qty = max(1, (int) ($item['kuantitas'] ?? $item['qty'] ?? 1));
                $hargaItem = (float) ($item['harga'] ?? 0);
                $itemSubtotal = (float) ($item['item_total'] ?? ($hargaItem * $qty));
                $idLayanan = (int) ($item['id_layanan'] ?? 0);
                if ($idLayanan <= 0) {
                    $idLayanan = findOrCreateLayananAwal(
                        $pdo,
                        $item['nama_layanan'] ?? 'Layanan Booking',
                        $hargaItem,
                        $item['foto'] ?? '',
                        $item['tipe_layanan'] ?? 'makeup'
                    );
                }
                insertBookingDetailAwal($pdo, $idBooking, $idLayanan, $qty, $hargaItem, $itemSubtotal);
            }
            
            $cartItemIds = $draft['cart_item_ids'] ?? [];
            if (empty($cartItemIds)) {
                $cartItemIds = array_column($draft['items'], 'id_keranjang');
            }

            $cartItemIds = array_values(array_unique(array_filter(array_map('intval', (array) $cartItemIds), fn($id) => $id > 0)));
            if (!empty($cartItemIds)) {
                $deletePlaceholders = implode(', ', array_fill(0, count($cartItemIds), '?'));
                $clearCartStmt = $pdo->prepare("DELETE FROM keranjang WHERE id_user = ? AND id_keranjang IN ($deletePlaceholders)");
                $clearCartStmt->execute(array_merge([$idUser], $cartItemIds));
            }
        } else {
            insertBookingDetailAwal($pdo, $idBooking, $primaryLayananId, 1, $subtotal, $subtotal);
        }

        $_SESSION['draft_booking']['id_booking'] = $idBooking;

        $bookedStmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM booking
            WHERE id_jadwal = ?
              AND status_booking <> 'dibatalkan'
        ");
        $bookedStmt->execute([$idJadwal]);
        if ((int) $bookedStmt->fetchColumn() >= $kapasitasMax) {
            $updateJadwal = $pdo->prepare("UPDATE jadwal_kerja SET status_slot = 'penuh' WHERE id_jadwal = ?");
            $updateJadwal->execute([$idJadwal]);
        }

        $pdo->commit();
    }
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['errors'] = ['Gagal menyimpan booking: ' . $e->getMessage()];
    $_SESSION['form_data'] = $_SESSION['pembayaran'];
    header('Location: ../public/pembayaran.php');
    exit;
}

// Redirect ke halaman konfirmasi awal di dalam sistem
header('Location: ../public/konfirmasi_awal.php' . $fromParam);
exit;
?>
