
<?php
session_start();

/*
|--------------------------------------------------------------------------
| DATA FOTO + NAMA BAJU
|--------------------------------------------------------------------------
*/

$gallery = [
    [
        "foto" => "../assets/fotokostum4.jpeg",
        "judul" => "Adat Jawa",
        "harga" => 6000000
    ],
    [
        "foto" => "../assets/adatjawa.jpeg",
        "judul" => "Adat Sunda",
        "harga" => 6000000
    ],
    [
        "foto" => "../assets/fotokostum5.jpeg",
        "judul" => "Adat Bali",
        "harga" => 6000000
    ],
    [
        "foto" => "../assets/adatmadura.jpeg",
        "judul" => "Adat Madura",
        "harga" => 6000000
    ],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gallery Kostum</title>

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- ICON -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="../assets/css/mua-theme.css">

<style>

body{
    background:#f5f1eb;
    font-family:Arial, Helvetica, sans-serif;
    padding-top:90px;
}

/* =========================================================
   WRAPPER
========================================================= */
.instagram-wrapper{

    max-width:1200px;

    margin:40px auto;

    background:white;

    border-radius:24px;

    overflow:hidden;

    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

/* =========================================================
   IMAGE SIDE
========================================================= */
.image-side{

    background:#f8f5f0;

    min-height:90vh;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:40px;
}

/* CAROUSEL */
.carousel,
.carousel-inner,
.carousel-item{
    width:100%;
}

.slide-content{

    display:flex;
    flex-direction:column;
    align-items:center;
}

/* FOTO */
.carousel-item img{

    width:100%;
    max-width:520px;

    height:650px;

    object-fit:cover;

    border-radius:24px;

    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

/* =========================================================
   BOTTOM INFO
========================================================= */
.info-box{

    width:100%;
    max-width:520px;

    background:white;

    padding:22px;

    border-radius:20px;

    margin-top:20px;

    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.nama-baju{

    font-size:28px;

    font-weight:700;

    color:#5c4033;

    margin-bottom:18px;
}

/* BUTTON */
.action-area{

    display:flex;
    gap:14px;
    position: relative;
    z-index: 10;
}

.btn-cart{

    width:60px;

    height:52px;

    border:none;

    border-radius:14px;

    background:#e8d7c5;

    color:#7a5a40;

    font-size:22px;

    transition:.3s;

    position: relative;

    z-index: 11;
}

.btn-cart:hover{

    background:#d4b99b;
}

.btn-booking{

    flex:1;

    border:none;

    border-radius:14px;

    background:#b5835a;

    color:white;

    font-weight:600;

    font-size:18px;

    transition:.3s;
}

.btn-booking:hover{

    background:#9c6b45;
}

/* CONTROL */
.carousel-control-prev-icon,
.carousel-control-next-icon{

    background-color:rgba(0,0,0,.4);

    border-radius:50%;

    padding:20px;
}

/* RESPONSIVE */
@media(max-width:992px){

    .image-side{
        min-height:auto;
        padding:20px;
    }

    .carousel-item img{

        height:500px;
    }

    .nama-baju{
        font-size:22px;
    }
}

</style>
</head>
<body>
    <?php include 'include/navbar.php'; ?>

<div class="container-fluid px-4 py-4">
    <div class="mb-4">
        <a href="kostum.php" class="btn btn-kembali shadow-sm"> Kembali</a>
    </div>

<div class="container-fluid">

    <div class="instagram-wrapper">

        <div class="row g-0">

            <div class="col-12">

                <div class="image-side">

                    <div id="gallerySlider"
                         class="carousel slide"
                         data-bs-ride="carousel">

                        <!-- INDICATOR -->
                        <div class="carousel-indicators">

                            <?php foreach($gallery as $index => $item): ?>

                                <button
                                    type="button"
                                    data-bs-target="#gallerySlider"
                                    data-bs-slide-to="<?= $index; ?>"
                                    class="<?= $index === 0 ? 'active' : ''; ?>">
                                </button>

                            <?php endforeach; ?>

                        </div>

                        <!-- SLIDE -->
                        <div class="carousel-inner">

                            <?php foreach($gallery as $index => $item): ?>

                                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">

                                    <div class="slide-content">

                                        <!-- FOTO -->
                                        <img src="<?= $item['foto']; ?>"
                                             alt="<?= $item['judul']; ?>">

                                        <!-- BOTTOM WHITE BOX -->
                                        <div class="info-box">

                                            <div class="nama-baju">
                                                <?= $item['judul']; ?>
                                            </div>

                                           <div class="action-area">

    <!-- CART -->
    <button 
        onclick="addToCart('<?= $item['judul']; ?>', 'kostum', <?= $item['harga']; ?>, '<?= $item['foto']; ?>')" 
        class="btn-cart">
        <i class="bi bi-cart3"></i>
    </button>

    <!-- BOOKING -->
    <a href="booking.php?from=kostum&nama=<?= urlencode($item['judul']); ?>&harga=<?= $item['harga']; ?>"
       class="btn btn-booking flex-grow-1 d-flex align-items-center justify-content-center text-decoration-none">

        Booking

    </a>

</div>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                        <!-- PREV -->
                        <button class="carousel-control-prev"
                                type="button"
                                data-bs-target="#gallerySlider"
                                data-bs-slide="prev">

                            <span class="carousel-control-prev-icon"></span>

                        </button>

                        <!-- NEXT -->
                        <button class="carousel-control-next"
                                type="button"
                                data-bs-target="#gallerySlider"
                                data-bs-slide="next">

                            <span class="carousel-control-next-icon"></span>

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>

