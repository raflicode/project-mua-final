<?php
session_start();

// DATA DUMMY PRODUK (biasanya dari database)
$products = [
    1 => ["nama" => "Makeup Graduation", "harga" => 800000, "gambar" => "https://via.placeholder.com/100"],
    2 => ["nama" => "Makeup Natural", "harga" => 450000, "gambar" => "https://via.placeholder.com/100"]
];

// INIT CART
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        1 => 1,
        2 => 1
    ];
}

// TAMBAH / KURANG / HAPUS
if (isset($_GET['action'])) {
    $id = $_GET['id'];

    if ($_GET['action'] == 'plus') {
        $_SESSION['cart'][$id]++;
    } elseif ($_GET['action'] == 'minus') {
        $_SESSION['cart'][$id]--;
        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    } elseif ($_GET['action'] == 'hapus') {
        unset($_SESSION['cart'][$id]);
    }
}

// HITUNG TOTAL
$subtotal = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $subtotal += $products[$id]['harga'] * $qty;
}
$biaya = 10000;
$total = $subtotal + $biaya;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Keranjang Saya</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background-color: #6f8f7a;
}
.card-custom {
    border-radius: 20px;
    padding: 20px;
}
.product-img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 10px;
}
.qty-box {
    background: #eee;
    border-radius: 10px;
    padding: 5px 10px;
}
.btn-checkout {
    background: #5a7fd8;
    color: white;
    border-radius: 10px;
}
</style>
</head>
<body>

<div class="container py-4">
<div class="row justify-content-center">
<div class="col-12 col-md-8 col-lg-5">

<div class="bg-white card-custom shadow">

<!-- Header -->
<div class="d-flex align-items-center mb-3">
    <a href="#" class="me-2 text-dark">&larr;</a>
    <h5 class="m-0">Keranjang Saya</h5>
</div>

<!-- LIST PRODUK -->
<?php foreach ($_SESSION['cart'] as $id => $qty): 
    $p = $products[$id];
?>
<div class="d-flex align-items-center mb-3">
    <img src="<?= $p['gambar'] ?>" class="product-img me-3">

    <div class="flex-grow-1">
        <div class="d-flex justify-content-between">
            <strong><?= $p['nama'] ?></strong>
            <a href="?action=hapus&id=<?= $id ?>" class="text-danger">x</a>
        </div>
        <div>Rp. <?= number_format($p['harga'],0,',','.') ?></div>
    </div>

    <div class="qty-box d-flex align-items-center ms-2">
        <a href="?action=minus&id=<?= $id ?>" class="px-2 text-dark">-</a>
        <span><?= $qty ?></span>
        <a href="?action=plus&id=<?= $id ?>" class="px-2 text-dark">+</a>
    </div>
</div>

<hr>
<?php endforeach; ?>

<!-- RINGKASAN -->
<div class="bg-light p-3 rounded mb-3">
    <div class="d-flex justify-content-between">
        <span>Produk</span>
        <span><?= count($_SESSION['cart']) ?> item</span>
    </div>
    <div class="d-flex justify-content-between">
        <span>Biaya Layanan</span>
        <span>Rp. <?= number_format($biaya,0,',','.') ?></span>
    </div>
    <div class="d-flex justify-content-between">
        <span>Subtotal</span>
        <span>Rp. <?= number_format($subtotal,0,',','.') ?></span>
    </div>
    <div class="d-flex justify-content-between fw-bold">
        <span>Total</span>
        <span>Rp. <?= number_format($total,0,',','.') ?></span>
    </div>
</div>

<!-- BUTTON -->
<a href="checkout.php" class="btn btn-checkout w-100 py-2">
    CHECKOUT
</a>

</div>
</div>
</div>
</div>

</body>
</html>