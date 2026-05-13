<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Makeup - Yayuk Makeover</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { background-color: #f4f4f4; font-family: 'Poppins', sans-serif; }

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
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>
<div class="container-fluid px-3 px-md-4 px-lg-5" style="padding-top: 65px;">
    <div class="hero-card mt-3">
        <img src="../assets/foto_muayayuk.jpeg" alt="Gallery Makeup">
        <div class="hero-overlay">
            <div>
                <h2 class="hero-title">Keindahan Makeup Profesional untuk Momen Istimewa Anda.</h2>
                <p class="hero-desc">Makeup artistry profesional dengan produk berkualitas tinggi yang membuat penampilan Anda semakin percaya diri, cantik, dan memukau di setiap kesempatan.</p>
            </div>
        </div>
    </div>

    <section class="mt-5">
        <h4 class="section-title">Gallery Makeup</h4>

        <div class="row g-3">
            <?php
            /*
            ================================================================
            CARA TAMBAH FOTO:
            Upload foto ke folder: assets/gallery_makeup/
            Tambah item baru di array $photos di bawah
            ================================================================
            */
            $photos = [
                ['src' => '../assets/gallery_makeup/makeup_1.jpeg', 'title' => 'Makeup Wedding Klasik',    'desc' => 'Riasan pengantin dengan konsep klasik dan elegan.'],
                ['src' => '../assets/gallery_makeup/makeup_2.jpeg', 'title' => 'Makeup Modern Natural',  'desc' => 'Natural makeup look untuk tampilan sehari-hari.'],
                ['src' => '../assets/gallery_makeup/makeup_3.jpeg', 'title' => 'Makeup Glamour',    'desc' => 'Riasan glamour dengan smokey eye yang memukau.'],
                ['src' => '../assets/gallery_makeup/makeup_4.jpeg', 'title' => 'Makeup Pengantin Adat',     'desc' => 'Makeup tradisional dengan sentuhan modern.'],
                ['src' => '../assets/gallery_makeup/makeup_5.jpeg', 'title' => 'Makeup Bold & Dramatic',       'desc' => 'Makeup berani dengan warna-warna cerah menawan.'],
                ['src' => '../assets/gallery_makeup/makeup_6.jpeg', 'title' => 'Makeup Engagement',   'desc' => 'Riasan cantik untuk acara tunangan spesial.'],
                ['src' => '../assets/gallery_makeup/makeup_7.jpeg', 'title' => 'Makeup Airbrush',      'desc' => 'Makeup flawless dengan teknik airbrush terkini.'],
                ['src' => '../assets/gallery_makeup/makeup_8.jpeg', 'title' => 'Makeup Editorial',         'desc' => 'Makeup profesional untuk keperluan fotografi.'],
                ['src' => '../assets/gallery_makeup/makeup_9.jpeg', 'title' => 'Makeup Bridal',  'desc' => 'Riasan sempurna untuk pengantin impian Anda.'],
            ];

            foreach ($photos as $i => $photo): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="gallery-card" onclick="openLightbox(<?= $i ?>)">
                    <div class="gallery-img-wrapper">
                        <img src="<?= htmlspecialchars($photo['src']) ?>"
                             class="gallery-img"
                             alt="<?= htmlspecialchars($photo['title']) ?>"
                             loading="lazy"
                             onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;color:#bbb;\'><i class=\'bi bi-image\' style=\'font-size:2rem;\'></i><small style=\'margin-top:8px;font-size:11px;\'>Foto belum tersedia</small></div>'">
                    </div>
                    <h6 class="blog-title"><?= htmlspecialchars($photo['title']) ?></h6>
                    <p class="blog-desc"><?= htmlspecialchars($photo['desc']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <div class="footer d-flex justify-content-between align-items-center">
        <p class="footer-text mb-0">@Yayuk Makeover 2025</p>
        <div class="social-icons">
            <i class="bi bi-facebook"></i>
            <i class="bi bi-instagram"></i>
            <i class="bi bi-twitter"></i>
        </div>
    </div>
</div>

<div class="lightbox" id="lightbox" onclick="closeLightboxOutside(event)">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="bi bi-x-lg"></i></button>
    <button class="lightbox-prev" onclick="event.stopPropagation();changePhoto(-1)"><i class="bi bi-chevron-left"></i></button>
    <img class="lightbox-img" id="lightboxImg" src="" alt="">
    <button class="lightbox-next" onclick="event.stopPropagation();changePhoto(1)"><i class="bi bi-chevron-right"></i></button>
    <div class="lightbox-counter" id="lightboxCounter"></div>
</div>

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