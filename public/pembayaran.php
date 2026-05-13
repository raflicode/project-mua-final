<?php
// pembayaran.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proses Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            /* Mengubah background menjadi putih polos */
            background: #ffffff; 
            font-family: Arial, Helvetica, sans-serif;
        }

        .wrapper {
            max-width: 420px;
            margin: auto;
        }

        .card-custom {
            border: 1px solid #eee; /* Menambah border tipis karena background sudah putih */
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        .judul {
            font-weight: bold;
            color: #333;
        }

        .total-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
        }

        .btn-bayar {
            background: #5a8dee;
            border: none;
            font-weight: bold;
            padding: 14px;
            border-radius: 10px;
        }

        .btn-bayar:hover {
            background: #3d73dc;
        }
    </style>
</head>
<body>

<!-- Bagian <?php // include 'include/navbar.php'; ?> telah dihapus agar menu navigasi tidak muncul -->

<div class="container py-5 wrapper">

    <!-- Judul -->
    <h2 class="text-center judul mb-4">Proses Pembayaran</h2>

    <!-- Card -->
    <div class="card card-custom">
        <div class="card-body p-4">

            <form action="konfirmasi.php" method="post">

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <!-- HP -->
                <div class="mb-3">
                    <label class="form-label">No Handphone</label>
                    <input type="text" name="hp" class="form-control" required>
                </div>

                <!-- Metode -->
                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option>DANA</option>
                        <option>OVO</option>
                        <option>GOPAY</option>
                        <option>Transfer Bank</option>
                        <option>COD</option>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label class="form-label">Alamat / Catatan</label>
                    <textarea name="alamat" rows="4" class="form-control"></textarea>
                </div>

                <!-- Total -->
                <div class="total-box d-flex justify-content-between fw-bold fs-5 mb-4">
                    <span>Total Bayar</span>
                    <span>Rp. 810.000</span>
                </div>

                <!-- Tombol -->
                <button type="submit" class="btn btn-primary btn-bayar w-100">
                    Bayar Sekarang
                </button>

            </form>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>