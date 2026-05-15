<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Dekor - Yayuk Makeover</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins',sans-serif;

            background:
            linear-gradient(
            135deg,
            #f8f8f8,
            #ececec
            );

            color:#222;
        }

        a{
            text-decoration:none;
        }

        /* =====================================================
           NAVBAR
        ===================================================== */
        .navbar-custom{
            padding:20px 0;
        }

        .brand-text{
            font-size:1.6rem;
            font-weight:700;
            color:#222;
        }

       .brand-text span{
    color:#f6b437;
}

        .menu-btn{
            width:46px;
            height:46px;

            border:none;
            border-radius:14px;

            background:#fff;

            display:flex;
            align-items:center;
            justify-content:center;

            box-shadow:
            0 10px 24px rgba(0,0,0,.06);
        }

        .menu-btn i{
            font-size:1.5rem;
            color:#333;
        }

        /* =====================================================
           HERO
        ===================================================== */
        .hero-section{
            position:relative;

            width:100%;
            height:290px;

            overflow:hidden;

            border-radius:32px;

            margin-top:10px;

            box-shadow:
            0 18px 45px rgba(0,0,0,.12);
        }

        .hero-section img{
            width:100%;
            height:100%;

            object-fit:cover;
        }

        .hero-overlay{
            position:absolute;
            inset:0;

            background:
            linear-gradient(
            to top,
            rgba(0,0,0,.65),
            rgba(0,0,0,.1)
            );

            display:flex;
            align-items:flex-end;

            padding:24px;
        }

        .hero-content h1{
            color:#fff;

            font-size:1.6rem;
            font-weight:700;

            margin-bottom:8px;
        }

        .hero-content p{
            color:rgba(255,255,255,.88);

            font-size:.82rem;
            line-height:1.7;

            margin-bottom:0;
        }

        /* =====================================================
           SECTION TITLE
        ===================================================== */
        .section-title{
            font-size:1.4rem;
            font-weight:700;

            margin-bottom:22px;

            color:#222;
        }

        /* =====================================================
           GALLERY CARD
        ===================================================== */
        .gallery-card{
            background:#fff;

            border-radius:24px;

            overflow:hidden;

            cursor:pointer;

            transition:all .3s ease;

            border:1px solid #eee;

            box-shadow:
            0 10px 24px rgba(0,0,0,.05);
        }

        .gallery-card:hover{
            transform:translateY(-6px);

            box-shadow:
            0 20px 40px rgba(0,0,0,.12);
        }

        .gallery-img-wrapper{
            width:100%;
            height:220px;

            overflow:hidden;
        }

        .gallery-img{
            width:100%;
            height:100%;

            object-fit:cover;

            transition:transform .4s ease;
        }

        .gallery-card:hover .gallery-img{
            transform:scale(1.08);
        }

        .gallery-body{
            padding:18px;
        }

        .gallery-title{
            font-size:.95rem;
            font-weight:700;

            margin-bottom:8px;

            color:#222;
        }

        .gallery-desc{
            font-size:.76rem;
            color:#777;

            line-height:1.7;

            margin-bottom:0;
        }

        /* =====================================================
           LIGHTBOX
        ===================================================== */
        .lightbox{
            display:none;

            position:fixed;
            inset:0;

            z-index:9999;

            background:rgba(0,0,0,.92);

            align-items:center;
            justify-content:center;
        }

        .lightbox.show{
            display:flex;
        }

        .lightbox-img{
            max-width:90vw;
            max-height:85vh;

            border-radius:20px;

            object-fit:contain;
        }

        .lightbox-close{
            position:absolute;
            top:20px;
            right:20px;

            width:46px;
            height:46px;

            border:none;
            border-radius:50%;

            background:rgba(255,255,255,.15);

            color:#fff;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:1.2rem;

            cursor:pointer;
        }

        .lightbox-prev,
        .lightbox-next{
            position:absolute;
            top:50%;

            transform:translateY(-50%);

            width:50px;
            height:50px;

            border:none;
            border-radius:50%;

            background:rgba(255,255,255,.15);

            color:#fff;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:1.3rem;

            cursor:pointer;
        }

        .lightbox-prev{
            left:20px;
        }

        .lightbox-next{
            right:20px;
        }

        .lightbox-counter{
            position:absolute;
            bottom:20px;
            left:50%;

            transform:translateX(-50%);

            color:rgba(255,255,255,.7);

            font-size:.85rem;
        }

        /* =====================================================
           FOOTER
        ===================================================== */
        .footer{
            margin-top:70px;
            padding-bottom:30px;
        }

        .footer-text{
            font-size:.8rem;
            color:#777;
        }

        .social-icons{
            display:flex;
            gap:18px;
        }

        .social-icons i{
            font-size:1.2rem;
            color:#666;

            transition:.25s;
        }

        .social-icons i:hover{
            color:#c78cff;
        }

        /* =====================================================
           TABLET
        ===================================================== */
        @media (min-width:768px){

            .hero-section{
                height:430px;
                border-radius:40px;
            }

            .hero-overlay{
                padding:40px;
            }

            .hero-content h1{
                font-size:2.7rem;
                max-width:700px;
            }

            .hero-content p{
                font-size:.95rem;
                max-width:700px;
            }

            .gallery-img-wrapper{
                height:260px;
            }

            .gallery-title{
                font-size:1.05rem;
            }

            .gallery-desc{
                font-size:.85rem;
            }

            .section-title{
                font-size:2rem;
            }
        }

        /* =====================================================
           DESKTOP
        ===================================================== */
        @media (min-width:992px){

            .container-custom{
                padding:
                0 50px;
            }

            .hero-section{
                height:520px;
            }

            .hero-content h1{
                font-size:3.4rem;
            }

            .hero-content p{
                font-size:1rem;
                line-height:1.9;
            }

            .gallery-img-wrapper{
                height:300px;
            }
        }

   .btn-kembali {
    position: fixed;
    bottom: 30px;
    left: 30px;
    background: #e74c3c;
    color: white;
    border-radius: 30px;
    padding: 10px 20px;
    z-index: 10;
    }

    </style>
</head>

<body>

<div class="container-custom container-fluid py-3">

    <!-- NAVBAR -->
    <nav class="navbar navbar-custom">

        <div class="container-fluid px-0">

            <a href="index.php" class="navbar-brand brand-text">
                Yayuk <span>Makeover</span>
            </a>

            <button class="menu-btn">
                <i class="bi bi-list"></i>
            </button>

        </div>

    </nav>

    <!-- HERO -->
    <div class="hero-section">

        <img src="../assets/foto_muayayuk.jpeg" alt="Gallery Dekor">

        <div class="hero-overlay">

            <div class="hero-content">

                <h1>
                    Gallery Dekor Elegan untuk Momen Istimewa
                </h1>

                <p>
                    Koleksi dekorasi premium dengan sentuhan modern,
                    aesthetic, dan elegan untuk wedding,
                    engagement, birthday, dan berbagai acara spesial lainnya.
                </p>

            </div>

        </div>

    </div>

    <!-- GALLERY -->
    <section class="mt-5">

        <h2 class="section-title">
            Gallery Dekor
        </h2>

        <div class="row g-4">

            <?php

            $photos = [

                [
                    'src'   => '../assets/gallery_dekor/dekor_1.jpeg',
                    'title' => 'Pelaminan Modern',
                    'desc'  => 'Dekorasi modern minimalis dengan nuansa elegan.'
                ],

                [
                    'src'   => '../assets/gallery_dekor/dekor_2.jpeg',
                    'title' => 'Wedding Decoration',
                    'desc'  => 'Setup dekor wedding indoor premium.'
                ],

                [
                    'src'   => '../assets/gallery_dekor/dekor_3.jpeg',
                    'title' => 'Dekor Akad Nikah',
                    'desc'  => 'Backdrop akad dengan floral aesthetic.'
                ],

                [
                    'src'   => '../assets/gallery_dekor/dekor_4.jpeg',
                    'title' => 'Standing Flower',
                    'desc'  => 'Rangkaian bunga segar mewah dan cantik.'
                ],

                [
                    'src'   => '../assets/gallery_dekor/dekor_5.jpeg',
                    'title' => 'Dekor Lamaran',
                    'desc'  => 'Dekor engagement modern dan clean.'
                ],

                [
                    'src'   => '../assets/gallery_dekor/dekor_6.jpeg',
                    'title' => 'Birthday Decoration',
                    'desc'  => 'Dekor ulang tahun aesthetic colorful.'
                ],

                [
                    'src'   => '../assets/gallery_dekor/dekor_7.jpeg',
                    'title' => 'Garden Party',
                    'desc'  => 'Konsep outdoor dengan nuansa natural.'
                ],

                [
                    'src'   => '../assets/gallery_dekor/dekor_8.jpeg',
                    'title' => 'Photo Booth',
                    'desc'  => 'Photo booth custom elegant design.'
                ],

            ];

            foreach($photos as $i => $photo):

            ?>

            <div class="col-6 col-md-4 col-lg-3">

                <div class="gallery-card"
                     onclick="openLightbox(<?= $i ?>)">

                    <div class="gallery-img-wrapper">

                        <img
                            src="<?= htmlspecialchars($photo['src']) ?>"
                            class="gallery-img"
                            alt="<?= htmlspecialchars($photo['title']) ?>"
                        >

                    </div>

                    <div class="gallery-body">

                        <h5 class="gallery-title">
                            <?= htmlspecialchars($photo['title']) ?>
                        </h5>

                        <p class="gallery-desc">
                            <?= htmlspecialchars($photo['desc']) ?>
                        </p>

                    </div>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    </section>

    <!-- FOOTER -->
    <div class="footer d-flex justify-content-between align-items-center">

        <p class="footer-text mb-0">
            © Yayuk Makeover 2025
        </p>

        <div class="social-icons">

            <i class="bi bi-facebook"></i>
            <i class="bi bi-instagram"></i>
            <i class="bi bi-twitter-x"></i>

        </div>

    </div>

</div>

<!-- LIGHTBOX -->
<div class="lightbox"
     id="lightbox"
     onclick="closeLightboxOutside(event)">

    <button class="lightbox-close"
            onclick="closeLightbox()">

        <i class="bi bi-x-lg"></i>

    </button>

    <button class="lightbox-prev"
            onclick="event.stopPropagation();changePhoto(-1)">

        <i class="bi bi-chevron-left"></i>

    </button>

    <img class="lightbox-img"
         id="lightboxImg"
         src=""
         alt="">

    <button class="lightbox-next"
            onclick="event.stopPropagation();changePhoto(1)">

        <i class="bi bi-chevron-right"></i>

    </button>

    <div class="lightbox-counter"
         id="lightboxCounter">

    </div>

</div>

<a href="javascript:history.back()" class="btn btn-kembali">Kembali</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    const photos = <?= json_encode($photos) ?>;

    let current = 0;

    function openLightbox(i){

        current = i;

        updateLightbox();

        document
        .getElementById('lightbox')
        .classList
        .add('show');

        document.body.style.overflow='hidden';
    }

    function closeLightbox(){

        document
        .getElementById('lightbox')
        .classList
        .remove('show');

        document.body.style.overflow='';
    }

    function closeLightboxOutside(e){

        if(
            e.target ===
            document.getElementById('lightbox')
        ){
            closeLightbox();
        }
    }

    function changePhoto(d){

        current =
        (current + d + photos.length)
        % photos.length;

        updateLightbox();
    }

    function updateLightbox(){

        document
        .getElementById('lightboxImg')
        .src = photos[current].src;

        document
        .getElementById('lightboxCounter')
        .textContent =
        (current + 1)
        + ' / ' +
        photos.length;
    }

    document.addEventListener('keydown', e => {

        const lb =
        document.getElementById('lightbox');

        if(!lb.classList.contains('show')) return;

        if(e.key === 'ArrowLeft'){
            changePhoto(-1);
        }

        if(e.key === 'ArrowRight'){
            changePhoto(1);
        }

        if(e.key === 'Escape'){
            closeLightbox();
        }

    });

</script>

</body>
</html>