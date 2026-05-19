<?php
// pembayaran.php
session_start();
$backHref = 'penjadwalan.php';

// Check for errors from proses_pembayaran
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

// Clear session after displaying
if (!empty($errors)) {
    unset($_SESSION['errors']);
    unset($_SESSION['form_data']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proses Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            /* Mengubah background menjadi putih polos */
            background: #ffffff; 
            font-family: Arial, Helvetica, sans-serif;
        }

      .wrapper {
    width: 100%;
    max-width: 850px;
    margin: auto;
    .container.wrapper {
    padding-left: 20px;
    padding-right: 20px;
}
}
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

       .btn-bayar{
    background: #b5835a !important;
    border: none !important;
    font-weight: bold;
    padding: 14px;
    border-radius: 10px;
    color: white !important;
}

.btn-bayar:hover,
.btn-bayar:focus,
.btn-bayar:active,
.btn-bayar.active,
.btn-check:checked + .btn-bayar{
    background: #b5835a !important;
    border-color: #b5835a !important;
    color: white !important;
    box-shadow: none !important;
}
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container py-5 wrapper">

    <div class="mb-4">
       <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="text-dark fs-3"><i class="bi bi-chevron-left"></i></a>
    </div>

    <!-- Judul -->
    <h2 class="text-center judul mb-4">Proses Pembayaran</h2>

    <!-- Card -->
    <div class="card card-custom">
        <div class="card-body p-4">

            <!-- Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <div>• <?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="../actions/proses_pembayaran.php" method="post">

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required pattern="[a-zA-Z\s]+" title="Nama hanya boleh mengandung huruf dan spasi" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');">
                </div>

                <!-- HP -->
                <div class="mb-3">
                    <label class="form-label">No Handphone</label>
                    <input type="tel" inputmode="numeric" pattern="[0-9]*" name="hp" class="form-control" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
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
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="form-control" placeholder="Masukkan alamat lengkap..." required></textarea>
                </div>

                <!-- Catatan -->
                <div class="mb-4">

                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" rows="3" class="form-control" placeholder="Tambahkan catatan khusus jika ada..."></textarea>

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

<script>
function goBack() {
    if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
        window.history.back();
    } else {
        window.location.href = 'booking.php';
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
