<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../config/db_helpers.php';

ensure_dynamic_booking_schema($pdo);

$monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
$monthlyIncome = [];
$monthlyLabels = [];
$firstMonth = new DateTime('first day of this month');
$firstMonth->modify('-11 months');
$currentMonthStart = (new DateTime('first day of this month'))->format('Y-m-01 00:00:00');
$nextMonthStart = (new DateTime('first day of next month'))->format('Y-m-01 00:00:00');

for ($i = 0; $i < 12; $i++) {
    $month = (clone $firstMonth)->modify("+{$i} months");
    $key = $month->format('Y-m');
    $monthlyIncome[$key] = 0;
    $monthlyLabels[] = $monthNames[((int) $month->format('n')) - 1] . ' ' . $month->format('y');
}

$incomeStmt = $pdo->prepare("
    SELECT DATE_FORMAT(COALESCE(tgl_upload, created_at), '%Y-%m') AS bulan,
           COALESCE(SUM(jumlah_bayar), 0) AS total
    FROM pembayaran
    WHERE status_verifikasi = 'diterima'
      AND COALESCE(tgl_upload, created_at) >= :start_date
    GROUP BY bulan
    ORDER BY bulan
");
$incomeStmt->execute(['start_date' => $firstMonth->format('Y-m-01 00:00:00')]);
foreach ($incomeStmt->fetchAll() as $row) {
    if (array_key_exists($row['bulan'], $monthlyIncome)) {
        $monthlyIncome[$row['bulan']] = (float) $row['total'];
    }
}

$unfinishedBookingStmt = $pdo->query("
    SELECT COUNT(*)
    FROM booking
    WHERE status_booking NOT IN ('selesai', 'dibatalkan')
");
$unfinishedBookingCount = (int) $unfinishedBookingStmt->fetchColumn();

$monthlyRevenueStmt = $pdo->prepare("
    SELECT COALESCE(SUM(jumlah_bayar), 0)
    FROM pembayaran
    WHERE status_verifikasi = 'diterima'
      AND COALESCE(tgl_upload, created_at) >= :start_date
      AND COALESCE(tgl_upload, created_at) < :end_date
");
$monthlyRevenueStmt->execute([
    'start_date' => $currentMonthStart,
    'end_date' => $nextMonthStart,
]);
$currentMonthRevenue = (float) $monthlyRevenueStmt->fetchColumn();

$pendingPaymentStmt = $pdo->query("
    SELECT COUNT(*)
    FROM pembayaran
    WHERE status_verifikasi = 'pending'
");
$pendingPaymentCount = (int) $pendingPaymentStmt->fetchColumn();

$monthlyBookingStmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM booking
    WHERE created_at >= :start_date
      AND created_at < :end_date
      AND status_booking <> 'dibatalkan'
");
$monthlyBookingStmt->execute([
    'start_date' => $currentMonthStart,
    'end_date' => $nextMonthStart,
]);
$currentMonthBookingCount = (int) $monthlyBookingStmt->fetchColumn();

$serviceStmt = $pdo->query("
    SELECT kategori_layanan, COALESCE(SUM(qty), 0) AS total_pesanan
    FROM (
        SELECT
            CASE
                WHEN LOWER(l.nama_layanan) LIKE '%makeup%' THEN 'Makeup'
                WHEN LOWER(l.nama_layanan) LIKE '%dekor%' OR LOWER(l.nama_layanan) LIKE '%terop%' THEN 'Dekor'
                WHEN LOWER(l.nama_layanan) LIKE '%kostum%' THEN 'Kostum'
                ELSE 'Paket'
            END AS kategori_layanan,
            bd.qty
        FROM booking_detail bd
        INNER JOIN layanan l ON l.id_layanan = bd.id_layanan
        INNER JOIN booking b ON b.id_booking = bd.id_booking
        WHERE b.status_booking <> 'dibatalkan'
    ) kategori
    GROUP BY kategori_layanan
    ORDER BY total_pesanan DESC, kategori_layanan ASC
");
$serviceRows = $serviceStmt->fetchAll();
$serviceLabels = array_column($serviceRows, 'kategori_layanan');
$serviceTotals = array_map('intval', array_column($serviceRows, 'total_pesanan'));

$paymentStmt = $pdo->query("
    SELECT p.id_pembayaran,
           p.jumlah_bayar,
           p.metode_bayar,
           COALESCE(p.tgl_upload, p.created_at) AS tanggal_bayar,
           p.status_verifikasi,
           p.bukti_transfer,
           b.status_booking,
           u.full_name,
           COALESCE(ls.nama_layanan, '-') AS nama_layanan
    FROM pembayaran p
    INNER JOIN booking b ON b.id_booking = p.id_booking
    INNER JOIN user u ON u.id_user = b.id_user
    LEFT JOIN (
        SELECT bd.id_booking, GROUP_CONCAT(l.nama_layanan ORDER BY l.nama_layanan SEPARATOR ', ') AS nama_layanan
        FROM booking_detail bd
        INNER JOIN layanan l ON l.id_layanan = bd.id_layanan
        GROUP BY bd.id_booking
    ) ls ON ls.id_booking = b.id_booking
    ORDER BY COALESCE(p.tgl_upload, p.created_at) DESC
    LIMIT 8
");
$paymentRows = $paymentStmt->fetchAll();

function rupiah($value): string {
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
}

function payment_badge(string $status): array {
    return match ($status) {
        'diterima' => ['Lunas', 'bg-success'],
        'ditolak' => ['Ditolak', 'bg-danger'],
        default => ['Menunggu', 'bg-warning text-dark'],
    };
}

function verification_message(?string $status): ?array {
    return match ($status) {
        'accepted' => ['success', 'Pembayaran berhasil diverifikasi sebagai diterima.'],
        'rejected' => ['warning', 'Pembayaran berhasil ditandai ditolak.'],
        'invalid' => ['danger', 'Data verifikasi tidak valid.'],
        'failed' => ['danger', 'Verifikasi gagal diproses. Coba lagi.'],
        default => null,
    };
}

function format_tanggal_id($date): string {
    if (!$date) {
        return '-';
    }

    $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return '-';
    }

    return date('d', $timestamp) . ' ' . $monthNames[((int) date('n', $timestamp)) - 1] . ' ' . date('Y', $timestamp);
}

function payment_proof_url(?string $fileName): string {
    $fileName = trim((string) $fileName);
    if ($fileName === '') {
        return '';
    }

    if (preg_match('#^https?://#i', $fileName)) {
        return $fileName;
    }

    $normalized = str_replace('\\', '/', $fileName);
    if (str_contains($normalized, '/')) {
        $normalized = basename($normalized);
    }

    return '../../assets/bukti_pembayaran/' . rawurlencode($normalized);
}

$summaryCards = [
    [
        'label' => 'Booking Belum Selesai',
        'value' => number_format($unfinishedBookingCount, 0, ',', '.'),
        'note' => 'Status pending, dibayar, atau diproses',
        'icon' => 'bi-calendar-check',
        'tone' => 'brown',
    ],
    [
        'label' => 'Pendapatan Bulan Ini',
        'value' => rupiah($currentMonthRevenue),
        'note' => 'Dari pembayaran yang diterima',
        'icon' => 'bi-cash-stack',
        'tone' => 'green',
    ],
    [
        'label' => 'Pembayaran Menunggu',
        'value' => number_format($pendingPaymentCount, 0, ',', '.'),
        'note' => 'Perlu verifikasi admin',
        'icon' => 'bi-hourglass-split',
        'tone' => 'gold',
    ],
    [
        'label' => 'Booking Bulan Ini',
        'value' => number_format($currentMonthBookingCount, 0, ',', '.'),
        'note' => 'Booking baru dari client',
        'icon' => 'bi-people',
        'tone' => 'mauve',
    ],
];

$verificationMessage = verification_message($_GET['verify'] ?? null);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Yayuk Makeover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="../assets/admin-brown.css" rel="stylesheet">
<link href="../assets/admin-layout.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root {
    --text: #4d3828;
    --text-main: #4d3828;
    --text-muted: #6b4f3d;
}
body {
    color: var(--text);
}
.text-muted {
    color: var(--text-muted) !important;
}
.welcome {
    background: linear-gradient(135deg, var(--brown-dark), var(--brown));
    color: var(--cream);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(139, 90, 43, 0.15);
}

.card-custom {
    padding: 24px;
}

canvas {
    max-height: 350px;
}

.chart-card h5,
.report-card h5 {
    color: var(--brown-dark);
    font-weight: 700;
}

.chart-note {
    color: #6b4f3d;
    font-size: 0.82rem;
}

.report-card {
    margin-top: 24px;
}

.empty-row {
    color: #6b4f3d;
    padding: 28px !important;
}

.table th,
.table td,
.summary-label,
.summary-note {
    color: #4d3828;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.summary-card {
    background: var(--white);
    border: 1.5px solid var(--cream-deep);
    border-radius: 18px;
    padding: 18px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.summary-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 42px;
    font-size: 1.1rem;
}

.summary-card.brown .summary-icon {
    background: #efe4d8;
    color: var(--brown-dark);
}

.summary-card.green .summary-icon {
    background: #edf4e6;
    color: #5f6f37;
}

.summary-card.gold .summary-icon {
    background: #fff3d8;
    color: #9a6b18;
}

.summary-card.mauve .summary-icon {
    background: #efe5ea;
    color: #8a5d6d;
}

.summary-label {
    color: var(--text-muted);
    font-size: 0.78rem;
    margin-bottom: 4px;
}

.summary-value {
    color: var(--brown-dark);
    font-size: 1.28rem;
    font-weight: 800;
    line-height: 1.15;
    word-break: normal;
    overflow-wrap: normal;
}

.summary-note {
    color: var(--text-muted);
    font-size: 0.72rem;
    margin-top: 6px;
}

.payment-actions {
    display: flex;
    justify-content: flex-end;
    gap: 6px;
}

.payment-actions form {
    margin: 0;
}

.btn-verify {
    border-radius: 10px;
    font-size: 0.76rem;
    padding: 5px 10px;
    white-space: nowrap;
}

.proof-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

@media (max-width: 1199px) {
    .summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 575px) {
    .summary-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</head>

<body>

<?php
$page = 'dashboard';
include 'include/sidebar.php';
?>

<div class="main">
    <?php
    $page_title = 'Dashboard';
    $breadcrumb = 'Admin / Dashboard';
    include 'include/header.php';
    ?>

    <div class="content">

    <!-- Welcome -->
    <div class="welcome mb-4">
        <h3>Hello, Yayuk MakeOver</h3>
        <p class="mb-0">Selamat datang kembali di dashboard Yayuk Makeover.</p>
    </div>

    <?php if ($verificationMessage): ?>
        <div class="alert alert-<?= htmlspecialchars($verificationMessage[0]) ?> mb-4">
            <?= htmlspecialchars($verificationMessage[1]) ?>
        </div>
    <?php endif; ?>

    <div class="summary-grid">
        <?php foreach ($summaryCards as $card): ?>
            <div class="summary-card <?= htmlspecialchars($card['tone']) ?>">
                <div class="summary-icon">
                    <i class="bi <?= htmlspecialchars($card['icon']) ?>"></i>
                </div>
                <div>
                    <div class="summary-label"><?= htmlspecialchars($card['label']) ?></div>
                    <div class="summary-value"><?= htmlspecialchars($card['value']) ?></div>
                    <div class="summary-note"><?= htmlspecialchars($card['note']) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Chart -->
    <div class="row g-4">

        <div class="col-lg-8">
            <div class="card card-custom chart-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-1">Pemasukan Bulanan</h5>
                        <div class="chart-note">Total pembayaran diterima dalam 12 bulan terakhir.</div>
                    </div>
                </div>
                <canvas id="incomeBarChart"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-custom chart-card p-4">
                <h5 class="mb-1">Layanan Banyak Dipesan</h5>
                <div class="chart-note mb-3">Berdasarkan kategori item booking.</div>
                <canvas id="servicePieChart"></canvas>
            </div>
        </div>

    </div>

    <div class="card card-custom report-card" id="laporan-pembayaran">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-1">Laporan Pembayaran</h5>
                <div class="chart-note">Pembayaran terbaru langsung tampil di dashboard.</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-nowrap modern-admin-table mb-0">
                <thead>
                    <tr>
                        <th class="text-nowrap table-cell-wide">Nama Pelanggan</th>
                        <th class="text-nowrap table-cell-wide">Layanan</th>
                        <th class="text-nowrap table-cell-date">Tanggal Bayar</th>
                        <th class="text-nowrap">Metode</th>
                        <th class="text-nowrap table-cell-wide">Bukti Transfer</th>
                        <th class="text-nowrap table-cell-status">Status</th>
                        <th class="text-nowrap text-end">Nominal</th>
                        <th class="text-nowrap text-end table-cell-action">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($paymentRows === []): ?>
                        <tr>
                            <td colspan="8" class="text-center empty-row">Belum ada laporan pembayaran.</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($paymentRows as $payment): ?>
                        <?php [$statusLabel, $statusClass] = payment_badge($payment['status_verifikasi']); ?>
                        <?php $proofUrl = payment_proof_url($payment['bukti_transfer']); ?>
                        <tr>
                            <td class="text-nowrap align-middle"><?= htmlspecialchars($payment['full_name']) ?></td>
                            <td class="text-nowrap align-middle"><span class="table-cell-truncate" title="<?= htmlspecialchars($payment['nama_layanan']) ?>"><?= htmlspecialchars($payment['nama_layanan']) ?></span></td>
                            <td class="text-nowrap align-middle"><?= htmlspecialchars(format_tanggal_id($payment['tanggal_bayar'])) ?></td>
                            <td class="text-nowrap align-middle"><?= htmlspecialchars(ucfirst($payment['metode_bayar'])) ?></td>
                            <td class="text-nowrap align-middle">
                                <?php if ($proofUrl !== ''): ?>
                                    <a href="<?= htmlspecialchars($proofUrl) ?>" target="_blank" class="btn btn-outline-primary btn-sm btn-verify proof-link">
                                        <i class="bi bi-receipt"></i>
                                        Cek Bukti
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Belum ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-nowrap align-middle"><span class="badge <?= $statusClass ?> rounded-pill px-3"><?= $statusLabel ?></span></td>
                            <td class="text-nowrap align-middle text-end fw-bold"><?= rupiah($payment['jumlah_bayar']) ?></td>
                            <td class="text-nowrap align-middle">
                                <div class="payment-actions">
                                    <?php if ($payment['status_verifikasi'] === 'pending'): ?>
                                        <form method="post" action="../../actions/verifikasi_pembayaran.php">
                                            <input type="hidden" name="id_pembayaran" value="<?= (int) $payment['id_pembayaran'] ?>">
                                            <input type="hidden" name="status_verifikasi" value="diterima">
                                            <button type="submit" class="btn btn-success btn-sm btn-verify" onclick="return confirm('Terima pembayaran ini?')">Terima</button>
                                        </form>
                                        <form method="post" action="../../actions/verifikasi_pembayaran.php">
                                            <input type="hidden" name="id_pembayaran" value="<?= (int) $payment['id_pembayaran'] ?>">
                                            <input type="hidden" name="status_verifikasi" value="ditolak">
                                            <button type="submit" class="btn btn-outline-danger btn-sm btn-verify" onclick="return confirm('Tolak pembayaran ini?')">Tolak</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    </div>
</div>

<script>
const incomeLabels = <?= json_encode($monthlyLabels) ?>;
const incomeData = <?= json_encode(array_values($monthlyIncome)) ?>;
const serviceLabels = <?= json_encode($serviceLabels !== [] ? $serviceLabels : ['Belum ada pesanan']) ?>;
const serviceData = <?= json_encode($serviceTotals !== [] ? $serviceTotals : [1]) ?>;
const serviceHasData = <?= json_encode($serviceTotals !== []) ?>;

new Chart(document.getElementById('incomeBarChart'), {
    type: 'bar',
    data: {
        labels: incomeLabels,
        datasets: [{
            label: 'Pemasukan',
            data: incomeData,
            backgroundColor: '#8b6b4a',
            borderColor: '#5c3d1e',
            borderWidth: 1,
            borderRadius: 8,
            maxBarThickness: 42
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Pemasukan: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw || 0);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID', {
                            notation: 'compact',
                            compactDisplay: 'short'
                        }).format(value);
                    }
                }
            }
        }
    }
});

new Chart(document.getElementById('servicePieChart'), {
    type: 'pie',
    data: {
        labels: serviceLabels,
        datasets: [{
            data: serviceData,
            backgroundColor: serviceHasData
                ? ['#d4956a', '#8b6b4a', '#5c3d1e', '#6f7d45']
                : ['#e0d5c5']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        if (!serviceHasData) return 'Belum ada data';
                        return context.label + ': ' + context.raw + ' pesanan';
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>
