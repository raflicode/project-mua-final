<<<<<<< HEAD
=======

>>>>>>> 28f7c26 (Menambahkan foto di bagian gallery)
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Gallery Dekor - Yayuk Makeover</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { background-color: #f4f4f4; font-family: 'Poppins', sans-serif; }
        .navbar-custom { background-color: #f4f4f4; padding: 14px 10px; }
        .brand-text { font-size: 20px; font-weight: 700; color: #222; }
        .brand-text span { color: #f6b437; }

        .hero-card { position: relative; border-radius: 12px; overflow: hidden; height: 260px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .hero-card img { width: 100%; height: 100%; object-fit: cover; }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.65), rgba(0,0,0,0.1)); display: flex; align-items: end; padding: 20px; color: white; }
        .hero-title { font-size: 18px; font-weight: 600; margin-bottom: 8px; }
        .hero-desc { font-size: 13px; line-height: 1.5; margin-bottom: 0; }

        .section-title { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #222; }

        .gallery-card { border: none; border-radius: 10px; overflow: hidden; background-color: transparent; display: flex; flex-direction: column; gap: 12px; cursor: pointer; }
        .gallery-img-wrapper { width: 100%; height: 210px; display: flex; align-items: center; justify-content: center; background-color: #ebebeb; border-radius: 10px; overflow: hidden; transition: transform 0.3s ease; }
        .gallery-card:hover .gallery-img-wrapper { transform: scale(1.02); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .gallery-img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 10px; transition: transform 0.35s ease; }
        .gallery-card:hover .gallery-img { transform: scale(1.06); }
        .blog-title { font-size: 14px; font-weight: 700; margin-top: 10px; margin-bottom: 4px; color: #222; }
        .blog-desc { font-size: 10px; color: #777; line-height: 1.4; margin-bottom: 0; }

        .lightbox { display: none; position: fixed; inset: 0; z-index: 1050; background: rgba(0,0,0,0.92); align-items: center; justify-content: center; }
        .lightbox.show { display: flex; }
        .lightbox-img { max-width: 90vw; max-height: 85vh; border-radius: 12px; object-fit: contain; }
        .lightbox-close { position: absolute; top: 16px; right: 20px; background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 50%; width: 42px; height: 42px; font-size: 1.3rem; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .lightbox-close:hover { background: rgba(255,255,255,0.3); }
        .lightbox-prev, .lightbox-next { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 50%; width: 46px; height: 46px; font-size: 1.3rem; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .lightbox-prev { left: 14px; }
        .lightbox-next { right: 14px; }
        .lightbox-prev:hover, .lightbox-next:hover { background: rgba(255,255,255,0.3); }
        .lightbox-counter { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); color: rgba(255,255,255,0.7); font-size: 0.8rem; }

        .footer { margin-top: 80px; padding-bottom: 25px; }
        .footer-text { font-size: 11px; color: #777; }
        .social-icons i { font-size: 20px; color: #666; margin-left: 20px; }
        .social-icons i:hover { color: #f6b437; cursor: pointer; }

        @media (min-width: 768px) {
            .hero-card { height: 380px; border-radius: 20px; }
            .hero-title { font-size: 30px; max-width: 700px; }
            .hero-desc { font-size: 15px; max-width: 650px; }
            .gallery-img-wrapper { height: 220px; }
            .blog-title { font-size: 16px; }
            .blog-desc { font-size: 13px; }
            .section-title { font-size: 28px; }
            .footer-text { font-size: 14px; }
        }
        @media (min-width: 992px) {
            body { background: #efefef; }
            .hero-card { height: 480px; }
            .hero-overlay { padding: 40px; }
            .hero-title { font-size: 42px; max-width: 850px; }
            .hero-desc { font-size: 16px; max-width: 700px; line-height: 1.8; }
            .gallery-img-wrapper { height: 260px; }
            .blog-title { font-size: 18px; }
            .blog-desc { font-size: 14px; }
            .section-title { font-size: 32px; }
            .navbar-custom { padding: 20px 0; }
            .brand-text { font-size: 28px; }
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
<div class="container-fluid px-3 px-md-4 px-lg-5 py-2">

    <!-- NAVBAR -->
    <?php include 'include/navbar.php'; ?>

    <div class="hero-card mt-2">
        <img src="../assets/foto_muayayuk.jpeg" alt="Gallery Dekor">
        <div class="hero-overlay">
            <div>
                <h2 class="hero-title">Keanggunan Abadi untuk Hari Istimewa Anda.</h2>
                <p class="hero-desc">Dekorasi pernikahan profesional dengan sentuhan terbaik yang menjadikan hari istimewa Anda semakin berkesan dan tak terlupakan.</p>
=======
    <title>Gallery Dekor</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-custom {
            background-color: #f4f4f4;
            padding: 14px 10px;
        }

        .brand-text {
            font-size: 20px;
            font-weight: 700;
            color: #222;
        }

        .brand-text span {
            color: #f6b437;
        }

        .hero-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            height: 260px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .hero-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.65), rgba(0,0,0,0.1));
            display: flex;
            align-items: end;
            padding: 20px;
            color: white;
        }

        .hero-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .hero-desc {
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #222;
        }

        .gallery-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            background-color: transparent;
        }

        .gallery-img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 10px;
            background-color: #ebebeb;
        }

        .gallery-placeholder {
            width: 100%;
            height: 110px;
            background-color: #ececec;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #999;
        }

        .gallery-placeholder i {
            font-size: 34px;
        }

        .blog-title {
            font-size: 14px;
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 4px;
            color: #222;
        }

        .blog-desc {
            font-size: 10px;
            color: #777;
            line-height: 1.4;
            margin-bottom: 0;
        }

        .footer {
            margin-top: 80px;
            padding-bottom: 25px;
        }

        .footer-text {
            font-size: 11px;
            color: #777;
        }

        .social-icons i {
            font-size: 20px;
            color: #666;
            margin-left: 20px;
        }
    </style>
</head>
<body>

<div class="container py-2" style="max-width: 430px;">

    <!-- Navbar -->
    <nav class="navbar navbar-custom">
        <div class="container-fluid px-0">
            <a class="navbar-brand brand-text" href="#">
                Yayuk <span>Makeover</span>
            </a>

            <button class="btn p-0 border-0">
                <i class="bi bi-list" style="font-size: 38px; color: #222;"></i>
            </button>
        </div>
    </nav>

    <!-- Hero -->
    <div class="hero-card mt-2">
        <img src="../assets/foto_dekor.jpeg" alt="Dekor Wedding">

        <div class="hero-overlay">
            <div>
                <h2 class="hero-title">
                    Keanggunan Abadi untuk Hari Istimewa Anda.
                </h2>

                <p class="hero-desc">
                    Riasan dan penataan rambut pengantin profesional dengan hasil akhir
                    yang sempurna dan alami yang menonjolkan kecantikan sejati Anda.
                </p>
>>>>>>> 28f7c26 (Menambahkan foto di bagian gallery)
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <section class="mt-5">
        <h4 class="section-title">Gallery Dekor</h4>

        <div class="row g-3">

<?php

$photos = [
    ['src' => '../assets/gallery_dekor/dekor_1.jpeg', 'title' => 'Pelaminan Modern',    'desc' => 'Dekorasi pelaminan tema modern minimalis.'],
    ['src' => '../assets/gallery_dekor/dekor_2.jpeg', 'title' => 'Wedding Decoration',  'desc' => 'Dekorasi pernikahan full setup indoor.'],
    ['src' => '../assets/gallery_dekor/dekor_3.jpeg', 'title' => 'Dekor Akad Nikah',    'desc' => 'Setup meja akad dengan floral premium.'],
    ['src' => '../assets/gallery_dekor/dekor_4.jpeg', 'title' => 'Standing Flower',     'desc' => 'Rangkaian bunga segar untuk pelaminan.'],
    ['src' => '../assets/gallery_dekor/dekor_5.jpeg', 'title' => 'Dekor Lamaran',       'desc' => 'Backdrop foto cantik untuk lamaran.'],
    ['src' => '../assets/gallery_dekor/dekor_6.jpeg', 'title' => 'Dekor Ulang Tahun',   'desc' => 'Tema balon dan bunting flag colorful.'],
    ['src' => '../assets/gallery_dekor/dekor_7.jpeg', 'title' => 'Dekor Syukuran',      'desc' => 'Dekorasi sederhana namun elegan.'],
    ['src' => '../assets/gallery_dekor/dekor_8.jpeg', 'title' => 'Photo Booth',         'desc' => 'Backdrop photo booth custom desain.'],
    ['src' => '../assets/gallery_dekor/dekor_9.jpeg', 'title' => 'Dekor Garden Party',  'desc' => 'Dekorasi outdoor nuansa alam terbuka.'],
];

foreach ($photos as $i => $photo):
?>

<div class="col-6 col-md-4 col-lg-3">
    <div class="gallery-card" onclick="openLightbox(<?= $i ?>)">

        <div class="gallery-img-wrapper">
            <img src="<?= htmlspecialchars($photo['src']) ?>"
                 class="gallery-img"
                 alt="<?= htmlspecialchars($photo['title']) ?>"
                 loading="lazy">
        </div>

        <h6 class="blog-title">
            <?= htmlspecialchars($photo['title']) ?>
        </h6>

        <p class="blog-desc">
            <?= htmlspecialchars($photo['desc']) ?>
        </p>

    </div>
</div>

<?php endforeach; ?>
        </div>
    </section>

    <div class="footer d-flex justify-content-between align-items-center">
        <p class="footer-text mb-0">@Yayuk Makeover 2025</p>
=======
    <!-- Gallery -->
    <section class="mt-5">
        <h4 class="section-title">Galerry Dekor</h4>

        <div class="row g-3">

            <!-- Card 1 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="../assets/fotodekor1.jpeg.png" class="gallery-img" alt="Dekor">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan dekorasi yang elegan.
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="../assets/fotodekor2.jpeg.png" class="gallery-img" alt="Dekor">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan dekorasi yang elegan.
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="../assets/fotodekor3.jpeg.png" class="gallery-img" alt="Dekor">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan dekorasi yang elegan.
                    </p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="../assets/fotodekor4.jpeg.png" class="gallery-img" alt="Dekor">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan dekorasi yang elegan.
                    </p>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="../assets/fotodekor5.jpeg.png" class="gallery-img" alt="Dekor">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan dekorasi yang elegan.
                    </p>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="../assets/fotodekor6.jpeg.jpeg" class="gallery-img" alt="Dekor">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan dekorasi yang elegan.
                    </p>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="../assets/fotodekor1.jpeg.png" class="gallery-img" alt="Dekor">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan dekorasi yang elegan.
                    </p>
                </div>
            </div>

            <!-- Card 8 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="../assets/fotodekor2.jpeg.png" class="gallery-img" alt="Dekor">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan dekorasi yang elegan.
                    </p>
                </div>
            </div>

            <!-- Card 9 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="../assets/fotodekor3.jpeg.png" class="gallery-img" alt="Dekor">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan dekorasi yang elegan.
                    </p>
                </div>
            </div>

            

        </div>
    </section>

    <!-- Footer -->
    <div class="footer d-flex justify-content-between align-items-center">
        <p class="footer-text mb-0">@Yayuk Makeover 2025</p>

>>>>>>> 28f7c26 (Menambahkan foto di bagian gallery)
        <div class="social-icons">
            <i class="bi bi-facebook"></i>
            <i class="bi bi-instagram"></i>
            <i class="bi bi-twitter"></i>
        </div>
    </div>
<<<<<<< HEAD
</div>

<div class="lightbox" id="lightbox" onclick="closeLightboxOutside(event)">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="bi bi-x-lg"></i></button>
    <button class="lightbox-prev" onclick="event.stopPropagation();changePhoto(-1)"><i class="bi bi-chevron-left"></i></button>
    <img class="lightbox-img" id="lightboxImg" src="" alt="">
    <button class="lightbox-next" onclick="event.stopPropagation();changePhoto(1)"><i class="bi bi-chevron-right"></i></button>
    <div class="lightbox-counter" id="lightboxCounter"></div>
</div>

<a href="javascript:history.back()" class="btn btn-kembali">Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const photos = <?= json_encode($photos) ?>;
    let current = 0;
    function openLightbox(i) { current=i; updateLightbox(); document.getElementById('lightbox').classList.add('show'); document.body.style.overflow='hidden'; }
    function closeLightbox() { document.getElementById('lightbox').classList.remove('show'); document.body.style.overflow=''; }
    function closeLightboxOutside(e) { if(e.target===document.getElementById('lightbox')) closeLightbox(); }
    function changePhoto(d) { current=(current+d+photos.length)%photos.length; updateLightbox(); }
    function updateLightbox() { document.getElementById('lightboxImg').src=photos[current].src; document.getElementById('lightboxCounter').textContent=(current+1)+' / '+photos.length; }
    document.addEventListener('keydown',e=>{ const lb=document.getElementById('lightbox'); if(!lb.classList.contains('show'))return; if(e.key==='ArrowLeft')changePhoto(-1); if(e.key==='ArrowRight')changePhoto(1); if(e.key==='Escape')closeLightbox(); });
</script>
</body>
</html>
=======

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
>>>>>>> 28f7c26 (Menambahkan foto di bagian gallery)
