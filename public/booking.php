<?php
session_start();

if(!isset($_SESSION['id_user'])){
    header("Location: login.php");
    exit;
}
?>
<?php
// booking.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Detail Pesanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#6f907e;
    font-family:Arial, Helvetica, sans-serif;
}

/* Container utama */
.booking-wrapper{
    max-width:420px;
    margin:auto;
}

/* Card */
.card-custom{
    border:none;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
}

/* Kotak gambar */
.gambar{
    width:75px;
    height:75px;
    background:#d9d9d9;
    border-radius:8px;
}

/* Textarea */
textarea.form-control{
    resize:none;
    height:110px;
}

/* Tombol */
.btn-lanjut{
    background:#5a8dee;
    border:none;
    font-weight:bold;
    padding:14px;
}

.btn-lanjut:hover{
    background:#4177df;
}
</style>
</head>

<body>

<!-- Navbar Include -->
<?php include 'public/include/navbar.php'; ?>

<div class="container py-5 booking-wrapper">

    <!-- Judul -->
    <h2 class="text-center fw-bold mb-5">Detail Pesanan</h2>

    <!-- Card -->
    <div class="card card-custom">

        <!-- Header produk -->
        <div class="card-body">
            <div class="d-flex gap-3 align-items-center">
                <div class="gambar"></div>

                <div>
                    <h5 class="mb-2">Makeup Graduation x1</h5>
                    <h6 class="mb-0">Rp. 800.000</h6>
                </div>
            </div>
        </div>

        <hr class="m-0">

        <!-- Detail -->
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <span>Total (1 item)</span>
                <span>Rp. 800.000</span>
            </div>

            <div class="d-flex justify-content-between mb-4">
                <span>Biaya layanan</span>
                <span>Rp. 10.000</span>
            </div>

            <textarea class="form-control mb-4" placeholder="Request khusus..."></textarea>

        </div>

        <hr class="m-0">

        <!-- Total -->
        <div class="card-body">

            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                <span>Total Bayar</span>
                <span>Rp. 810.000</span>
            </div>

            <a href="penjadwalan.php" class="btn btn-primary btn-lanjut w-100">
                Lanjut Penjadwalan
            </a>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
```
