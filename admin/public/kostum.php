<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Kostum - Yayuk Makeover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
* {
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: #efefef;
    color: #222;
}

.page-wrap {
    padding-top: 95px;
    padding-bottom: 80px;
}

.judul h1 {
    font-family: 'Lobster', cursive;
    font-size: 70px;
    color: #b85a00;
    text-shadow: 3px 3px 6px rgba(0,0,0,0.25);
}

.line {
    width: 220px;
    height: 2px;
    background: #b85a00;
    margin: auto;
}

.card-custom {
    height: 100%;
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.12);
    transition: 0.3s;
}

.card-custom:hover {
    transform: translateY(-5px);
}

.img-paket {
    width: 100%;
    height: 260px;
    object-fit: cover;
    border-radius: 14px;
    margin-bottom: 18px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card-custom ul {
    padding-left: 0;
    list-style: none;
}

.card-custom ul li {
    margin-bottom: 8px;
    color: #666;
}

.card-custom ul li::before {
    content: "\2713 ";
    font-weight: 700;
    color: #111;
}

.btn-booking {
    height: 45px;
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
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    border: none;
    flex-shrink: 0;
}

.btn-cart-icon i {
    font-size: 18px;
}

.btn-kembali {
    position: fixed;
    bottom: 20px;
    left: 20px;
    border-radius: 30px;
    padding: 10px 20px;
    z-index: 1000;
}

@media (max-width: 768px) {
    .page-wrap {
        padding-top: 82px;
    }

    .judul h1 {
        font-size: 55px;
    }

    .img-paket {
        height: 220px;
    }
}
</style>
</head>

<body>

<?php include '../../public/include/navbar.php'; ?>

<main class="page-wrap">
    <div class="container">

        <div class="text-center mb-5 judul">
            <h1>Kostum</h1>
            <div class="line mt-2"></div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card card-custom p-3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold mb-4">Kostum Baju Adat</h5>
                        <img src="../../assets/gallery_kostum/kostum_4.jpeg" class="img-paket" alt="Kostum Baju Adat">
                        <p class="fw-semibold">Include :</p>
                        <ul>
                            <li>Baju adat pengantin</li>
                            <li>Aksesoris kepala</li>
                            <li>Kalung dan detail pelengkap</li>
                            <li>Custom fitting</li>
                        </ul>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="../../public/detail_kostum.php?from=kostum&nama=Kostum+Baju+Adat&harga=8000000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                            Lihat lebih banyak
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-custom p-3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold mb-4">Kostum Wedding</h5>
                        <img src="../../assets/gallery_kostum/foto_resepsi.jpeg" class="img-paket" alt="Kostum Wedding">
                        <p class="fw-semibold">Include :</p>
                        <ul>
                            <li>Kostum pengantin utama</li>
                            <li>Selendang dan veil</li>
                            <li>Aksesoris lengkap</li>
                            <li>Elegant design</li>
                        </ul>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="../../public/detailkostum_wedding.php?from=kostum&nama=Kostum+Wedding&harga=4000000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                            Lihat lebih banyak
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-custom p-3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold mb-4">Kostum Graduation</h5>
                        <img src="../../assets/fotograduation.jpeg" class="img-paket" alt="Kostum Graduation">
                        <p class="fw-semibold">Include :</p>
                        <ul>
                            <li>Kebaya graduation</li>
                            <li>Rok atau kain bawahan</li>
                            <li>Aksesoris pendukung</li>
                            <li>Penyesuaian ukuran</li>
                        </ul>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="../../public/detailkostum_graduation.php?from=kostum&nama=Kostum+Graduation&harga=6000000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                           Lihat lebih banyak
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-custom p-3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold mb-4">Kostum Kebaya</h5>
                        <img src="../../assets/gallery_kostum/kostum_5.jpeg" class="img-paket" alt="Kostum Kebaya">
                        <p class="fw-semibold">Include :</p>
                        <ul>
                            <li>Kebaya pilihan</li>
                            <li>Kain bawahan</li>
                            <li>Kostum pahlawan for kids</li>
                            <li>Custom size</li>
                        </ul>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="../../public/detailkostum_pahlawan.php?from=kostum&nama=Kostum+Kebaya&harga=2000000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                           Lihat lebih banyak
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;
document.querySelectorAll('.btn-booking-trigger').forEach(btn => {
    btn.addEventListener('click', function(e) {
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

<a href="data_layanan.php" class="btn btn-danger btn-kembali shadow">
    Kembali
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../../public/include/add_to_cart_script.php'; ?>
</body>
</html>
