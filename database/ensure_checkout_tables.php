<?php
require_once __DIR__ . '/../config/koneksi.php';

function columnExists(PDO $pdo, string $table, string $column): bool
{
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?'
    );
    $stmt->execute([$table, $column]);
    return (int) $stmt->fetchColumn() > 0;
}

$pdo->exec("
    CREATE TABLE IF NOT EXISTS layanan (
        id_layanan int(11) NOT NULL AUTO_INCREMENT,
        nama_layanan varchar(100) NOT NULL,
        deskripsi text DEFAULT NULL,
        harga_dasar decimal(12,2) NOT NULL,
        foto_layanan varchar(255) DEFAULT NULL,
        is_active tinyint(1) DEFAULT 1,
        created_at datetime DEFAULT current_timestamp(),
        updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id_layanan),
        UNIQUE KEY uq_layanan_nama (nama_layanan)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS jadwal_kerja (
        id_jadwal int(11) NOT NULL AUTO_INCREMENT,
        tanggal date NOT NULL,
        jam_mulai time NOT NULL,
        jam_selesai time NOT NULL,
        kapasitas_max int(11) NOT NULL DEFAULT 1,
        status_slot enum('tersedia','penuh','libur') DEFAULT 'tersedia',
        created_at datetime DEFAULT current_timestamp(),
        updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id_jadwal)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS booking (
        id_booking int(11) NOT NULL AUTO_INCREMENT,
        id_user int(11) NOT NULL,
        id_layanan int(11) NOT NULL,
        id_jadwal int(11) NOT NULL,
        tanggal_booking datetime DEFAULT current_timestamp(),
        total_harga decimal(12,2) NOT NULL,
        status_booking enum('pending','dibayar','dikonfirmasi','selesai','dibatalkan') DEFAULT 'pending',
        catatan text DEFAULT NULL,
        created_at datetime DEFAULT current_timestamp(),
        updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id_booking),
        KEY idx_booking_user (id_user),
        KEY idx_booking_layanan (id_layanan),
        KEY idx_booking_jadwal (id_jadwal)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS booking_detail (
        id_booking_detail int(11) NOT NULL AUTO_INCREMENT,
        id_booking int(11) NOT NULL,
        id_layanan int(11) NOT NULL,
        id_addon int(11) DEFAULT NULL,
        harga_transaksi decimal(12,2) NOT NULL,
        catatan_item text DEFAULT NULL,
        created_at datetime DEFAULT current_timestamp(),
        updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id_booking_detail),
        KEY idx_bd_booking (id_booking),
        KEY idx_bd_layanan (id_layanan)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
");

if (!columnExists($pdo, 'keranjang', 'foto')) {
    $pdo->exec("ALTER TABLE keranjang ADD COLUMN foto varchar(255) DEFAULT NULL AFTER tipe_layanan");
}

$services = [
    ['Makeup Graduation', 'Makeup wisuda natural dan tahan lama.', 800000, '../assets/foto_makeup.jpeg'],
    ['Makeup Wedding', 'Makeup pengantin lengkap untuk acara pernikahan.', 1500000, '../assets/foto_makeup.jpeg'],
    ['Makeup Carnaval', 'Makeup artistik untuk karnaval.', 1000000, '../assets/foto_makeup.jpeg'],
    ['Makeup Carnava', 'Makeup artistik untuk karnaval.', 1000000, '../assets/foto_makeup.jpeg'],
    ['Makeup Natural', 'Makeup natural untuk acara spesial.', 2000000, '../assets/foto_makeup.jpeg'],
    ['Dekor 1', 'Paket dekorasi acara.', 3000000, '../assets/foto_dekor.jpeg'],
    ['Dekor 2', 'Paket dekorasi acara.', 4000000, '../assets/foto_dekor.jpeg'],
    ['Dekor 3', 'Paket dekorasi acara.', 6000000, '../assets/foto_dekor.jpeg'],
    ['Dekor 4', 'Paket dekorasi acara.', 2000000, '../assets/foto_dekor.jpeg'],
    ['Kostum Baju Adat', 'Sewa kostum baju adat.', 8000000, '../assets/fotokostum3.jpeg'],
    ['Kostum Wedding', 'Sewa kostum wedding.', 4000000, '../assets/fotokostum6.jpeg'],
    ['Kostum Graduation', 'Sewa kostum graduation.', 6000000, '../assets/fotokostum3.jpg'],
    ['Kostum Kebaya', 'Sewa kostum kebaya.', 2000000, '../assets/fotokostum4.jpg'],
];

$serviceStmt = $pdo->prepare(
    'INSERT INTO layanan (nama_layanan, deskripsi, harga_dasar, foto_layanan)
     VALUES (?, ?, ?, ?)
     ON DUPLICATE KEY UPDATE
        deskripsi = VALUES(deskripsi),
        harga_dasar = VALUES(harga_dasar),
        foto_layanan = VALUES(foto_layanan),
        is_active = 1'
);

foreach ($services as $service) {
    $serviceStmt->execute($service);
}

$slotStmt = $pdo->prepare(
    'INSERT INTO jadwal_kerja (tanggal, jam_mulai, jam_selesai, kapasitas_max, status_slot)
     SELECT ?, ?, ?, 1, ?
     WHERE NOT EXISTS (
        SELECT 1 FROM jadwal_kerja WHERE tanggal = ? AND jam_mulai = ? AND jam_selesai = ?
     )'
);

$today = new DateTimeImmutable('today');
$slots = [
    [1, '07:00:00', '10:00:00'],
    [2, '11:00:00', '13:00:00'],
    [3, '15:00:00', '18:00:00'],
    [5, '07:00:00', '10:00:00'],
    [6, '11:00:00', '13:00:00'],
    [7, '15:00:00', '18:00:00'],
];

foreach ($slots as [$dayOffset, $start, $end]) {
    $date = $today->modify("+{$dayOffset} days")->format('Y-m-d');
    $slotStmt->execute([$date, $start, $end, 'tersedia', $date, $start, $end]);
}

echo "Checkout tables are ready.\n";
