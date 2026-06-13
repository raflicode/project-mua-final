<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/db_helpers.php';

ensure_dynamic_booking_schema($pdo);

// Redirect jika belum login
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$backHref = '../index.php';

// Handle error message
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
if (isset($_SESSION['error_message'])) {
    unset($_SESSION['error_message']);
}

// Ambil data riwayat pesanan dari booking
try {

    $stmt = $pdo->prepare("
        SELECT
            b.id_booking,
            b.total_harga,
            b.status_booking,
            b.created_at,
            COALESCE(GROUP_CONCAT(DISTINCT COALESCE(l.nama_layanan, 'Layanan Booking') ORDER BY COALESCE(l.nama_layanan, 'Layanan Booking') SEPARATOR ', '), 'Layanan Booking') AS nama_layanan,
            COALESCE(MIN(l.foto_layanan), '') AS foto_layanan,
            COALESCE(GROUP_CONCAT(DISTINCT COALESCE(l.kategori_layanan, 'makeup') ORDER BY COALESCE(l.kategori_layanan, 'makeup') SEPARATOR ', '), 'makeup') AS kategori_layanan,
            COALESCE(SUM(bd.qty), 0) AS total_qty
        FROM booking b
        LEFT JOIN booking_detail bd ON bd.id_booking = b.id_booking
        LEFT JOIN layanan l ON l.id_layanan = bd.id_layanan
        WHERE b.id_user = ?
          AND b.status_booking <> 'dibatalkan'
        GROUP BY b.id_booking
        ORDER BY b.created_at DESC
    ");

    $stmt->execute([$id_user]);

    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {

    $riwayat = [];
}

// Format rupiah
function formatRupiah($angka)
{
    return 'Rp ' . number_format((float)$angka, 0, ',', '.');
}

function riwayatImagePath(?string $foto, string $kategori = '', string $namaLayanan = ''): string
{
    $foto = trim((string) $foto);
    $type = strtolower($kategori . ' ' . $namaLayanan);
    if (str_contains($type, 'paket')) {
        return '';
    }

    if ($foto === '') {
        if (str_contains($type, 'dekor')) {
            return '../assets/foto_dekor.jpeg';
        }
        if (str_contains($type, 'kostum')) {
            return '../assets/gallery_kostum/kostum_4.jpeg';
        }

        return '../assets/foto_makeup.jpeg';
    }

    $foto = str_replace('\\', '/', $foto);
    if (preg_match('#^(https?:)?//#', $foto) || str_starts_with($foto, '/')) {
        return $foto;
    }

    if (str_starts_with($foto, '../assets/')) {
        return $foto;
    }

    if (str_starts_with($foto, 'assets/')) {
        return '../' . $foto;
    }

    return '../assets/' . ltrim($foto, '/');
}

// Badge status pesanan
function statusBadge($status)
{
    switch (strtolower((string) $status)) {
        case 'pending':
            return '<span class="status-badge warning">Menunggu Konfirmasi</span>';
        case 'dikonfirmasi':
            return '<span class="status-badge warning">Dikonfirmasi</span>';
        case 'konfirmasi':
            return '<span class="status-badge warning">Menunggu Pembayaran</span>';
        case 'selesai':
            return '<span class="status-badge success">Selesai</span>';
        case 'dibatalkan':
            return '<span class="status-badge danger">Dibatalkan</span>';
        default:
            return '<span class="status-badge warning">Menunggu Konfirmasi</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Pesanan - Yayuk Makeover</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>

        :root{
            --primary:#d07f26;
            --primary-dark:#8a4c18;
            --bg-soft:#f7f1e8;
            --card:#ffffff;
            --text:#2b1f15;
        }

        body{
            background: var(--bg-soft);
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding-top: 100px;
            padding-bottom: 120px;
            color: var(--text);
        }

        .section-title{
            font-size: 2.4rem;
            font-weight: 800;
            color: #b78455;
        }

        .section-subtitle{
            color:#6e5a49;
            margin-top: 8px;
        }

        .history-header,
        .history-item{

            width:100%;
            background: white;
            border-radius: 24px;
            padding: 22px;
            margin-bottom: 18px;

            display:flex;
            align-items:center;
            gap:20px;

            box-shadow: 0 10px 35px rgba(0,0,0,0.05);
        }

        .history-header{
            font-weight:700;
            color:#3d2d1f;
        }

        .col-produk{
            width:40%;
            display:flex;
            align-items:center;
            gap:18px;
        }

        .col-tipe,
        .col-harga,
        .col-total,
        .col-status{
            width:15%;
            text-align:center;
        }

        .history-item img{
            width:90px;
            height:90px;
            border-radius:18px;
            object-fit:cover;
        }

        .item-title{
            font-size:1.05rem;
            font-weight:700;
        }

        .item-id{
            font-size:0.9rem;
            color:#7a7a7a;
            margin-top:4px;
        }

        .badge-tipe{

            display:inline-block;
            padding:8px 14px;

            background:#fff0db;
            color:var(--primary-dark);

            border-radius:999px;

            font-size:0.85rem;
            font-weight:700;
        }

        .status-badge{

            display:inline-block;

            padding:10px 16px;
            border-radius:999px;

            font-size:0.85rem;
            font-weight:700;
        }

        .success{
            background:#dcfce7;
            color:#166534;
        }

        .danger{
            background:#fee2e2;
            color:#991b1b;
        }

        .warning{
            background:#fff4d6;
            color:#9a6700;
        }

        .btn-kembali{
            border-radius:50px;
            padding:12px 28px;
            border: 1px solid #b78455;
            background: #ffffff;
            color: #b78455;
            font-weight: 700;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-kembali:hover,
        .btn-kembali:focus{
            background: #b78455;
            color: #ffffff;
            border-color: #b78455;
            text-decoration: none;
        }

        .empty-box{

            background:white;

            border-radius:24px;

            padding:80px 20px;

            text-align:center;

            box-shadow:0 10px 35px rgba(0,0,0,0.05);
        }

        .empty-box i{
            font-size:4rem;
            color:#d2d2d2;
        }

        .empty-box h4{
            margin-top:20px;
            color:#6f5f52;
        }

        .btn-service{

            background: linear-gradient(135deg, #d07f26, #ae5c16);

            color:white;

            border:none;

            border-radius:999px;

            padding:12px 26px;

            font-weight:700;

            margin-top:20px;
        }

        .btn-service:hover{
            color:white;
            opacity:0.95;
        }

        @media(max-width:992px){

            body{
                padding-top: 86px;
                padding-bottom: 48px;
            }

            .section-title{
                font-size: 1.75rem;
            }

            .section-subtitle{
                font-size: 0.95rem;
            }

            .btn-kembali{
                width:100%;
                margin-top:14px;
                text-align:center;
            }

            .history-header{
                display:none;
            }

            .history-item{
                display:block;
                border-radius:18px;
                padding:18px;
            }

            .col-produk,
            .col-tipe,
            .col-harga,
            .col-total,
            .col-status{

                width:100%;
                text-align:left;
                margin-bottom:18px;
            }

            .col-tipe::before,
            .col-harga::before,
            .col-total::before,
            .col-status::before{
                content: attr(data-label);
                display:block;
                margin-bottom:10px;
                font-size:0.95rem;
                font-weight:700;
                color:#3d2d1f;
            }

            .col-produk{
                margin-bottom:18px;
                gap:14px;
                align-items:flex-start;
            }

            .history-item img{
                width:74px;
                height:74px;
                border-radius:14px;
                flex:0 0 74px;
            }

            .item-title{
                font-size:0.98rem;
                line-height:1.35;
                overflow-wrap:anywhere;
            }

            .status-badge,
            .badge-tipe{
                padding:8px 12px;
                font-size:0.8rem;
            }
        }

        @media(max-width:575px){
            .container-fluid{
                padding-left:14px;
                padding-right:14px;
            }

            .empty-box{
                padding:48px 16px;
                border-radius:18px;
            }
        }

    </style>

</head>

<body>

<?php include 'include/navbar.php'; ?>

<?php if (!empty($error_message)): ?>
    <div class="container-fluid px-lg-5 mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<div class="container-fluid px-lg-5">

    <!-- Heading -->
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row mb-4">

        <div>

            <h1 class="section-title">
                Riwayat Pesanan
            </h1>

            <p class="section-subtitle">
                Lihat seluruh status pesanan dan konfirmasi admin Anda.
            </p>

        </div>

        <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>"
           class="btn btn-outline-secondary btn-kembali">

            <i class="bi bi-chevron-left me-2"></i>Kembali

        </a>

    </div>

    <!-- Header -->
    <div class="history-header d-none d-lg-flex">

        <div class="col-produk">
            Produk
        </div>

        <div class="col-tipe">
            Tipe
        </div>

        <div class="col-harga">
            Harga
        </div>

        <div class="col-total">
            Total
        </div>

        <div class="col-status">
            Status
        </div>

    </div>

    <!-- Data -->
    <?php if (empty($riwayat)): ?>

        <div class="empty-box">

            <i class="bi bi-clock-history"></i>

            <h4>
                Belum Ada Riwayat Pesanan
            </h4>

            <p class="text-muted">
                Pesanan yang telah Anda checkout akan tampil di halaman ini.
            </p>

            <a href="service.php" class="btn btn-service">

                Lihat Layanan

            </a>

        </div>

    <?php else: ?>

        <?php foreach ($riwayat as $item): ?>

            <?php
                $namaLayanan = trim($item['nama_layanan'] ?? 'Layanan Booking');
                $kategori = trim(explode(',', $item['kategori_layanan'] ?? 'makeup')[0] ?? 'makeup');
                $foto = riwayatImagePath($item['foto_layanan'] ?? '', $kategori, $namaLayanan);
                $kategoriLabel = ucfirst($kategori);
                $status = $item['status_booking'] ?? 'pending';
                $totalHarga = (float) ($item['total_harga'] ?? 0);
            ?>

            <div class="history-item">

                <!-- Produk -->
                <div class="col-produk">

                    <?php if ($foto !== ''): ?>
                        <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>" alt="produk" onerror="this.onerror=null;this.src='../assets/foto_makeup.jpeg';">
                    <?php endif; ?>

                    <div>

                        <div class="item-title">
                            <?= htmlspecialchars($namaLayanan, ENT_QUOTES, 'UTF-8'); ?>
                        </div>

                        <div class="item-id">
                            ID Booking :
                            <?= htmlspecialchars($item['id_booking'], ENT_QUOTES, 'UTF-8'); ?>
                        </div>

                    </div>

                </div>

                <!-- Tipe -->
                <div class="col-tipe" data-label="Tipe">

                    <span class="badge-tipe">
                        <?= htmlspecialchars($kategoriLabel, ENT_QUOTES, 'UTF-8'); ?>
                    </span>

                </div>

                <!-- Harga -->
                <div class="col-harga" data-label="Harga">

                    <?= formatRupiah($totalHarga); ?>

                </div>

                <!-- Total -->
                <div class="col-total" data-label="Total">

                    <?= formatRupiah($totalHarga); ?>

                </div>

                <!-- Status -->
                <div class="col-status" data-label="Status">

                    <?= statusBadge($status); ?>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
