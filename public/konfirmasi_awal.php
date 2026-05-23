<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['draft_booking'])) {
    header('Location: booking.php');
    exit;
}

if (!isset($_SESSION['pembayaran'])) {
    header('Location: pembayaran.php');
    exit;
}

$draft = $_SESSION['draft_booking'];
$pembayaran = $_SESSION['pembayaran'];
$backHref = 'pembayaran.php';

function formatRupiah($value)
{
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
}

$namaLayanan = $draft['nama_layanan'] ?? 'Layanan booking';
$idBooking = (int) ($draft['id_booking'] ?? 0);
$total = (float) ($draft['total'] ?? $draft['harga'] ?? 0) + 10000;
$tanggal = $draft['tanggal'] ?? '-';
$jamMulai = isset($draft['jam_mulai']) ? substr($draft['jam_mulai'], 0, 5) : '-';
$jamSelesai = isset($draft['jam_selesai']) ? substr($draft['jam_selesai'], 0, 5) : '-';

if (!empty($draft['items']) && is_array($draft['items'])) {
    $itemLines = [];
    foreach ($draft['items'] as $item) {
        $qty = (int) ($item['kuantitas'] ?? $item['qty'] ?? 1);
        $name = $item['nama_layanan'] ?? 'Layanan';
        $itemLines[] = "- {$name} x{$qty}";
    }
    $layananText = implode("\n", $itemLines);
} else {
    $layananText = "- {$namaLayanan}";
}

$pesan = "Halo Admin Yayuk Makeover, saya ingin konfirmasi ketersediaan booking.\n\n"
    . ($idBooking > 0 ? "ID Booking: {$idBooking}\n" : '')
    . "Nama: " . ($pembayaran['nama'] ?? '-') . "\n"
    . "No HP: " . ($pembayaran['hp'] ?? '-') . "\n"
    . "Layanan:\n{$layananText}\n"
    . "Tanggal: {$tanggal}\n"
    . "Jam: {$jamMulai} - {$jamSelesai}\n"
    . "Metode Pembayaran: " . ($pembayaran['metode'] ?? '-') . "\n"
    . "Alamat: " . ($pembayaran['alamat'] ?? '-') . "\n";

if (!empty($pembayaran['catatan'])) {
    $pesan .= "Catatan: {$pembayaran['catatan']}\n";
}

$pesan .= "Total estimasi: " . formatRupiah($total) . "\n\nMohon konfirmasi apakah jadwal dan layanan masih tersedia.";
$waUrl = 'https://wa.me/6281333273119?' . http_build_query(['text' => $pesan]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Ketersediaan - Yayuk Makeover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background: #fff5e7;
            color: #2b1f15;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            padding-top: 100px;
        }

        .wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 24px;
        }

        .card-custom {
            border: 0;
            border-radius: 24px;
            box-shadow: 0 18px 48px rgba(74, 49, 29, 0.12);
            overflow: hidden;
        }

        .hero {
            background: linear-gradient(135deg, #fff2d9, #f4d1a3);
            padding: 32px;
            border-bottom: 1px solid #eed2a6;
        }

        .icon-box {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #25d366;
            color: white;
            font-size: 2rem;
            box-shadow: 0 14px 28px rgba(37, 211, 102, 0.25);
        }

        .summary-box {
            background: #fff8ef;
            border: 1px solid rgba(208, 127, 38, 0.16);
            border-radius: 18px;
            padding: 20px;
        }

        .btn-wa {
            background: #25d366;
            border: none;
            color: white;
            font-weight: 800;
            padding: 15px 18px;
            border-radius: 16px;
            box-shadow: 0 16px 30px rgba(37, 211, 102, 0.22);
        }

        .btn-wa:hover {
            background: #1fb85a;
            color: white;
        }
    </style>
</head>
<body>
<?php include 'include/navbar.php'; ?>

<div class="wrapper">
    <div class="mb-3">
        <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-chevron-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card card-custom">
        <div class="hero">
            <div class="icon-box mb-3"><i class="bi bi-whatsapp"></i></div>
            <h1 class="fw-bold mb-2">Konfirmasi Ketersediaan</h1>
            <p class="mb-0 text-muted">Kirim ringkasan booking ke admin melalui WhatsApp untuk memastikan jadwal dan layanan tersedia.</p>
        </div>

        <div class="card-body p-4">
            <div class="summary-box mb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Nama</div>
                        <div class="fw-bold"><?= htmlspecialchars($pembayaran['nama'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">No HP</div>
                        <div class="fw-bold"><?= htmlspecialchars($pembayaran['hp'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">Tanggal & Jam</div>
                        <div class="fw-bold"><?= htmlspecialchars($tanggal . ' / ' . $jamMulai . ' - ' . $jamSelesai, ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">Total Estimasi</div>
                        <div class="fw-bold"><?= htmlspecialchars(formatRupiah($total), ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small">Layanan</div>
                        <pre class="mb-0 fw-bold" style="white-space: pre-wrap; font-family: inherit;"><?= htmlspecialchars($layananText, ENT_QUOTES, 'UTF-8'); ?></pre>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small">Alamat</div>
                        <div class="fw-bold"><?= nl2br(htmlspecialchars($pembayaran['alamat'] ?? '-', ENT_QUOTES, 'UTF-8')); ?></div>
                    </div>
                </div>
            </div>

            <a href="<?= htmlspecialchars($waUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener" class="btn btn-wa w-100">
                <i class="bi bi-whatsapp me-2"></i>Konfirmasi via WhatsApp
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
