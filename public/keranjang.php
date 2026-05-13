<?php
session_start();
$backHref = '../index.php';
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
        <div class="col-include">Include</div>
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
let cartData = JSON.parse(localStorage.getItem('yayuk_cart')) || [];
let selectedItems = new Set(cartData.map((_, index) => index));

function formatRupiah(value) {
    return "Rp " + Number(value).toLocaleString('id-ID');
}

function saveCart() {
    localStorage.setItem('yayuk_cart', JSON.stringify(cartData));
    if (typeof updateNavbarBadge === 'function') {
        updateNavbarBadge();
    }
}

function updateDisplay() {
    const container = document.getElementById('cart-items-container');
    let html = "";

    cartData.forEach((item, index) => {
        const totalHargaItem = Number(item.harga) * Number(item.qty);
        const checked = selectedItems.has(index) ? 'checked' : '';

        // Tentukan include berdasarkan nama item
        let includes = [];
        const namaLower = item.nama.toLowerCase();
        if (namaLower.includes('makeup')) {
            includes = ['Makeup', 'Softlens', 'Hairdo'];
        } else if (namaLower.includes('dekor')) {
            includes = ['Dekorasi', 'Lighting', 'Props'];
        } else if (namaLower.includes('kostum')) {
            includes = ['Kostum', 'Aksesoris', 'Makeup'];
        } else {
            includes = ['Makeup', 'Softlens', 'Hairdo'];
        }

        const includeList = includes.map(inc => `<li><i class="fas fa-check text-success me-2"></i>${inc}</li>`).join('');

        html += `
            <div class="cart-item">
                <div class="col-checkbox">
                    <input type="checkbox" class="item-checkbox cart-checkbox" ${checked} onchange="toggleItem(${index}, this.checked)">
                </div>
                <div class="col-produk">
                    <img src="${item.foto}" class="img-thumbnail" alt="${item.nama}">
                    <div>
                        <div class="fw-bold fs-5 text-dark">${item.nama}</div>
                        <div class="text-muted small">${item.desc || ''}</div>
                    </div>
                </div>

                <div class="col-include">
                    <button class="btn btn-sm dropdown-toggle border-0 text-muted fw-medium" type="button" onclick="toggleInclude(${index})">
                        Include
                    </button>
                    <div class="include-popover shadow-sm" id="details-include-${index}" style="display: none;">
                        <ul class="list-unstyled mb-0 p-2 text-start">
                            ${includeList}
                        </ul>
                    </div>
                </div>

                <div class="col-harga">${formatRupiah(item.harga)}</div>

                <div class="col-kuantitas">
                    <div class="d-flex justify-content-center justify-content-lg-center align-items-center">
                        <button class="btn-qty" onclick="changeQty(${index}, -1)">-</button>
                        <input type="text" class="qty-input" value="${item.qty}" readonly>
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

    container.innerHTML = html || "<div class='text-center bg-white p-5 rounded'>Keranjang Kosong</div>";
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    let count = 0;

    cartData.forEach((item, index) => {
        if (selectedItems.has(index)) {
            subtotal += Number(item.harga) * Number(item.qty);
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
    const nextQty = Number(cartData[index].qty) + amount;
    if (nextQty > 0) {
        cartData[index].qty = nextQty;
        saveCart();
        updateDisplay();
    }
}

function removeItem(index) {
    cartData.splice(index, 1);
    selectedItems = new Set(cartData.map((_, itemIndex) => itemIndex));
    saveCart();
    updateDisplay();
}

function removeSelected() {
    cartData = cartData.filter((_, index) => !selectedItems.has(index));
    selectedItems = new Set(cartData.map((_, index) => index));
    saveCart();
    updateDisplay();
}

function toggleInclude(index) {
    const details = document.getElementById(`details-include-${index}`);
    if (!details) return;
    details.style.display = details.style.display === "none" ? "block" : "none";
}

function checkoutSelected() {
    const selectedCartItems = cartData.filter((_, index) => selectedItems.has(index));
    if (selectedCartItems.length === 0) {
        alert('Pilih minimal 1 item untuk checkout');
        return;
    }
    
    sessionStorage.setItem('checkout_items', JSON.stringify(selectedCartItems));
    window.location.href = 'booking.php';
}

function toggleInclude(index) {
    const details = document.getElementById(`details-include-${index}`);
    if (!details) return;
    details.style.display = details.style.display === "none" ? "block" : "none";
}

updateDisplay();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
