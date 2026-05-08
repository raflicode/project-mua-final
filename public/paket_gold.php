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
</head>

<body class="bg-light" style="font-family:'Poppins',sans-serif;">

<div class="container-fluid px-3 py-2" style="max-width:430px; min-height:100vh;">

    <!-- Navbar -->
    <div class="d-flex justify-content-between align-items-center mb-2">

        <div class="fw-bold" style="font-size:18px;">
            Yayuk <span class="text-warning">Makeover</span>
        </div>

        <a href="keranjang.php" class="text-dark text-decoration-none">
            <i class="bi bi-cart3 fs-2"></i>
        </a>

    </div>

    <!-- Back -->
    <div class="mb-4">
        <a href="service.php" class="text-dark">
            <i class="bi bi-chevron-left fs-2"></i>
        </a>
    </div>

    <!-- Title -->
    <div class="text-center mt-5 mb-4">

        <h1
            class="fw-bold mb-3"
            style="
                font-family:'Lobster',cursive;
                color:#c96b00;
                font-size:72px;
                text-shadow:3px 3px 0px #8a4700;
            "
        >
            GOLD
        </h1>

        <div
            class="mx-auto"
            style="
                width:180px;
                height:2px;
                background-color:#d39a5c;
            "
        ></div>

    </div>

    <!-- Card -->
    <div class="d-flex justify-content-center mt-5">

        <div
            class="bg-white rounded-4 shadow position-relative overflow-hidden"
            style="
                width:230px;
                box-shadow:0 0 18px rgba(255,193,7,0.5)!important;
                border:2px solid #ffd54f;
            "
        >

            <!-- Header -->
            <div
                class="position-relative px-3 pt-3 pb-5"
                style="
                    background:linear-gradient(to bottom,#facc15,#fff3c4);
                "
            >

                <!-- Lengkung -->
                <div
                    class="position-absolute bottom-0 end-0 bg-white"
                    style="
                        width:90px;
                        height:90px;
                        border-top-left-radius:100%;
                    "
                ></div>

                <h5 class="fw-bold text-warning-emphasis mb-3">
                    PAKET GOLD
                </h5>

                <div class="d-flex align-items-center gap-2">

                    <span class="fw-bold fs-5">
                        IDR
                    </span>

                    <span class="fw-bold fs-3">
                        10.000.000
                    </span>

                </div>

            </div>

            <!-- Body -->
            <div class="px-3 pt-3 pb-4">

                <p class="mb-4">Include :</p>

                <!-- Item -->
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div class="d-flex align-items-center gap-3">

                        <i class="bi bi-check-lg fs-3"></i>

                        <span class="text-secondary">
                            Kostum
                        </span>

                    </div>

                    <div
                        class="rounded-circle bg-secondary-subtle"
                        style="width:55px; height:55px;"
                    ></div>

                </div>

                <!-- Item -->
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div class="d-flex align-items-center gap-3">

                        <i class="bi bi-check-lg fs-3"></i>

                        <span class="text-secondary">
                            Makeup
                        </span>

                    </div>

                    <div
                        class="rounded-circle bg-secondary-subtle"
                        style="width:55px; height:55px;"
                    ></div>

                </div>

                <!-- Item -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="d-flex align-items-center gap-3">

                        <i class="bi bi-check-lg fs-3"></i>

                        <span class="text-secondary">
                            Dekor
                        </span>

                    </div>

                    <div
                        class="rounded-circle bg-secondary-subtle"
                        style="width:55px; height:55px;"
                    ></div>

                </div>

                <!-- Button -->
                <div class="d-flex gap-2 mt-4">

                    <!-- Cart -->
                    <a
                        href="keranjang.php"
                        class="btn text-white d-flex justify-content-center align-items-center"
                        style="
                            background-color:#facc15;
                            width:35px;
                            height:35px;
                        "
                    >
                        <i class="bi bi-cart3"></i>
                    </a>

                    <!-- Booking -->
                    <a
                        href="/project-mua/public/booking.php"
                        class="btn w-100 text-white"
                        style="background-color:#facc15;"
                    >
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