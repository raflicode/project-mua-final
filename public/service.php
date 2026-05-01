<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Yayuk Makeover</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #6f8f7b;
        }

        .container-custom {
            background: #f5f5f5;
            border-radius: 10px;
            padding: 20px;
            min-height: 95vh;
        }

        .brand span {
            color: orange;
            font-weight: bold;
        }

        .card-custom {
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background: #fff;
        }

        .btn-booking {
            border-radius: 20px;
        }

        .btn-black {
            background: #000;
            color: #fff;
        }

        .btn-black:hover {
            background: #333;
        }

        .wedding-box {
            height: 180px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
        }

        .silver {
            background: #eaeaea;
        }

        .gold {
            background: #fff;
            border: 3px solid gold;
            box-shadow: 0 0 20px gold;
        }

        .label {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px 20px;
            border-radius: 10px;
            font-size: 12px;
        }

        .label-silver {
            background: #ddd;
        }

        .label-gold {
            background: gold;
            color: #000;
        }

        .btn-kembali {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: #e74c3c;
            color: white;
            border-radius: 30px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>

<div class="container mt-3">
    <div class="container-custom">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="brand">Yayuk <span>Makeover</span></h5>
            <h4>☰</h4>
        </div>

        <!-- Title -->
        <div class="text-center mb-5">
            <h2 class="fw-bold">Pilih paket yang sesuai<br>dengan tujuan Anda.</h2>
            <p class="text-muted">Pilih paket yang sesuai dengan kebutuhan Anda dan tingkatkan produktivitas Anda.</p>
        </div>

        <!-- Cards -->
        <div class="row text-center mb-5">
            <div class="col-md-4 mb-3">
                <div class="card-custom">
                    <h6>Makeup Wedding</h6>
                    <ul class="text-start small mt-3">
                        <li>Makeup</li>
                        <li>Softlens</li>
                        <li>Hairdo</li>
                        <li>dll</li>
                    </ul>
                    <a href="../../project-mua-final/public/makeup.php" class="btn btn-outline-dark btn-booking w-100">Lihat Lebih Banyak
                    </a>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card-custom">
                    <h6>Wedding Kostum</h6>
                    <ul class="text-start small mt-3">
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                        <li>Teks 3</li>
                        <li>Teks 4</li>
                    </ul>
                    <a href="../../project-mua-final/public/kostum.php" class="btn btn-outline-dark btn-booking w-100">Lihat Lebih Banyak
                    </a>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card-custom">
                    <h6>Dekor/Terop</h6>
                    <ul class="text-start small mt-3">
                        <li>Teks 5</li>
                        <li>Teks 6</li>
                        <li>Teks 7</li>
                        <li>Teks 8</li>
                    </ul>
                    <a href="../../project-mua-final/public/dekor.php" class="btn btn-outline-dark btn-booking w-100">Lihat Lebih Banyak
                    </a>
                </div>
            </div>
        </div>

        <!-- Paket Wedding -->
        <div class="text-center mb-4">
            <h4>Paket Wedding</h4>
        </div>

        <div class="row justify-content-center">
            <div class="col-4">
                <div class="wedding-box silver">
                    <div class="label label-silver">SILVER</div>
                </div>
            </div>

            <div class="col-4">
                <div class="wedding-box gold">
                    <div class="label label-gold">GOLD</div>
                </div>
            </div>
        </div>

        <!-- Button Kembali -->
        <a href="#" class="btn btn-kembali">Kembali ⤴</a>

    </div>
</div>

</body>
</html>