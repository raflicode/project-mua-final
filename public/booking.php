<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$allowedBack = [
    'makeup' => 'makeup.php',
    'dekor' => 'dekor.php',
    'kostum' => 'kostum.php'
];
$fromPage = filter_input(INPUT_GET, 'from', FILTER_SANITIZE_STRING);
$backHref = 'service.php';
if ($fromPage && isset($allowedBack[$fromPage])) {
    $backHref = $allowedBack[$fromPage];
}

$namaProduk = filter_input(INPUT_GET, 'nama', FILTER_SANITIZE_STRING);
$hargaProduk = filter_input(INPUT_GET, 'harga', FILTER_VALIDATE_INT);

$foto = '../assets/foto_makeup.jpeg';
if ($fromPage === 'dekor') {
    $foto = '../assets/foto_dekor.jpeg';
} elseif ($fromPage === 'kostum') {
    $foto = '../assets/foto_kostum.jpeg';
}

$checkoutItems = [
    [
        'nama' => $namaProduk ?: 'Makeup Graduation',
        'harga' => $hargaProduk ?: 800000,
        'qty' => 1,
        'foto' => $foto
    ]
];
$biayaLayanan = 10000;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Pesanan - Yayuk Makeover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #d07f26;
            --primary-dark: #8a4c18;
            --bg-soft: #fff5e7;
            --text-dark: #2b1f15;
            --text-muted: #5e4a37;
            --card-bg: #ffffff;
            --shadow-soft: rgba(0, 0, 0, 0.12);
        }

        body {
            background-color: var(--bg-soft);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            padding-top: 100px !important;
        }

        .back-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: var(--card-bg);
            border-radius: 14px;
            box-shadow: 0 10px 28px rgba(0,0,0,0.1);
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .back-nav:hover {
            background: #d07f26;
            color: white;
            transform: translateX(-4px);
        }

        .order-card {
            border: 1px solid rgba(208, 127, 38, 0.16);
            border-radius: 24px;
            box-shadow: 0 24px 50px rgba(0, 0, 0, 0.08);
            background-color: var(--card-bg);
            padding: 28px;
            height: 100%;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #3c2b1f;
        }

        .page-subtitle {
            color: var(--text-muted);
            margin-top: 6px;
        }

        .card-inside-title {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 24px;
            color: #4a361e;
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 18px 0;
        }

        .product-img-wrapper {
            width: 90px;
            height: 90px;
            border-radius: 20px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid rgba(208, 127, 38, 0.18);
            background: #fff5e9;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info h6 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: #352715;
        }

        .product-info p {
            margin-bottom: 0;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .qty-badge {
            font-size: 0.75rem;
            background: #fff0d9;
            color: var(--primary-dark);
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 700;
        }

        .divider {
            height: 1px;
            background-color: #e7d1b0;
            margin: 24px 0;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 0.95rem;
        }

        .price-label { color: var(--text-muted); }
        .price-value { font-weight: 700; color: #3b2a1f; }

        .request-box {
            background-color: #fff4e4;
            border: 1px solid #e3b97a;
            border-radius: 16px;
            padding: 16px;
            font-size: 0.95rem;
            height: 130px;
            resize: none;
        }

        .request-box:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(208, 127, 38, 0.16);
            background-color: white;
        }

        .total-box-premium {
            background: #fff2d9;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #e2b579;
        }

        .btn-payment {
            background: linear-gradient(135deg, #d07f26, #b15f18);
            color: white;
            border: none;
            border-radius: 18px;
            padding: 15px;
            font-weight: 700;
            width: 100%;
            transition: transform 0.22s ease, box-shadow 0.25s ease;
            box-shadow: 0 14px 32px rgba(208, 127, 38, 0.28);
        }

        .btn-payment:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 36px rgba(208, 127, 38, 0.32);
        }

        @media (min-width: 992px) {
            .sticky-sidebar {
                position: sticky;
                top: 110px;
            }
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container my-4">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-column flex-md-row gap-3">
        <a href="#" onclick="history.back(); return false;" class="back-nav">
            <i class="bi bi-chevron-left"></i>
        </a>
        <div>
            <h2 class="section-title mb-1">Review Pesanan</h2>
            <p class="page-subtitle mb-0">Pastikan detail layanan sudah benar sebelum melanjutkan ke penjadwalan.</p>
        </div>
        <div style="width: 48px;"></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="order-card">
                <h5 class="card-inside-title"><i class="bi bi-bag-check me-2 text-warning"></i>Detail Pesanan</h5>
                <div id="order-items-container"></div>

                <div class="divider"></div>

                <div class="mt-4">
                    <label class="form-label small fw-bold text-muted"><i class="bi bi-chat-left-text me-2"></i>Notes untuk tim</label>
                    <textarea class="form-control request-box" placeholder="Contoh: Mohon hasil natural, lokasi outdoor, atau detail tambahan..."></textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="sticky-sidebar">
                <div class="order-card">
                    <h5 class="card-inside-title"><i class="bi bi-wallet2 me-2 text-warning"></i>Ringkasan Biaya</h5>

                    <div class="price-row">
                        <span class="price-label">Total produk</span>
                        <span class="price-value" id="total-items">0 item</span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Subtotal</span>
                        <span class="price-value" id="subtotal-text">Rp 0</span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Biaya layanan</span>
                        <span class="price-value">Rp 10.000</span>
                    </div>

                    <div class="divider"></div>

                    <div class="total-box-premium d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-muted small">Total Bayar</span>
                        <span class="fw-bold fs-5 text-dark" id="total-bayar-text">Rp 0</span>
                    </div>

                    <a href="penjadwalan.php" class="btn btn-payment">
                        Lanjut ke Penjadwalan <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function formatRupiah(value) {
    return "Rp " + Number(value).toLocaleString('id-ID');
}

function loadCheckoutItems() {
    const checkoutItems = JSON.parse(sessionStorage.getItem('checkout_items')) || <?php echo json_encode($checkoutItems); ?>;
    
    const container = document.getElementById('order-items-container');
    let html = '';
    let totalItems = 0;
    let totalHarga = 0;
    
    checkoutItems.forEach((item, index) => {
        const itemTotal = Number(item.harga) * Number(item.qty);
        totalItems += Number(item.qty);
        totalHarga += itemTotal;
        
        html += `
            <div class="product-item">
                <div class="product-img-wrapper">
                    <img src="${item.foto}" class="product-img" alt="${item.nama}">
                </div>
                <div class="product-info flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">${item.nama}</h6>
                        <span class="qty-badge">x${item.qty}</span>
                    </div>
                    <p class="price-value mb-0 text-primary small mt-1">${formatRupiah(item.harga)}</p>
                </div>
            </div>
        `;
        
        if (index < checkoutItems.length - 1) {
            html += '<div class="divider"></div>';
        }
    });
    
    container.innerHTML = html;
    
    document.getElementById('total-items').innerText = totalItems;
    document.getElementById('subtotal-text').innerText = formatRupiah(totalHarga);
    document.getElementById('total-bayar-text').innerText = formatRupiah(totalHarga + 10000);
}

document.addEventListener('DOMContentLoaded', loadCheckoutItems);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>