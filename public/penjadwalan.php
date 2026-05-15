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
    $id_jadwal = filter_input(INPUT_POST, 'id_jadwal', FILTER_VALIDATE_INT);
    if (!$id_jadwal) {
        $errors[] = 'Silakan pilih jadwal terlebih dahulu.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM jadwal_kerja WHERE id_jadwal = ? AND status_slot = ? LIMIT 1');
        $stmt->execute([$id_jadwal, 'tersedia']);
        $jadwal = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$jadwal) {
            $errors[] = 'Jadwal yang dipilih tidak tersedia.';
        } else {
            $_SESSION['draft_booking']['id_jadwal'] = $jadwal['id_jadwal'];
            $_SESSION['draft_booking']['tanggal'] = $jadwal['tanggal'];
            $_SESSION['draft_booking']['jam_mulai'] = $jadwal['jam_mulai'];
            $_SESSION['draft_booking']['jam_selesai'] = $jadwal['jam_selesai'];
            header('Location: pembayaran.php');
            exit;
        }
    }
}

try {
    $stmt = $pdo->query("SELECT * FROM jadwal_kerja WHERE status_slot = 'tersedia' ORDER BY tanggal ASC, jam_mulai ASC");
    $jadwals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $jadwals = [];
}

$namaProduk = htmlspecialchars($draft['nama_layanan'] ?? 'Layanan', ENT_QUOTES, 'UTF-8');
$hargaProduk = intval($draft['total'] ?? $draft['harga'] ?? 0);
$foto = htmlspecialchars($draft['foto'] ?? '../assets/foto_makeup.jpeg', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Penjadwalan - Yayuk Makeover</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
:root {
    --primary-color: #d07f26;
    --primary-dark: #8a4c18;
    --bg-soft: #fff5e7;
    --text-dark: #2b1f15;
    --text-muted: #5e4a37;
    --card-bg: #ffffff;
}

body {
    background: var(--bg-soft);
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-dark);
    padding-top: 100px !important;
}

.wrapper {
    width: 100%;
    max-width: 1180px;
    margin: auto;
}

.page-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.page-top h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 800;
}

.page-top p {
    margin: 4px 0 0;
    color: var(--text-muted);
}

.btn-back {
    width: 52px;
    height: 52px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 18px;
    background: var(--card-bg);
    color: var(--text-dark);
    border: 1px solid rgba(43, 31, 21, 0.12);
    box-shadow: 0 12px 26px rgba(0, 0, 0, 0.06);
    transition: transform 0.2s ease, background 0.2s ease;
}

.btn-back:hover {
    background: var(--primary-color);
    color: white;
    transform: translateX(-2px);
}

.card-custom {
    border: 1px solid rgba(208, 127, 38, 0.16);
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.08);
    background: var(--card-bg);
}

.header-booking {
    background: linear-gradient(135deg, #f8dc9b, #e7b76f);
    padding: 28px 26px;
}

.header-booking h2 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 800;
    color: #3c2919;
}

.header-booking p {
    margin: 8px 0 0;
    color: var(--text-muted);
}

.slot-area {
    background: #fff7ee;
    border: 1px solid rgba(208, 127, 38, 0.16);
    border-radius: 24px;
    padding: 26px;
    margin-top: 24px;
}

.slot-list {
    display: grid;
    gap: 16px;
    margin-top: 18px;
}

.slot {
    border: 1px solid rgba(208, 127, 38, 0.16);
    border-radius: 18px;
    padding: 18px;
    background: #ffffff;
    cursor: pointer;
    transition: transform 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.slot:hover {
    transform: translateY(-2px);
    border-color: var(--primary-color);
    box-shadow: 0 12px 24px rgba(208, 127, 38, 0.14);
}

.slot.selected {
    background: var(--primary-color);
    color: white;
    border-color: #b15b12;
    box-shadow: 0 14px 28px rgba(208, 127, 38, 0.24);
}

.slot input[type="radio"] {
    display: none;
}

.summary-card {
    border-radius: 22px;
    padding: 20px 22px;
    background: #fffaf2;
    border: 1px solid rgba(208, 127, 38, 0.16);
    margin-top: 24px;
}

.summary-card h5 {
    margin-bottom: 16px;
    font-size: 1rem;
    font-weight: 800;
    color: #3b2817;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 12px;
}

.summary-row span:last-child {
    font-weight: 700;
    color: #3b2817;
}

.btn-lanjut {
    background: linear-gradient(135deg, #d07f26, #ae5c16);
    border: none;
    color: white;
    padding: 14px 18px;
    font-weight: 700;
    border-radius: 18px;
    width: 100%;
    box-shadow: 0 16px 30px rgba(208, 127, 38, 0.24);
    transition: transform 0.22s ease;
}

.btn-lanjut:hover {
    transform: translateY(-2px);
}

@media (max-width: 899px) {
    .slot-list {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>
<?php include 'include/navbar.php'; ?>

<div class="container my-4 wrapper">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="booking.php" class="btn-back">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div>
            <h1>Booking Layanan</h1>
            <p class="text-muted small mb-0">Pilih tanggal dan jam yang tersedia untuk layanan Anda.</p>
        </div>
        <div style="width: 52px;"></div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card card-custom">
                <div class="header-booking">
                    <h2>Pilih Jadwal</h2>
                    <p>Slot tersedia di bawah ini berasal langsung dari database jadwal kerja.</p>
                </div>
                <div class="slot-area">
                    <form method="post" action="penjadwalan.php">
                        <div class="slot-list">
                            <?php if (!empty($jadwals)): ?>
                                <?php foreach ($jadwals as $jadwal): ?>
                                    <?php $slotLabel = date('d M Y', strtotime($jadwal['tanggal'])) . ' • ' . substr($jadwal['jam_mulai'], 0, 5) . ' - ' . substr($jadwal['jam_selesai'], 0, 5); ?>
                                    <label class="slot" for="jadwal-<?= intval($jadwal['id_jadwal']) ?>">
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($slotLabel) ?></div>
                                            <div class="text-muted small">Kapasitas: <?= intval($jadwal['kapasitas_max']) ?> / Status: <?= htmlspecialchars($jadwal['status_slot']) ?></div>
                                        </div>
                                        <input type="radio" id="jadwal-<?= intval($jadwal['id_jadwal']) ?>" name="id_jadwal" value="<?= intval($jadwal['id_jadwal']) ?>">
                                    </label>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">Belum ada jadwal tersedia saat ini. Silakan kembali lagi nanti.</p>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-lanjut mt-4">Konfirmasi Jadwal</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="summary-card">
                <h5>Ringkasan Layanan</h5>
                <div class="summary-row">
                    <span>Nama Layanan</span>
                    <span><?= htmlspecialchars($namaProduk) ?></span>
                </div>
                <div class="summary-row">
                    <span>Harga</span>
                    <span><?= htmlspecialchars(number_format($hargaProduk, 0, ',', '.')) ?></span>
                </div>
                <div class="summary-row">
                    <span>Estimasi Total</span>
                    <span><?= htmlspecialchars(number_format($hargaProduk + 10000, 0, ',', '.')) ?></span>
                </div>
                <p class="text-muted small mt-3">Setelah jadwal dipilih, Anda akan diarahkan ke halaman pembayaran.</p>
            </div>
        </div>
    </div>
</div>

<script>
const slots = document.querySelectorAll('.slot');
slots.forEach(slot => {
    const input = slot.querySelector('input[type="radio"]');
    input.addEventListener('change', () => {
        slots.forEach(item => item.classList.remove('selected'));
        slot.classList.add('selected');
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
