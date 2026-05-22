
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Gold</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Lobster&display=swap" rel="stylesheet">

    <style>
        body{
            background:#f4f4f4;
            font-family:'Poppins',sans-serif;
        }

        .title-gold{
            font-family:'Lobster',cursive;
            font-size:95px;
            color:#c96b00;
            text-shadow:7px 7px 0px #8a4700;
            line-height:1;
        }

        .line-gold{
            width:120px;
            height:2px;
            background:#d7a066;
            margin:auto;
        }

        .gold-card{
            width:100%;
            max-width:420px;
            background:white;
            border-radius:30px;
            overflow:hidden;
            border:1px solid #f2d35e;
            box-shadow:0 0 25px rgba(255,193,7,0.35);
        }

        .gold-header{
            background:linear-gradient(to bottom,#ffd43b,#fff4bf);
            padding:35px 35px 70px;
            position:relative;
        }

        .gold-header::after{
            content:'';
            position:absolute;
            right:0;
            bottom:0;
            width:140px;
            height:140px;
            background:white;
            border-top-left-radius:100%;
        }

        .paket-title{
            color:#c7a300;
            font-weight:700;
            font-size:20px;
        }

        .price{
            font-size:22px;
            font-weight:700;
            color:#111827;
        }

        .price-number{
            font-size:34px;
            font-weight:800;
            color:#111827;
        }

        .include-title{
            font-size:18px;
            font-weight:500;
            color:#222;
        }

        .item-text{
            color:#9ca3af;
            font-size:20px;
        }

        .circle-img{
            width:82px;
            height:82px;
            background:#dddddd;
            border-radius:50%;
        }

        .btn-cart{
            width:50px;
            height:50px;
            background:#facc15;
            border:none;
            border-radius:6px;
            color:white;
        }

        .btn-booking{
            background:#facc15;
            border:none;
            border-radius:6px;
            color:white;
            font-weight:500;
            height:50px;
        }

        .btn-booking:hover,
        .btn-cart:hover{
            background:#eab308;
            color:white;
        }
    </style>
</head>

<body>

<div class="container py-3" style="max-width:480px;">

    <!-- Navbar -->
    <div class="d-flex justify-content-between align-items-center">

        <div class="fw-bold">
            Yayuk <span class="text-warning">Makeover</span>
        </div>

        <a href="keranjang.php" class="text-dark">
            <i class="bi bi-cart3 fs-2"></i>
        </a>

    </div>

    <!-- Back -->
    <div class="mt-2">
        <a href="#" onclick="history.back(); return false;" class="text-dark">
            <i class="bi bi-chevron-left fs-2"></i>
        </a>
    </div>

    <!-- Title -->
    <div class="text-center mt-4 mb-5">

        <h1 class="title-gold">
            GOLD
        </h1>

        <div class="line-gold mt-3"></div>

    </div>

    <!-- Card -->
    <div class="d-flex justify-content-center">

        <div class="gold-card">

            <!-- Header -->
            <div class="gold-header">

                <h3 class="paket-title mb-4">
                    PAKET GOLD
                </h3>

                <div class="d-flex align-items-center gap-3">

                    <span class="price">
                        IDR
                    </span>

                    <span class="price-number">
                        10.000.000
                    </span>

                </div>

            </div>

            <!-- Body -->
            <div class="p-4">

                <h5 class="include-title mb-5">
                    Include :
                </h5>

                <!-- Item -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="d-flex align-items-center gap-4">

                        <i class="bi bi-check-lg fs-1"></i>

                        <span class="item-text">
                            Kostum
                        </span>

                    </div>

                    <div class="circle-img"></div>

                </div>

                <!-- Item -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="d-flex align-items-center gap-4">

                        <i class="bi bi-check-lg fs-1"></i>

                        <span class="item-text">
                            Makeup
                        </span>

                    </div>

                    <div class="circle-img"></div>

                </div>

                <!-- Item -->
                <div class="d-flex justify-content-between align-items-center mb-5">

                    <div class="d-flex align-items-center gap-4">

                        <i class="bi bi-check-lg fs-1"></i>

                        <span class="item-text">
                            Dekor
                        </span>

                    </div>

                    <div class="circle-img"></div>

                </div>

                <!-- Button -->
                <div class="d-flex gap-3">

                    <!-- Cart -->
                    <a href="keranjang.php"
                       class="btn btn-cart d-flex justify-content-center align-items-center">

                        <i class="bi bi-cart3 fs-5"></i>

                    </a>

                    <!-- Booking -->
                    <a href="booking.php?from=paket&nama=Paket+Gold&harga=10000000"
                       class="btn btn-booking w-100 d-flex justify-content-center align-items-center">

                        Booking

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```
