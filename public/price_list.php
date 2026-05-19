<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

function formatRupiah($value)
{
    return 'Rp ' . number_format($value, 0, ',', '.');
}

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

try {
    $stmt = $pdo->prepare('SELECT * FROM layanan WHERE is_active = 1 ORDER BY nama_layanan ASC');
    $stmt->execute();
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $services = [];
}

$defaultServices = [
    [
        'img' => '../assets/foto_makeup.jpeg',
        'title' => 'Makeup Wedding',
        'price' => 1500000,
        'description' => 'Paket lengkap berdasar pengalaman profesional untuk tampil memukau di hari pernikahan.',
        'features' => [
            'Makeup full bridal',
            'Softlens & eyebrow',
            'Hairdo & styling rambut',
            'Trial makeup sebelum hari H'
        ],
        'link' => 'booking.php?layanan=Makeup+Wedding&harga=1500000'
    ],
    [
        'img' => '../assets/foto_kostum.jpeg',
        'title' => 'Wedding Kostum',
        'price' => 900000,
        'description' => 'Sewa kostum elegan untuk pesta, adat, dan tema spesial Anda.',
        'features' => [
            'Kostum pengantin pria atau wanita',
            'Aksesoris kepala dan kerudung',
            'Korset dan payet detail',
            'Fitting kostum sebelum acara'
        ],
        'link' => 'booking.php?layanan=Wedding+Kostum&harga=900000'
    ],
    [
        'img' => '../assets/foto_dekor.jpeg',
        'title' => 'Dekorasi / Terop',
        'price' => 1200000,
        'description' => 'Dekorasi tenda dan area acara dengan nuansa hangat dan detail estetik yang instagramable.',
        'features' => [
            'Tenda dan terop',
            'Pengaturan kursi dan meja',
            'Hiasan bunga & lampu',
            'Transportasi setup lokasi'
        ],
        'link' => 'booking.php?layanan=Dekorasi+Terop&harga=1200000'
    ]
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Yayuk Makeover - Price List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f7f3ec;
            color: #2d2d2d;
        }

        .container-custom {
            background: #ffffff;
            border-radius: 28px;
            padding: 48px 36px;
            max-width: 1380px;
            margin: 80px auto 64px;
            box-shadow: 0 28px 80px rgba(41, 31, 20, 0.12);
        }

        .page-heading {
            max-width: 860px;
            margin: 0 auto 42px;
        }

        .top-note {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            color: #b9773d;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .page-heading h1 {
            font-size: clamp(2.4rem, 4vw, 3.2rem);
            line-height: 1.05;
            margin-bottom: 1rem;
        }

        .page-heading p {
            color: #6c5b4d;
            font-size: 1rem;
            line-height: 1.8;
            max-width: 720px;
            margin: 0 auto;
        }

        .price-card {
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid rgba(210, 143, 65, 0.14);
            transition: transform 0.28s ease, box-shadow 0.28s ease;
            background: #fff;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .price-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 28px 60px rgba(74, 49, 29, 0.15);
        }

        .price-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .price-card-body {
            padding: 30px 28px 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        .price-card-title {
            font-size: 1.5rem;
            margin-bottom: 0.85rem;
            font-weight: 800;
            color: #2b1f14;
        }

        .price-value {
            font-size: 1.55rem;
            font-weight: 800;
            color: #ba6c26;
            margin-bottom: 18px;
        }

        .price-description {
            color: #5b4a3e;
            line-height: 1.75;
            margin-bottom: 22px;
            min-height: 90px;
        }

        .price-list {
            list-style: none;
            padding: 0;
            margin: 0 0 26px;
        }

        .price-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            margin-bottom: 0.85rem;
            color: #5e4f44;
            font-size: 0.96rem;
        }

        .price-list li::before {
            content: '•';
            color: #d08746;
            margin-top: 0.2rem;
            font-size: 0.9rem;
        }

        .price-card-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-primary {
            border-radius: 999px;
            padding: 0.95rem 1.8rem;
            font-weight: 700;
            box-shadow: 0 14px 28px rgba(208, 127, 38, 0.2);
        }

        .badge-new {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 0.9rem;
            border-radius: 999px;
            background: rgba(208, 127, 38, 0.14);
            color: #ad5b16;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        @media (max-width: 1199px) {
            .container-custom {
                padding: 36px 24px;
            }
        }

        @media (max-width: 767px) {
            .container-custom {
                margin: 60px 16px 40px;
                padding: 28px 20px;
            }

            .price-card img {
                height: 220px;
            }

            .price-card-body {
                padding: 24px;
            }

            .price-card-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-primary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <?php include 'include/navbar.php'; ?>

    <div class="container-fluid px-0">
        <div class="container-custom">
            <div class="text-center page-heading">
                <span class="top-note">Price List</span>
                <h1 class="fw-bold">Daftar Harga Layanan</h1>
                <p class="text-muted mx-auto">Temukan paket lengkap kami dengan detail harga dan servis yang sudah termasuk. Pilih layanan yang sesuai untuk momen spesial Anda.</p>
            </div>

            <div class="row g-4">
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service): ?>
                        <div class="col-lg-4">
                            <div class="price-card">
                                <img src="<?= htmlspecialchars(resolveImagePath($service['foto_layanan'])) ?>" alt="<?= htmlspecialchars($service['nama_layanan']) ?>">
                                <div class="price-card-body">
                                    <h2 class="price-card-title"><?= htmlspecialchars($service['nama_layanan']) ?></h2>
                                    <div class="price-value"><?= htmlspecialchars(formatRupiah($service['harga_dasar'])) ?></div>
                                    <p class="price-description"><?= nl2br(htmlspecialchars($service['deskripsi'] ?? 'Deskripsi paket belum tersedia.')) ?></p>
                                    <div class="price-card-footer">
                                        <span class="badge-new">Popular</span>
                                        <a href="booking.php?id=<?= intval($service['id_layanan']) ?>" class="btn btn-primary">Booking Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach ($defaultServices as $service): ?>
                        <div class="col-lg-4">
                            <div class="price-card">
                                <img src="<?= htmlspecialchars($service['img']) ?>" alt="<?= htmlspecialchars($service['title']) ?>">
                                <div class="price-card-body">
                                    <h2 class="price-card-title"><?= htmlspecialchars($service['title']) ?></h2>
                                    <div class="price-value"><?= htmlspecialchars(formatRupiah($service['price'])) ?></div>
                                    <p class="price-description"><?= htmlspecialchars($service['description']) ?></p>
                                    <ul class="price-list">
                                        <?php foreach ($service['features'] as $feature): ?>
                                            <li><?= htmlspecialchars($feature) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div class="price-card-footer">
                                        <span class="badge-new">Best Value</span>
                                        <a href="<?= htmlspecialchars($service['link']) ?>" class="btn btn-primary">Booking Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
