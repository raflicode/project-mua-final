<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Yayuk Makeover - Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins',sans-serif;
            background:#f7f2eb;
            color:#222;
        }

        a{
            text-decoration:none;
        }

        /* =====================================================
           NAVBAR
        ===================================================== */

        .back-btn-bottom{
            position:fixed;
            bottom:20px;
            left:20px;

            width:50px;
            height:50px;

            border-radius:50%;

            background:#f2f2f2;

            display:flex;
            align-items:center;
            justify-content:center;

            color:#222;

            font-size:1.2rem;

            transition:.2s;

            z-index:1000;
        }

        .back-btn-bottom:hover{
            background:#e7e7e7;
            color:#000;
        }

        /* =====================================================
           CONTAINER
        ===================================================== */
        .main-container{
            width:100%;
            max-width:1400px;

            margin:auto;

            padding:
            100px
            18px
            60px;
        }

        /* =====================================================
           TITLE
        ===================================================== */
        .section-title{
            text-align:center;
            margin-bottom:45px;
        }

        .section-title h1{
            font-size:2.4rem;
            font-weight:700;
            line-height:1.15;

            margin-bottom:14px;
        }

        .section-title p{
            font-size:.95rem;
            color:#777;

            max-width:650px;
            margin:auto;
        }

        /* =====================================================
           CARD SERVICE
        ===================================================== */
        .service-card{
            background:#fff;

            border-radius:28px;

            padding:20px;

            height:100%;

            box-shadow:
            0 10px 28px rgba(0,0,0,.06);

            transition:.25s;
        }

        .service-card:hover{
            transform:translateY(-4px);
        }

        .service-img{
            width:100%;
            height:220px;

            border-radius:20px;

            overflow:hidden;

            margin-bottom:18px;
        }

        .service-img img{
            width:100%;
            height:100%;

            object-fit:cover;
        }

        .service-title{
            font-size:1.1rem;
            font-weight:700;

            margin-bottom:14px;
        }

        .service-list{
            padding-left:18px;

            color:#666;

            margin-bottom:24px;
        }

        .service-list li{
            margin-bottom:8px;
            font-size:.9rem;
        }

        .service-bottom{
            display:flex;
        }

        .btn-book{
            flex:1;

            height:44px;

            border:none;
            border-radius:999px;

            background:#111;

            color:#fff;

            font-size:.85rem;
            font-weight:600;
        }

        a.btn-book{
            display:flex;
            align-items:center;
            justify-content:center;

            text-decoration:none;
        }

        /* =====================================================
           PAKET WEDDING
        ===================================================== */
        .wedding-section{
            margin-top:80px;
        }

        .wedding-title{
            text-align:center;
            margin-bottom:35px;
        }

        .wedding-title h2{
            font-size:2rem;
            font-weight:700;
        }

        .wedding-card{
            position:relative;

            background:#fff;

            border-radius:28px;

            overflow:hidden;

            padding:18px;

            height:100%;

            box-shadow:
            0 12px 30px rgba(0,0,0,.08);
        }

        .wedding-image{
            width:100%;
            height:240px;

            border-radius:22px;

            overflow:hidden;

            margin-bottom:20px;
        }

        .wedding-image img{
            width:100%;
            height:100%;

            object-fit:cover;
        }

        .wedding-label{
            position:absolute;
            top:18px;
            left:18px;

            padding:
            8px
            18px;

            border-radius:999px;

            font-size:.72rem;
            font-weight:700;

            letter-spacing:.08em;
        }

        .silver-label{
            background:#e7e7e7;
            color:#666;
        }

        .gold-label{
            background:#f6b437;
            color:#fff;
        }

        .wedding-card h3{
            font-size:1.3rem;
            font-weight:700;

            margin-bottom:12px;
        }

        .wedding-card ul{
            padding-left:18px;
            color:#666;

            margin-bottom:22px;
        }

        .wedding-card ul li{
            margin-bottom:8px;
            font-size:.92rem;
        }

        .silver-card{
            border:2px solid #ececec;
        }

        .gold-card{
            border:2px solid #f6b437;

            box-shadow:
            0 0 25px rgba(246,180,55,.25);
        }

        /* =====================================================
           MOBILE
        ===================================================== */
        @media(max-width:767px){

            .section-title h1{
                font-size:2rem;
            }

            .service-img{
                height:180px;
            }

            .wedding-image{
                height:200px;
            }

            .main-container{
                padding:
                80px
                14px
                40px;
            }

            .navbar-custom{
                padding:16px;
            }
        }

    </style>
</head>

<body>

    <!-- NAVBAR -->
    <?php include 'include/navbar.php'; ?>

    <div class="main-container">

        <!-- TITLE -->
        <div class="section-title">

            <h1>
                Pilih paket yang sesuai <br>
                dengan tujuan Anda.
            </h1>

            <p>
                Pilih layanan terbaik dari Yayuk Makeover untuk
                membuat acara spesial Anda semakin elegan dan berkesan.
            </p>

        </div>

        <!-- SERVICE -->
        <div class="row g-4">

            <!-- MAKEUP -->
            <div class="col-md-4">

                <div class="service-card">

                    <div class="service-img">
                        <img src="../assets/gallery_makeup/makeup_1.jpeg" alt="">
                    </div>

                    <h3 class="service-title">
                        Makeup Wedding
                    </h3>

                    <ul class="service-list">
                        <li>Makeup Premium</li>
                        <li>Hairdo Elegant</li>
                        <li>Softlens</li>
                        <li>Touch Up Wedding</li>
                    </ul>

                    <div class="service-bottom">

                        <a href="makeup.php" class="btn-book">
                            Booking
                        </a>

                    </div>

                </div>

            </div>

            <!-- KOSTUM -->
            <div class="col-md-4">

                <div class="service-card">

                    <div class="service-img">
                        <img src="../assets/gallery_makeup/makeup_2.jpeg" alt="">
                    </div>

                    <h3 class="service-title">
                        Wedding Kostum
                    </h3>

                    <ul class="service-list">
                        <li>Kostum Pengantin</li>
                        <li>Aksesoris Lengkap</li>
                        <li>Custom Size</li>
                        <li>Elegant Design</li>
                    </ul>

                    <div class="service-bottom">

                        <a href="kostum.php" class="btn-book">
                            Booking
                        </a>

                    </div>

                </div>

            </div>

            <!-- DEKOR -->
            <div class="col-md-4">

                <div class="service-card">

                    <div class="service-img">
                        <img src="../assets/gallery_makeup/makeup_3.jpeg" alt="">
                    </div>

                    <h3 class="service-title">
                        Dekor Wedding
                    </h3>

                    <ul class="service-list">
                        <li>Dekor Pelaminan</li>
                        <li>Standing Flower</li>
                        <li>Photo Booth</li>
                        <li>Lighting Wedding</li>
                    </ul>

                    <div class="service-bottom">

                        <a href="dekor.php" class="btn-book">
                            Booking
                        </a>

                    </div>

                </div>

            </div>

        </div>

        <!-- PAKET -->
        <div class="wedding-section">

            <div class="wedding-title">
                <h2>Paket Wedding</h2>
            </div>

            <div class="row g-4 justify-content-center">

                <!-- SILVER -->
                <div class="col-md-5">

                    <div class="wedding-card silver-card">

                        <div class="wedding-label silver-label">
                            SILVER
                        </div>

                        <div class="wedding-image">
                            <img src="../assets/gallery_makeup/makeup_4.jpeg" alt="">
                        </div>

                        <h3>Paket Silver</h3>

                        <ul>
                            <li>Makeup Wedding</li>
                            <li>Kostum Wedding</li>
                            <li>Dekor Basic</li>
                            <li>Hairdo Elegant</li>
                        </ul>

                        <div class="service-bottom">

                            <a href="paket_silver.php" class="btn-book">
                                Booking
                            </a>

                        </div>

                    </div>

                </div>

                <!-- GOLD -->
                <div class="col-md-5">

                    <div class="wedding-card gold-card">

                        <div class="wedding-label gold-label">
                            GOLD
                        </div>

                        <div class="wedding-image">
                            <img src="../assets/gallery_makeup/makeup_5.jpeg" alt="">
                        </div>

                        <h3>Paket Gold</h3>

                        <ul>
                            <li>Makeup Premium</li>
                            <li>Kostum Exclusive</li>
                            <li>Dekor Full Wedding</li>
                            <li>Photo Booth + Lighting</li>
                        </ul>

                        <div class="service-bottom">

                            <a href="paket_gold.php" class="btn-book">
                                Booking
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- BACK BUTTON BOTTOM -->
    <a href="#" onclick="history.back(); return false;" class="back-btn-bottom">
        <i class="bi bi-chevron-left"></i>
    </a>

</body>
</html>
