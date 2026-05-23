<?php
header('Location: service.php?kategori=makeup');
exit;

session_start();

$makeupPackages = [
    ['name' => 'Makeup Graduation', 'price' => 800000, 'image' => '../assets/fotomakeup_1.jpeg', 'includes' => ['Makeup wisuda', 'Softlens', 'Hairdo natural']],
    ['name' => 'Makeup Wedding', 'price' => 1500000, 'image' => '../assets/fotomakeup_2.jpeg', 'includes' => ['Makeup bridal', 'Softlens', 'Hairdo wedding', 'Retouch']],
    ['name' => 'Makeup Carnaval', 'price' => 1000000, 'image' => '../assets/fotomakeup_3.jpeg', 'includes' => ['Makeup karakter', 'Glitter detail', 'Hairdo kreatif']],
    ['name' => 'Makeup Natural', 'price' => 600000, 'image' => '../assets/fotomakeup_4.jpeg', 'includes' => ['Makeup soft natural', 'Softlens', 'Simple hairdo']],
    ['name' => 'Makeup Engagement', 'price' => 900000, 'image' => '../assets/fotomakeup_5.jpeg', 'includes' => ['Makeup lamaran', 'Softlens', 'Hairdo elegan']],
    ['name' => 'Makeup Party', 'price' => 700000, 'image' => '../assets/fotomakeup_6.png', 'includes' => ['Makeup pesta', 'Bulu mata', 'Hair styling']],
    ['name' => 'Makeup Bridesmaid', 'price' => 650000, 'image' => '../assets/fotomakeup_7.png', 'includes' => ['Makeup bridesmaid', 'Softlens', 'Hairdo simple']],
    ['name' => 'Makeup Photoshoot', 'price' => 750000, 'image' => '../assets/fotomakeup_8.png', 'includes' => ['Makeup camera ready', 'Touch up', 'Hair styling']],
    ['name' => 'Makeup Prewedding', 'price' => 1200000, 'image' => '../assets/fotomakeup_9.png', 'includes' => ['Makeup prewedding', 'Softlens', 'Hairdo', 'Retouch']],
];
?>

<?php
// halaman_kostum.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Makeup - Yayuk Makeover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{
    font-family:'Poppins', sans-serif;
    background:#efefef;
}

/* Judul */
.judul h1{
    font-family:'Lobster', cursive;
    font-size:70px;
    color:#b85a00;
    text-shadow:3px 3px 6px rgba(0,0,0,0.25);
}

.line{
    width:220px;
    height:2px;
    background:#b85a00;
    margin:auto;
}


/* Card */
.card-custom{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.12);
    transition:0.3s;
}

.card-custom:hover{
    transform:translateY(-5px);
}

.card-custom ul{
    padding-left:0;
    list-style:none;
}

.card-custom ul li{
    margin-bottom:8px;
    color:#666;
}

.card-custom ul li::before{
    content:"✓ ";
    font-weight:bold;
    color:black;
}

.btn-booking {
    height: 45px; /* Samakan tinggi dengan tombol keranjang */
    border-radius: 30px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.btn-cart-icon {
    width: 45px;
    height: 45px;
    background-color: #212529;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    border: none;
    flex-shrink: 0; /* Agar tidak tertekan/gepeng */
}

.btn-cart-icon i {
    font-size: 18px; /* Ukuran besar kecilnya logo keranjang */
} 

/* Styling Gambar Paket */
.img-paket {
    width: 100%;
    height: 200px; /* Tinggi tetap agar card sejajar */
    object-fit: cover; /* Memotong gambar secara proporsional agar memenuhi area */
    border-radius: 12px;
    margin-bottom: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Tombol kembali */
.btn-kembali{
    position:fixed;
    bottom:20px;
    left:20px;
    border-radius:30px;
    padding:10px 20px;
}

/* ======================================================
   RESPONSIVE MOBILE
====================================================== */

@media (max-width:576px){

    .mobile-wrapper{
        width:100%;
        min-height:100vh;
    }

    /* NAVBAR */
    .topbar{
        padding:16px 16px;
    }

    .brand{
        font-size:.85rem;
    }

    .icon-btn{
        width:40px;
        height:40px;
    }

    .icon-btn i{
        font-size:1.2rem;
    }

    /* HERO */
    .hero{
        padding:10px 18px 24px;
    }

    .hero-title{
        font-size:3.9rem;
    }

    .hero-sub{
        font-size:.72rem;
        letter-spacing:3px;
    }

    .hero-line{
        width:120px;
        margin:10px 0 14px;
    }

    .hero-desc{
        font-size:.82rem;
        max-width:150px;
        line-height:1.5;
    }

    .hero-image{
        width:250px;
        right:-70px;
        top:10px;
    }

    /* CARD GRID */
    .card-grid{
        padding:0 14px 24px;
        gap:14px;
    }

    .service-card{
        padding:10px;
        border-radius:20px;
    }

    .service-title{
        font-size:.72rem;
        margin-bottom:8px;
    }

    .service-image{
        height:78px;
        border-radius:12px;
        margin-bottom:10px;
    }

    .include-title{
        font-size:.72rem;
    }

    .include-list li{
        font-size:.65rem;
        margin-bottom:3px;
    }

    .card-bottom{
        gap:6px;
    }

    .cart-btn{
        width:32px;
        height:32px;
        border-radius:8px;
    }

    .booking-btn{
        height:32px;
        font-size:.68rem;
        border-radius:8px;
    }
}

/* ======================================================
   TABLET
====================================================== */

@media (min-width:577px) and (max-width:991px){

    .mobile-wrapper{
        max-width:650px;
    }

    .hero{
        padding:18px 26px 28px;
    }

    .hero-title{
        font-size:5rem;
    }

    .hero-image{
        width:340px;
        right:-70px;
    }

    .hero-desc{
        max-width:220px;
    }

    .card-grid{
        gap:18px;
    }

    .service-image{
        height:110px;
    }
}

/* ======================================================
   DESKTOP
====================================================== */

@media (min-width:992px){

    body{
        padding:30px;
    }

    .mobile-wrapper{
        max-width:1200px;
        border-radius:30px;
        overflow:hidden;
        box-shadow:
        0 20px 60px rgba(0,0,0,.12);
    }

    .topbar{
        padding:24px 34px;
    }

    .brand{
        font-size:1.1rem;
    }

    .hero{
        padding:10px 40px 10px;
        min-height:360px;
    }

    .hero-title{
        font-size:7rem;
    }

    .hero-sub{
        font-size:.95rem;
    }

    .hero-line{
        width:220px;
    }

    .hero-desc{
        font-size:1.05rem;
        max-width:280px;
    }

    .hero-image{
        width:500px;
        right:0;
        top:-20px;
    }

    .card-grid{
        grid-template-columns:
        repeat(4,1fr);

        padding:0 34px 40px;

        gap:24px;
    }

    .service-card{
        border-radius:28px;
        padding:16px;
    }

    .service-title{
        font-size:1rem;
    }

    .service-image{
        height:150px;
    }

    .include-title{
        font-size:.9rem;
    }

    .include-list li{
        font-size:.8rem;
    }

    .booking-btn{
        height:40px;
    }

    .cart-btn{
        width:40px;
        height:40px;
    }
}
</style>
</head>

<body>

<!-- Navbar Include -->
<?php include 'include/navbar.php'; ?>

<div class="container py-5">

    <!-- Judul -->
    <div class="text-center mb-5 judul">
        <h1>Makeup</h1>
        <div class="line mt-2"></div>
    </div>

    <!-- Card Produk -->
    <div class="row g-4">
        <?php foreach ($makeupPackages as $package): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom h-100 p-3">
                    <div class="card-body">
                        <h5 class="mb-3"><?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <img src="<?= htmlspecialchars($package['image'], ENT_QUOTES, 'UTF-8'); ?>" class="img-paket" alt="<?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?>">
                        <p class="fw-semibold">Include :</p>
                        <ul>
                            <?php foreach ($package['includes'] as $include): ?>
                                <li><?= htmlspecialchars($include, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="d-flex gap-2 mt-auto">
                        <button onclick="addToCart('<?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?>', 'makeup', <?= intval($package['price']); ?>, '<?= htmlspecialchars($package['image'], ENT_QUOTES, 'UTF-8'); ?>')" class="btn-cart-icon">
                            <i class="bi bi-cart3"></i>
                        </button>
                        <a href="booking.php?from=makeup&nama=<?= urlencode($package['name']); ?>&harga=<?= intval($package['price']); ?>" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                            Booking
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="d-none">

        <!-- Card 1 -->
        <div class="row g-4">

    <div class="col-md-6">
        <div class="card card-custom h-100 p-3">
            <div class="card-body">
                <h5 class="mb-3">Makeup Graduation</h5>
                <img src="../assets/foto_makeup.jpeg" class="img-paket" alt="Makeup Graduation">
                
                <p class="fw-semibold">Include :</p>
                <ul>
                    <li>Makeup</li>
                    <li>Softlens</li>
                    <li>Hairdo</li>
                </ul>
            </div>
            <div class="d-flex gap-2 mt-auto">
                    <button onclick="addToCart('Makeup Graduation', 'makeup', 800000, '../assets/foto_makeup.jpeg')" class="btn-cart-icon">
                    🛒
                    </button>
                    <a href="booking.php?from=makeup&nama=Makeup+Graduation&harga=800000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                    Booking
                </a>
            </div>
        </div>
    </div>

        <!-- Card 2 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Makeup Wedding</h5>
                    <img src="../assets/foto_makeup.jpeg" class="img-paket" alt="Makeup Graduation">
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                        <li>Teks 3</li>
                        <li>Teks 4</li>
                    </ul>
                </div>
                <div class="d-flex gap-2 mt-auto">
                    <button onclick="addToCart('Makeup Wedding', 'makeup', 1500000, '../assets/foto_makeup.jpeg')" class="btn-cart-icon">
                    🛒
                    </button>
                    <a href="booking.php?from=makeup&nama=Makeup+Wedding&harga=1500000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                        Booking
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Makeup Carnaval</h5>
                    <img src="../assets/foto_makeup.jpeg" class="img-paket" alt="Makeup Graduation">
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                        <li>Teks 3</li>
                        <li>Teks 4</li>
                    </ul>
                </div>
                <div class="d-flex gap-2 mt-auto">
                    <button onclick="addToCart('Makeup Carnava', 'makeup', 1000000, '../assets/foto_makeup.jpeg')" class="btn-cart-icon">
                    🛒
                    </button>
                    <a href="booking.php?from=makeup&nama=Makeup+Carnaval&harga=1000000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                        Booking
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Makeup Natural</h5>
                    <img src="../assets/foto_makeup.jpeg" class="img-paket" alt="Makeup Graduation">
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Teks 5</li>
                        <li>Teks 6</li>
                        <li>Teks 7</li>
                        <li>Teks 8</li>
                    </ul>
                </div>
                <div class="d-flex gap-2 mt-auto">
                    <button onclick="addToCart('Makeup Natural', 'makeup', 2000000, '../assets/foto_makeup.jpeg')" class="btn-cart-icon">
                    🛒
                    </button>
                    <a href="booking.php?from=makeup&nama=Makeup+Natural&harga=2000000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                        Booking
                    </a>
                </div>
            </div>
        </div>

    </div>
    </div>

</div>

<script>
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;
document.querySelectorAll('.btn-booking-trigger').forEach(btn => {
    btn.addEventListener('click', function(e){
        if (!isLoggedIn) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Login diperlukan',
                text: 'Silakan login atau register terlebih dahulu sebelum melakukan booking.',
                showCancelButton: true,
                confirmButtonText: 'Login',
                cancelButtonText: 'Register',
                reverseButtons: true,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = 'register.php';
                }
            });
        }
    });
});
</script>

<!-- Tombol Kembali -->
<a href="service.php" class="btn btn-danger btn-kembali shadow">
    kembali 
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>
