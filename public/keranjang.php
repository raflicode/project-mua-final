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
        body {
            background-color: #f5f5f5;
            padding-top: 100px !important;
            padding-bottom: 110px;
        }

        .cart-header,
        .cart-item {
            width: 100%;
            background: white;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        }

        .cart-header {
            position: sticky;
            top: 86px;
            z-index: 99;
            border-bottom: 1px solid #eee;
            font-size: 18px;
            font-weight: 600;
        }

        .col-checkbox {
            width: 5%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .col-produk {
            width: 35%;
            display: flex;
            gap: 15px;
            align-items: center;
            text-align: left;
        }

        .col-include {
            width: 15%;
            position: relative;
            text-align: center;
        }

        .col-harga,
        .col-kuantitas,
        .col-total {
            width: 15%;
            text-align: center;
        }

        .col-total {
            color: #ee4d2d;
            font-weight: bold;
        }

        .col-aksi {
            width: 10%;
            text-align: center;
        }

        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #eee;
            border-radius: 6px;
        }

        .item-checkbox {
            transform: scale(1.4);
            cursor: pointer;
            accent-color: #1943ff;
        }

        .include-popover {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 180px;
            z-index: 100;
            font-size: 14px;
        }

        .qty-input {
            width: 60px;
            height: 42px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border: 1px solid #ddd;
            border-left: none;
            border-right: none;
        }

        .btn-qty {
            width: 42px;
            height: 42px;
            border: 1px solid #ddd;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .btn-qty:hover {
            background-color: #f8f8f8;
            color: #ee4d2d;
        }

        .checkout-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: white;
            padding: 18px 0;
            box-shadow: 0 -5px 10px rgba(0, 0, 0, 0.10);
            z-index: 1000;
        }

        .total-price {
            color: #ee4d2d;
            font-size: 24px;
            font-weight: 600;
        }

        .btn-checkout {
            background-color: #ee4d2d;
            color: white;
            padding: 10px 40px;
            font-weight: bold;
            border-radius: 2px;
        }

        .btn-checkout:hover {
            background-color: #d73211;
            color: white;
        }

        @media (max-width: 991px) {
            .cart-header {
                display: none;
            }

            .btn-checkout {
                font-size: 20px;
            }

            .cart-item {
                align-items: flex-start;
                gap: 12px;
                flex-wrap: wrap;
            }

            .col-checkbox {
                width: 8%;
            }

            .col-produk {
                width: 87%;
            }

            .col-include,
            .col-harga,
            .col-kuantitas,
            .col-total,
            .col-aksi {
                width: 100%;
                text-align: left;
                padding-left: 12%;
            }

            .checkout-footer .container {
                flex-direction: column;
                gap: 14px;
                align-items: stretch !important;
            }

            .checkout-footer .checkout-actions {
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container-fluid mt-4 px-lg-5">
    <a href="<?= htmlspecialchars($backHref, ENT_QUOTES, 'UTF-8'); ?>" class="text-dark fs-3"><i class="bi bi-chevron-left"></i></a>
    <h4 class="fw-bold mb-4">Keranjang Belanja</h4>

    <div class="cart-header d-none d-lg-flex">
        <div class="col-checkbox"><input type="checkbox" id="selectAll" class="item-checkbox" checked onchange="toggleSelectAll(this.checked)"></div>
        <div class="col-produk">Produk</div>
        <div class="col-include">Tipe</div>
        <div class="col-harga">Harga Satuan</div>
        <div class="col-kuantitas">Kuantitas</div>
        <div class="col-total">Total Harga</div>
        <div class="col-aksi">Aksi</div>
    </div>

    <div id="cart-items-container"></div>
</div>

<div class="checkout-footer">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3 checkout-actions">
            <input type="checkbox" id="selectAllBottom" class="item-checkbox" checked onchange="toggleSelectAll(this.checked)">
            <span>Pilih Semua (<span id="count-selected">0</span>)</span>
            <button class="btn btn-link text-danger text-decoration-none" onclick="removeSelected()">Hapus</button>
        </div>
        <div class="d-flex align-items-center gap-4 justify-content-end checkout-actions">
            <div class="text-end">
                <span class="text-muted">Total (<span id="item-total">0</span> produk): </span>
                <span class="total-price" id="total-text">Rp 0</span>
            </div>
            <a href="#" onclick="checkoutSelected()" class="btn btn-checkout">Checkout</a>
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
                    <div style="width: 100px; height: 100px; background: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid #eee;">
                        <i class="bi bi-image" style="font-size: 2rem; color: #ccc;"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-dark">${escapeHtml(item.nama_layanan)}</div>
                        <div class="text-muted small">ID: ${item.id_keranjang}</div>
                    </div>
                </div>

                <div class="col-include">
                    <span class="badge bg-secondary">${escapeHtml(item.tipe_layanan)}</span>
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
    const selectedCartItems = Array.from(selectedItems).map(index => cartData[index]);
    
    if (selectedCartItems.length === 0) {
        alert('Pilih minimal 1 item untuk checkout');
        return;
    }
    
    sessionStorage.setItem('checkout_items', JSON.stringify(selectedCartItems));
    window.location.href = 'booking.php';
}

// Initialize display
updateDisplay();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
