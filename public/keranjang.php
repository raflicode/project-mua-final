<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Saya - Yayuk Makeover</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
    body { background-color: #f5f5f5; }
    
    .cart-header {
        position: sticky;
        top: 100px; /* Jarak dari atas (sesuaikan dengan tinggi navbar putihmu) */
        background-color: #ffffff; /* Supaya pas di-scroll, tulisan di bawahnya tidak kelihatan */
        z-index: 99; /* Agar tetap di atas produk saat bergulir */
        border-bottom: 1px solid #eee;
        display: flex; /* Memastikan kolom sejajar horizontal */
        padding: 15px 0;
        font-size: 20px;
    }

 

    /* Footer ala Shopee */
    .checkout-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        padding: 15px 0;
        box-shadow: 0 -5px 10px rgba(0,0,0,0.10);
        z-index: 1000;
    }

    .total-price {
        color: #ee4d2d;
        font-size: 24px;
        font-weight: 500;
    }

    .btn-checkout {
        background-color: #ee4d2d;
        color: white;
        padding: 10px 40px;
        font-weight: bold;
        border-radius: 2px;
    }

    .btn-checkout:hover { background-color: #d73211; color: white; }

    /* Style Input Quantity */
    .qty-input {
        width: 40px;
        text-align: center;
        border: 1px solid #ddd;
        border-left: none;
        border-right: none;
    }
    .btn-qty {
        border: 1px solid #ddd;
        background: white;
        width: 30px;
    }

    <style>
    /* Membuat background abu-abu khas Shopee memenuhi layar */
    body { 
        background-color: #f5f5f5; 
    }

    /* Header dan Item dibuat Full Width */
    .cart-header, .cart-item {
        width: 100%;
        background: white;
        padding: 20px;
        border-radius: 4px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        box-shadow: 0 1px 1px rgba(0,0,0,0.05);
    }

    /* Sesuaikan proporsi kolom agar lebih proporsional saat lebar */
    .col-checkbox { width: 5%; text-align: center; }
    .col-produk { width: 45%; display: flex; gap: 20px; align-items: center; }
    .col-harga { width: 15%; text-align: center; }
    .col-kuantitas { width: 15%; text-align: center; }
    .col-total { width: 15%; text-align: center; color: #ee4d2d; font-weight: bold; }
    .col-aksi { width: 5%; text-align: center; }

    /* Ukuran gambar diperbesar sedikit agar tidak kebanting dengan layar lebar */
    .cart-item img { 
        width: 100px; 
        height: 100px; 
        object-fit: cover; 
        border: 1px solid #eee;
    }

    /* Footer checkout dibuat lebih rapi untuk layar lebar */
    .checkout-footer {
        padding: 20px 0;
    }

    /* Pengaturan lebar kolom agar sejajar rata */
    .col-checkbox { width: 10%; }
    .col-produk   { width: 20%; display: flex; align-items: center; gap: 15px; text-align: left; }
    .col-include  { width: 15%; position: relative; text-align: center; } /* Kolom Baru */
    .col-harga    { width: 15%; text-align: center; }
    .col-kuantitas{ width: 15%; text-align: center; }
    .col-total    { width: 15%; text-align: center; color: #ee4d2d; font-weight: bold; }
    .col-aksi     { width: 10%;  text-align: center; }

    /* Styling Popover Include agar melayang di atas */
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
        font-size: 20px;
    }

    .dropdown-toggle::after {
        color: #888;
        vertical-align: middle;
    }

    /* Mengatur ukuran kotak centang */
    .item-checkbox {
        transform: scale(1.6); /* Ubah angka 1.5 jika ingin lebih besar lagi */
        cursor: pointer;
        margin-right: 10px; /* Jarak tambahan ke gambar/teks */
    }

    /* Opsional: Mengubah warna centang saat aktif (aksen Shopee) */
    .item-checkbox:checked {
        accent-color: #1943ff;
    }

    /* Menyesuaikan posisi kolom checkbox agar tetap di tengah */
    .col-checkbox {
        width: 5%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    <style>
    /* Memperbesar Nama Produk */
    .col-produk .fw-bold {
        font-size: 20px !important; /* Ubah angka ini sesuai selera */
    }

    /* Memperbesar Teks Harga Satuan & Total */
    .col-harga, .col-total {
        font-size: 20px;
    }

    /* Memperbesar teks tombol Checkout */
    .btn-checkout {
        font-size: 20px;
    }

    /* Menargetkan teks di dalam kolom include */
    .col-include .btn {
        font-size: 1.2rem !important; /* Ukuran teks lebih besar */
        font-weight: 600; /* Membuat tulisan sedikit lebih tebal */
        color: #444 !important; /* Warna sedikit lebih gelap agar jelas */
    }

    /* Memperbesar icon segitiga (caret) agar mengikuti ukuran teks */
    .col-include .dropdown-toggle::after {
        border-top-width: 0.4em;
        border-right-width: 0.4em;
        border-left-width: 0.4em;
        vertical-align: middle;
    }

    /* Mengatur lebar dan tinggi tombol serta input kuantitas */
    .btn-qty {
        width: 45px !important; /* Diperbesar dari standar */
        height: 45px !important;
        font-size: 45px !important; /* Memperbesar simbol + dan - */
        display: flex;
        align-items: center;
        justify-content: center;
        padding-bottom: 10px;
        border: 1px solid #ddd;
        background: white;
    }

    .qty-input {
        width: 60px !important; /* Diperbesar agar angka jelas */
        height: 45px !important;
        text-align: center;
        font-size: 18px !important; /* Memperbesar angka kuantitas */
        font-weight: bold;
        border: 1px solid #ddd;
        border-left: none;
        border-right: none;
    }

    /* Memberikan efek hover agar lebih interaktif */
    .btn-qty:hover {
        background-color: #f8f8f8;
        color: #ee4d2d;
    }

    /* Menargetkan tombol hapus di dalam kolom aksi */
    .col-aksi .btn {
        font-size: 1.2rem !important; /* Sesuaikan angka ini untuk ukuran teks */
        font-weight: 600; /* Membuat tulisan lebih tebal agar jelas */
        transition: color 0.2s;
    }

    /* Memberikan efek saat kursor diarahkan ke tulisan Hapus */
    .col-aksi .btn:hover {
        color: #b22222 !important; /* Warna merah yang lebih gelap saat hover */
        text-decoration: underline !important;
    }
</style>
</style>
</style>
</style>
</style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container-fluid mt-5 pt-5 px-lg-5"> 
    <h4 class="fw-bold mb-4">Keranjang Belanja</h4>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="cart-header d-none d-lg-flex"> 
                <div class="col-checkbox"><input type="checkbox" id="selectAll" class="item-checkbox" checked onchange="calculateTotal()"></div>
                <div class="col-produk">Produk</div>
                <div class="col-include">Include</div>
                <div class="col-harga">Harga Satuan</div>
                <div class="col-kuantitas">Kuantitas</div>
                <div class="col-total">Total Harga</div>
                <div class="col-aksi">Aksi</div>
            </div>

            <div id="cart-items-container"></div>
        </div>
    </div>
</div>

<div class="checkout-footer">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3" >
            <input type="checkbox" id="selectAllBottom" class="item-checkbox" checked onchange="calculateTotal()">
            <span>Pilih Semua (<span id="count-selected" >0</span>)</span>
            <button class="btn btn-link text-danger text-decoration-none">Hapus</button>
        </div>
        <div class="d-flex align-items-center gap-4">
            <div class="text-end">
                <span class="text-muted">Total (<span id="item-total">0</span> produk): </span>
                <span class="total-price" id="total-text">Rp 0</span>
            </div>
            <button class="btn btn-checkout">Checkout</button>
        </div>
    </div>
</div>

<script>
    // Ambil data yang dikirim dari halaman produk tadi
    let cartData = JSON.parse(localStorage.getItem('yayuk_cart')) || [];

    function updateDisplay() {
        const container = document.getElementById('cart-items-container');
        container.innerHTML = '';
        let subtotal = 0;

        if (cartData.length === 0) {
            container.innerHTML = '<div class="text-center py-5"><h5>Keranjang kosong</h5></div>';
        }

        cartData.forEach((item, index) => {
            subtotal += item.harga * item.qty;
            container.innerHTML += `
                <div class="cart-item">
                    <img src="${item.foto}" alt="${item.nama}">
                    <div class="item-details flex-grow-1">
                        <h5>${item.nama}</h5>
                        <div class="item-price">Rp. ${item.harga.toLocaleString('id-ID')}</div>
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        <div class="qty-wrapper">
                            <button class="btn-qty" onclick="changeQty(${index}, -1)">-</button>
                            <input type="text" class="qty-input" value="${item.qty}" readonly>
                            <button class="btn-qty" onclick="changeQty(${index}, 1)">+</button>
                        </div>
                        <i class="fas fa-trash-alt text-danger" style="cursor:pointer" onclick="removeItem(${index})"></i>
                    </div>
                </div>`;
        });

        document.getElementById('subtotal-text').innerText = 'Rp. ' + subtotal.toLocaleString('id-ID');
        document.getElementById('total-text').innerText = 'Rp. ' + (subtotal + 10000).toLocaleString('id-ID');
    }

    function changeQty(index, amount) {
        if (cartData[index].qty + amount > 0) {
            cartData[index].qty += amount;
            localStorage.setItem('yayuk_cart', JSON.stringify(cartData)); // Simpan perubahan
            updateDisplay();
        }
    }

    function removeItem(index) {
        cartData.splice(index, 1);
        localStorage.setItem('yayuk_cart', JSON.stringify(cartData)); // Simpan perubahan
        updateDisplay();
    }

    updateDisplay();

    function updateDisplay() {
    const container = document.getElementById('cart-items-container');
    let cartData = JSON.parse(localStorage.getItem('yayuk_cart')) || [];
    let html = "";
    let subtotal = 0;

    cartData.forEach((item, index) => {
    let totalHargaItem = item.harga * item.qty;
    subtotal += totalHargaItem;
    
    html += ` 

    <div class="cart-item">
        <div class="col-checkbox">
        <input type="checkbox" class="item-checkbox" checked onchange="calculateTotal()"></div>
        <div class="col-produk">
            <img src="${item.foto}" class="img-thumbnail me-3"> 
            <div>
                <div class="fw-bold fs-4 text-dark">${item.nama}</div>
            </div>
        </div>

            <div class="col-include">
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle border-0 text-muted fs-5 fw-medium" 
        type="button" 
        onclick="toggleInclude(${index})">
    Include
</button>
                    <div class="include-popover shadow-sm" id="details-include-${index}" style="display: none;">
                        <ul class="list-unstyled mb-0 p-2 text-start">
                            <li><i class="fas fa-check text-success me-2"></i> Foundation</li>
                            <li><i class="fas fa-check text-success me-2"></i> Bulu Mata</li>
                            <li><i class="fas fa-check text-success me-2"></i> Hairdo/Hijab</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-harga">Rp ${item.harga.toLocaleString('id-ID')}</div>
            
            <div class="col-kuantitas">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn-qty" onclick="changeQty(${index}, -1)">-</button>
                
                <input type="text" class="qty-input" value="${item.qty}" readonly>
                
                <button class="btn-qty" onclick="changeQty(${index}, 1)">+</button>
            </div>
        </div>

            <div class="col-total">Rp ${totalHargaItem.toLocaleString('id-ID')}</div>
            
            <div class="col-aksi">
        <button class="btn btn-link text-danger text-decoration-none fs-5 fw-bold" 
                onclick="removeItem(${index})">
            Hapus
        </button>
    </div>
        </div>
    `;
});

    container.innerHTML = html || "<div class='text-center p-5 white-bg'>Keranjang Kosong</div>";
    
    // Update angka di footer melayang
    document.getElementById('item-total').innerText = cartData.length;
    document.getElementById('count-selected').innerText = cartData.length;
    document.getElementById('total-text').innerText = "Rp " + subtotal.toLocaleString('id-ID');
}

function toggleInclude(index) {
    const details = document.getElementById(`details-include-${index}`);
    const icon = document.getElementById(`icon-include-${index}`);
    
    if (details.style.display === "none") {
        details.style.display = "block";
        icon.classList.add('icon-rotate');
    } else {
        details.style.display = "none";
        icon.classList.remove('icon-rotate');
    }
}
</script>
