<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Silver Desktop</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Lobster&display=swap" rel="stylesheet">
</head>

<body class="bg-light" style="font-family:'Poppins',sans-serif; min-height:100vh;">

<div class="container py-4">

    <!-- Navbar -->
    <?php include 'include/navbar.php'; ?>

    <!-- Back -->
   

    <!-- Title -->
    <div class="text-center mt-4 mb-5">

        <h1
            class="fw-bold mb-3"
            style="
                font-family:'Lobster',cursive;
                color:#c96b00;
                font-size:100px;
                text-shadow:10px 10px 0px #8a4700;
            "
        >
            SILVER
        </h1>

        <div
            class="mx-auto"
            style="
                width:100px;
                height:2px;
                background-color:#d39a5c;
            "
        ></div>

    </div>

    <div class="d-flex justify-content-center">

    <!-- WRAPPER SCALE -->
    <div style="transform: scale(0.8); transform-origin: top center;">

        <div
            class="bg-white rounded-5 overflow-hidden position-relative"
            style="
                width:500px;
                border:2px solid #d9d9d9;
                box-shadow:0 0 25px rgba(0,0,0,0.2);
            "
        >

                <div class="d-flex justify-content-center">

        <div
            class="bg-white rounded-5 overflow-hidden position-relative"
            style="
                width:500px;
                border:2px solid #d9d9d9;
                box-shadow:0 0 25px rgba(0,0,0,0.2);
            "
        >

            <!-- Header -->
            <div
                class="position-relative px-5 pt-4 pb-5"
                style="
                    background:linear-gradient(to bottom,#d9d9d9,#ffffff);
                "
            >

                <!-- Lengkungan -->
                <div
                    class="position-absolute bottom-0 end-0 bg-white"
                    style="
                        width:150px;
                        height:150px;
                        border-top-left-radius:100%;
                        border-top:1px solid #d9d9d9;
                        border-left:1px solid #d9d9d9;
                    "
                ></div>

                <h3 class="fw-bold text-secondary mb-4">
                    PAKET SILVER
                </h3>

                <div class="d-flex align-items-center gap-3">

                    <span class="fw-bold fs-2">
                        IDR
                    </span>

                    <span class="fw-bold" style="font-size:45px;">
                        7.500.000
                    </span>

                </div>

            </div>

            <!-- Body -->
            <div class="px-5 pt-4 pb-5">

                <p class="fs-4 mb-5">Include :</p>

                <!-- Item -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="d-flex align-items-center gap-4">

                        <i class="bi bi-check-lg" style="font-size:40px;"></i>

                        <span class="text-secondary fs-4">
                            Kostum
                        </span>

                    </div>

                    <div
                        class="rounded-circle bg-secondary-subtle"
                        style="width:90px; height:90px;"
                    ></div>

                </div>

                <!-- Item -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="d-flex align-items-center gap-4">

                        <i class="bi bi-check-lg" style="font-size:40px;"></i>

                        <span class="text-secondary fs-4">
                            Makeup
                        </span>

                    </div>

                    <div
                        class="rounded-circle bg-secondary-subtle"
                        style="width:90px; height:90px;"
                    ></div>

                </div>

                <!-- Item -->
                <div class="d-flex justify-content-between align-items-center mb-5">

                    <div class="d-flex align-items-center gap-4">

                        <i class="bi bi-check-lg" style="font-size:40px;"></i>

                        <span class="text-secondary fs-4">
                            Dekor
                        </span>

                    </div>

                    <div
                        class="rounded-circle bg-secondary-subtle"
                        style="width:90px; height:90px;"
                    ></div>

                </div>

                <!-- Button -->
                <div class="d-flex gap-3 mt-4">

                    <!-- Cart -->
                    <a
                        href="keranjang.php"
                        class="btn d-flex justify-content-center align-items-center"
                        style="
                            background-color:#d9d9d9;
                            width:60px;
                            height:60px;
                        "
                    >
                        <i class="bi bi-cart3 text-dark fs-4"></i>
                    </a>

                    <!-- Booking -->
                    <a
                        href="booking.php?from=paket&nama=Paket+Silver&harga=7500000"
                        class="btn w-100 text-dark fw-semibold fs-5 py-3"
                        style="
                            background-color:#d9d9d9;
                        "
                    >
                        Booking
                    </a>

                </div>

            </div>

        </div>

    </div>

        </div>

    </div>

</div>
    <!-- Card -->


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
