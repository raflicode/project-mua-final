<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

function formatRupiah($value)
{
    return 'Rp ' . number_format($value, 0, ',', '.');
}

$fromPage = filter_input(INPUT_GET, 'from', FILTER_SANITIZE_STRING);
$sourcePage = filter_input(INPUT_GET, 'source_page', FILTER_SANITIZE_STRING);
$backMap = [
    'makeup' => 'makeup.php',
    'dekor' => 'dekor.php',
    'kostum' => 'kostum.php'
];
$backHref = $backMap[$sourcePage] ?? $backMap[$fromPage] ?? 'price_list.php';

function resolveImagePath($path, $default = '../assets/foto_makeup.jpeg')
{
    if (empty($path)) {
        return $default;
    }

    $path = trim($path);
    if (preg_match('#^(https?://|/)#', $path)) {
        return $path;
    }

    if (strpos($path, 'assets/') === 0) {
        return '../' . $path;
    }

    return '../' . ltrim($path, '/');
}

$checkout = $_SESSION['checkout_booking'] ?? null;
$draft = $_SESSION['draft_booking'] ?? null;
$checkoutMode = false;
$checkoutItems = [];
$hargaProduk = 0;
$foto = '../assets/foto_makeup.jpeg';
$namaProduk = trim(filter_input(INPUT_GET, 'layanan', FILTER_SANITIZE_STRING));
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$hargaProduk = filter_input(INPUT_GET, 'harga', FILTER_VALIDATE_INT);
$service = null;
$layananTableExists = false;

try {
    $tableStmt = $pdo->query("SHOW TABLES LIKE 'layanan'");
    $layananTableExists = (bool) $tableStmt->fetchColumn();
} catch (Exception $e) {
    $layananTableExists = false;
}

if ($checkout && !empty($checkout['items']) && is_array($checkout['items'])) {
    $checkoutMode = true;
    $checkoutItems = $checkout['items'];
    $hargaProduk = floatval($checkout['total_price']);
    $namaProduk = count($checkoutItems) . ' item terpilih';
    $backHref = 'keranjang.php';
    $serviceFoto = $checkoutItems[0]['foto'] ?? '';
    $foto = resolveImagePath($serviceFoto, '../assets/foto_makeup.jpeg');

    $_SESSION['draft_booking'] = [
        'source' => 'cart',
        'items' => $checkoutItems,
        'total' => $hargaProduk,
        'cart_item_ids' => $checkout['cart_item_ids'] ?? [],
        'id_layanan' => $checkoutItems[0]['id_layanan'] ?? null,
        'nama_layanan' => $namaProduk,
        'harga' => $hargaProduk,
        'foto' => $foto
    ];
} else {
    if ($id && $layananTableExists) {
        $stmt = $pdo->prepare('SELECT * FROM layanan WHERE id_layanan = ? LIMIT 1');
        $stmt->execute([$id]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($service) {
            $namaProduk = $service['nama_layanan'];
            $hargaProduk = $service['harga_dasar'];
            $foto = resolveImagePath($service['foto_layanan']);
        }
    }

    if (empty($namaProduk) && isset($draft['nama_layanan'])) {
        $namaProduk = $draft['nama_layanan'];
        $hargaProduk = $draft['harga'];
        $foto = $draft['foto'] ?? $foto;
    }

    if (empty($foto) && isset($draft['foto'])) {
        $foto = $draft['foto'];
    }

    if (empty($namaProduk) || $hargaProduk <= 0) {
        header('Location: price_list.php');
        exit;
    }

    $_SESSION['draft_booking'] = [
        'source' => 'single',
        'id_layanan' => $service['id_layanan'] ?? ($draft['id_layanan'] ?? null),
        'nama_layanan' => $namaProduk,
        'harga' => $hargaProduk,
        'foto' => $foto
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Review Pesanan - Yayuk Makeover</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --primary-color: #d07f26;
    --primary-dark: #8a4c18;
    --bg-soft: #fff5e7;
    --text-dark: #2b1f15;
    --text-muted: #5e4a37;
    --card-bg: #ffffff;
    --shadow-soft: rgba(0, 0, 0, 0.12);
}

body {
    background-color: var(--bg-soft);
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-dark);
    min-height: 100vh;
    padding-top: 100px !important;
}

.back-nav {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: var(--card-bg);
    border-radius: 14px;
    box-shadow: 0 10px 28px rgba(0,0,0,0.1);
    color: var(--text-dark);
    text-decoration: none;
    transition: all 0.25s ease;
}

.back-nav:hover {
    background: #d07f26;
    color: white;
    transform: translateX(-4px);
}

.order-card {
    border: 1px solid rgba(208, 127, 38, 0.16);
    border-radius: 24px;
    box-shadow: 0 24px 50px rgba(0, 0, 0, 0.08);
    background-color: var(--card-bg);
    padding: 28px;
    height: 100%;
}

.section-title {
    font-size: 1.8rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: #3c2b1f;
}

.page-subtitle {
    color: var(--text-muted);
    margin-top: 6px;
}

.product-item {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 18px 0;
}

.product-img-wrapper {
    width: 90px;
    height: 90px;
    border-radius: 20px;
    overflow: hidden;
    flex-shrink: 0;
    border: 1px solid rgba(208, 127, 38, 0.18);
    background: #fff5e9;
}

.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info h6 {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 6px;
    color: #352715;
}

.product-info p {
    margin-bottom: 0;
    color: var(--text-muted);
    font-size: 0.95rem;
}

.qty-badge {
    font-size: 0.75rem;
    background: #fff0d9;
    color: var(--primary-dark);
    padding: 6px 12px;
    border-radius: 999px;
    font-weight: 700;
}

.divider {
    height: 1px;
    background-color: #e7d1b0;
    margin: 24px 0;
}

.price-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    font-size: 0.95rem;
}

.price-label { color: var(--text-muted); }
.price-value { font-weight: 700; color: #3b2a1f; }

.request-box {
    background: #fff4e4;
    border: 1px solid #e3b97a;
    border-radius: 16px;
    padding: 16px;
    font-size: 0.95rem;
    height: 130px;
    resize: none;
}

.request-box:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(208, 127, 38, 0.16);
    background-color: white;
}

.total-box-premium {
    background: #fff2d9;
    border-radius: 18px;
    padding: 22px;
    border: 1px solid #e2b579;
}

.btn-payment {
    background: linear-gradient(135deg, #d07f26, #b15f18);
    color: white;
    border: none;
    border-radius: 18px;
    padding: 15px;
    font-weight: 700;
    width: 100%;
    transition: transform 0.22s ease, box-shadow 0.25s ease;
    box-shadow: 0 14px 32px rgba(208, 127, 38, 0.28);
}

.btn-payment:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 36px rgba(208, 127, 38, 0.32);
}

@media (min-width: 992px) {
    .sticky-sidebar {
        position: sticky;
        top: 110px;
    }
}
</style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container my-4">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-column flex-md-row gap-3">
        <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="back-nav">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div>
            <h2 class="section-title mb-1">Review Pesanan</h2>
            <p class="page-subtitle mb-0">Pastikan detail layanan sudah benar sebelum melanjutkan ke penjadwalan.</p>
        </div>
        <div style="width: 48px;"></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="order-card">
                <h5 class="card-inside-title mb-4"><i class="bi bi-bag-check me-2 text-warning"></i>Detail Pesanan</h5>
                <?php if (!empty($checkoutMode) && !empty($checkoutItems)): ?>
                    <?php foreach ($checkoutItems as $item): ?>
                        <div class="product-item">
                            <div class="product-img-wrapper">
                                <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>" class="product-img" alt="<?= htmlspecialchars($item['nama_layanan'], ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="product-info flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><?= htmlspecialchars($item['nama_layanan'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                    <span class="qty-badge">x<?= intval($item['kuantitas']) ?></span>
                                </div>
                                <p class="price-value mb-0 text-primary small mt-1"><?= htmlspecialchars(formatRupiah($item['item_total']), ENT_QUOTES, 'UTF-8'); ?></p>
                                <p class="item-subtext mt-2">Tipe: <?= htmlspecialchars($item['tipe_layanan'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="product-item">
                        <div class="product-img-wrapper">
                            <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>" class="product-img" alt="<?= htmlspecialchars($namaProduk, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="product-info flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><?= htmlspecialchars($namaProduk, ENT_QUOTES, 'UTF-8'); ?></h6>
                                <span class="qty-badge">x1</span>
                            </div>
                            <p class="price-value mb-0 text-primary small mt-1"><?= htmlspecialchars(formatRupiah($hargaProduk), ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="item-subtext mt-2">Layanan ini akan disimpan sebagai draft booking Anda sebelum memilih jadwal.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="divider"></div>

                <div class="mt-4">
                    <div class="total-box-premium">
                        <div class="price-row">
                            <span class="price-label">Subtotal</span>
                            <span class="price-value"><?= htmlspecialchars(formatRupiah($hargaProduk), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Biaya layanan</span>
                            <span class="price-value">Rp 10.000</span>
                        </div>
                        <div class="divider"></div>
                        <div class="price-row">
                            <span class="fw-bold">Total Bayar</span>
                            <span class="fw-bold"><?= htmlspecialchars(formatRupiah($hargaProduk + 10000), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="sticky-sidebar">
                <div class="order-card">
                    <h5 class="card-inside-title"><i class="bi bi-calendar-check me-2 text-warning"></i>Langkah Selanjutnya</h5>
                    <p class="text-muted small mb-4">Pilih tanggal dan jam yang tersedia pada langkah berikutnya.</p>
                    <a href="penjadwalan.php" class="btn btn-payment">
                        Lanjut ke Penjadwalan <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
