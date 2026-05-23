<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/db_helpers.php';

ensure_dynamic_booking_schema($pdo);

function serviceImagePath(?string $path): string
{
    if (!$path) {
        return '../assets/foto_makeup.jpeg';
    }

    if (preg_match('#^(https?://|/)#', $path)) {
        return $path;
    }

    return '../' . ltrim($path, '/');
}

$stmt = $pdo->query("
    SELECT id_layanan, kategori_layanan, nama_layanan, deskripsi, harga_dasar, foto_layanan
    FROM layanan
    WHERE is_active = 1
    ORDER BY FIELD(kategori_layanan, 'makeup', 'kostum', 'dekor', 'paket'), nama_layanan ASC
");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
$servicesByCategory = [];
foreach ($services as $service) {
    $category = $service['kategori_layanan'] ?: 'makeup';
    $servicesByCategory[$category][] = $service;
}
$categoryLabels = [
    'makeup' => 'Makeup',
    'kostum' => 'Kostum',
    'dekor' => 'Dekor/Terop',
    'paket' => 'Paket Wedding',
];
$selectedCategory = $_GET['kategori'] ?? 'semua';
if ($selectedCategory !== 'semua' && !isset($categoryLabels[$selectedCategory])) {
    $selectedCategory = 'semua';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Pilih Paket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Lobster&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('WhatsApp Image 2026-05-22 at 20.20.36.jpeg') no-repeat center center fixed; 
            background-size: cover;
            position: relative;
            padding-top: 100px !important;
        }

        /* Style untuk 3 Card Kategori Atas */
        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: #ffffff;
            min-height: 380px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .card-custom h5 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0f172a;
        }

        .btn-booking {
            border-radius: 20px;
            width: 100%;
            padding: 12px;
            font-weight: 600;
        }

        /* ----------------------------------------------------
           STYLE CARD PREMIUM WEDDING (SILVER & GOLD) 
        ---------------------------------------------------- */
        .card-premium {
            border: 4px solid transparent;
            border-radius: 25px;
            overflow: hidden;
            background: #ffffff;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            height: 100%; /* Mengikuti tinggi grid pembungkus agar seimbang */
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        /* Border khusus Logam Silver */
        .card-silver-theme {
            background: linear-gradient(#ffffff, #ffffff) padding-box,
                        linear-gradient(135deg, #cbd5e1 0%, #ffffff 50%, #94a3b8 100%) border-box;
        }

        /* Border khusus Logam Gold berkilau */
        .card-gold-theme {
            background: linear-gradient(#ffffff, #ffffff) padding-box,
                        linear-gradient(135deg, #fca311 0%, #fffbeb 50%, #b45309 100%) border-box;
        }

        .card-premium:hover {
            transform: translateY(-8px);
        }
        .card-silver-theme:hover {
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.3), 0 15px 35px rgba(0, 0, 0, 0.4);
        }
        .card-gold-theme:hover {
            box-shadow: 0 0 25px rgba(252, 163, 17, 0.4), 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        /* Header Tema Silver & Gold */
        .card-header-silver {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            padding: 25px 25px 20px 25px;
            border-bottom: 2px solid #cbd5e1;
        }
        .card-header-gold {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            padding: 25px 25px 20px 25px;
            border-bottom: 2px solid #fcd34d;
        }

        .badge-package {
            color: #ffffff;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1.5px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 8px;
        }
        .badge-silver { background: #475569; }
        .badge-gold { background: #b45309; }

        .price-style {
            font-size: 2.2rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .price-currency {
            font-size: 1rem;
            font-weight: 600;
            color: #475569;
            vertical-align: super;
            margin-right: 3px;
        }

        .card-body-custom {
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        .include-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 25px;
        }

        .include-list li {
            padding: 10px 0;
            border-bottom: 1px dashed #e2e8f0;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            color: #334155;
            font-weight: 500;
        }

        .include-list li:last-child {
            border-bottom: none;
        }

        .icon-check {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .icon-silver-check { background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .icon-gold-check { background-color: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }

        /* Tombol Aksi */
        .btn-action-silver {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 12px;
            border: none;
            transition: 0.3s;
        }
        .btn-action-silver:hover { background: linear-gradient(135deg, #475569 0%, #334155 100%); color: white; }

        .btn-action-gold {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 12px;
            border: none;
            transition: 0.3s;
        }
        .btn-action-gold:hover { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; }

        .btn-cart-custom {
            background: #f8fafc;
            color: #0f172a;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            border: 2px solid #cbd5e1;
        }
        .btn-cart-custom:hover { background: #e2e8f0; }

        .btn-kembali {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: #e74c3c;
            color: white;
            border-radius: 30px;
            padding: 10px 20px;
            z-index: 10;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .btn-kembali:hover { background: #c0392b; color: white; }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container mt-3 px-lg-5">
    <div class="text-center mb-5 text-white">
        <h1 class="fw-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.6);">Pilih Layanan</h1>
        <p class="small opacity-75">Seluruh layanan di halaman ini diambil langsung dari database admin.</p>
    </div>

    <?php if (empty($services)): ?>
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-5 text-muted"></i>
                <h5 class="mt-3">Belum ada layanan aktif</h5>
                <p class="text-muted mb-0">Admin dapat menambahkan layanan dari menu Data Layanan.</p>
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($categoryLabels as $category => $label): ?>
        <?php if ($selectedCategory !== 'semua' && $selectedCategory !== $category) continue; ?>
        <?php if (empty($servicesByCategory[$category])) continue; ?>
        <section class="mb-5">
            <div class="text-center mb-4 text-white">
                <h2 class="fw-bold" style="font-family:'Lobster', cursive; font-size: 42px; text-shadow: 2px 2px 6px rgba(0,0,0,0.6);">
                    <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                </h2>
                <div class="mx-auto" style="width: 80px; height: 3px; background-color: #ffffff; border-radius: 2px;"></div>
            </div>

            <div class="row g-4 justify-content-center">
                <?php foreach ($servicesByCategory[$category] as $service): ?>
                    <?php
                    $id = (int) $service['id_layanan'];
                    $name = $service['nama_layanan'];
                    $price = (float) $service['harga_dasar'];
                    $image = serviceImagePath($service['foto_layanan'] ?? '');
                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card-custom h-100">
                            <div>
                                <img src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" class="w-100 mb-3" style="height:190px;object-fit:cover;border-radius:16px;">
                                <span class="badge bg-dark-subtle text-dark text-uppercase mb-2"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
                                <h5 class="mb-2"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></h5>
                                <div class="fw-bold text-warning mb-2">Rp <?= number_format($price, 0, ',', '.'); ?></div>
                                <p class="small text-muted"><?= nl2br(htmlspecialchars($service['deskripsi'] ?: 'Layanan tersedia untuk booking.', ENT_QUOTES, 'UTF-8')); ?></p>
                            </div>
                            <div class="d-flex gap-2">
                                <button
                                    type="button"
                                    onclick='addToCart(<?= json_encode($name, JSON_HEX_APOS | JSON_HEX_QUOT); ?>, <?= json_encode($category, JSON_HEX_APOS | JSON_HEX_QUOT); ?>, <?= (int) $price; ?>, <?= json_encode($image, JSON_HEX_APOS | JSON_HEX_QUOT); ?>, <?= $id; ?>)'
                                    class="btn btn-cart-custom"
                                    title="Tambah ke Keranjang">
                                    <i class="bi bi-cart3 fs-5"></i>
                                </button>
                                <button
                                    type="button"
                                    onclick='handleServiceBooking(<?= $id; ?>, <?= json_encode($name, JSON_HEX_APOS | JSON_HEX_QUOT); ?>, <?= (int) $price; ?>)'
                                    class="btn btn-action-gold flex-grow-1">
                                    Booking
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>

<a href="../index.php" class="btn btn-kembali"><i class="bi bi-arrow-left me-2"></i>Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include 'include/add_to_cart_script.php'; ?>
<script>
const isLoggedIn = <?= isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;
function handleServiceBooking(id, layanan, harga) {
    if (!isLoggedIn) {
        Swal.fire({
            icon: 'warning',
            title: 'Login diperlukan',
            text: 'Silakan login terlebih dahulu',
            confirmButtonText: 'Login Sekarang',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'login.php';
            }
        });
        return;
    }
    window.location.href = `booking.php?from=service&id=${encodeURIComponent(id)}&layanan=${encodeURIComponent(layanan)}&harga=${harga}`;
}
</script>
</body>
</html>
