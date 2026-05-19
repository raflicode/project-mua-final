<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

// Redirect jika belum login
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$backHref = '../index.php';

// Fetch keranjang data dari database
try {
    $stmt = $pdo->prepare("SELECT * FROM keranjang WHERE id_user = ? ORDER BY created_at DESC");
    $stmt->execute([$id_user]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    function getCartImagePath(array $item): string {
        $name = strtolower($item['nama_layanan'] ?? '');
        $type = strtolower($item['tipe_layanan'] ?? '');

        if ($type === 'kostum') {
            if (str_contains($name, 'graduation')) {
                return '../assets/fotograduation.jpeg';
            }
            if (str_contains($name, 'pahlawan')) {
                return '../assets/fotopahlawan.jpeg';
            }
            if (str_contains($name, 'wedding')) {
                return '../assets/fotokostum6.jpeg.png';
            }
            if (str_contains($name, 'baju adat jawa')) {
                return '../assets/fotokostum4.jpeg';
            }
            if (str_contains($name, 'baju adat sunda')) {
                return '../assets/adatjawa.jpeg';
            }
            if (str_contains($name, 'baju adat bali')) {
                return '../assets/fotokostum5.jpeg';
            }
            if (str_contains($name, 'baju adat madura')) {
                return '../assets/adatmadura.jpeg';
            }
            if (str_contains($name, 'baju adat') || str_contains($name, 'kostum')) {
                return '../assets/fotokostum3.jpeg.jpg';
            }
        }

        if ($type === 'makeup') {
            return '../assets/foto_makeup.jpeg';
        }

        if ($type === 'dekor') {
            return '../assets/foto_dekor.jpeg';
        }

        return '../assets/fotokostum1.jpeg';
    }

    foreach ($cart_items as &$item) {
        if (empty($item['foto'])) {
            $item['foto'] = getCartImagePath($item);
        }
    }
    unset($item);
} catch (Exception $e) {
    $cart_items = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Saya - Yayuk Makeover</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #d07f26;
            --primary-dark: #8a4c18;
            --bg-soft: #fff5e7;
            --card-bg: #ffffff;
            --text-dark: #2b1f15;
            --text-muted: #5e4a37;
            --border-soft: rgba(208, 127, 38, 0.22);
        }

        body {
            background-color: var(--bg-soft);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            padding-top: 100px !important;
            padding-bottom: 140px;
        }

        .page-heading {
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #3a2a1e;
        }

        .section-subtitle {
            color: var(--text-muted);
            margin-top: 6px;
        }

        .cart-header,
        .cart-item {
            width: 100%;
            background: var(--card-bg);
            border-radius: 22px;
            padding: 22px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 20px 48px rgba(0, 0, 0, 0.08);
        }

        .cart-header {
            position: sticky;
            top: 92px;
            z-index: 99;
            border: 1px solid rgba(208, 127, 38, 0.12);
            background: rgba(255,255,255,0.96);
            font-size: 0.95rem;
            font-weight: 700;
            color: #3f2d1f;
        }

        .col-checkbox { width: 5%; display: flex; justify-content: center; align-items: center; }
        .col-produk { width: 35%; display: flex; gap: 18px; align-items: center; }
        .col-include { width: 18%; text-align: center; }
        .col-harga,
        .col-kuantitas,
        .col-total { width: 14%; text-align: center; }
        .col-aksi { width: 10%; text-align: center; }

        .cart-item img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border: 1px solid var(--border-soft);
            border-radius: 18px;
        }

        .item-checkbox {
            transform: scale(1.3);
            cursor: pointer;
            accent-color: var(--primary-color);
        }

        .badge-type {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #fff1d8;
            color: var(--primary-dark);
            font-weight: 700;
            font-size: 0.85rem;
        }

        .qty-input {
            width: 60px;
            height: 44px;
            text-align: center;
            font-size: 1rem;
            font-weight: 700;
            border: 1px solid #e7c59c;
            border-left: none;
            border-right: none;
            background: transparent;
        }

        .btn-qty {
            width: 45px;
            height: 44px;
            border: 1px solid #e7c59c;
            background: var(--card-bg);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: background 0.2s ease;
        }

        .btn-qty:hover {
            background-color: #fff2d8;
            color: var(--primary-dark);
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .item-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: #3a2920;
        }

        .item-subtext {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .checkout-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #fff;
            padding: 18px 0;
            border-top: 1px solid rgba(208, 127, 38, 0.14);
            box-shadow: 0 -14px 30px rgba(0, 0, 0, 0.08);
            z-index: 1000;
        }

        .total-price {
            color: var(--primary-dark);
            font-size: 1.5rem;
            font-weight: 800;
        }

        .btn-checkout {
            background: linear-gradient(135deg, #d07f26, #ae5c16);
            color: white;
            padding: 14px 32px;
            font-weight: 700;
            border-radius: 16px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 16px 32px rgba(208, 127, 38, 0.25);
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 38px rgba(208, 127, 38, 0.3);
        }

        @media (max-width: 991px) {
            .cart-header { display: none; }
            .cart-item { flex-direction: column; align-items: stretch; }
            .col-checkbox,
            .col-include,
            .col-harga,
            .col-kuantitas,
            .col-total,
            .col-aksi { width: 100%; text-align: left; padding-left: 0; }
            .col-produk { width: 100%; }
            .checkout-footer .container { flex-direction: column; gap: 16px; align-items: stretch; }
            .btn-checkout { width: 100%; }
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container-fluid mt-4 px-lg-5">
    <div class="d-flex align-items-center justify-content-between flex-column flex-md-row page-heading">
        <div>
            <h2 class="section-title mb-1">Keranjang Belanja</h2>
            <p class="section-subtitle mb-0">Kelola pesanan Anda sebelum checkout.</p>
        </div>
        <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-chevron-left me-2"></i>Kembali
        </a>
    </div>

    <div class="cart-header d-none d-lg-flex">
        <div class="col-checkbox"><input type="checkbox" id="selectAll" class="item-checkbox" checked onchange="toggleSelectAll(this.checked)"></div>
        <div class="col-produk">Produk</div>
        <div class="col-include">Tipe</div>
        <div class="col-harga">Harga</div>
        <div class="col-kuantitas">Kuantitas</div>
        <div class="col-total">Total</div>
        <div class="col-aksi">Aksi</div>
    </div>

    <div id="cart-items-container"></div>
</div>

<div class="checkout-footer">
    <div class="container d-flex align-items-center justify-content-between flex-column flex-md-row gap-3">
        <div class="d-flex align-items-center gap-3 checkout-actions">
            <input type="checkbox" id="selectAllBottom" class="item-checkbox" checked onchange="toggleSelectAll(this.checked)">
            <span class="fw-semibold">Pilih Semua (<span id="count-selected">0</span>)</span>
            <button class="btn btn-link text-dark text-decoration-none" onclick="removeSelected()">Hapus</button>
        </div>
        <div class="d-flex align-items-center gap-4 justify-content-between checkout-actions w-100 w-md-auto">
            <div class="text-end">
                <span class="text-muted">Total (<span id="item-total">0</span> item)</span><br>
                <span class="total-price" id="total-text">Rp 0</span>
            </div>
            <a href="#" onclick="checkoutSelected(); return false;" class="btn btn-checkout">Checkout Sekarang</a>
        </div>
    </div>
</div>

<script>
let cartData = <?= json_encode($cart_items); ?>;
let selectedItems = new Set(cartData.map((_, index) => index));

function formatRupiah(value) {
    return "Rp " + Number(value).toLocaleString('id-ID');
}

function updateDisplay() {
    const container = document.getElementById('cart-items-container');
    let html = "";

    if (cartData.length === 0) {
        html = `
            <div class="text-center bg-white p-5 rounded">
                <i class="bi bi-cart-x" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Keranjang Kosong</p>
                <a href="service.php" class="btn btn-primary mt-2">Lihat Layanan</a>
            </div>
        `;
        container.innerHTML = html;
        calculateTotal();
        return;
    }

    cartData.forEach((item, index) => {
        const totalHargaItem = Number(item.harga) * Number(item.kuantitas);
        const checked = selectedItems.has(index) ? 'checked' : '';

        html += `
            <div class="cart-item" data-id="${item.id_keranjang}">
                <div class="col-checkbox">
                    <input type="checkbox" class="item-checkbox cart-checkbox" ${checked} onchange="toggleItem(${index}, this.checked)">
                </div>
                <div class="col-produk">
                    <img src="${escapeHtml(item.foto)}" alt="${escapeHtml(item.nama_layanan)}" />
                    <div class="cart-item-details">
                        <div class="item-title">${escapeHtml(item.nama_layanan)}</div>
                        <div class="item-subtext">ID: ${item.id_keranjang}</div>
                    </div>
                </div>

                <div class="col-include">
                    <span class="badge-type">${escapeHtml(item.tipe_layanan)}</span>
                </div>

                <div class="col-harga">${formatRupiah(item.harga)}</div>

                <div class="col-kuantitas">
                    <div class="d-flex justify-content-center justify-content-lg-center align-items-center">
                        <button class="btn-qty" onclick="changeQty(${index}, -1)">-</button>
                        <input type="text" class="qty-input" value="${item.kuantitas}" readonly>
                        <button class="btn-qty" onclick="changeQty(${index}, 1)">+</button>
                    </div>
                </div>

                <div class="col-total">${formatRupiah(totalHargaItem)}</div>

                <div class="col-aksi">
                    <button class="btn btn-link text-danger text-decoration-none fw-bold" onclick="removeItem(${index})">
                        Hapus
                    </button>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
    calculateTotal();
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function calculateTotal() {
    let subtotal = 0;
    let count = 0;

    cartData.forEach((item, index) => {
        if (selectedItems.has(index)) {
            subtotal += Number(item.harga) * Number(item.kuantitas);
            count += 1;
        }
    });

    document.getElementById('item-total').innerText = count;
    document.getElementById('count-selected').innerText = count;
    document.getElementById('total-text').innerText = formatRupiah(subtotal);

    const allSelected = cartData.length > 0 && selectedItems.size === cartData.length;
    document.getElementById('selectAll').checked = allSelected;
    document.getElementById('selectAllBottom').checked = allSelected;
}

function toggleItem(index, checked) {
    if (checked) {
        selectedItems.add(index);
    } else {
        selectedItems.delete(index);
    }
    calculateTotal();
}

function toggleSelectAll(checked) {
    selectedItems = checked ? new Set(cartData.map((_, index) => index)) : new Set();
    updateDisplay();
}

function changeQty(index, amount) {
    const item = cartData[index];
    const nextQty = Number(item.kuantitas) + amount;
    
    if (nextQty > 0) {
        // Send to backend
        const formData = new FormData();
        formData.append('id_keranjang', item.id_keranjang);
        formData.append('kuantitas', nextQty);

        fetch('/project-mua-final/actions/update_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                item.kuantitas = nextQty;
                updateDisplay();
            } else {
                alert('Gagal update kuantitas: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

function removeItem(index) {
    if (confirm('Hapus item ini?')) {
        const item = cartData[index];
        const formData = new FormData();
        formData.append('id_keranjang', item.id_keranjang);

        fetch('/project-mua-final/actions/remove_from_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cartData.splice(index, 1);
                selectedItems = new Set(cartData.map((_, itemIndex) => itemIndex));
                updateDisplay();
                
                // Update navbar cart count
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
            } else {
                alert('Gagal hapus item: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

function removeSelected() {
    if (selectedItems.size === 0) {
        alert('Pilih minimal 1 item');
        return;
    }

    if (confirm('Hapus item terpilih?')) {
        const itemsToRemove = Array.from(selectedItems).sort((a, b) => b - a);
        
        let removeCount = 0;
        let totalToRemove = itemsToRemove.length;

        itemsToRemove.forEach(index => {
            const item = cartData[index];
            const formData = new FormData();
            formData.append('id_keranjang', item.id_keranjang);

            fetch('/project-mua-final/actions/remove_from_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    removeCount++;
                    if (removeCount === totalToRemove) {
                        cartData = cartData.filter((_, i) => !itemsToRemove.includes(i));
                        selectedItems = new Set();
                        updateDisplay();
                        
                        if (typeof updateCartCount === 'function') {
                            updateCartCount();
                        }
                    }
                }
            });
        });
    }
}

function checkoutSelected() {
    const selectedCartItems = Array.from(selectedItems).map(index => {
        const it = cartData[index];
        return {
            nama: it.nama_layanan || it.nama || it.nama_produk || '',
            harga: Number(it.harga) || 0,
            qty: Number(it.kuantitas || it.qty || 1),
            foto: it.foto || it.image || ''
        };
    });

    if (selectedCartItems.length === 0) {
        alert('Pilih minimal 1 item untuk checkout');
        return;
    }

    const formData = new FormData();
    selectedCartItems.forEach(item => {
        formData.append('id_keranjang[]', item.id_keranjang);
    });

    fetch('/project-mua-final/actions/checkout_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'booking.php';
        } else {
            alert('Gagal checkout: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat checkout');
    });
}

// Initialize display
updateDisplay();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
