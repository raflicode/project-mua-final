<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Yayuk Makeover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #fff;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333;
            padding-top: 100px !important;
        }

        .order-detail-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        .order-card {
            border: 1px solid #eee;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background-color: #fff;
        }

        .product-img-placeholder {
            width: 80px;
            height: 80px;
            background-color: #d1d1d1;
            border: 3px solid #3b82f6;
            border-radius: 12px;
        }

        .request-box {
            background-color: #f8f8f8;
            border: none;
            border-radius: 12px;
            padding: 15px;
            width: 100%;
            height: 120px;
            resize: none;
            font-size: 0.9rem;
            color: #888;
        }

        .request-box:focus {
            outline: none;
            box-shadow: none;
            background-color: #f0f0f0;
        }

        .btn-payment {
            background-color: #6493e9;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-payment:hover {
            background-color: #5381d6;
            color: white;
        }

        .divider {
            border-top: 1px solid #f0f0f0;
            margin: 20px 0;
        }

        .text-price {
            font-weight: 600;
        }

        .label-muted {
            color: #999;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="order-detail-container">
    <div class="mb-4">
        <a href="service.php" class="text-dark fs-3"><i class="bi bi-chevron-left"></i></a>
    </div>

    <h2 class="text-center fw-bold mb-5">Detail Pesanan</h2>

    <div class="order-card p-4">
        <div class="d-flex align-items-start mb-4">
            <div class="product-img-placeholder me-3"></div>
            <div>
                <h6 class="fw-bold mb-1">Makeup Graduation <span class="ms-2">x1</span></h6>
                <p class="text-price mb-0">Rp. 800.000</p>
            </div>
        </div>

        <div class="divider"></div>

        <div class="d-flex justify-content-between mb-2">
            <span class="label-muted">Total (1 item)</span>
            <span class="text-price">Rp. 800.000</span>
        </div>
        <div class="d-flex justify-content-between mb-4">
            <span class="label-muted">Biaya layanan</span>
            <span class="text-price">Rp. 10.000</span>
        </div>

        <div class="mb-4">
            <textarea class="form-control request-box" placeholder="Request khusus..."></textarea>
        </div>

        <div class="divider"></div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-bold">Total Bayar</span>
            <span class="fw-bold text-price">Rp. 810.000</span>
        </div>

        <a href="penjadwalan.php" class="btn btn-payment">
            Lanjut Penjadwalan
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
