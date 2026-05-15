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
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px;
            transition: transform 0.3s;
        }

        .card-custom:hover,
        .wedding-card:hover {
            transform: translateY(-5px);
        }

        .card-custom h5 {
            font-size: 1.5rem;
            font-weight: bold;
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

        .btn-silver:hover {
            background-color: #c7c7c7;
            color: #333;
        }

        .btn-gold {
            background-color: #ffd54f;
            border: none;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px;
        }

        .btn-gold:hover {
            background-color: #ffc107;
            color: white;
        }

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
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container-fluid mt-3 px-lg-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Pilih paket yang sesuai<br>dengan tujuan Anda.</h1>
        <p class="text-muted small">Pilih paket yang sesuai dengan kebutuhan Anda dan tingkatkan produktivitas Anda.</p>
    </div>

    <div class="row g-4 justify-content-center mb-5">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card-custom">
                <div>
                    <h5 class="mb-4">Makeup Wedding</h5>
                    <p class="small fw-bold mb-2">Include:</p>
                    <ul class="text-start mt-3" style="font-size: 1.1rem;">
                        <li>Wedding Akad</li>
                        <li>Wedding Resepsi</li>
                        <li>Graduation</li>
                        <li>Natural look</li>
                    </ul>
                </div>
                <a href="makeup.php" class="btn btn-outline-dark btn-booking">Lihat Lebih Banyak</a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card-custom">
                <div>
                    <h5 class="mb-4">Wedding Kostum</h5>
                    <p class="small fw-bold mb-2">Include:</p>
                    <ul class="text-start mt-3" style="font-size: 1.1rem;">
                        <li>Kostum Wedding</li>
                        <li>Kostum Graduation</li>
                        <li>Baju Adat</li>
                        <li>Kostum Karnaval</li>
                    </ul>
                </div>
                <a href="kostum.php" class="btn btn-outline-dark btn-booking">Lihat Lebih Banyak</a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card-custom">
                <div>
                    <h5 class="mb-4">Dekor/Terop</h5>
                    <p class="small fw-bold mb-2">Include:</p>
                    <ul class="text-start mt-3" style="font-size: 1.1rem;">
                        <li>Outdoor</li>
                        <li>Indoor</li>
                    </ul>
                </div>
                <a href="dekor.php" class="btn btn-outline-dark btn-booking">Lihat Lebih Banyak</a>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-4">
        <h3 class="fw-bold">Paket Wedding</h3>
    </div>

    <div class="row g-4 justify-content-center pb-5">
        <div class="col-10 col-sm-6 col-md-4 col-lg-3">
            <div class="card wedding-card silver-card">
                <div class="header-silver text-uppercase">Silver</div>
                <div class="card-body py-5 text-center" style="min-height: 200px;"></div>
                <div class="card-footer bg-white border-0 p-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-silver" type="button"><i class="bi bi-cart3"></i></button>
                        <a href="paket_silver.php" class="btn btn-silver w-100">Booking</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-10 col-sm-6 col-md-4 col-lg-3">
            <div class="card wedding-card gold-card">
                <div class="header-gold text-uppercase">Gold</div>
                <div class="card-body py-5 text-center" style="min-height: 200px;"></div>
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
</body>
</html>
