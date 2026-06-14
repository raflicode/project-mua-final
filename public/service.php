<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/db_helpers.php';
require_once __DIR__ . '/../config/service_catalog.php';

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

function serviceCategoryRoute(string $category): string
{
    return match ($category) {
        'makeup' => 'makeup.php',
        'kostum' => 'kostum.php',
        'dekor' => 'dekor.php',
        default => 'service.php',
    };
}

function premiumTier(string $nama, ?string $deskripsi = ''): string
{
    $haystack = strtolower($nama . ' ' . ($deskripsi ?? ''));
    if (str_contains($haystack, 'gold')) {
        return 'gold';
    }

    if (str_contains($haystack, 'silver')) {
        return 'silver';
    }

    return 'silver';
}

function premiumItems(?string $deskripsi): array
{
    if (!$deskripsi) {
        return ['Layanan premium siap untuk booking.'];
    }

    $items = [];
    foreach (preg_split('/\r\n|\n|;/', $deskripsi) as $part) {
        $part = trim($part);
        if ($part !== '') {
            $items[] = $part;
        }
    }

    return $items ?: ['Layanan premium siap untuk booking.'];
}

$stmt = $pdo->query(
    "
    SELECT kategori_layanan, nama_layanan
    FROM layanan
    WHERE is_active = 1
    ORDER BY FIELD(kategori_layanan, 'makeup', 'kostum', 'dekor', 'paket'), nama_layanan ASC
    "
);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
$servicesByCategory = [];
foreach ($services as $service) {
    $category = $service['kategori_layanan'] ?: 'makeup';
    $servicesByCategory[$category][] = $service;
}
$categoryCards = [
    'makeup' => [
        'title' => 'Makeup',
        'description' => 'Lihat semua paket makeup dan booking langsung dari halaman khusus.',
        'count' => count($servicesByCategory['makeup'] ?? []),
    ],
    'kostum' => [
        'title' => 'Kostum',
        'description' => 'Temukan koleksi kostum untuk berbagai acara.',
        'count' => count($servicesByCategory['kostum'] ?? []),
    ],
    'dekor' => [
        'title' => 'Dekor/Terop',
        'description' => 'Jelajahi paket dekorasi dengan tampilan yang sama seperti halaman katalog.',
        'count' => count($servicesByCategory['dekor'] ?? []),
    ],
];
$packageDataFromDB = fetch_catalog_by_category(
    $pdo,
    'paket',
    '../assets/silver.jpeg',
    'Layanan paket siap untuk booking.'
);

// Hardcoded paket wedding
$paketWedding = [
    [
        'id' => 1001,
        'jenis' => 'Paket Silver',
        'variasi' => [
            [
                'id' => 1001,
                'nama' => 'Paket Silver',
                'foto' => '',
                'harga' => 'Rp 5.000.000',
                'harga_value' => 5000000,
                'include' => [
                    'Make Up (inc: softlens, hijab/hair do & retouch)',
                    'Fresh Melati',
                    'Baju Akad & Resepsi "couple"',
                    'Baju Penerima Tamu 4',
                    'Bucket Bunga',
                    'Dekorasi 4 Meter'
                ],
            ]
        ],
    ],
    [
        'id' => 1002,
        'jenis' => 'Paket Gold',
        'variasi' => [
            [
                'id' => 1002,
                'nama' => 'Paket Gold',
                'foto' => '',
                'harga' => 'Rp 7.500.000',
                'harga_value' => 7500000,
                'include' => [
                    'Make Up (inc: softlens, henna, nail art, hijab/hair d0 & retouch)',
                    'Fresh Melati',
                    'Baju Akad & Resepsi "couple"',
                    'Baju Perima Tamu 4 & Temu Manten',
                    'Baju Adat Jawa Couple ',
                    'Baju Adat Jawa Orang Tua 4',
                    'Baju Adat Jawa Kembar Mayang',
                    'Baju Adat Jawa Joko Bagus',
                    'Dalang',
                    'Perlengkapan Temu Manten',
                    'Bucket Bunga',
                    'Dekorasi 6 Meter'
                ],
            ]
        ],
    ],
];

// Merge database packages with hardcoded packages
$packageDataFromDB = array_merge($paketWedding, $packageDataFromDB);
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
            background: linear-gradient(135deg, #441f0c, #ce8e26);
            background-size: cover;
            position: relative;
            padding-top: 100px !important;
        }

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

        .category-hero-card {
            min-height: 240px;
            text-decoration: none;
            color: inherit;
        }

        .category-icon {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fff7e0, #f6c76a);
            color: #7c3d0d;
            margin-bottom: 18px;
            font-size: 1.5rem;
        }

        .btn-booking {
            border-radius: 20px;
            width: 100%;
            padding: 12px;
            font-weight: 600;
        }

        .card-premium {
            border: 4px solid transparent;
            border-radius: 25px;
            overflow: hidden;
            background: #ffffff;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .card-silver-theme {
            background: linear-gradient(#ffffff, #ffffff) padding-box,
                        linear-gradient(135deg, #cbd5e1 0%, #ffffff 50%, #94a3b8 100%) border-box;
        }

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
        <p class="small opacity-100" style="color: black;">Pilih kategori di bawah ini untuk masuk ke halaman khusus, atau lihat paket premium dari admin.</p>
    </div>

    <div class="row g-4 mb-5">
        <?php foreach ($categoryCards as $category => $meta): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="<?= htmlspecialchars(serviceCategoryRoute($category), ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none">
                    <div class="card-custom h-100 category-hero-card">
                        <div>
                            <div class="category-icon"><i class="bi <?= $category === 'makeup' ? 'bi-flower1' : ($category === 'kostum' ? 'bi-person-badge' : 'bi-stars'); ?>"></i></div>
                            <h5 class="mb-2"><?= htmlspecialchars($meta['title'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="small text-muted mb-3"><?= htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="btn btn-sm btn-action-gold">Lihat</span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</div>

 <div class="text-center mt-5 mb-4 text-white">
        <h2 class="fw-bold" style="font-family:'Lobster', cursive; font-size: 45px; text-shadow: 2px 2px 6px rgba(0,0,0,0.6);">Paket Wedding</h2>
        <div class="mx-auto" style="width: 80px; height: 3px; background-color: #ffffff; border-radius: 2px;"></div>
    </div>

    <div class="row g-4 justify-content-center pb-5">
        <?php foreach ($packageDataFromDB as $package): ?>
            <?php
            $variant = $package['variasi'][0];
            $tier = premiumTier($package['jenis'], implode(' ', $variant['include']));
            $isGold = $tier === 'gold';
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-premium <?= $isGold ? 'card-gold-theme' : 'card-silver-theme'; ?>">
                    <div class="<?= $isGold ? 'card-header-gold' : 'card-header-silver'; ?>">
                        <div class="badge-package <?= $isGold ? 'badge-gold' : 'badge-silver'; ?>"><?= $isGold ? 'Best Seller Package' : 'Bundling Package'; ?></div>
                        <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($package['jenis'], ENT_QUOTES, 'UTF-8'); ?></h4>
                        <div class="d-flex align-items-baseline mt-2">
                            <span class="price-currency">IDR</span>
                            <span class="price-style"><?= htmlspecialchars(str_replace('Rp ', '', $variant['harga']), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>

                    <div class="card-body-custom">
                        <ul class="include-list">
                            <?php foreach ($variant['include'] as $include): ?>
                                <li>
                                    <span class="icon-check <?= $isGold ? 'icon-gold-check' : 'icon-silver-check'; ?>"><i class="bi bi-check-lg"></i></span>
                                    <?= htmlspecialchars($include, ENT_QUOTES, 'UTF-8'); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="d-flex gap-2 mt-auto">
                            <button type="button" onclick="addToCart(<?= htmlspecialchars(json_encode($variant['nama']), ENT_QUOTES, 'UTF-8'); ?>, 'paket', <?= (float) $variant['harga_value']; ?>, '', <?= (int) $variant['id']; ?>)" class="btn btn-cart-custom" title="Tambah ke Keranjang"<?= $isGold ? ' style="border-color: #fcd34d;"' : ''; ?>>
                                <i class="bi bi-cart3 fs-5"></i>
                            </button>
                            <button type="button" onclick="handleServiceBooking(<?= htmlspecialchars(json_encode($variant['nama']), ENT_QUOTES, 'UTF-8'); ?>, <?= (float) $variant['harga_value']; ?>, '', <?= (int) $variant['id']; ?>)" class="btn <?= $isGold ? 'btn-action-gold' : 'btn-action-silver'; ?> flex-grow-1 text-center">
                                Cek Ketersediaan Jadwal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<a href="../index.php" class="btn btn-kembali"><i class="bi bi-arrow-left me-2"></i>Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include 'include/add_to_cart_script.php'; ?>
<?php include 'include/floating_chatbot.php'; ?>
<script>
const isLoggedIn = <?= isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

function handleServiceBooking(layanan, harga, foto = null, id = null) {
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

    let url = `penjadwalan.php?from=service&layanan=${encodeURIComponent(layanan)}&harga=${encodeURIComponent(harga)}&tipe=paket`;
    if (id) url += `&id=${encodeURIComponent(id)}`;
    if (foto) url += `&foto=${encodeURIComponent(foto)}`;
    window.location.href = url;
}
</script>
</body>
</html>
