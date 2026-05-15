<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Pilih Paket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            padding-top: 100px !important;
        }

        .text-gold {
            color: #ffc107;
        }



        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            background: #fff;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            overflow: hidden;
            align-items: stretch;
            width: 100%;
            min-height: 320px;
            transition: transform 0.3s;
            gap: 0;
            padding: 0 !important;
        }

        .card-custom:hover,
        .wedding-card:hover {
            transform: translateY(-5px);
        }

        .card-img-left {
            width: 320px;
            min-width: 320px;
            object-fit: cover;
            border-radius: 20px 0 0 20px;
            height: auto;
        }

        .card-body-right {
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1;
            min-width: 0;
        }

        .card-custom h5 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .package-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .package-price {
            font-size: 1rem;
            font-weight: 700;
            color: #b8860b;
            background: #fff8e1;
            border: 1.5px solid #ffc107;
            padding: 4px 14px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .btn-booking {
            border-radius: 20px;
            width: 100%;
            padding: 12px;
            font-weight: 600;
        }

        .wedding-card {
            border-radius: 25px;
            overflow: hidden;
            border: none;
            transition: 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            min-height: 320px;
        }

        .header-silver {
            background: linear-gradient(to bottom, #d9d9d9, #f8f9fa);
            padding: 18px;
            text-align: center;
            font-weight: bold;
            font-size: 1.3rem;
            color: #666;
        }

        .header-gold {
            background: linear-gradient(to bottom, #ffd54f, #fff3c4);
            padding: 18px;
            text-align: center;
            font-weight: bold;
            font-size: 1.3rem;
            color: #b8860b;
        }

        .silver-card {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 2px solid #d9d9d9;
        }

        .gold-card {
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.35);
            border: 2px solid #ffd54f;
        }

        .btn-silver {
            background-color: #d9d9d9;
            border: none;
            color: #555;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px;
        }
        .btn-silver:hover { background-color: #c7c7c7; color: #333; }

        .btn-gold {
            background-color: #ffd54f;
            border: none;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px;
        }
        .btn-gold:hover { background-color: #ffc107; color: white; }

        /* Include list Silver & Gold */
        .wedding-include {
            padding: 16px 24px 8px;
            font-size: 0.9rem;
            color: #444;
            flex-grow: 1;
        }
        .wedding-include .cat-label {
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            margin-top: 12px;
            margin-bottom: 3px;
        }
        .wedding-include ul {
            padding-left: 18px;
            margin-bottom: 0;
        }
        .wedding-include ul li { margin-bottom: 2px; }

        .btn-kembali {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: #e74c3c;
            color: white;
            border-radius: 30px;
            padding: 10px 20px;
            z-index: 10;
        }

        #section-service {
            min-height: 100vh;
        }

        @media (max-width: 576px) {
            .card-custom { flex-direction: column !important; }
            .card-img-left {
                width: 100%;
                min-width: unset;
                height: 200px;
                border-radius: 20px 20px 0 0;
            }
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div id="section-service" class="container-fluid mt-3 px-lg-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Pilih paket yang sesuai<br>dengan tujuan Anda.</h1>
        <p class="text-muted small">Pilih paket yang sesuai dengan kebutuhan Anda dan tingkatkan produktivitas Anda.</p>
    </div>

    <div class="row g-4 justify-content-center mb-5">

        <!-- PAKET 1: Makeup Wedding � col-12 = full width -->
        <div class="col-12">
            <div class="card-custom">
                <img src="../assets/gallery_makeup/makeup_1.jpeg" alt="Makeup Wedding" class="card-img-left">
                <div class="card-body-right">
                    <div>
                        <div class="package-header">
                            <h5 class="mb-0">Makeup Wedding</h5>
                            <span class="package-price">Rp 2.500.000</span>
                        </div>
                        <p class="small fw-bold mb-2">Include:</p>
                        <ul class="text-start mt-3" style="font-size: 1.1rem;">
                            <li>Makeup</li>
                            <li>Softlens</li>
                            <li>Hairdo</li>
                            <li>dll</li>
                        </ul>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="makeup.php" class="btn btn-outline-dark btn-booking flex-grow-1"><i class="bi bi-cart3"></i> Lihat Produk</a>
                        <a href="makeup.php" class="btn btn-outline-dark btn-booking flex-grow-1">Booking</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAKET 2: Wedding Kostum � col-12 = full width -->
        <div class="col-12">
            <div class="card-custom">
                <img src="../assets/gallery_makeup/makeup_2.jpeg" alt="Wedding Kostum" class="card-img-left">
                <div class="card-body-right">
                    <div>
                        <div class="package-header">
                            <h5 class="mb-0">Wedding Kostum</h5>
                            <span class="package-price">Rp 4.000.000</span>
                        </div>
                        <p class="small fw-bold mb-2">Include:</p>
                        <ul class="text-start mt-3" style="font-size: 1.1rem;">
                            <li>Teks 1</li>
                            <li>Teks 2</li>
                            <li>Teks 3</li>
                            <li>Teks 4</li>
                        </ul>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="kostum.php" class="btn btn-outline-dark btn-booking flex-grow-1"><i class="bi bi-cart3"></i> Lihat Produk</a>
                        <a href="kostum.php" class="btn btn-outline-dark btn-booking flex-grow-1">Booking</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAKET 3: Dekor/Terop � col-12 = full width -->
        <div class="col-12">
            <div class="card-custom">
                <img src="../assets/gallery_makeup/makeup_3.jpeg" alt="Dekor Terop" class="card-img-left">
                <div class="card-body-right">
                    <div>
                        <div class="package-header">
                            <h5 class="mb-0">Dekor/Terop</h5>
                            <span class="package-price">Rp 6.500.000</span>
                        </div>
                        <p class="small fw-bold mb-2">Include:</p>
                        <ul class="text-start mt-3" style="font-size: 1.1rem;">
                            <li>Teks 5</li>
                            <li>Teks 6</li>
                            <li>Teks 7</li>
                            <li>Teks 8</li>
                        </ul>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="dekor.php" class="btn btn-outline-dark btn-booking flex-grow-1"><i class="bi bi-cart3"></i> Lihat Produk</a>
                        <a href="dekor.php" class="btn btn-outline-dark btn-booking flex-grow-1">Booking</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center mt-5 mb-4">
        <h3 class="fw-bold">Paket Wedding</h3>
    </div>

    <div class="row g-4 justify-content-center pb-5">

        <!-- SILVER � dengan include lengkap -->
        <div class="col-12 col-lg-6">
            <div class="card wedding-card silver-card">
                <div class="header-silver text-uppercase">Silver</div>
                <div class="wedding-include">
                    <div class="cat-label">Makeup</div>
                    <ul>
                        <li>Makeup</li>
                        <li>Softlens</li>
                        <li>Hairdo</li>
                    </ul>
                    <div class="cat-label">Kostum</div>
                    <ul>
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                    </ul>
                    <div class="cat-label">Dekorasi</div>
                    <ul>
                        <li>Teks 5</li>
                        <li>Teks 6</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 p-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-silver" type="button"><i class="bi bi-cart3"></i></button>
                        <a href="paket_silver.php" class="btn btn-silver w-100">Booking</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- GOLD � dengan include lengkap -->
        <div class="col-12 col-lg-6">
            <div class="card wedding-card gold-card">
                <div class="header-gold text-uppercase">Gold</div>
                <div class="wedding-include">
                    <div class="cat-label">Makeup</div>
                    <ul>
                        <li>Makeup</li>
                        <li>Softlens</li>
                        <li>Hairdo</li>
                        <li>dll</li>
                    </ul>
                    <div class="cat-label">Kostum</div>
                    <ul>
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                        <li>Teks 3</li>
                        <li>Teks 4</li>
                    </ul>
                    <div class="cat-label">Dekorasi</div>
                    <ul>
                        <li>Teks 5</li>
                        <li>Teks 6</li>
                        <li>Teks 7</li>
                        <li>Teks 8</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 p-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-gold text-white" type="button"><i class="bi bi-cart3"></i></button>
                        <a href="paket_gold.php" class="btn btn-gold w-100 text-white">Booking</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<a href="javascript:history.back()" class="btn btn-kembali">Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            navbar.classList.toggle('scrolled', window.scrollY > 10);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.navbar *').forEach(function (el) {
            if (el.children.length === 0 && el.textContent.trim().toLowerCase().includes('yayuk')) {
                const navItem = el.closest('.nav-item, .navbar-brand, li, a, span, div');
                if (navItem) navItem.remove();
            }
        });

        document.querySelectorAll(
            '.navbar-toggler, [data-bs-toggle="dropdown"] .bi-three-dots, [data-bs-toggle="dropdown"] .bi-three-dots-vertical'
        ).forEach(function (el) {
            const parent = el.closest('.nav-item, button, .dropdown') || el;
            parent.remove();
        });
    });
</script>
</body>
</html>
