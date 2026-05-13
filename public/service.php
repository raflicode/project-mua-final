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
        .brand span {
            color: orange;
            font-weight: bold;
        }

        .card-custom {
            border-radius: 15px;
            padding: 15px;

            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);

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

            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);

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

    .card-custom {
        border-radius: 20px; /* Lebih melengkung */
        padding: 30px; /* Perbesar ruang dalam dari 15px ke 30px */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        background: #fff;
        min-height: 400px; /* Menentukan tinggi minimal agar kotak seragam */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Perbesar ukuran teks judul di dalam card */
    .card-custom h6 {
        font-size: 1.5rem; 
        font-weight: bold;
    }

    /* Perbesar area Paket Wedding */
    .wedding-box {
        height: 250px; /* Perbesar tinggi dari 180px ke 250px */
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        position: relative;
    }

    /* Perbesar teks label SILVER/GOLD */
    .label {
        font-size: 14px;
        padding: 8px 30px;
        font-weight: bold;
    }

        body {
    /* Sesuaikan angka ini dengan tinggi navbar kamu */
    padding-top: 100px !important; 
}
    </style>
</head>

<body>

    <?php include 'include/navbar.php'; ?>
    <div class="container-fluid mt-3 px-lg-5"> 
    <div class="container-custom">

        <div class="text-center mb-5">
            <h2 class="fw-bold" style="font-size: 2.5rem;">Pilih paket yang sesuai<br>dengan tujuan Anda.</h2>
            <h10>Pilih paket yang sesuai dengan kebutuhan Anda dan tingkatkan produktivitas Anda.</h10>
        </div>

        <div class="row text-center mb-5 justify-content-center">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card-custom">
                    <h6>Makeup Wedding</h6>
                    <ul class="text-start mt-3" style="font-size: 1.1rem;">
                        <li>Makeup</li>
                        <li>Softlens</li>
                        <li>Hairdo</li>
                        <li>dll</li>
                    </ul>
                    <a href="../../project-mua-final/public/makeup.php"
                        class="btn btn-outline-dark btn-booking w-100 py-3">Lihat Lebih Banyak
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card-custom">
                    <h6>Wedding Kostum</h6>
                    <ul class="text-start mt-3" style="font-size: 1.1rem;">
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                        <li>Teks 3</li>
                        <li>Teks 4</li>
                    </ul>
                    <a href="../../project-mua-final/public/kostum.php"
                        class="btn btn-outline-dark btn-booking w-100 py-3">Lihat Lebih Banyak
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card-custom">
                    <h6>Dekor/Terop</h6>
                    <ul class="text-start mt-3" style="font-size: 1.1rem;">
                        <li>Teks 5</li>
                        <li>Teks 6</li>
                        <li>Teks 7</li>
                        <li>Teks 8</li>
                    </ul>
                    <a href="../../project-mua-final/public/dekor.php"
                        class="btn btn-outline-dark btn-booking w-100 py-3">Lihat Lebih Banyak
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-md-5 col-lg-4 mb-4"> <div class="wedding-box silver">
                    <div class="label label-silver">SILVER</div>
                </div>
            </div>
            <div class="col-md-5 col-lg-4 mb-4">
                <div class="wedding-box gold">
                    <div class="label label-gold">GOLD</div>
                </div>
            </div>
        </div>
    </div>
</div>

            <!-- Button Kembali -->
            <a href="#" class="btn btn-kembali">Kembali ⤴</a>

        </div>
    </div>

</body>

</html>