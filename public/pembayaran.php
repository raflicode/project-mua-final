<?php
// pembayaran.php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$fromPage = filter_input(INPUT_GET, 'from', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$backMap = [
    'makeup' => 'makeup.php',
    'dekor' => 'dekor.php',
    'kostum' => 'kostum.php'
];
$backHref = $backMap[$fromPage] ?? 'penjadwalan.php';

if (!isset($_SESSION['draft_booking'])) {
    $redirectUrl = 'booking.php';
    if ($fromPage) {
        $redirectUrl .= '?from=' . urlencode($fromPage);
    }
    header('Location: ' . $redirectUrl);
    exit;
}

if (empty($_SESSION['draft_booking']['id_jadwal'])) {
    header('Location: penjadwalan.php');
    exit;
}

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
    <title>Proses Pembayaran - Yayuk Makeover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #d07f26;
            --primary-dark: #8a4c18;
            --bg-soft: #fff5e7;
            --text-dark: #2b1f15;
            --text-muted: #5e4a37;
            --card-bg: #ffffff;
        }

        body {
            background: var(--bg-soft);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            padding-top: 100px !important;
            min-height: 100vh;
        }

.wrapper {
            max-width: 1000px;
            margin: auto;
        }

        /* Navigasi Top */
        .back-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .back-nav:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(-4px);
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Card Wrapper Premium */
        .card-custom {
            border: none;
            border-radius: 24px;
            box-shadow: 0 16px 45px rgba(0, 0, 0, 0.08);
            background: var(--card-bg);
            overflow: hidden;
        }

        /* Header Card Modern */
        .card-header-custom {
            background: linear-gradient(135deg, #fff2d9, #f4d1a3);
            padding: 30px;
            border-bottom: 1px solid #eed2a6;
        }

        .card-header-custom h2 {
            margin: 0;
            font-size: 1.55rem;
            font-weight: 800;
            color: #3c2919;
        }

        .step-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(208, 127, 38, 0.16);
            color: var(--primary-dark);
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* Form Controls Overhaul */
        .form-label {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 0.95rem;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 18px;
            border: 1px solid rgba(208, 127, 38, 0.18);
            padding: 14px 16px;
            font-size: 0.95rem;
            background-color: #fff9f1;
            transition: all 0.25s ease;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(208, 127, 38, 0.16);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        /* Inner Section Card untuk Alamat & Catatan */
        .inner-form-section {
            background: #fff7ee;
            border: 1px solid rgba(208, 127, 38, 0.16);
            border-radius: 22px;
            padding: 24px;
        }

        /* Sticky Sidebar Ringkasan di Desktop */
        @media (min-width: 992px) {
            .sticky-sidebar {
                position: sticky;
                top: 120px;
            }
        }

        /* Total Box Premium */
        .total-box-premium {
            background: #fff7eb;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #ecd4af;
        }

        .btn-bayar {
            background: linear-gradient(135deg, var(--primary-color), #ae5c16);
            border: none;
            color: white;
            font-weight: 700;
            padding: 16px;
            border-radius: 18px;
            font-size: 1rem;
            box-shadow: 0 16px 30px rgba(208, 127, 38, 0.24);
            transition: all 0.25s ease;
        }

        .btn-bayar:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 36px rgba(208, 127, 38, 0.28);
            color: white;
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container my-4 wrapper">

    <!-- Header Navigation -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="back-nav">
            <i class="bi bi-chevron-left"></i>
        </a>
        <h1 class="page-title mb-0">Pembayaran</h1>
        <div style="width: 45px;"></div>
    </div>

    <!-- Alert Error handling -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius: 16px;" role="alert">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Periksa kembali data Anda:</div>
            <?php foreach ($errors as $error): ?>
                <div class="small ms-4">• <?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form Utama -->
    <form action="../actions/proses_pembayaran.php<?= $fromPage ? '?from=' . urlencode($fromPage) : '' ?>" method="post">
        <div class="row g-4">
            
            <!-- Kolom Kiri: Form Input Data Pelanggan -->
            <div class="col-lg-7">
                <div class="card card-custom">
                    <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h2>Data Pelanggan & Metode</h2>
                            <p class="text-muted small mb-0 mt-1">Lengkapi informasi berikut untuk validasi booking.</p>
                        </div>
                        <span class="step-badge"><i class="bi bi-check-circle-fill"></i> Langkah 3 dari 3</span>
                    </div>

                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Input Nama -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" class="form-control" value="<?= htmlspecialchars($formData['nama'] ?? '', ENT_QUOTES) ?>" required pattern="[a-zA-Z\s]+" title="Nama hanya boleh mengandung huruf dan spasi" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" placeholder="Nama Anda">
                            </div>

                            <!-- Input No HP -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="hp">No. Handphone</label>
                                <input type="tel" id="hp" inputmode="numeric" pattern="[0-9]*" name="hp" class="form-control" value="<?= htmlspecialchars($formData['hp'] ?? '', ENT_QUOTES) ?>" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Contoh: 08123456xxx">
                            </div>

                            <!-- Pilihan Metode Pembayaran -->
                            <div class="col-12 mb-4">
                                <label class="form-label" for="metode">Metode Pembayaran</label>
                                <select id="metode" name="metode" class="form-select" required>
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <option value="DANA" <?= (isset($formData['metode']) && $formData['metode'] === 'DANA') ? 'selected' : '' ?>>DANA</option>
                                    <option value="OVO" <?= (isset($formData['metode']) && $formData['metode'] === 'OVO') ? 'selected' : '' ?>>OVO</option>
                                    <option value="GOPAY" <?= (isset($formData['metode']) && $formData['metode'] === 'GOPAY') ? 'selected' : '' ?>>GOPAY</option>
                                    <option value="Transfer Bank" <?= (isset($formData['metode']) && $formData['metode'] === 'Transfer Bank') ? 'selected' : '' ?>>Transfer Bank</option>
                                    <option value="COD" <?= (isset($formData['metode']) && $formData['metode'] === 'COD') ? 'selected' : '' ?>>COD (Bayar di Tempat)</option>
                                </select>
                            </div>

                            <!-- Section Alamat & Catatan -->
                            <div class="col-12">
                                <div class="inner-form-section">
                                    <div class="mb-3">
                                        <label class="form-label" for="alamat"><i class="bi bi-geo-alt-fill me-1" style="color: var(--primary-dark);"></i> Alamat Lengkap Lokasi</label>
                                        <textarea id="alamat" name="alamat" class="form-control" placeholder="Tuliskan alamat lengkap acara / pengerjaan..." required><?= htmlspecialchars($formData['alamat'] ?? '', ENT_QUOTES) ?></textarea>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label" for="catatan"><i class="bi bi-pencil-square me-1" style="color: var(--primary-dark);"></i> Catatan Tambahan (Opsional)</label>
                                        <textarea id="catatan" name="catatan" class="form-control" placeholder="Tambahkan catatan khusus jika ada..."><?= htmlspecialchars($formData['catatan'] ?? '', ENT_QUOTES) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Rincian Akhir & Tombol Submit (Sticky Desktop) -->
            <div class="col-lg-5">
                <div class="sticky-sidebar">
                    <div class="card card-custom">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="font-size: 1.1rem;"><i class="bi bi-receipt me-2" style="color: var(--primary-dark);"></i>Konfirmasi Final</h5>
                            <p class="text-muted small mb-4">Pastikan seluruh data penagihan dan alamat pengerjaan sudah benar sebelum menekan tombol bayar.</p>
                            
                            <div class="total-box-premium d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold text-muted small">Total Pembayaran</span>
                                <span class="fw-bold fs-4" style="color: var(--primary-dark);">Rp 810.000</span>
                            </div>

                            <button type="submit" class="btn btn-bayar w-100">
                                <i class="bi bi-shield-lock-fill me-2"></i> Konfirmasi Ketersediaan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>