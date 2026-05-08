<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Pilih Paket</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #fff; }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        .text-gold { color: #ffc107; }
        
        /* Card Styling */
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            height: 100%;
        }
        .card-selected {
            border: 3px solid #007bff;
        }
        .btn-booking {
            background-color: #1a1a1a;
            color: white;
            border-radius: 20px;
            width: 100%;
            padding: 10px;
            font-weight: bold;
        }
        
        /* Paket Wedding Style */
        .wedding-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: none;
        }
        .header-silver { background: linear-gradient(to bottom, #d1d1d1, #f8f9fa); padding: 15px; text-align: center; font-weight: bold; color: #666; }
        .header-gold { background: linear-gradient(to bottom, #ffe082, #fff); padding: 15px; text-align: center; font-weight: bold; color: #b8860b; }
        
        .btn-gold { background-color: #ffd54f; border: none; color: white; border-radius: 5px; }
        .btn-silver { background-color: #e0e0e0; border: none; color: #757575; border-radius: 5px; }
    </style>
</head>
<body>

<!-- Header / Nav -->
<nav class="navbar navbar-light bg-white px-3 py-3">
    <div class="container-fluid">
        <span class="navbar-brand">Yayuk <span class="text-gold">Makeover</span></span>
        <button class="navbar-toggler border-0" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container mt-4">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="#" class="text-dark"><i class="bi bi-chevron-left fs-3"></i></a>
    </div>

    <!-- Judul Utama -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">Pilih paket yang sesuai<br>dengan tujuan Anda.</h1>
        <p class="text-muted small">Pilih paket yang sesuai dengan kebutuhan<br>Anda dan tingkatkan produktivitas Anda.</p>
    </div>

    <!-- Section 1: Paket Utama -->
    <div class="row g-4 justify-content-center mb-5">
        <!-- Makeup Wedding -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card card-custom p-4">
                <h5 class="fw-bold mb-4">Makeup Wedding</h5>
                <p class="small fw-bold mb-2">Include :</p>
                <ul class="list-unstyled small mb-5">
                    <li><i class="bi bi-check2 text-dark"></i> Makeup</li>
                    <li><i class="bi bi-check2 text-dark"></i> Softlens</li>
                    <li><i class="bi bi-check2 text-dark"></i> Hairdo</li>
                </ul>
                  <!-- LINK -->
            <a href="makeup.php" class="btn btn-booking mt-auto">
                  Booking
            </a>

            </div>
        </div>

        <!-- Wedding Kostum -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card card-custom p-4">
                <h5 class="fw-bold mb-4">Wedding Kostum</h5>
                <p class="small fw-bold mb-2">Include :</p>
                <ul class="list-unstyled small mb-5">
                    <li><i class="bi bi-check2 text-dark"></i> Teks 1</li>
                    <li><i class="bi bi-check2 text-dark"></i> Teks 2</li>
                    <li><i class="bi bi-check2 text-dark"></i> Teks 3</li>
                    <li><i class="bi bi-check2 text-dark"></i> Teks 4</li>
                </ul>
                 <!-- LINK -->
            <a href="dekor.php" class="btn btn-booking mt-auto">
    Booking
</a>
            </div>
        </div>

        <!-- Dekor/Terop (Selected) -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card card-custom card-selected p-4">
                <h5 class="fw-bold mb-4">Dekor/Terop</h5>
                <p class="small fw-bold mb-2">Include :</p>
                <ul class="list-unstyled small mb-5">
                    <li><i class="bi bi-check2 text-dark"></i> Teks 5</li>
                    <li><i class="bi bi-check2 text-dark"></i> Teks 6</li>
                    <li><i class="bi bi-check2 text-dark"></i> Teks 7</li>
                    <li><i class="bi bi-check2 text-dark"></i> Teks 8</li>
                </ul>
                  <!-- LINK -->
            <a href="kostum.php" class="btn btn-booking mt-auto">
                  Booking
            </a>
            </div>
        </div>
    </div>

    <!-- Section 2: Paket Wedding -->
    <div class="text-center mt-5 mb-4">
        <h3 class="fw-bold">Paket Wedding</h3>
    </div>

    <div class="row g-4 justify-content-center pb-5">
        <!-- Silver Package -->
        <div class="col-10 col-sm-6 col-md-4 col-lg-3">
            <div class="card wedding-card">
                <div class="header-silver text-uppercase">Silver</div>
                <div class="card-body py-5 text-center" style="min-height: 200px;">
                    <!-- Konten isi di sini -->
                </div>
                <div class="card-footer bg-white border-0 p-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-silver"><i class="bi bi-cart3"></i></button>
                       <a href="paket_silver.php" class="btn btn-silver w-100">
    Booking
</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gold Package -->
        <div class="col-10 col-sm-6 col-md-4 col-lg-3">
            <div class="card wedding-card" style="box-shadow: 0 15px 35px rgba(255, 193, 7, 0.2);">
                <div class="header-gold text-uppercase">Gold</div>
                <div class="card-body py-5 text-center" style="min-height: 200px;">
                    <!-- Konten isi di sini -->
                </div>
                <div class="card-footer bg-white border-0 p-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-gold text-white"><i class="bi bi-cart3"></i></button>
                       <a href="paket_gold.php" class="btn btn-gold w-100 text-white">
    Booking
</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>