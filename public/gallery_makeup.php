<?php
session_start();
require_once '../config/koneksi.php';
require_once '../config/db_helpers.php';

ensure_dynamic_booking_schema($pdo);
ensure_dynamic_gallery_schema($pdo);

$photos = [];
$stmt = $pdo->prepare("SELECT foto, judul, deskripsi FROM gallery WHERE kategori = ? AND is_active = 1 ORDER BY urutan ASC, id_gallery ASC");
$stmt->execute(['makeup']);
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $photos[] = [
        'src' => '../' . ltrim($row['foto'], '/'),
        'title' => $row['judul'],
        'desc' => $row['deskripsi'] ?? '',
    ];
}

if (empty($photos)) {
    $photos = [
        ['src' => '../assets/foto_makeup.jpeg', 'title' => 'Makeup Natural', 'desc' => 'Makeup natural untuk tampilan yang anggun.'],
        ['src' => '../assets/fotomakeup_1.jpeg', 'title' => 'Makeup Wedding', 'desc' => 'Riasan pengantin untuk hari istimewa.'],
        ['src' => '../assets/fotomakeup_2.jpeg', 'title' => 'Makeup Elegan', 'desc' => 'Riasan elegan dengan hasil akhir rapi.'],
        ['src' => '../assets/fotomakeup_3.jpeg', 'title' => 'Makeup Glamour', 'desc' => 'Tampilan glamour yang tetap lembut.'],
        ['src' => '../assets/fotomakeup_4.jpeg', 'title' => 'Makeup Adat', 'desc' => 'Makeup adat dengan sentuhan modern.'],
        ['src' => '../assets/fotomakeup_5.jpeg', 'title' => 'Makeup Spesial', 'desc' => 'Riasan cantik untuk acara spesial.'],
        ['src' => '../assets/fotomakeup_6.png', 'title' => 'Makeup Engagement', 'desc' => 'Makeup cantik untuk acara tunangan.'],
        ['src' => '../assets/fotomakeup_7.png', 'title' => 'Makeup Soft Look', 'desc' => 'Look lembut yang menonjolkan kecantikan alami.'],
        ['src' => '../assets/fotomakeup_8.png', 'title' => 'Makeup Bridal', 'desc' => 'Riasan bridal yang flawless dan tahan lama.'],
        ['src' => '../assets/fotomakeup_9.png', 'title' => 'Makeup Premium', 'desc' => 'Riasan premium untuk momen terbaik Anda.'],
    ];
}
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
        .lightbox-prev, .lightbox-next { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 50%; width: 46px; height: 46px; font-size: 1.3rem; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .lightbox-prev { left: 14px; }
        .lightbox-next { right: 14px; }
        .lightbox-counter { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); color: rgba(255,255,255,0.7); font-size: 0.8rem; }
        .footer { margin-top: 80px; padding-bottom: 25px; }
        .footer-text { font-size: 11px; color: #777; }
        .social-icons i { font-size: 20px; color: #666; margin-left: 20px; }
        .social-icons i:hover { color: #f6b437; cursor: pointer; }
        .btn-kembali { position: fixed; bottom: 30px; left: 30px; background: #e74c3c; color: white; border-radius: 30px; padding: 10px 20px; z-index: 10; }

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
                <h2 class="hero-title" style="color:white;">Keindahan Makeup Profesional untuk Momen Istimewa Anda.</h2>
                <p class="hero-desc">Makeup artistry profesional dengan produk berkualitas tinggi yang membuat penampilan Anda semakin percaya diri, cantik, dan memukau di setiap kesempatan.</p>
            </div>
        </div>
    </div>

    <section class="mt-5">
        <h4 class="section-title">Gallery Makeup</h4>
        <div class="row g-3">
            <?php foreach ($photos as $i => $photo): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="gallery-card" onclick="openLightbox(<?= $i ?>)">
                        <div class="gallery-img-wrapper">
                            <img src="<?= htmlspecialchars($photo['src']) ?>" class="gallery-img" alt="<?= htmlspecialchars($photo['title']) ?>" loading="lazy">
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

<a href="javascript:history.back()" class="btn btn-kembali">Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const photos = <?= json_encode($photos) ?>;
    let current = 0;
    function openLightbox(i) { current = i; updateLightbox(); document.getElementById('lightbox').classList.add('show'); document.body.style.overflow = 'hidden'; }
    function closeLightbox() { document.getElementById('lightbox').classList.remove('show'); document.body.style.overflow = ''; }
    function closeLightboxOutside(e) { if (e.target === document.getElementById('lightbox')) closeLightbox(); }
    function changePhoto(d) { current = (current + d + photos.length) % photos.length; updateLightbox(); }
    function updateLightbox() { document.getElementById('lightboxImg').src = photos[current].src; document.getElementById('lightboxCounter').textContent = (current + 1) + ' / ' + photos.length; }
    document.addEventListener('keydown', e => { const lb = document.getElementById('lightbox'); if (!lb.classList.contains('show')) return; if (e.key === 'ArrowLeft') changePhoto(-1); if (e.key === 'ArrowRight') changePhoto(1); if (e.key === 'Escape') closeLightbox(); });
</script>
</body>
</html>
