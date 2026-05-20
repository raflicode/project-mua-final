<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$draft = $_SESSION['draft_booking'] ?? null;
if (!$draft) {
    header('Location: booking.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedSlotRaw = trim($_POST['selected_slot'] ?? '');
    $selectedId = filter_var($selectedSlotRaw, FILTER_VALIDATE_INT);
    $jadwal = null;

    if ($selectedSlotRaw !== '') {
        if ($selectedId) {
            $stmt = $pdo->prepare('SELECT * FROM jadwal_kerja WHERE id_jadwal = ? LIMIT 1');
            $stmt->execute([$selectedId]);
            $jadwal = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($jadwal) {
                $bstmt = $pdo->prepare('SELECT COUNT(*) FROM booking WHERE id_jadwal = ? AND status_booking != ?');
                $bstmt->execute([$jadwal['id_jadwal'], 'dibatalkan']);
                $bookedSlot = intval($bstmt->fetchColumn());

                $dbstmt = $pdo->prepare('SELECT COUNT(*) FROM booking b JOIN jadwal_kerja jk ON b.id_jadwal = jk.id_jadwal WHERE jk.tanggal = ? AND b.status_booking != ?');
                $dbstmt->execute([$jadwal['tanggal'], 'dibatalkan']);
                $bookedDate = intval($dbstmt->fetchColumn());

                if ($jadwal['status_slot'] === 'tersedia' && $bookedSlot < intval($jadwal['kapasitas_max']) && $bookedDate < 3) {
                    $_SESSION['draft_booking']['id_jadwal'] = $jadwal['id_jadwal'];
                    $_SESSION['draft_booking']['tanggal'] = $jadwal['tanggal'];
                    $_SESSION['draft_booking']['jam_mulai'] = $jadwal['jam_mulai'];
                    $_SESSION['draft_booking']['jam_selesai'] = $jadwal['jam_selesai'];
                    header('Location: pembayaran.php');
                    exit;
                }
            }

        } elseif (preg_match('/^default\|(\d{4}-\d{2}-\d{2})\|([0-2]\d:[0-5]\d)\|([0-2]\d:[0-5]\d)$/', $selectedSlotRaw, $matches)) {
            $selectedDate = $matches[1];
            $jamMulai = $matches[2];
            $jamSelesai = $matches[3];

            $existingStmt = $pdo->prepare('SELECT * FROM jadwal_kerja WHERE tanggal = ? AND jam_mulai = ? AND jam_selesai = ? LIMIT 1');
            $existingStmt->execute([$selectedDate, $jamMulai, $jamSelesai]);
            $existingJadwal = $existingStmt->fetch(PDO::FETCH_ASSOC);

            $dbstmt = $pdo->prepare('SELECT COUNT(*) FROM booking b JOIN jadwal_kerja jk ON b.id_jadwal = jk.id_jadwal WHERE jk.tanggal = ? AND b.status_booking != ?');
            $dbstmt->execute([$selectedDate, 'dibatalkan']);
            $bookedDate = intval($dbstmt->fetchColumn());

            if ($existingJadwal) {
                $bstmt = $pdo->prepare('SELECT COUNT(*) FROM booking WHERE id_jadwal = ? AND status_booking != ?');
                $bstmt->execute([$existingJadwal['id_jadwal'], 'dibatalkan']);
                $bookedSlot = intval($bstmt->fetchColumn());

                if ($existingJadwal['status_slot'] === 'tersedia' && $bookedSlot < intval($existingJadwal['kapasitas_max']) && $bookedDate < 3) {
                    $_SESSION['draft_booking']['id_jadwal'] = $existingJadwal['id_jadwal'];
                    $_SESSION['draft_booking']['tanggal'] = $existingJadwal['tanggal'];
                    $_SESSION['draft_booking']['jam_mulai'] = $existingJadwal['jam_mulai'];
                    $_SESSION['draft_booking']['jam_selesai'] = $existingJadwal['jam_selesai'];
                    header('Location: pembayaran.php');
                    exit;
                }
            } elseif ($bookedDate < 3) {
                $insertStmt = $pdo->prepare('INSERT INTO jadwal_kerja (tanggal, jam_mulai, jam_selesai, kapasitas_max, status_slot) VALUES (?, ?, ?, ?, ?)');
                $insertStmt->execute([$selectedDate, $jamMulai, $jamSelesai, 1, 'tersedia']);
                $lastId = $pdo->lastInsertId();
                $stmt = $pdo->prepare('SELECT * FROM jadwal_kerja WHERE id_jadwal = ? LIMIT 1');
                $stmt->execute([$lastId]);
                $jadwal = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($jadwal) {
                    $_SESSION['draft_booking']['id_jadwal'] = $jadwal['id_jadwal'];
                    $_SESSION['draft_booking']['tanggal'] = $jadwal['tanggal'];
                    $_SESSION['draft_booking']['jam_mulai'] = $jadwal['jam_mulai'];
                    $_SESSION['draft_booking']['jam_selesai'] = $jadwal['jam_selesai'];
                    header('Location: pembayaran.php');
                    exit;
                }
            }
        }

        $errors[] = 'Slot yang dipilih telah terisi atau tanggal tidak tersedia. Silakan pilih lagi.';
    } else {
        $errors[] = 'Silakan pilih slot waktu terlebih dahulu.';
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
        'booked_count' => $bookedByDate[$date] ?? 0
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
</style>
</head>

<body>

<!-- Navbar Include -->
<?php include 'include/navbar.php'; ?>

<div class="container-fluid mt-5 px-lg-5" style="padding-top: 50px;">
    <div class="card card-custom">

        <div class="header-booking">
            Pilih Ketersediaan Tanggal
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

            <!-- Slot -->
            <form id="slotForm" method="post" action="penjadwalan.php">
                <div id="slotArea" style="display:none;">

                    <h5 class="slot-title">Pilih Slot Waktu</h5>
                    <p class="text-muted mb-4">Pilih slot yang tersedia untuk tanggal terpilih.</p>

                    <input type="hidden" name="selected_slot" id="selected_slot" value="">
                    <div id="slotList"></div>

                    <button type="submit" class="btn btn-lanjut w-100 mt-3">
                        LANJUTKAN BOOKING →
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

<script>
const jadwalData = <?= json_encode($jadwalByDate, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
const bookedByJadwal = <?= json_encode($bookedByJadwal ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
const bookedByDate = <?= json_encode($bookedByDate ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
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
        const isDisabled = (bookedByDate[dateStr] || 0) >= 3;
        calendar.innerHTML += `
            <button type="button" class="tgl${isDisabled ? ' disabled' : ''}" ${isDisabled ? 'disabled' : ''} data-date="${dateStr}" onclick="pilihTanggal(this)">
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
    document.querySelectorAll('.tgl').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    const selectedDate = el.dataset.date;
    renderSlots(selectedDate);
    document.getElementById('slotArea').style.display = 'block';
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
    document.getElementById('slotList').innerHTML = '';
    document.getElementById('selected_slot').value = '';
}

renderCalendar();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

