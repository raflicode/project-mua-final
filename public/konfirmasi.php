<?php
// konfirmasi.php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --primary: #d07f26;
            --primary-dark: #8a4c18;
            --bg-soft: #f9f6f0;
            --card-bg: #ffffff;
            --muted: #6b563f;
        }

        body {
            background: var(--bg-soft);
            font-family: 'Plus Jakarta Sans', Arial, Helvetica, sans-serif;
            color: #3b2817;
            padding-top: 90px;
        }

        .wrapper {
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px;
        }

        .card-custom {
            border-radius: 20px;
            border: 1px solid rgba(208,127,38,0.12);
            box-shadow: 0 20px 48px rgba(0,0,0,0.08);
            background: var(--card-bg);
        }

        .icon-box {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, rgba(208,127,38,0.12), rgba(208,127,38,0.06));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: var(--primary-dark);
            margin: 0 auto;
        }

        .bank-box {
            background: #fff8ed;
            border-radius: 12px;
            padding: 18px;
            border: 1px solid rgba(226,181,121,0.2);
        }

        .upload-box {
            border: 2px dashed rgba(208,127,38,0.18);
            border-radius: 12px;
            padding: 28px 18px;
            text-align: center;
            cursor: pointer;
            transition: 0.18s;
            background: white;
        }

        .upload-box:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(0,0,0,0.06);}        

        .upload-box input { display: none; }

        .btn-konfirmasi {
            background: #b5835a;
            border: none;
            padding: 14px;
            font-weight: 800;
            border-radius: 12px;
            color: white;
            width: 100%;
        }

        .btn-konfirmasi:hover,
        .btn-konfirmasi:focus,
        .btn-konfirmasi:active,
        .btn-konfirmasi.active,
        .btn-check:checked + .btn-konfirmasi {
            background: #9c6d4e;
            border-color: #9c6d4e;
            color: white;
            box-shadow: none;
            transform: translateY(-3px);
        }

        @media (min-width: 992px) {
            .grid-2 { display: grid; grid-template-columns: 1fr 420px; gap: 28px; align-items: start; }
        }
    </style>
</head>

<body>

<?php include 'include/navbar.php'; ?>

<div class="wrapper">

    <div class="mb-3">
        <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="text-dark fs-4"><i class="bi bi-chevron-left"></i> Kembali</a>
    </div>

    <h2 class="fw-bold mb-4">Konfirmasi Pembayaran</h2>

    <div class="card card-custom">
        <div class="card-body p-4 grid-2">

            <!-- Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <div>• <?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div>
                <div class="icon-box mb-3">💳</div>
                <h5 class="fw-bold mb-1">Selesaikan Pembayaran</h5>
                <p class="text-muted small mb-3">Data Pembayaran Anda</p>

                <div class="bank-box mb-3">
                    <small class="text-muted d-block mb-2">Nama Pemesan</small>
                    <h6 class="mb-2"><?= htmlspecialchars($pembayaran['nama']) ?></h6>

                    <small class="text-muted d-block mb-2">No Handphone</small>
                    <h6 class="mb-2"><?= htmlspecialchars($pembayaran['hp']) ?></h6>

                    <small class="text-muted d-block mb-2">Metode Pembayaran</small>
                    <h6 class="mb-0"><?= htmlspecialchars($pembayaran['metode']) ?></h6>
                </div>

                <p class="text-muted small">Silahkan transfer ke rekening berikut untuk melanjutkan pemesanan:</p>

                <div class="bank-box mb-3">
                    <small class="text-muted d-block mb-2">BANK BRI</small>
                    <h4 class="mb-2">883 0987 224</h4>
                    <small class="text-muted">A/N YAYUK ERNAWATI</small>
                </div>

                <form action="../actions/proses_konfirmasi.php" method="post" enctype="multipart/form-data">
                    <label class="upload-box w-100 mb-3" id="uploadBox">
                        <div class="fs-3">⇪</div>
                        <div class="small text-muted">Upload Bukti Pembayaran (.jpg, .png)</div>
                        <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png" required id="fileInput">
                    </label>

                    <div id="fileNameDisplay" class="small text-muted mb-3" style="display:none;">File: <strong id="fileName"></strong></div>

                    <button type="submit" class="btn-konfirmasi btn-konfirmasi w-100">Kirim Bukti Pembayaran</button>
                </form>
            </div>

            <div>
                <div class="card p-3">
                    <h6 class="fw-bold">Ringkasan</h6>
                    <div class="small text-muted mb-3">Simpan bukti transfer agar kami dapat memverifikasi pembayaran Anda lebih cepat.</div>
                    <div class="d-grid gap-2">
                        <a href="booking.php" class="btn btn-outline-secondary">Lihat Booking Saya</a>
                        <a href="../public/keranjang.php" class="btn btn-outline-secondary">Kembali ke Keranjang</a>
                    </div>
                </div>
            </div>

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

// Handle file input display
document.getElementById('fileInput').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const fileNameText = document.getElementById('fileName');
    
    if (fileName) {
        fileNameText.textContent = fileName;
        fileNameDisplay.style.display = 'block';
    } else {
        fileNameDisplay.style.display = 'none';
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>