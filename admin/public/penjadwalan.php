<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);
require_once __DIR__ . '/../../config/koneksi.php';

$selectedYear = (int) ($_GET['year'] ?? date('Y'));
$selectedMonth = (int) ($_GET['month'] ?? date('n'));

if ($selectedMonth < 1 || $selectedMonth > 12) {
    $selectedMonth = (int) date('n');
}

if ($selectedYear < 2000 || $selectedYear > 2100) {
    $selectedYear = (int) date('Y');
}

$monthNames = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
];

// Mengubah nama hari menjadi format Inggris minimalis sesuai referensi gambar
$weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

$monthLabel = $monthNames[$selectedMonth] . ' ' . $selectedYear;
$firstDayOfMonth = strtotime(sprintf('%04d-%02d-01', $selectedYear, $selectedMonth));
$daysInMonth = (int) date('t', $firstDayOfMonth);
$firstWeekDay = (int) date('w', $firstDayOfMonth);
$startPadding = $firstWeekDay;
$selectedMonthStart = date('Y-m-01 00:00:00', $firstDayOfMonth);
$selectedMonthEnd = date('Y-m-01 00:00:00', strtotime('+1 month', $firstDayOfMonth));

$bookingCounts = [];
$bookingDetailsByDate = [];
$allBookingsThisMonth = []; // Menampung semua list untuk panel kanan

$stmt = $pdo->prepare(
    "SELECT DATE(tgl_booking) AS booking_date, COUNT(*) AS total_pesanan
     FROM booking
     WHERE status_booking <> 'dibatalkan'
       AND tgl_booking IS NOT NULL
       AND tgl_booking >= :start_date
       AND tgl_booking < :end_date
     GROUP BY DATE(tgl_booking)"
);
$stmt->execute([
    ':start_date' => $selectedMonthStart,
    ':end_date' => $selectedMonthEnd,
]);

foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $dateKey = $row['booking_date'];
    $bookingCounts[$dateKey] = (int) $row['total_pesanan'];
}

$detailStmt = $pdo->prepare(
    "SELECT id_booking, tgl_booking, total_harga, status_booking
     FROM booking
     WHERE status_booking <> 'dibatalkan'
       AND tgl_booking IS NOT NULL
       AND tgl_booking >= :start_date
       AND tgl_booking < :end_date
     ORDER BY tgl_booking ASC, id_booking ASC"
);
$detailStmt->execute([
    ':start_date' => $selectedMonthStart,
    ':end_date' => $selectedMonthEnd,
]);

foreach ($detailStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $dateKey = date('Y-m-d', strtotime($row['tgl_booking']));
    $bookingData = [
        'id_booking' => (int) $row['id_booking'],
        'tanggal' => $row['tgl_booking'],
        'tgl_label' => date('d M Y', strtotime($row['tgl_booking'])),
        'jam_label' => date('H:i', strtotime($row['tgl_booking'])),
        'status' => $row['status_booking'],
        'total_harga' => (int) $row['total_harga'],
    ];
    $bookingDetailsByDate[$dateKey][] = $bookingData;
    $allBookingsThisMonth[] = $bookingData;
}

$prevYear = $selectedMonth === 1 ? $selectedYear - 1 : $selectedYear;
$prevMonth = $selectedMonth === 1 ? 12 : $selectedMonth - 1;
$nextYear = $selectedMonth === 12 ? $selectedYear + 1 : $selectedYear;
$nextMonth = $selectedMonth === 12 ? 1 : $selectedMonth + 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Schedules</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="../assets/admin-brown.css" rel="stylesheet">
    <link href="../assets/admin-layout.css" rel="stylesheet">

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f8fafc;
        }

        .content-container {
            padding: 1.5rem;
        }

        .page-main-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.5rem;
        }

        /* --- STYLING CARD KIRI & KANAN (UI CLEAN STYLE) --- */
        .ui-schedule-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.01);
            height: 100%;
        }

        .calendar-header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .calendar-ui-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .calendar-nav-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-nav-arrow {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-nav-arrow:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        /* --- GRID KALENDER PERSIS SEPERTI GAMBAR --- */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            row-gap: 1rem;
            column-gap: 0.5rem;
        }

        .calendar-head {
            text-align: center;
            font-size: 0.8rem;
            font-weight: 500;
            color: #94a3b8; /* Abu-abu terang untuk header hari */
            padding-bottom: 0.5rem;
        }

        .calendar-cell {
            aspect-ratio: 1 / 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .calendar-day-number {
            font-weight: 500;
            color: #334155;
            font-size: 1rem;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .calendar-cell.clickable {
            cursor: pointer;
        }

        /* Titik indikator kecil di bawah tanggal jika ada pesanan */
        .calendar-dot-indicator {
            width: 4px;
            height: 4px;
            background-color: #8b5e3c;
            border-radius: 50%;
            position: absolute;
            bottom: 2px;
        }

        /* Highlight Hari Ini (Today) */
        .calendar-cell.today .calendar-day-number {
            border: 2px solid #c78d49;
            color: #c78d49;
            font-weight: 700;
        }

        /* Highlight Hari yang Dipilih / Paling Ramai (Bulatan Soft Krem kekuningan) */
        .calendar-cell.has-orders .calendar-day-number {
            background: #fef3e2; 
            color: #c78d49;
            font-weight: 600;
        }

        .calendar-cell.clickable:hover .calendar-day-number {
            background: #f1f5f9;
        }

        /* --- RIGHT SIDEBAR: LIST SCHEDULES --- */
        .schedule-right-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .schedule-right-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .btn-add-schedule {
            background: #e0f2fe;
            color: #0369a1;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 0.4rem 0.85rem;
            border-radius: 12px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .schedule-list-wrapper {
            max-height: 420px;
            overflow-y: auto;
            padding-right: 0.25rem;
        }

        /* Item Pesanan Bergaya Garis Vertikal Indikator Warna */
        .schedule-item-card {
            border-left: 4px solid #8b5e3c; /* Warna utama MUA */
            background: #f8fafc;
            padding: 0.85rem 1rem;
            border-radius: 0 12px 12px 0;
            margin-bottom: 1rem;
            transition: transform 0.15s;
        }

        .schedule-item-card:hover {
            transform: translateX(2px);
            background: #f1f5f9;
        }

        .schedule-item-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1e293b;
            margin-bottom: 0.2rem;
        }

        .schedule-item-time {
            font-size: 0.8rem;
            color: #64748b;
        }

        /* Filter Selector Atas */
        .filter-form-wrapper {
            background: #ffffff;
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }
    </style>
</head>

<body>
    <?php
    $page = 'penjadwalan';
    include 'include/sidebar.php';
    ?>

    <div class="main">
        <?php
        $page_title = 'Schedules';
        $breadcrumb = 'Admin / Schedules';
        include 'include/header.php';
        ?>

        <div class="content content-container">
            <h1 class="page-main-title">Schedules</h1>

            <div class="filter-form-wrapper">
                <form method="get" class="row g-2 align-items-center">
                    <div class="col-auto">
                        <select name="month" class="form-select form-select-sm">
                            <?php for ($m = 1; $m <= 12; $m++) : ?>
                                <option value="<?= $m ?>" <?= $m === $selectedMonth ? 'selected' : '' ?>><?= $monthNames[$m] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select name="year" class="form-select form-select-sm">
                            <?php for ($y = (int) date('Y') - 2; $y <= (int) date('Y') + 1; $y++) : ?>
                                <option value="<?= $y ?>" <?= $y === $selectedYear ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-dark px-3">Filter</button>
                    </div>
                </form>
            </div>

            <div class="row g-4">
                
                <div class="col-xl-8 col-lg-7">
                    <div class="ui-schedule-card">
                        <div class="calendar-header-wrapper">
                            <h2 class="calendar-ui-title"><?= htmlspecialchars($monthLabel) ?></h2>
                            <div class="calendar-nav-buttons">
                                <a class="btn-nav-arrow" href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" title="Previous Month">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                                <a class="btn-nav-arrow" href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" title="Next Month">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="calendar-grid">
                            <?php foreach ($weekDays as $day) : ?>
                                <div class="calendar-head"><?= $day ?></div>
                            <?php endforeach; ?>

                            <?php for ($i = 0; $i < $startPadding; $i++) : ?>
                                <div class="calendar-cell empty"></div>
                            <?php endfor; ?>

                            <?php for ($day = 1; $day <= $daysInMonth; $day++) :
                                $dateKey = sprintf('%04d-%02d-%02d', $selectedYear, $selectedMonth, $day);
                                $count = (int) ($bookingCounts[$dateKey] ?? 0);
                                $isToday = $dateKey === date('Y-m-d');
                            ?>
                                <div
                                    class="calendar-cell <?= $count > 0 ? 'has-orders clickable' : '' ?> <?= $isToday ? 'today' : '' ?>"
                                    data-date="<?= htmlspecialchars($dateKey) ?>"
                                    role="<?= $count > 0 ? 'button' : 'presentation' ?>"
                                    tabindex="<?= $count > 0 ? '0' : '-1' ?>"
                                >
                                    <div class="calendar-day-number"><?= $day ?></div>
                                    
                                    <?php if ($count > 0) : ?>
                                        <div class="calendar-dot-indicator"></div>
                                    <?php endif; ?>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5">
                    <div class="ui-schedule-card">
                        <div class="schedule-right-header">
                            <h3 class="schedule-right-title">Schedules</h3>
                            <button class="btn-add-schedule" onclick="window.location.href='booking.php'">
                                <i class="bi bi-plus-lg"></i> Add
                            </button>
                        </div>

                        <div class="schedule-list-wrapper" id="scheduleDisplayList">
                            <?php if (empty($allBookingsThisMonth)) : ?>
                                <div class="text-muted small text-center py-5">No schedules for this month.</div>
                            <?php else : ?>
                                <?php foreach ($allBookingsThisMonth as $b) : ?>
                                    <div class="schedule-item-card" style="cursor: pointer;" onclick="filterModalFromRight('<?= date('Y-m-d', strtotime($b['tanggal'])) ?>')">
                                        <div class="schedule-item-title">Booking #<?= $b['id_booking'] ?> (<?= htmlspecialchars($b['status']) ?>)</div>
                                        <div class="schedule-item-time">
                                            <i class="bi bi-clock me-1"></i> <?= $b['jam_label'] ?> | <i class="bi bi-calendar3 me-1"></i> <?= $b['tgl_label'] ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header" style="border-bottom: 1px solid #f1f5f9;">
                    <h5 class="modal-title font-weight-bold" id="bookingDetailModalLabel" style="color: #0f172a; font-weight: 700;">Schedule Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="bookingDetailModalBody">
                    <div class="text-muted">Loading data...</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const bookingDetailsByDate = <?= json_encode($bookingDetailsByDate, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        const detailModal = new bootstrap.Modal(document.getElementById('bookingDetailModal'));
        const modalTitle = document.getElementById('bookingDetailModalLabel');
        const modalBody = document.getElementById('bookingDetailModalBody');

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(Number(value) || 0);
        }

        function formatDateLabel(dateValue) {
            const safeDate = new Date(`${dateValue}T12:00:00`);
            return safeDate.toLocaleDateString('en-US', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
            });
        }

        function renderBookingRows(bookings) {
            if (!bookings || bookings.length === 0) {
                return '<div class="text-muted text-center py-3">No schedules on this date.</div>';
            }

            return bookings.map((booking) => `
                <div class="p-3 mb-2" style="background: #f8fafc; border-radius: 12px; border-left: 4px solid #c78d49;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong style="color: #1e293b;">Booking #${booking.id_booking}</strong>
                        <span class="badge" style="background: #fef3e2; color: #c78d49;">${booking.status}</span>
                    </div>
                    <div class="small text-muted mb-2"><i class="bi bi-clock"></i> Time: ${booking.jam_label}</div>
                    <div class="small font-weight-bold text-dark" style="font-weight: 500;">Total: ${formatRupiah(booking.total_harga)}</div>
                </div>
            `).join('');
        }

        function openBookingDetails(date) {
            const bookings = bookingDetailsByDate[date] || [];
            modalTitle.textContent = `Schedule - ${formatDateLabel(date)}`;
            modalBody.innerHTML = renderBookingRows(bookings);
            detailModal.show();
        }

        function filterModalFromRight(date) {
            openBookingDetails(date);
        }

        document.querySelectorAll('.calendar-cell.clickable').forEach((cell) => {
            cell.addEventListener('click', () => {
                openBookingDetails(cell.dataset.date);
            });
        });
    </script>
</body>
</html>