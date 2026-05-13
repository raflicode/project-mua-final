<?php session_start(); ?>
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
            background: linear-gradient(135deg, #fff8f2 0%, #f1e4d7 100%);
        }

        .container-custom {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px 32px;
            max-width: 1400px;
            margin: 100px auto 60px;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.08);
        }

        .page-heading {
            max-width: 820px;
            margin: 0 auto 40px;
        }

        .price-card {
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .price-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .price-card img {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        .price-card-body {
            padding: 28px;
        }

        .price-card-title {
            font-size: 1.35rem;
            margin-bottom: 0.75rem;
        }

        .price-list {
            list-style: none;
            padding: 0;
            margin: 18px 0 0;
        }

        .price-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.7rem;
            color: #555;
        }

        .price-list li::before {
            content: '•';
            color: #d08b3f;
            margin-top: 2px;
        }

        .price-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f1f1f;
            margin-bottom: 14px;
        }

        .btn-primary {
            border-radius: 999px;
            padding: 0.85rem 1.6rem;
        }

        .top-note {
            display: inline-block;
            margin-bottom: 1.75rem;
            color: #7b6f61;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-size: 0.78rem;
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
                <div class="col-lg-4">
                    <div class="price-card">
                        <img src="../assets/foto_makeup.jpeg" alt="Makeup Wedding">
                        <div class="price-card-body">
                            <h2 class="price-card-title">Makeup Wedding</h2>
                            <div class="price-value">Rp 1.500.000</div>
                            <p class="mb-3">Paket lengkap berdasar pengalaman profesional untuk tampil memukau di hari pernikahan.</p>
                            <p class="fw-semibold mb-2">Include :</p>
                            <ul class="price-list">
                                <li>Makeup full bridal</li>
                                <li>Softlens & eyebrow</li>
                                <li>Hairdo & styling rambut</li>
                                <li>Trial makeup sebelum hari H</li>
                            </ul>
                            <a href="booking.php?layanan=Makeup+Wedding&harga=1500000" class="btn btn-primary mt-3">Booking Sekarang</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="price-card">
                        <img src="../assets/foto_kostum.jpeg" alt="Wedding Kostum">
                        <div class="price-card-body">
                            <h2 class="price-card-title">Wedding Kostum</h2>
                            <div class="price-value">Rp 900.000</div>
                            <p class="mb-3">Sewa kostum elegan untuk pengantin dengan pilihan desain yang anggun dan nyaman.</p>
                            <p class="fw-semibold mb-2">Include :</p>
                            <ul class="price-list">
                                <li>Kostum pengantin pria atau wanita</li>
                                <li>Aksesoris kepala dan kerudung</li>
                                <li>Korset dan payet detail</li>
                                <li>Fitting kostum sebelum acara</li>
                            </ul>
                            <a href="booking.php?layanan=Wedding+Kostum&harga=900000" class="btn btn-primary mt-3">Booking Sekarang</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="price-card">
                        <img src="../assets/foto_dekor.jpeg" alt="Dekor Terop">
                        <div class="price-card-body">
                            <h2 class="price-card-title">Dekorasi / Terop</h2>
                            <div class="price-value">Rp 1.200.000</div>
                            <p class="mb-3">Dekorasi tenda dan area acara dengan nuansa hangat dan detail estetik yang instagramable.</p>
                            <p class="fw-semibold mb-2">Include :</p>
                            <ul class="price-list">
                                <li>Tenda dan terop</li>
                                <li>Pengaturan kursi dan meja</li>
                                <li>Hiasan bunga & lampu</li>
                                <li>Transportasi setup lokasi</li>
                            </ul>
                            <a href="booking.php?layanan=Dekorasi+Terop&harga=1200000" class="btn btn-primary mt-3">Booking Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
