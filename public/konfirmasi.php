```php id="20458"
<?php
// konfirmasi.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Pembayaran</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#6f907e;
    font-family:Arial, Helvetica, sans-serif;
}

.wrapper{
    max-width:420px;
    margin:auto;
}

.card-custom{
    border:none;
    border-radius:18px;
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
}

.icon-box{
    width:65px;
    height:65px;
    background:#f6d8c8;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    margin:auto;
}

.bank-box{
    background:#f8f8f8;
    border-radius:12px;
    padding:16px;
}

.upload-box{
    border:2px dashed #ced4da;
    border-radius:12px;
    padding:25px 15px;
    text-align:center;
    cursor:pointer;
    transition:0.2s;
}

.upload-box:hover{
    background:#f8f9fa;
}

.upload-box input{
    display:none;
}

.btn-konfirmasi{
    background:#5a8dee;
    border:none;
    padding:14px;
    font-weight:bold;
}

.btn-konfirmasi:hover{
    background:#3d73dc;
}
</style>
</head>

<body>

<!-- Navbar Include -->
<?php include 'include/navbar.php'; ?>

<div class="container py-5 wrapper">

    <!-- Judul -->
    <h2 class="text-center fw-bold mb-5">Pembayaran</h2>

    <!-- Card -->
    <div class="card card-custom">
        <div class="card-body p-4">

            <!-- Icon -->
            <div class="icon-box mb-4">💳</div>

            <!-- Text -->
            <h5 class="text-center fw-bold mb-2">
                Selesaikan Pembayaran
            </h5>

            <p class="text-center text-muted small mb-4">
                Silahkan transfer ke rekening ini untuk melanjutkan pemesanan
            </p>

            <!-- Rekening -->
            <div class="bank-box mb-4">
                <small class="text-muted d-block mb-2">BANK BRI</small>

                <h4 class="mb-2">883 0987 224</h4>

                <small class="text-muted">
                    A/N YAYUK ERNAWATI
                </small>
            </div>

            <!-- Upload -->
            <label class="upload-box w-100 mb-4">
                <div class="fs-3">⇪</div>
                <div class="small text-muted">
                    Upload Bukti Pembayaran (.jpg, .png)
                </div>
                <input type="file" accept=".jpg,.jpeg,.png">
            </label>

            <!-- Tombol WA -->
            <button
                class="btn btn-primary btn-konfirmasi w-100"
                onclick="window.open('https://wa.me/6281217857682?text=Halo%20Admin,%20saya%20ingin%20konfirmasi%20pembayaran%20booking%20makeup.%20Saya%20sudah%20transfer%20dan%20mengirim%20bukti%20pembayaran.','_blank')"
            >
                Konfirmasi Pembayaran
            </button>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
```
