<?php
// konfirmasi.php
session_start();

// Check jika belum ada data pembayaran dari proses_pembayaran
if (!isset($_SESSION['pembayaran'])) {
    header('Location: pembayaran.php');
    exit;
}

// Check untuk errors dari proses_konfirmasi
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
if (!empty($errors)) {
    unset($_SESSION['errors']);
}

$pembayaran = $_SESSION['pembayaran'];
$backHref = 'pembayaran.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pembayaran</title>

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
    max-width: 900px;
    margin: auto;
}
    .container.wrapper {
    padding-left: 20px;
    padding-right: 20px;
}


        .card-custom {
            /* Menambahkan border tipis agar card terlihat di background putih */
            border: 1px solid #f0f0f0;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        .icon-box {
            width: 65px;
            height: 65px;
            background: #f6d8c8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: auto;
        }

        .bank-box {
            background: #f8f8f8;
            border-radius: 12px;
            padding: 16px;
        }

        .upload-box {
            border: 2px dashed #ced4da;
            border-radius: 12px;
            padding: 25px 15px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .upload-box:hover {
            background: #f8f9fa;
        }

        .upload-box input {
            display: none;
        }

        .btn-konfirmasi {
    background: #b5835a !important;
    border: none !important;
    padding: 14px;
    font-weight: bold;
    border-radius: 10px;
    color: white !important;
}

.btn-konfirmasi:hover,
.btn-konfirmasi:focus,
.btn-konfirmasi:active,
.btn-konfirmasi.active,
.btn-check:checked + .btn-konfirmasi {
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
    <h2 class="text-center fw-bold mb-5">Pembayaran</h2>

    <!-- Card -->
    <div class="card card-custom">
        <div class="card-body p-4">

            <!-- Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <div>- <?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Icon -->
            <div class="icon-box mb-4"><i class="bi bi-credit-card"></i></div>

            <!-- Text -->
            <h5 class="text-center fw-bold mb-2">
                Selesaikan Pembayaran
            </h5>

            <p class="text-center text-muted small mb-4">
                Data Pembayaran Anda:
            </p>

            <!-- Data Pembayaran -->
            <div class="bank-box mb-4" style="background: #fff3cd;">
                <small class="text-muted d-block mb-2">Nama Pemesan</small>
                <h6 class="mb-3"><?= htmlspecialchars($pembayaran['nama']) ?></h6>

                <small class="text-muted d-block mb-2">No Handphone</small>
                <h6 class="mb-3"><?= htmlspecialchars($pembayaran['hp']) ?></h6>

                <small class="text-muted d-block mb-2">Metode Pembayaran</small>
                <h6 class="mb-0"><?= htmlspecialchars($pembayaran['metode']) ?></h6>
            </div>

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
            <form action="../actions/proses_konfirmasi.php" method="post" enctype="multipart/form-data" novalidate>
                <label class="upload-box w-100 mb-4" id="uploadBox">
                    <div class="fs-3"><i class="bi bi-upload"></i></div>
                    <div class="small text-muted">
                        Upload Bukti Pembayaran (.jpg, .png)
                    </div>
                    <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png" id="fileInput">
                </label>

                <div id="fileNameDisplay" class="small text-muted mb-3" style="display:none;">
                    File: <strong id="fileName"></strong>
                </div>

                <!-- Tombol Konfirmasi -->
                <button type="submit" class="btn btn-primary btn-konfirmasi w-100">
                    Kirim Bukti Pembayaran
                </button>
            </form>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function goBack() {
    if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
        window.history.back();
    } else {
        window.location.href = 'booking.php';
    }
}

const fileInput = document.getElementById('fileInput');
const fileNameDisplay = document.getElementById('fileNameDisplay');
const fileNameText = document.getElementById('fileName');
const konfirmasiForm = document.querySelector('form[action="../actions/proses_konfirmasi.php"]');

if (fileInput) {
    fileInput.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            fileNameText.textContent = fileName;
            fileNameDisplay.style.display = 'block';
        } else {
            fileNameDisplay.style.display = 'none';
        }
    });
}

if (konfirmasiForm) {
    konfirmasiForm.addEventListener('submit', function(e) {
        if (!fileInput || !fileInput.files.length) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Bukti Pembayaran Belum Diunggah',
                text: 'Silakan upload gambar bukti pembayaran terlebih dahulu.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#c19775'
            });
        }
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
