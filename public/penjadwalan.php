<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/db_helpers.php';

ensure_dynamic_booking_schema($pdo);

$backHref = 'booking.php';
$fromPage = filter_input(INPUT_GET, 'from', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$backMap = [
    'makeup' => 'makeup.php',
    'dekor' => 'dekor.php',
    'kostum' => 'kostum.php',
    'cart' => 'keranjang.php',
    'service' => 'service.php'
];
$backHref = $backMap[$fromPage] ?? 'booking.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

function resolveScheduleImagePath($path): string
{
    $path = trim((string) $path);
    if ($path === '') {
        return '';
    }

    if (preg_match('#^(https?://|/)#', $path)) {
        return $path;
    }

    if (strpos($path, '../assets/') === 0) {
        return $path;
    }

    if (strpos($path, 'assets/') === 0) {
        return '../' . $path;
    }

    return '../' . ltrim($path, '/');
}

function shouldStoreScheduleImage(?string $foto, string $type = '', string $name = ''): bool
{
    $foto = trim((string) $foto);
    $haystack = strtolower($type . ' ' . $name);
    if (str_contains($haystack, 'paket') || str_contains($haystack, 'paket silver') || str_contains($haystack, 'paket gold')) {
        return false;
    }

    return $foto !== '';
}

$namaProdukParam = trim((string) filter_input(INPUT_GET, 'layanan', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
if ($namaProdukParam === '') {
    $namaProdukParam = trim((string) filter_input(INPUT_GET, 'nama', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}
$hargaProdukParam = filter_input(INPUT_GET, 'harga', FILTER_VALIDATE_INT);
$idLayananParam = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$fotoParam = trim((string) filter_input(INPUT_GET, 'foto', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$tipeParam = trim((string) filter_input(INPUT_GET, 'tipe', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$hasDirectSelection = $idLayananParam || $namaProdukParam !== '' || $hargaProdukParam > 0;

if ($hasDirectSelection) {
    $service = null;
    if ($idLayananParam) {
        try {
            $stmt = $pdo->prepare('SELECT * FROM layanan WHERE id_layanan = ? LIMIT 1');
            $stmt->execute([$idLayananParam]);
            $service = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $service = null;
        }
    }

    $namaProduk = $service['nama_layanan'] ?? $namaProdukParam;
    $hargaProduk = (float) ($service['harga_dasar'] ?? $hargaProdukParam ?? 0);
    $tipeLayanan = $tipeParam ?: ($service['kategori_layanan'] ?? $fromPage ?: 'makeup');
    $foto = resolveScheduleImagePath($service['foto_layanan'] ?? $fotoParam);

    if ($namaProduk !== '' && $hargaProduk > 0) {
        unset($_SESSION['checkout_booking']);
        $_SESSION['draft_booking'] = [
            'source' => 'single',
            'id_layanan' => $service['id_layanan'] ?? null,
            'nama_layanan' => $namaProduk,
            'harga' => $hargaProduk,
            'foto' => shouldStoreScheduleImage($foto, $tipeLayanan, $namaProduk) ? $foto : '',
            'tipe_layanan' => $tipeLayanan,
        ];
    }
}

$draft = $_SESSION['draft_booking'] ?? null;
if (!$draft) {
    $redirectUrl = 'booking.php';
    if ($fromPage) {
        $redirectUrl .= '?from=' . urlencode($fromPage);
    }
    header('Location: ' . $redirectUrl);
    exit;
}

$errors = [];
$today = date('Y-m-d');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $selectedDate = trim($_POST['selected_date'] ?? '');
$jamMulai = trim($_POST['jam_mulai'] ?? '');
    
    $jadwal = null;

    if ($selectedDate && $jamMulai) {

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate) || $selectedDate < $today) {
        $errors[] = 'Tanggal booking tidak boleh sebelum hari ini.';
    } else {

    $closedStmt = $pdo->prepare('SELECT COUNT(*) FROM jadwal_tutup WHERE tanggal = ?');
    $closedStmt->execute([$selectedDate]);

    if ((int) $closedStmt->fetchColumn() > 0) {
        $errors[] = 'Tanggal ini sedang ditutup oleh admin. Silakan pilih tanggal lain.';
    } else {

    $dbstmt = $pdo->prepare(
        'SELECT COUNT(*) FROM booking b
         JOIN jadwal_kerja jk ON b.id_jadwal = jk.id_jadwal
         WHERE jk.tanggal = ?
         AND b.status_booking != ?'
    );

    $dbstmt->execute([$selectedDate, 'dibatalkan']);

    $bookedDate = intval($dbstmt->fetchColumn());

    if ($bookedDate < 3) {

        $jamSelesai = date('H:i:s', strtotime($jamMulai . ' +2 hours'));

$insertStmt = $pdo->prepare(
    'INSERT INTO jadwal_kerja
    (tanggal, jam_mulai, jam_selesai, kapasitas_max, status_slot)
    VALUES (?, ?, ?, ?, ?)'
);

$insertStmt->execute([
    $selectedDate,
    $jamMulai,
    $jamSelesai,
    1,
    'tersedia'
]);
        $lastId = $pdo->lastInsertId();

        $_SESSION['draft_booking']['id_jadwal'] = $lastId;
        $_SESSION['draft_booking']['tanggal'] = $selectedDate;
        $_SESSION['draft_booking']['jam_mulai'] = $jamMulai;
        $_SESSION['draft_booking']['jam_selesai'] = $jamSelesai;
        $redirectUrl = 'booking.php';
        if ($fromPage) {
            $redirectUrl .= '?from=' . urlencode($fromPage);
        }
        header('Location: ' . $redirectUrl);
        exit;

    } else {

        $errors[] = 'Tanggal ini sudah penuh. Silakan pilih tanggal lain.';

    }

    }

    }

} else {

    $errors[] = 'Lengkapi tanggal dan jam booking terlebih dahulu.';

}
        
    }

try {
    $stmt = $pdo->query('SELECT * FROM jadwal_kerja ORDER BY tanggal ASC, jam_mulai ASC');
    $jadwals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $jadwals = [];
}

// Count how many jadwal rows exist per date (used for display/info)
$dateSlotCounts = [];
$jadwalByDate = [];
foreach ($jadwals as $jadwal) {
    $date = $jadwal['tanggal'];
    $dateSlotCounts[$date] = ($dateSlotCounts[$date] ?? 0) + 1;
    $jadwalByDate[$date][] = $jadwal;
}

// Count actual bookings per jadwal (slot) and per date so we can disable fully-booked slots/dates
try {
    $bookedByJadwal = [];
    $bstmt = $pdo->query("SELECT b.id_jadwal, COUNT(*) AS cnt FROM booking b WHERE b.status_booking != 'dibatalkan' GROUP BY b.id_jadwal");
    while ($r = $bstmt->fetch(PDO::FETCH_ASSOC)) {
        $bookedByJadwal[$r['id_jadwal']] = intval($r['cnt']);
    }

    $bookedByDate = [];
    $dbstmt = $pdo->query("SELECT jk.tanggal, COUNT(*) AS cnt FROM booking b JOIN jadwal_kerja jk ON b.id_jadwal = jk.id_jadwal WHERE b.status_booking != 'dibatalkan' GROUP BY jk.tanggal");
    while ($r = $dbstmt->fetch(PDO::FETCH_ASSOC)) {
        $bookedByDate[$r['tanggal']] = intval($r['cnt']);
    }
} catch (Exception $e) {
    $bookedByJadwal = [];
    $bookedByDate = [];
}

try {
    $closedDateStmt = $pdo->query('SELECT tanggal, alasan FROM jadwal_tutup ORDER BY tanggal ASC');
    $closedDates = [];
    foreach ($closedDateStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $closedDates[$row['tanggal']] = $row['alasan'] ?: 'Tanggal ditutup admin';
    }
} catch (Exception $e) {
    $closedDates = [];
}

$currentMonth = !empty($jadwals) ? date('Y-m', strtotime($jadwals[0]['tanggal'])) : date('Y-m');
$monthStart = new DateTime($currentMonth . '-01');
$monthDays = intval($monthStart->format('t'));
$startWeekday = intval($monthStart->format('N'));
$weekDays = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
$calendarDays = [];
for ($day = 1; $day <= $monthDays; $day++) {
    $date = $currentMonth . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
    $calendarDays[$day] = [
        'date' => $date,
        'slot_count' => $dateSlotCounts[$date] ?? 0,
        'hasData' => !empty($jadwalByDate[$date]),
        'available' => (!empty($jadwalByDate[$date]) && ($dateSlotCounts[$date] ?? 0) < 3),
        'booked_count' => $bookedByDate[$date] ?? 0,
        'closed' => isset($closedDates[$date])
    ];
}

$namaProduk = htmlspecialchars($draft['nama_layanan'] ?? 'Layanan', ENT_QUOTES, 'UTF-8');
$hargaProduk = intval($draft['total'] ?? $draft['harga'] ?? 0);
$foto = htmlspecialchars($draft['foto'] ?? '../assets/foto_makeup.jpeg', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Booking MUA Yayuk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
body {
    background: #f9f6f0;
    font-family: 'Plus Jakarta Sans', Arial, Helvetica, sans-serif;
}

.wrapper {
    width: 100%;
    max-width: 1200px;
    margin: auto;
}

.card-custom {
    border: none;
    border-radius: 26px;
    overflow: hidden;
    box-shadow: 0 18px 42px rgba(0, 0, 0, 0.08);
}

.header-booking {
    background: linear-gradient(135deg, #f9d26b, #d07f26);
    padding: 24px;
    text-align: center;
    font-weight: 800;
    font-size: 24px;
    color: #3b2817;
}

.calendar-header {
    background: #ffffff;
    border-radius: 18px;
    padding: 14px 18px;
    border: 1px solid rgba(208, 127, 38, 0.18);
}

.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 12px;
    margin-top: 16px;
}

.tgl {
    border: none;
    background: #fff;
    padding: 14px 0;
    border-radius: 14px;
    font-size: 16px;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    min-height: 58px;
    color: #4f3a25;
    box-shadow: inset 0 0 0 1px rgba(208, 127, 38, 0.1);
}

.tgl:hover {
    transform: translateY(-2px);
    background: #fff3e0;
}

.tgl.active {
    background: linear-gradient(135deg, #d07f26, #f0b062);
    color: #fff;
    box-shadow: 0 12px 20px rgba(208, 127, 38, 0.18);
}

.tgl.disabled {
    background: #f4f0eb;
    cursor: not-allowed;
    opacity: 0.6;
    color: #8d7c6a;
    box-shadow: none;
}

.tgl.unavailable {
    background: #fff1e8;
    color: #9a3412;
    box-shadow: inset 0 0 0 1px rgba(154, 52, 18, 0.18);
}

.slot {
    background: #ffffff;
    padding: 16px;
    border-radius: 16px;
    cursor: pointer;
    margin-bottom: 12px;
    transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid rgba(208, 127, 38, 0.14);
}

.slot:hover {
    transform: translateY(-2px);
    border-color: #d07f26;
}

.slot.selected {
    background: linear-gradient(135deg, #d07f26, #f0b062);
    font-weight: 700;
    color: #fff;
    border-color: #b15b12;
}

.slot.disabled {
    cursor: not-allowed;
    opacity: 0.6;
    background: #f4f0eb;
    border-color: rgba(208, 127, 38, 0.08);
}

.btn-lanjut {
    background: linear-gradient(135deg, #d07f26, #b15b12);
    border: none;
    padding: 14px;
    font-weight: 700;
    color: #fff;
    width: 100%;
    border-radius: 16px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-lanjut:hover {
    background: linear-gradient(135deg, #b15b12, #8a4c18);
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.14);
}

.alert {
    border-radius: 16px;
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
}

.availability-note {
    border-radius: 16px;
    padding: 16px;
    margin-bottom: 18px;
    border: 1px solid rgba(208, 127, 38, 0.18);
    background: #fff8ed;
    color: #4f3a25;
}

.slot-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 16px;
    color: #3b2817;
}

.badge-info {
    background: #f9e1bc;
    color: #8a5b2f;
    border-radius: 999px;
    padding: 4px 10px;
    font-size: 0.8rem;
    font-weight: 700;
}
.back-nav {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 28px rgba(0,0,0,0.1);
    color: #2b1f15;
    text-decoration: none;
    transition: all 0.25s ease;
}

.back-nav:hover {
    background: #d07f26;
    color: white;
    transform: translateX(-4px);
}
.back-container {
    margin-top: 110px;
    margin-bottom: 20px;
}
.label-waktu {
    font-weight: 600; /* Membuat teks tebal/semibold */
    display: block;
    margin-bottom: 8px; /* Memberi jarak antara label dan input */
}

.input-waktu {
    width: 10%; /* Atur angka ini untuk memendekkan lebar (contoh: 150px, 200px, atau 20%) */
    padding: 10px 15px; /* Menjaga ukuran input tetap proporsional */
    border: 1px solid #E5E5E5;
    border-radius: 8px; /* Melanjutkan lengkungan yang pas dari sebelumnya */
    font-size: 16px; /* Ukuran teks di dalam input */
}

@media (max-width: 768px) {
    body {
        padding-bottom: 32px;
    }

    .back-container {
        margin-top: 88px;
        margin-bottom: 14px;
    }

    .container-fluid {
        padding-left: 14px;
        padding-right: 14px;
    }

    .card-custom {
        border-radius: 18px;
    }

    .header-booking {
        padding: 18px 14px;
        font-size: 20px;
    }

    .calendar-header {
        padding: 12px;
        gap: 10px;
    }

    .calendar {
        gap: 7px;
    }

    .tgl {
        min-height: 44px;
        padding: 9px 0;
        border-radius: 10px;
        font-size: 14px;
    }

    .input-waktu {
        width: 100%;
        max-width: 260px;
    }

    .slot-title {
        font-size: 1rem;
    }
}
</style>
</head>

<body>

<!-- Navbar Include -->
<?php include 'include/navbar.php'; ?>
<div class="container back-container">
    <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="back-nav">
        <i class="bi bi-chevron-left"></i>
    </a>
</div>

<div class="container-fluid px-lg-5">
    <div class="card card-custom">

        <div class="header-booking">
            Cek Ketersediaan Jadwal
        </div>


        
        <div class="card-body">

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Header Bulan -->
            <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-sm btn-outline-dark" onclick="prevMonth()">❮</button>

                <span class="fw-semibold" id="bulanTahun"></span>

                <button class="btn btn-sm btn-outline-dark" onclick="nextMonth()">❯</button>
            </div>

            <!-- Kalender -->
            <div class="calendar mb-4" id="calendar"></div>

            <div id="availabilityMessage" class="availability-note" style="display:none;"></div>

          <!-- Form Booking -->
<form id="slotForm" method="post" action="penjadwalan.php<?= $fromPage ? '?from=' . urlencode($fromPage) : '' ?>">

    <div id="slotArea" style="display:none;">

        <h5 class="slot-title">Jadwal Tersedia</h5>
        <p class="text-muted mb-4">
            Silakan tentukan jam booking sesuai kebutuhan Anda, lalu lanjutkan ke review booking.
        </p>

        <input type="hidden" name="selected_date" id="selected_date">

        <div class="mb-3">

    <label class="label-waktu">
    Pilih Jam Booking
</label>

<input
    type="time"
    name="jam_mulai"
    class="input-waktu"
    required
>

</div>

        <button type="submit" class="btn btn-lanjut w-100 mt-3">
            LANJUTKAN KE BOOKING &rarr;
        </button>

    </div>

</form>

<script>
const jadwalData = <?= json_encode($jadwalByDate, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
const bookedByJadwal = <?= json_encode($bookedByJadwal ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
const bookedByDate = <?= json_encode($bookedByDate ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
const closedDates = <?= json_encode($closedDates ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
const todayStr = <?= json_encode($today); ?>;
const defaultSlots = [
    { label: 'Pagi', start: '07:00', end: '10:00' },
    { label: 'Siang', start: '11:00', end: '13:00' },
    { label: 'Malam', start: '15:00', end: '18:00' }
];
let currentDate = new Date();

function renderCalendar() {
    const calendar = document.getElementById('calendar');
    calendar.innerHTML = '';

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    const bulanNama = [
        'Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember'
    ];

    document.getElementById('bulanTahun').innerText = bulanNama[month] + ' ' + year;

    const firstDay = new Date(year, month, 1).getDay();
    const totalDays = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
        calendar.innerHTML += '<div></div>';
    }

    for (let i = 1; i <= totalDays; i++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
        const isClosed = Object.prototype.hasOwnProperty.call(closedDates, dateStr);
        const isPastDate = dateStr < todayStr;
        const isFull = (bookedByDate[dateStr] || 0) >= 3;
        const isDisabled = isPastDate;
        const isUnavailable = isClosed || isFull;
        const disabledLabel = isPastDate ? 'Tanggal sudah lewat' : (isClosed ? 'Ditutup admin' : 'Penuh');
        calendar.innerHTML += `
            <button type="button" class="tgl${isDisabled ? ' disabled' : ''}${isUnavailable ? ' unavailable' : ''}" ${isDisabled ? 'disabled' : ''} data-date="${dateStr}" title="${(isDisabled || isUnavailable) ? disabledLabel : 'Tersedia'}" onclick="pilihTanggal(this)">
                ${i}
            </button>
        `;
    }
}

function prevMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
    clearSlotSelection();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
    clearSlotSelection();
}

function pilihTanggal(el) {

    document.querySelectorAll('.tgl').forEach(t => {
        t.classList.remove('active');
    });

    el.classList.add('active');

    const selectedDate = el.dataset.date;
    const message = document.getElementById('availabilityMessage');
    const isClosed = Object.prototype.hasOwnProperty.call(closedDates, selectedDate);
    const isFull = (bookedByDate[selectedDate] || 0) >= 3;

    if (isClosed || isFull) {
        const reason = isClosed ? `Tanggal ini ditutup oleh admin: ${closedDates[selectedDate]}` : 'Tanggal ini sudah penuh.';
        const alternatives = findAlternativeDates(selectedDate);
        message.style.display = 'block';
        message.innerHTML = `
            <div class="fw-bold mb-1">Jadwal tidak tersedia</div>
            <div>${reason}</div>
            ${alternatives.length ? `<div class="small mt-2">Rekomendasi tanggal lain: ${alternatives.join(', ')}</div>` : '<div class="small mt-2">Belum ada rekomendasi tanggal tersedia di bulan ini. Coba geser ke bulan berikutnya.</div>'}
        `;
        document.getElementById('slotArea').style.display = 'none';
        document.getElementById('selected_date').value = '';
        return;
    }

    document.getElementById('selected_date').value = selectedDate;

    message.style.display = 'block';
    message.innerHTML = `
        <div class="fw-bold mb-1">Jadwal tersedia</div>
        <div>Tanggal ini masih tersedia. Silakan pilih jam booking untuk melanjutkan.</div>
    `;

    document.getElementById('slotArea').style.display = 'block';
}

function findAlternativeDates(selectedDate) {
    const dates = [];
    const selected = new Date(selectedDate + 'T00:00:00');
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const totalDays = new Date(year, month + 1, 0).getDate();

    for (let i = 1; i <= totalDays; i++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
        const dateObj = new Date(dateStr + 'T00:00:00');
        if (dateObj <= selected || dateStr < todayStr) {
            continue;
        }
        if (Object.prototype.hasOwnProperty.call(closedDates, dateStr) || (bookedByDate[dateStr] || 0) >= 3) {
            continue;
        }
        dates.push(formatDisplayDate(dateStr));
        if (dates.length === 3) {
            break;
        }
    }

    return dates;
}

function formatDisplayDate(dateStr) {
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
}
function renderSlots(date) {
    const slots = jadwalData[date] || [];
    const slotList = document.getElementById('slotList');
    const fullDate = (bookedByDate[date] || 0) >= 3;

    // If date is fully booked, show message
    if (fullDate) {
        slotList.innerHTML = '<p class="text-muted">Tanggal ini sudah penuh. Silakan pilih tanggal lain.</p>';
        document.getElementById('selected_slot').value = '';
        return;
    }

    let html = '';

    html = defaultSlots.map(defaultSlot => {
        const existingSlot = slots.find(slot => {
            return slot.jam_mulai.slice(0, 5) === defaultSlot.start
                && slot.jam_selesai.slice(0, 5) === defaultSlot.end;
        });

        if (existingSlot) {
            const bookedCount = bookedByJadwal[existingSlot.id_jadwal] || 0;
            const kapasitas = parseInt(existingSlot.kapasitas_max || 1, 10);
            const isAvailable = existingSlot.status_slot === 'tersedia' && bookedCount < kapasitas;
            return `
                <div class="slot${isAvailable ? '' : ' disabled'}" data-id="${existingSlot.id_jadwal}" onclick="pilihSlot(this)">
                    <div>
                        <div>${defaultSlot.label} (${defaultSlot.start} - ${defaultSlot.end})</div>
                        <div class="text-muted small">${isAvailable ? 'Tersedia' : 'Sudah terisi'}</div>
                    </div>
                    <span class="badge-info">${isAvailable ? 'Open' : 'Closed'}</span>
                </div>
            `;
        }

        return `
            <div class="slot" data-id="default|${date}|${defaultSlot.start}|${defaultSlot.end}" onclick="pilihSlot(this)">
                <div>
                    <div>${defaultSlot.label} (${defaultSlot.start} - ${defaultSlot.end})</div>
                    <div class="text-muted small">Tersedia</div>
                </div>
                <span class="badge-info">Open</span>
            </div>
        `;
    }).join('');

    slotList.innerHTML = html;
    document.getElementById('selected_slot').value = '';
}

function pilihSlot(el) {
    if (el.classList.contains('disabled')) {
        return;
    }
    document.querySelectorAll('.slot').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selected_slot').value = el.dataset.id;
}

function clearSlotSelection() {
    document.getElementById('slotArea').style.display = 'none';
    const message = document.getElementById('availabilityMessage');
    if (message) {
        message.style.display = 'none';
        message.innerHTML = '';
    }
}

renderCalendar();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

