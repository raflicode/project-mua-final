<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/db_helpers.php';
require_once __DIR__ . '/../config/service_catalog.php';

ensure_dynamic_booking_schema($pdo);

function fcw_json(array $payload): void
{
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function fcw_user_name(): string
{
    $name = trim((string) ($_SESSION['full_name'] ?? $_SESSION['username'] ?? ''));
    return $name !== '' ? $name : 'Kak';
}

function fcw_flatten_catalog(PDO $pdo, string $category): array
{
    $fallbacks = [
        'makeup' => ['../assets/foto_makeup.jpeg', 'Layanan makeup siap untuk booking.'],
        'kostum' => ['../assets/gallery_kostum/fotoakad.jpeg', 'Layanan kostum siap untuk booking.'],
        'dekor' => ['../assets/fotodekor1.png', 'Layanan dekorasi siap untuk booking.'],
        'paket' => ['../assets/silver.jpeg', 'Layanan paket siap untuk booking.'],
    ];

    [$fallbackImage, $fallbackText] = $fallbacks[$category] ?? $fallbacks['makeup'];
    $catalog = fetch_catalog_by_category($pdo, $category, $fallbackImage, $fallbackText);
    $items = [];

    foreach ($catalog as $group) {
        foreach (($group['variasi'] ?? []) as $variant) {
            $items[] = [
                'id' => (int) ($variant['id'] ?? 0),
                'nama' => (string) ($variant['nama'] ?? $group['jenis'] ?? 'Layanan'),
                'jenis' => (string) ($group['jenis'] ?? ''),
                'harga' => (string) ($variant['harga'] ?? catalog_format_rupiah($variant['harga_value'] ?? 0)),
                'harga_value' => (float) ($variant['harga_value'] ?? 0),
                'include' => array_slice(array_values($variant['include'] ?? []), 0, 4),
            ];
        }
    }

    return $items;
}

function fcw_schedule(PDO $pdo): array
{
    $today = new DateTimeImmutable('today');
    $days = [];

    $closedStmt = $pdo->prepare('SELECT tanggal, alasan FROM jadwal_tutup WHERE tanggal >= ? AND tanggal <= ?');
    $closedStmt->execute([$today->format('Y-m-d'), $today->modify('+30 days')->format('Y-m-d')]);
    $closed = [];
    foreach ($closedStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $closed[$row['tanggal']] = $row['alasan'] ?: 'Tanggal ditutup admin';
    }

    $bookedDateStmt = $pdo->prepare("
        SELECT jk.tanggal, COUNT(*) AS total
        FROM booking b
        INNER JOIN jadwal_kerja jk ON jk.id_jadwal = b.id_jadwal
        WHERE jk.tanggal >= ?
          AND jk.tanggal <= ?
          AND b.status_booking <> 'dibatalkan'
        GROUP BY jk.tanggal
    ");
    $bookedDateStmt->execute([$today->format('Y-m-d'), $today->modify('+30 days')->format('Y-m-d')]);
    $bookedByDate = [];
    foreach ($bookedDateStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $bookedByDate[$row['tanggal']] = (int) $row['total'];
    }

    $slotStmt = $pdo->prepare("
        SELECT
            jk.id_jadwal,
            jk.tanggal,
            jk.jam_mulai,
            jk.jam_selesai,
            jk.kapasitas_max,
            jk.status_slot,
            COUNT(b.id_booking) AS terbooking
        FROM jadwal_kerja jk
        LEFT JOIN booking b ON b.id_jadwal = jk.id_jadwal AND b.status_booking <> 'dibatalkan'
        WHERE jk.tanggal >= ?
          AND jk.tanggal <= ?
        GROUP BY jk.id_jadwal, jk.tanggal, jk.jam_mulai, jk.jam_selesai, jk.kapasitas_max, jk.status_slot
        ORDER BY jk.tanggal ASC, jk.jam_mulai ASC
    ");
    $slotStmt->execute([$today->format('Y-m-d'), $today->modify('+30 days')->format('Y-m-d')]);
    $slotsByDate = [];
    foreach ($slotStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $remainingSlot = max(0, (int) $row['kapasitas_max'] - (int) $row['terbooking']);
        if ($row['status_slot'] === 'tersedia' && $remainingSlot > 0) {
            $slotsByDate[$row['tanggal']][] = substr($row['jam_mulai'], 0, 5) . '-' . substr($row['jam_selesai'], 0, 5);
        }
    }

    for ($i = 0; $i <= 30 && count($days) < 7; $i++) {
        $date = $today->modify("+{$i} days")->format('Y-m-d');
        if (isset($closed[$date])) {
            continue;
        }

        $booked = $bookedByDate[$date] ?? 0;
        $remainingDate = max(0, 3 - $booked);
        if ($remainingDate <= 0) {
            continue;
        }

        $days[] = [
            'tanggal' => $date,
            'label' => date('d M Y', strtotime($date)),
            'sisa_slot' => $remainingDate,
            'jam' => array_slice($slotsByDate[$date] ?? [], 0, 4),
        ];
    }

    return $days;
}

$action = $_GET['action'] ?? 'init';

try {
    if ($action === 'schedule') {
        fcw_json(['ok' => true, 'schedule' => fcw_schedule($pdo)]);
    }

    if ($action === 'category') {
        $category = preg_replace('/[^a-z]/', '', (string) ($_GET['category'] ?? 'makeup'));
        if (!in_array($category, ['makeup', 'kostum', 'dekor', 'paket'], true)) {
            $category = 'makeup';
        }

        fcw_json(['ok' => true, 'category' => $category, 'items' => array_slice(fcw_flatten_catalog($pdo, $category), 0, 8)]);
    }

    fcw_json([
        'ok' => true,
        'user_name' => fcw_user_name(),
    ]);
} catch (Throwable $e) {
    fcw_json(['ok' => false, 'message' => 'Data chatbot belum bisa dimuat. Silakan coba beberapa saat lagi.']);
}
?>
