<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Pilih Paket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-soft);
            color: var(--text-dark);
            padding-top: 100px !important;
            min-height: 100vh;
        }

        .wrapper {
            max-width: 1160px;
            margin: auto;
        }

        .back-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 14px 36px rgba(0,0,0,0.08);
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .back-nav:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(-2px);
        }

        .page-title {
            font-size: 2.1rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        .section-title {
            font-size: 1.55rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .card-custom {
            border-radius: 28px;
            border: 1px solid rgba(208, 127, 38, 0.16);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            background: var(--card-bg);
            overflow: hidden;
            transition: transform 0.25s ease;
            height: 100%;
        }

        .card-custom:hover {
            transform: translateY(-4px);
        }

        .package-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px;
            min-height: 420px;
        }

        .package-card h5 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .package-card .package-list {
            list-style: none;
            padding: 0;
            margin: 0;
            color: var(--text-dark);
        }

        .package-card .package-list li {
            position: relative;
            padding-left: 28px;
            margin-bottom: 0.9rem;
            font-size: 1rem;
        }

        .package-card .package-list li::before {
            content: '\f2db';
            font-family: 'bootstrap-icons';
            position: absolute;
            left: 0;
            top: 2px;
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .package-card p {
            color: var(--text-muted);
            margin-bottom: 1.75rem;
        }

        .btn-booking,
        .btn-gold,
        .btn-silver {
            width: 100%;
            border-radius: 18px;
            padding: 14px 18px;
            font-weight: 700;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-booking {
            background: linear-gradient(135deg, var(--primary-color), #ae5c16);
            border: none;
            color: white;
            box-shadow: 0 14px 28px rgba(208, 127, 38, 0.24);
        }

        .btn-booking:hover,
        .btn-gold:hover,
        .btn-silver:hover {
            transform: translateY(-2px);
        }

        .btn-silver {
            background: #f7e6c5;
            border: 1px solid rgba(208, 127, 38, 0.18);
            color: var(--text-dark);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--primary-color), #ae5c16);
            border: none;
            color: white;
            box-shadow: 0 14px 28px rgba(208, 127, 38, 0.24);
        }

        .package-header {
            padding: 22px 24px;
            border-radius: 22px;
            margin-bottom: 24px;
            color: var(--primary-dark);
            font-size: 1.3rem;
            font-weight: 800;
        }

        .package-header.gold {
            background: linear-gradient(135deg, #fff2d9, #f4d1a3);
        }

        .package-header.silver {
            background: linear-gradient(135deg, #f8f1de, #e7d1a3);
            color: #7f5a2f;
        }

        .wedding-card {
            border-radius: 28px;
            overflow: hidden;
            transition: transform 0.25s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .wedding-card:hover {
            transform: translateY(-4px);
        }

        .wedding-card .card-body {
            padding: 34px 28px;
            flex: 1;
        }

        .wedding-card .card-footer {
            background: transparent;
            border-top: none;
            padding: 24px 28px 30px;
        }

        .btn-kembali {
            display: none;
        }

        @media (max-width: 991px) {
            .package-card,
            .wedding-card .card-body,
            .wedding-card .card-footer {
                padding: 24px;
            }
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container-fluid mt-3 px-lg-5 wrapper">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <a href="javascript:history.back()" class="back-nav">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div>
            <h1 class="page-title">Pilih Paket Layanan</h1>
            <p class="page-subtitle">Pilih paket makeup, kostum, atau dekor yang paling cocok untuk acara Anda.</p>
        </div>
        <div style="width:50px;"></div>
    </div>

    <div class="row g-4 justify-content-center mb-5">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card card-custom package-card">
                <div>
                    <h5>Makeup Wedding</h5>
                    <p>Solusi lengkap untuk tampilan pengantin, keluarga, dan tamu spesial.</p>
                    <ul class="package-list mb-0">
                        <li>Wedding Akad</li>
                        <li>Wedding Resepsi</li>
                        <li>Graduation</li>
                        <li>Natural Look</li>
                    </ul>
                </div>
                <a href="makeup.php" class="btn btn-booking mt-4">Lihat Lebih Banyak</a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card card-custom package-card">
                <div>
                    <h5>Wedding Kostum</h5>
                    <p>Kostum premium untuk pesta, adat, dan tema spesial Anda.</p>
                    <ul class="package-list mb-0">
                        <li>Kostum Wedding</li>
                        <li>Kostum Graduation</li>
                        <li>Baju Adat</li>
                        <li>Kostum Karnaval</li>
                    </ul>
                </div>
                <a href="kostum.php" class="btn btn-booking mt-4">Lihat Lebih Banyak</a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card card-custom package-card">
                <div>
                    <h5>Dekor / Terop</h5>
                    <p>Jasa dekorasi event untuk konsep indoor dan outdoor Anda.</p>
                    <ul class="package-list mb-0">
                        <li>Outdoor</li>
                        <li>Indoor</li>
                    </ul>
                </div>
                <a href="dekor.php" class="btn btn-booking mt-4">Lihat Lebih Banyak</a>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4">
        <h2 class="section-title">Paket Wedding</h2>
        <p class="text-muted small">Pilih paket resmi untuk kebutuhan pernikahan Anda.</p>
    </div>

    <div class="row g-4 justify-content-center pb-5">
        <div class="col-10 col-sm-6 col-md-4 col-lg-3">
            <div class="card wedding-card silver-card">
                <div class="package-header silver text-uppercase">Silver</div>
                <div class="card-body text-center d-flex flex-column justify-content-center" style="min-height: 210px;">
                    <p class="mb-4 text-muted">Paket hemat dengan layanan utama yang tetap lengkap.</p>
                    <a href="paket_silver.php" class="btn btn-silver w-100">Booking</a>
                </div>
            </div>
        </div>

        <div class="col-10 col-sm-6 col-md-4 col-lg-3">
            <div class="card wedding-card gold-card">
                <div class="package-header gold text-uppercase">Gold</div>
                <div class="card-body text-center d-flex flex-column justify-content-center" style="min-height: 210px;">
                    <p class="mb-4 text-muted">Paket premium dengan nilai tambah dan detail eksklusif.</p>
                    <a href="paket_gold.php" class="btn btn-gold w-100">Booking</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
