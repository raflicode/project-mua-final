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

// Check login
if (!isset($_SESSION['id_user'])) {
    header('Location: ../public/login.php');
    exit;
}

// Pastikan draft booking sudah ada dan jadwal sudah dipilih
if (!isset($_SESSION['draft_booking'])) {
    header('Location: ../public/booking.php');
    exit;
}

if (empty($_SESSION['draft_booking']['id_jadwal'])) {
    header('Location: ../public/penjadwalan.php');
    exit;
}

// Sanitize dan validasi input
$nama = trim(filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING));
$hp = trim(filter_input(INPUT_POST, 'hp', FILTER_SANITIZE_STRING));
$metode = trim(filter_input(INPUT_POST, 'metode', FILTER_SANITIZE_STRING));
$alamat = trim(filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING));

// Validasi data
$errors = [];

// Validasi nama - hanya huruf dan spasi
if (empty($nama)) {
    $errors[] = 'Nama lengkap harus diisi';
} elseif (!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
    $errors[] = 'Nama hanya boleh mengandung huruf dan spasi';
}

// Validasi HP
if (empty($hp)) {
    $errors[] = 'No Handphone harus diisi';
} elseif (!preg_match('/^[0-9]+$/', $hp)) {
    $errors[] = 'No Handphone hanya boleh mengandung angka';
} elseif (strlen($hp) < 10 || strlen($hp) > 12) {
    $errors[] = 'No Handphone harus 10-12 digit';
}

// Validasi metode
if (empty($metode)) {
    $errors[] = 'Metode pembayaran harus dipilih';
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
        'metode' => $metode,
        'alamat' => $alamat
    ];
    header('Location: ../public/pembayaran.php');
    exit;
}

// Simpan data ke session untuk halaman konfirmasi
$_SESSION['pembayaran'] = [
    'nama' => $nama,
    'hp' => $hp,
    'metode' => $metode,
    'alamat' => $alamat,
    'catatan' => trim(filter_input(INPUT_POST, 'catatan', FILTER_SANITIZE_STRING) ?? '')
];

function findOrCreateLayananAwal(PDO $pdo, string $nama, float $harga, string $foto = '', string $kategori = 'makeup'): int
{
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
    if (empty($draft['id_booking'])) {
        $idUser = (int) $_SESSION['id_user'];
        $idJadwal = (int) $draft['id_jadwal'];
        $isCartCheckout = ($draft['source'] ?? '') === 'cart';
        $subtotal = (float) ($draft['total'] ?? $draft['harga'] ?? 0);
        $totalHarga = $subtotal + 10000;
        $primaryLayananId = (int) ($draft['id_layanan'] ?? ($draft['items'][0]['id_layanan'] ?? 0));

        if ($primaryLayananId <= 0) {
            $primaryLayananId = findOrCreateLayananAwal(
                $pdo,
                $draft['nama_layanan'] ?? 'Layanan Booking',
                (float) ($draft['harga'] ?? $draft['total'] ?? 0),
                $draft['foto'] ?? '',
                ($draft['source'] ?? '') === 'cart' ? 'paket' : 'makeup'
            );
        }

        $pdo->beginTransaction();

        $checkStmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM booking
            WHERE id_jadwal = ?
              AND status_booking <> 'dibatalkan'
        ");
        $checkStmt->execute([$idJadwal]);
        if ((int) $checkStmt->fetchColumn() >= 3) {
            throw new Exception('Jadwal ini sudah penuh. Silakan pilih jadwal lain.');
        }

        $stmt = $pdo->prepare('
            INSERT INTO booking (id_user, id_jadwal, total_harga, status_booking, catatan)
            VALUES (?, ?, ?, ?, ?)
        ');
        $stmt->execute([$idUser, $idJadwal, $totalHarga, 'pending', $alamat]);
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
        } else {
            insertBookingDetailAwal($pdo, $idBooking, $primaryLayananId, 1, $subtotal, $subtotal);
        }

        $_SESSION['draft_booking']['id_booking'] = $idBooking;
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

// Redirect ke halaman konfirmasi awal melalui WhatsApp
header('Location: ../public/konfirmasi_awal.php');
exit;
?>
