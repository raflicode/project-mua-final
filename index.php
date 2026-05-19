<?php
include __DIR__ . '/actions/proses_index.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Eternal Beauty</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins',sans-serif;
            color:#4a4a4a;
            background-color:#f7f2eb;
        }

        h1,
        h2,
        h3,
        .serif{
            font-family:'Playfair Display',serif;
        }

        /* =====================================================
           HERO SECTION
        ===================================================== */
        .hero-section{

            background:
            linear-gradient(
            rgba(0,0,0,.35),
            rgba(0,0,0,.35)
            ),
            url('assets/foto_muayayuk.jpeg');

            background-size:cover;
            background-position:center;

            height:80vh;

            display:flex;
            align-items:center;
            justify-content:center;

            color:white;
            text-align:center;

            border-radius:24px;

            margin:
            0 15px;

            overflow:hidden;
        }

        .hero-title{
            max-width:720px;

            margin:
            0 auto 16px;

            font-size:
            clamp(2rem,4vw,3rem);

            line-height:1.18;
            color:#b5835a;
        }

        .hero-subtitle{
            max-width:650px;

            margin:
            0 auto 24px;

            font-size:
            clamp(.92rem,1.6vw,1.08rem);

            line-height:1.65;
        }

        .btn-booking{

            border:2px solid #b5835a;

            color:white;

            padding:10px 32px;

            border-radius:999px;

            text-transform:uppercase;

            font-size:.86rem;

            letter-spacing:.04em;

            background:linear-gradient(135deg,#a58459,#7b5d3f);

            transition:.3s;
        }

        .btn-booking:hover{

            background:#7b5d3f;
            color:#fff;
        }

        /* =====================================================
           ABOUT
        ===================================================== */
        .custom-shape{

            border-radius:
            150px 0px 150px 0px;

            object-fit:cover;

            border:10px solid #f8f9fa;
        }

        .section-title{
            color:#b5835a;
        }

        .animated-divider{

            width:450px;
            height:4px;

            margin:0;

            border-radius:999px;

            background:
            linear-gradient(
            90deg,
            #b5835a,
            #FED03A
            );

            transform:scaleX(0);
            transform-origin:left;

            opacity:0;

            transition:
            transform 1s ease,
            opacity .4s ease;
        }

        .animated-divider.is-visible{
            transform:scaleX(1);
            opacity:1;
        }

        /* =====================================================
           WHY CHOOSE US
        ===================================================== */
        .soft-section{
            background-color:#f1e8dd !important;
        }

        /* =====================================================
           GALLERY CARD
        ===================================================== */
        .gallery-card{

            border:none;

            border-radius:22px;

            overflow:hidden;

            transition:.35s ease;

            background:#fff;
        }

        .gallery-card:hover{

            transform:
            translateY(-10px);

            box-shadow:
            0 18px 40px rgba(0,0,0,.12);
        }

        .gallery-img{

            height:400px;

            object-fit:cover;

            transition:.4s ease;
        }

        .gallery-card:hover .gallery-img{
            transform:scale(1.05);
        }

        .gallery-btn{

            border-radius:999px;

            padding:8px 26px;

            font-size:.82rem;

            border:1px solid #b5835a;

            color:#b5835a;

            background:transparent;

            transition:.3s;
        }

        .gallery-btn:hover{

            background:#b5835a;
            color:#fff;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */
        @media(max-width:768px){

            .hero-section{

                height:72vh;

                border-radius:20px;

                margin:0 10px;
            }

            .hero-title{
                font-size:2rem;
            }

            .hero-subtitle{
                font-size:.92rem;
                padding:0 14px;
            }

            .animated-divider{
                width:180px;
            }

            .gallery-img{
                height:300px;
            }

            .custom-shape{

                border-radius:
                80px 0 80px 0;
            }
        }

    </style>
</head>

<body>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['success'])): ?>

<script>

    Swal.fire({
        icon:'success',
        title:'Berhasil!',
        text:'<?php echo htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8'); ?>',
        timer:2000,
        showConfirmButton:false
    });

    if(window.history.replaceState){
        window.history.replaceState({}, document.title, window.location.pathname);
    }

</script>

<?php endif; ?>

<!-- NAVBAR -->
<?php include __DIR__ . '/public/include/navbar.php'; ?>

<!-- HERO -->
<header class="hero-section shadow" style="margin-top:60px;">

    <div class="container">

        <h1 class="hero-title fw-bold">
            Keanggunan Abadi untuk Hari Istimewa Anda.
        </h1>

        <p class="hero-subtitle">

            Riasan dan penataan rambut pengantin profesional
            dengan hasil akhir yang sempurna dan alami untuk
            menonjolkan kecantikan sejati Anda.

        </p>

        <a href="/project-mua-final/public/service.php"
           class="btn btn-booking">

            Booking

        </a>

    </div>

</header>

<!-- ABOUT -->
<section class="py-5 container">

    <div class="row align-items-center g-5">

        <div class="col-lg-7">

            <h2 class="section-title h1 mb-4">

                Merajut Kenangan <br>
                dalam Setiap Sentuhan

            </h2>

            <div class="animated-divider"></div>

            <p class="mt-4">

                Perjalanan Yayuk Makeover tumbuh bersama ribuan
                senyum dan cerita bahagia dari para pasangan
                yang telah menjadi bagian dari keluarga kami.

            </p>

            <p>

                Kami memahami bahwa pernikahan adalah momen
                sekali seumur hidup yang penuh dengan detail
                dan harapan.

            </p>

            <p>

                Melalui diskusi yang mendalam dan sentuhan
                profesional, kita akan merajut sebuah kisah
                kecantikan yang terasa hangat di jiwa.

            </p>

        </div>

        <div class="col-lg-5 text-center">

            <img src="assets/foto_profile.jpeg"
                 class="img-fluid custom-shape shadow-lg"
                 alt="Yayuk">

        </div>

    </div>

</section>

<!-- WHY CHOOSE US -->
<section class="soft-section py-5">

    <div class="container text-center p-5 rounded-4"
         style="background-color:#A58459;color:white;">

        <h3 class="fw-bold mb-5">
            MENGAPA MEMILIH KAMI?
        </h3>

        <div class="row g-4">

            <div class="col-md-4">

                <i class="bi bi-stars fs-1 mb-3"></i>

                <h5 class="fw-bold">
                    TIM AHLI & BERPENGALAMAN
                </h5>

                <p class="small">

                    Didukung oleh MUA profesional yang
                    berdedikasi menciptakan tampilan impian Anda.

                </p>

            </div>

            <div class="col-md-4">

                <i class="bi bi-brush fs-1 mb-3"></i>

                <h5 class="fw-bold">
                    PRODUK PREMIUM
                </h5>

                <p class="small">

                    Menggunakan produk makeup asli &
                    berkualitas tinggi untuk hasil flawless.

                </p>

            </div>

            <div class="col-md-4">

                <i class="bi bi-person-check fs-1 mb-3"></i>

                <h5 class="fw-bold">
                    PERSONALISASI
                </h5>

                <p class="small">

                    Konsultasi mendalam untuk menciptakan
                    riasan sesuai karakter Anda.

                </p>

            </div>

        </div>

    </div>

</section>

<!-- GALLERY -->
<section id="gallery" class="py-5 container text-center">

    <h2 class="section-title h1">

        Mengabadikan Keindahan
        di Setiap Momen Berharga

    </h2>

    <p class="text-muted mb-5">

        Karena setiap detail hari pernikahan Anda
        adalah kisah yang akan selalu dikenang.

    </p>

    <div class="row g-4">

        <!-- MAKEUP -->
        <div class="col-md-4">

            <div class="card gallery-card shadow-sm">

                <img src="assets/foto_makeup.jpeg"
                     class="card-img-top gallery-img"
                     alt="Gallery Makeup">

                <div class="card-body">

                    <h6 class="fw-bold">
                        Gallery Makeup
                    </h6>

                    <a href="public/gallery_makeup.php"
                       class="btn gallery-btn">

                        LIHAT

                    </a>

                </div>

            </div>

        </div>

        <!-- DEKOR -->
        <div class="col-md-4">

            <div class="card gallery-card shadow-sm">

                <img src="assets/foto_dekor.jpeg"
                     class="card-img-top gallery-img"
                     alt="Gallery Dekor">

                <div class="card-body">

                    <h6 class="fw-bold">
                        Gallery Dekor
                    </h6>

                    <a href="public/gallery_dekor.php"
                       class="btn gallery-btn">

                        LIHAT

                    </a>

                </div>

            </div>

        </div>

        <!-- KOSTUM -->
<div class="col-md-4">

    <div class="card gallery-card shadow-sm">

        <img src="assets/fotokostum1.jpeg"
             class="card-img-top gallery-img"
             alt="Gallery Kostum">

        <div class="card-body">

            <h6 class="fw-bold">
                Gallery Kostum
            </h6>

            <a href="public/gallery_kostum.php"
               class="btn gallery-btn">

                LIHAT

            </a>

        </div>

    </div>

</div>

</section>

<!-- FOOTER -->
<?php include 'public/include/footer.php'; ?>

<!-- SCRIPT -->
<script>

document.addEventListener('DOMContentLoaded', function(){

    const divider =
    document.querySelector('.animated-divider');

    if(!divider) return;

    const observer =
    new IntersectionObserver(function(entries){

        entries.forEach(function(entry){

            divider.classList.toggle(
                'is-visible',
                entry.isIntersecting
            );

        });

    }, { threshold:.45 });

    observer.observe(divider);

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>