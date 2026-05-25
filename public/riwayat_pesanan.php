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

// Ambil data riwayat pesanan dari booking
try {

    $stmt = $pdo->prepare("
        SELECT
            b.id_booking,
            b.total_harga,
            b.status_booking,
            b.created_at,
            COALESCE(GROUP_CONCAT(DISTINCT COALESCE(l.nama_layanan, 'Layanan Booking') ORDER BY COALESCE(l.nama_layanan, 'Layanan Booking') SEPARATOR ', '), 'Layanan Booking') AS nama_layanan,
            COALESCE(MIN(l.foto_layanan), '../assets/gallery_kostum/kostum_4.jpeg') AS foto_layanan,
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
            border-radius:999px;
            padding:12px 24px;
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

            .history-header{
                display:none;
            }

            .history-item{
                display:block;
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
        }

    </style>

</head>

<body>

<?php include 'include/navbar.php'; ?>

<div class="container-fluid px-lg-5">

    <!-- Heading -->
    <div class="d-flex align-items-center justify-content-between flex-column flex-md-row mb-4">

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
                $foto = !empty($item['foto_layanan'])
                    ? $item['foto_layanan']
                    : '../assets/gallery_kostum/kostum_4.jpeg';

                $namaLayanan = trim($item['nama_layanan'] ?? 'Layanan Booking');
                $kategori = trim(explode(',', $item['kategori_layanan'] ?? 'makeup')[0] ?? 'makeup');
                $kategoriLabel = ucfirst($kategori);
                $status = $item['status_booking'] ?? 'pending';
                $totalHarga = (float) ($item['total_harga'] ?? 0);
            ?>

            <div class="history-item">

                <!-- Produk -->
                <div class="col-produk">

                    <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>" alt="produk">

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
                <div class="col-tipe">

                    <span class="badge-tipe">
                        <?= htmlspecialchars($kategoriLabel, ENT_QUOTES, 'UTF-8'); ?>
                    </span>

                </div>

                <!-- Harga -->
                <div class="col-harga">

                    <?= formatRupiah($totalHarga); ?>

                </div>

                <!-- Total -->
                <div class="col-total">

                    <?= formatRupiah($totalHarga); ?>

                </div>

                <!-- Status -->
                <div class="col-status">

                    <?= statusBadge($status); ?>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
