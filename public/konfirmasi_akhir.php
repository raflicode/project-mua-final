<?php
// konfirmasi_akhir.php
session_start();
require_once '../config/koneksi.php';
require_once '../config/db_helpers.php';

ensure_dynamic_booking_schema($pdo);

$tokenMode = !empty($_GET['token']);
$idBookingMode = !empty($_GET['id_booking']);
$token = $tokenMode ? trim($_GET['token']) : '';
$idBooking = $idBookingMode ? (int) $_GET['id_booking'] : 0;
$booking = null;

if ($tokenMode || $idBookingMode) {
    $where = $tokenMode ? 'b.konfirmasi_akhir_token = ?' : 'b.id_booking = ?';
    $param = $tokenMode ? $token : $idBooking;
    $stmt = $pdo->prepare("
        SELECT
            b.id_booking,
            b.total_harga,
            b.status_booking,
            b.catatan,
            b.tgl_booking,
            u.full_name,
            u.username,
            u.no_telp,
            GROUP_CONCAT(DISTINCT l.nama_layanan ORDER BY l.nama_layanan SEPARATOR ', ') AS nama_layanan
        FROM booking b
        LEFT JOIN user u ON u.id_user = b.id_user
        LEFT JOIN booking_detail bd ON bd.id_booking = b.id_booking
        LEFT JOIN layanan l ON l.id_layanan = bd.id_layanan
        WHERE {$where} AND b.status_booking IN ('dikonfirmasi', 'konfirmasi')
        GROUP BY b.id_booking
        LIMIT 1
    ");
    $stmt->execute([$param]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        http_response_code(404);
        die('Data booking tidak ditemukan.');
    }

    $pembayaran = [
        'nama' => $booking['full_name'] ?: ($booking['username'] ?: 'Client'),
        'hp' => $booking['no_telp'] ?: '-',
        'metode' => isset($_POST['metode']) ? trim($_POST['metode']) : 'Transfer Bank',
    ];
    $backHref = 'booking.php';
} else {
    if (!isset($_SESSION['id_user'])) {
        header('Location: login.php');
        exit;
    }

    // Check jika belum ada data pembayaran dari proses_pembayaran
    if (!isset($_SESSION['pembayaran'])) {
        header('Location: pembayaran.php');
        exit;
    }

    $pembayaran = $_SESSION['pembayaran'];
    // Add metode pembayaran dari form input jika ada
    if (isset($_POST['metode'])) {
        $pembayaran['metode'] = trim($_POST['metode']);
        $_SESSION['pembayaran']['metode'] = $pembayaran['metode'];
    } elseif (!isset($pembayaran['metode'])) {
        $pembayaran['metode'] = 'Transfer Bank'; // Default value
    }
    $backHref = 'pembayaran.php';
}

// Check untuk errors dari proses_konfirmasi
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
if (!empty($errors)) {
    unset($_SESSION['errors']);
}

// Form data untuk repopulate form jika ada error
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
if (!empty($formData)) {
    unset($_SESSION['form_data']);
}

$uploadSuccess = !empty($_GET['uploaded']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pembayaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

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
        .back-nav {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 28px rgba(0,0,0,0.1);
    color: #2b1f15;
    text-decoration: none;
    transition: all 0.25s ease;
}

.back-nav:hover {
    background: #d07f26;
    color: white;
    transform: translateX(-4px);
}

.back-container {
    margin-bottom: 20px;
}

        @media (min-width: 992px) {
            .grid-2 { display: grid; grid-template-columns: 1fr 420px; gap: 28px; align-items: start; }
        }
    </style>
</head>

<body>

<?php include 'include/navbar.php'; ?>

<div class="wrapper">

    <div class="back-container">
    <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="back-nav">
        <i class="bi bi-chevron-left"></i>
    </a>
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
            <?php if ($uploadSuccess): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Bukti pembayaran berhasil dikirim. Silakan tunggu konfirmasi admin.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div>
                <div class="icon-box mb-3"><?= $uploadSuccess ? '✅' : '💳'; ?></div>
                <?php if ($uploadSuccess): ?>
                    <h5 class="fw-bold mb-1">Pembayaran Terkirim</h5>
                    <p class="text-muted small mb-4">Bukti pembayaran berhasil dikirim. Silakan tunggu konfirmasi admin.</p>
                <?php else: ?>
                    <h5 class="fw-bold mb-1">Selesaikan Pembayaran</h5>
                    <p class="text-muted small mb-3">Data Pembayaran Anda</p>

                    <div class="bank-box mb-3">
                        <small class="text-muted d-block mb-2">Nama Pemesan</small>
                        <h6 class="mb-2"><?= htmlspecialchars($pembayaran['nama']) ?></h6>

                        <small class="text-muted d-block mb-2">No Handphone</small>
                        <h6 class="mb-2"><?= htmlspecialchars($pembayaran['hp']) ?></h6>

                        <div class="bank-box mb-3">
                            <label class="text-muted d-block mb-2 small fw-bold" for="metode">Pilih Metode Pembayaran</label>
                            <select id="metode" name="metode" class="form-select" required>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="DANA" <?= (isset($pembayaran['metode']) && $pembayaran['metode'] === 'DANA') ? 'selected' : '' ?>>DANA</option>
                                <option value="OVO" <?= (isset($pembayaran['metode']) && $pembayaran['metode'] === 'OVO') ? 'selected' : '' ?>>OVO</option>
                                <option value="GOPAY" <?= (isset($pembayaran['metode']) && $pembayaran['metode'] === 'GOPAY') ? 'selected' : '' ?>>GOPAY</option>
                                <option value="Transfer Bank" <?= (isset($pembayaran['metode']) && $pembayaran['metode'] === 'Transfer Bank') ? 'selected' : '' ?>>Transfer Bank</option>
                                <option value="COD" <?= (isset($pembayaran['metode']) && $pembayaran['metode'] === 'COD') ? 'selected' : '' ?>>COD (Bayar di Tempat)</option>
                            </select>
                        </div>

                        <div class="bank-box mb-3">
                            <small class="text-muted d-block mb-2">Metode Terpilih</small>
                            <h6 class="mb-0" id="selectedMethod"><?= htmlspecialchars($pembayaran['metode'] ?? 'Transfer Bank') ?></h6>
                        </div>

                        <?php if ($tokenMode && $booking): ?>
                            <div class="bank-box mb-3">
                                <small class="text-muted d-block mb-2 mt-1">Layanan</small>
                                <h6 class="mb-2"><?= htmlspecialchars($booking['nama_layanan'] ?: 'Layanan Booking') ?></h6>

                                <small class="text-muted d-block mb-2">Total Pembayaran</small>
                                <h6 class="mb-0">Rp <?= number_format((float) $booking['total_harga'], 0, ',', '.') ?></h6>
                            </div>
                        <?php endif; ?>

                        <p class="text-muted small mb-2">Silahkan transfer ke rekening berikut untuk melanjutkan pemesanan:</p>

                        <div class="bank-box mb-3">
                            <small class="text-muted d-block mb-2">BANK BRI</small>
                            <h4 class="mb-2">883 0987 224</h4>
                            <small class="text-muted">A/N YAYUK ERNAWATI</small>
                        </div>

                        <form action="../actions/proses_konfirmasi.php" method="post" enctype="multipart/form-data" novalidate>
                            <?php if ($tokenMode): ?>
                                <input type="hidden" name="konfirmasi_akhir_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
                            <?php elseif ($idBookingMode): ?>
                                <input type="hidden" name="id_booking" value="<?= (int) $idBooking ?>">
                            <?php endif; ?>
                            <label class="upload-box w-100 mb-3" id="uploadBox">
                                <div class="fs-3">⇪</div>
                                <div class="small text-muted">Upload Bukti Pembayaran (.jpg, .png)</div>
                                <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png" id="fileInput" required>
                            </label>

                            <div id="fileNameDisplay" class="small text-muted mb-3" style="display:none;">File: <strong id="fileName"></strong></div>

                            <button type="submit" class="btn-konfirmasi btn-konfirmasi w-100">Kirim Bukti Pembayaran</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!$uploadSuccess): ?>
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
            <?php endif; ?>

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

const pageErrors = <?php echo json_encode($errors, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
const uploadSuccess = <?php echo json_encode(!empty($_GET['uploaded'])); ?>;

function showPopupMessages() {
    if (pageErrors && pageErrors.length) {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            html: pageErrors.map(msg => `<div>${msg}</div>`).join(''),
            confirmButtonText: 'Tutup'
        });
    } else if (uploadSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Bukti pembayaran berhasil dikirim. Silakan tunggu konfirmasi admin.',
            confirmButtonText: 'Oke'
        });
    }
}

// Handle file input display
const fileInput = document.getElementById('fileInput');
const fileNameDisplay = document.getElementById('fileNameDisplay');
const fileNameText = document.getElementById('fileName');

function updateFileDisplay() {
    const fileName = fileInput?.files[0]?.name;
    if (fileName) {
        fileNameText.textContent = fileName;
        fileNameDisplay.style.display = 'block';
    } else {
        fileNameDisplay.style.display = 'none';
    }
}

if (fileInput) {
    fileInput.addEventListener('change', updateFileDisplay);
}

const konfirmasiForm = document.querySelector('form[action="../actions/proses_konfirmasi.php"]');
if (konfirmasiForm) {
    konfirmasiForm.addEventListener('submit', function(event) {
        if (!fileInput || !fileInput.files.length) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Upload Bukti Diperlukan',
                text: 'Silakan upload bukti pembayaran terlebih dahulu sebelum mengirim.',
                confirmButtonText: 'Oke'
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', showPopupMessages);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
