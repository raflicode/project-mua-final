<?php
include __DIR__ . '/actions/proses_index.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Eternal Beauty</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --mua-bg: #f7f2eb;
            --mua-bg-soft: #f1e8dd;
            --mua-surface: #fffaf4;
            --mua-primary: #a58459;
            --mua-primary-deep: #7b5d3f;
            --mua-secondary: #b5835a;
            --mua-accent: #FED03A;
            --mua-text: #4a4a4a;
            --mua-heading: #3b3028;
            --mua-muted: #7b6b5d;
            --mua-border: rgba(165, 132, 89, 0.22);
            --mua-shadow: 0 20px 48px rgba(73, 55, 40, 0.13);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--mua-text);
            background:
                radial-gradient(circle at top left, rgba(254, 208, 58, 0.13), transparent 28rem),
                linear-gradient(180deg, var(--mua-bg) 0%, #fffaf4 44%, var(--mua-bg-soft) 100%);
        }

        h1,
        h2,
        h3,
        .serif {
            font-family: 'Playfair Display', serif;
            color: var(--mua-heading);
        }

        .section-pad {
            padding: 92px 0;
        }

        .section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--mua-primary-deep);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .section-kicker::before {
            content: "";
            width: 36px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--mua-secondary), var(--mua-accent));
        }

        .section-title {
            color: var(--mua-secondary);
            font-weight: 700;
            line-height: 1.12;
        }

        .section-copy {
            color: var(--mua-muted);
            line-height: 1.85;
        }

        .btn-booking {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 48px;
            padding: 12px 28px;
            border: 1px solid rgba(255, 255, 255, 0.34);
            border-radius: 999px;
            color: #ffffff;
            background: linear-gradient(135deg, var(--mua-primary), var(--mua-primary-deep));
            font-weight: 700;
            letter-spacing: 0.02em;
            text-decoration: none;
            box-shadow: 0 16px 34px rgba(123, 93, 63, 0.24);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        .btn-booking:hover {
            color: #ffffff;
            background: linear-gradient(135deg, var(--mua-primary-deep), var(--mua-secondary));
            box-shadow: 0 20px 42px rgba(123, 93, 63, 0.3);
            transform: translateY(-2px);
        }

        .btn-soft {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 48px;
            padding: 12px 24px;
            border: 1px solid var(--mua-border);
            border-radius: 999px;
            color: var(--mua-primary-deep);
            background: rgba(255, 250, 244, 0.78);
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        .btn-soft:hover {
            color: #ffffff;
            background: var(--mua-secondary);
            box-shadow: 0 16px 34px rgba(181, 131, 90, 0.24);
            transform: translateY(-2px);
        }

        .hero-section {
            min-height: calc(100vh - 24px);
            padding: 96px 0 34px;
            display: flex;
            align-items: stretch;
        }

        .hero-shell {
            width: 100%;
            display: grid;
            grid-template-columns: minmax(0, 1.02fr) minmax(360px, 0.78fr);
            align-items: center;
            gap: 44px;
            padding: 38px;
            border: 1px solid var(--mua-border);
            border-radius: 28px;
            background: rgba(255, 250, 244, 0.74);
            box-shadow: var(--mua-shadow);
            overflow: hidden;
            animation: heroLift 0.9s ease both;
        }

        .hero-copy {
            max-width: 720px;
        }

        .hero-title {
            margin: 18px 0 18px;
            font-size: clamp(2.5rem, 5.4vw, 5.85rem);
            line-height: 0.98;
            letter-spacing: 0;
            animation: fadeUp 0.85s ease 0.12s both;
        }

        .hero-title span {
            color: var(--mua-secondary);
            font-style: italic;
            font-weight: 400;
        }

        .hero-subtitle {
            max-width: 640px;
            margin: 0 0 28px;
            color: var(--mua-muted);
            font-size: clamp(0.98rem, 1.3vw, 1.08rem);
            line-height: 1.85;
            animation: fadeUp 0.85s ease 0.24s both;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: center;
            animation: fadeUp 0.85s ease 0.36s both;
        }

        .hero-notes {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 34px;
        }

        .hero-note {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1px solid var(--mua-border);
            border-radius: 999px;
            color: var(--mua-primary-deep);
            background: rgba(255, 255, 255, 0.5);
            font-size: 0.88rem;
            font-weight: 600;
            transition: transform 0.25s ease, border-color 0.25s ease, background 0.25s ease;
        }

        .hero-note:hover {
            border-color: rgba(181, 131, 90, 0.45);
            background: rgba(255, 250, 244, 0.9);
            transform: translateY(-2px);
        }

        .hero-visual {
            position: relative;
            min-height: 560px;
        }

        .hero-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 190px 190px 16px 16px;
            box-shadow: 0 24px 54px rgba(59, 48, 40, 0.18);
            animation: imageSettle 1.1s ease 0.16s both;
        }

        .hero-photo-frame {
            position: absolute;
            inset: 18px -18px -18px 18px;
            border: 1px solid rgba(181, 131, 90, 0.42);
            border-radius: 190px 190px 16px 16px;
            animation: frameFloat 5.5s ease-in-out infinite;
        }

        .hero-badge {
            position: absolute;
            right: -10px;
            bottom: 26px;
            max-width: 230px;
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 18px;
            background: rgba(123, 93, 63, 0.94);
            color: #ffffff;
            box-shadow: 0 18px 38px rgba(59, 48, 40, 0.22);
            animation: fadeUp 0.85s ease 0.48s both;
        }

        .hero-badge strong {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 1.38rem;
            line-height: 1.1;
        }

        .hero-badge small {
            display: block;
            margin-top: 8px;
            color: rgba(255, 255, 255, 0.82);
            line-height: 1.55;
        }

        .about-grid {
            align-items: center;
        }

        .about-image-wrap {
            position: relative;
            max-width: 470px;
            margin: 0 auto;
        }

        .about-image-wrap::before {
            content: "";
            position: absolute;
            inset: 22px 22px -22px -22px;
            border: 1px solid rgba(181, 131, 90, 0.36);
            border-radius: 36px 140px 36px 140px;
        }

        .custom-shape {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 5;
            object-fit: cover;
            border: 10px solid #fffaf4;
            border-radius: 36px 140px 36px 140px;
            box-shadow: var(--mua-shadow);
        }

        .animated-divider {
            width: min(420px, 100%);
            height: 4px;
            margin: 24px 0;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--mua-secondary), var(--mua-accent));
            opacity: 0;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 1s ease, opacity 0.4s ease;
        }

        .animated-divider.is-visible {
            opacity: 1;
            transform: scaleX(1);
        }

        .soft-section {
            background:
                linear-gradient(135deg, rgba(241, 232, 221, 0.96), rgba(255, 250, 244, 0.88));
        }

        .why-shell {
            padding: 54px;
            border-radius: 28px;
            background:
                linear-gradient(135deg, rgba(123, 93, 63, 0.98), rgba(165, 132, 89, 0.95)),
                var(--mua-primary);
            color: #ffffff;
            box-shadow: var(--mua-shadow);
        }

        .why-title {
            color: #ffffff;
            font-size: clamp(2rem, 3.3vw, 3.35rem);
        }

        .why-item {
            height: 100%;
            padding: 26px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.08);
            transition: transform 0.28s ease, background 0.28s ease, border-color 0.28s ease;
        }

        .why-item:hover {
            border-color: rgba(255, 255, 255, 0.38);
            background: rgba(255, 255, 255, 0.13);
            transform: translateY(-6px);
        }

        .why-icon {
            width: 56px;
            height: 56px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            border-radius: 50%;
            color: var(--mua-primary-deep);
            background: #fff7df;
            font-size: 1.55rem;
        }

        .why-item h5 {
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .why-item p {
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            line-height: 1.7;
        }

        .gallery-intro {
            max-width: 760px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .gallery-card {
            height: 100%;
            border: 1px solid var(--mua-border);
            border-radius: 22px;
            overflow: hidden;
            background: rgba(255, 250, 244, 0.94);
            box-shadow: 0 14px 34px rgba(73, 55, 40, 0.11);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 50px rgba(73, 55, 40, 0.15);
        }

        .gallery-img-wrap {
            position: relative;
            aspect-ratio: 4 / 5;
            overflow: hidden;
            background: #efe3d5;
        }

        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.45s ease;
        }

        .gallery-card:hover .gallery-img {
            transform: scale(1.05);
        }

        .gallery-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 20px;
        }

        .gallery-body h3 {
            margin: 0;
            font-size: 1.32rem;
        }

        .gallery-btn {
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border: 1px solid var(--mua-secondary);
            border-radius: 50%;
            color: var(--mua-secondary);
            background: transparent;
            text-decoration: none;
            transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease;
        }

        .gallery-btn:hover {
            color: #ffffff;
            background: var(--mua-secondary);
            transform: translateX(2px);
        }

        .reveal {
            opacity: 0;
            transform: translateY(26px);
            transition: opacity 0.75s ease, transform 0.75s ease;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: 0.1s;
        }

        .reveal-delay-2 {
            transition-delay: 0.2s;
        }

        .reveal-delay-3 {
            transition-delay: 0.3s;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes heroLift {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.985);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes imageSettle {
            from {
                opacity: 0;
                transform: scale(1.035);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes frameFloat {
            0%,
            100% {
                transform: translate3d(0, 0, 0);
            }
            50% {
                transform: translate3d(-8px, 8px, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }

        @media (max-width: 991.98px) {
            .section-pad {
                padding: 72px 0;
            }

            .hero-section {
                min-height: auto;
                padding-top: 88px;
            }

            .hero-shell {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 28px;
            }

            .hero-copy {
                max-width: none;
            }

            .hero-visual {
                min-height: 430px;
                order: -1;
            }

            .hero-photo,
            .hero-photo-frame {
                border-radius: 120px 120px 16px 16px;
            }

            .why-shell {
                padding: 36px 24px;
            }
        }

        @media (max-width: 767.98px) {
            .container {
                --bs-gutter-x: 1.25rem;
            }

            .section-pad {
                padding: 58px 0;
            }

            .hero-section {
                padding: 78px 0 24px;
            }

            .hero-shell {
                padding: 18px;
                border-radius: 22px;
            }

            .hero-visual {
                min-height: 360px;
            }

            .hero-badge {
                right: 10px;
                bottom: 14px;
                max-width: 190px;
                padding: 14px;
            }

            .hero-actions {
                align-items: stretch;
            }

            .hero-actions a {
                width: 100%;
            }

            .hero-notes {
                margin-top: 24px;
            }

            .hero-note {
                width: 100%;
                justify-content: center;
            }

            .about-image-wrap::before {
                inset: 14px 14px -14px -14px;
                border-radius: 28px 86px 28px 86px;
            }

            .custom-shape {
                border-width: 7px;
                border-radius: 28px 86px 28px 86px;
            }

            .gallery-body {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['success'])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?php echo htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8'); ?>',
        timer: 2000,
        showConfirmButton: false
    });

    if (window.history.replaceState) {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
</script>
<?php endif; ?>

<?php if(isset($_SESSION['success_message'])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?php echo htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?>',
        timer: 3000,
        showConfirmButton: false
    });
</script>
<?php unset($_SESSION['success_message']); endif; ?>

<?php include __DIR__ . '/public/include/navbar.php'; ?>

<header class="hero-section">
    <div class="container">
        <div class="hero-shell">
            <div class="hero-copy">
                <span class="section-kicker">Yayuk Makeover</span>
                <h1 class="hero-title">
                    Keanggunan Abadi untuk <span>Hari Istimewa</span> Anda.
                </h1>
                <p class="hero-subtitle">
                    Riasan dan penataan rambut pengantin profesional dengan hasil akhir yang sempurna dan alami untuk menonjolkan kecantikan sejati Anda.
                </p>

                <div class="hero-actions">
                    <a href="/project-mua-final/public/service.php" class="btn-booking">
                        Booking <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="hero-notes" aria-label="Keunggulan layanan">
                    <span class="hero-note"><i class="bi bi-stars"></i> Makeup Artist Profesional</span>
                    <span class="hero-note"><i class="bi bi-flower1"></i> Wedding, Dekor, Kostum</span>
                </div>
            </div>

            <div class="hero-visual" aria-hidden="true">
                <div class="hero-photo-frame"></div>
                <img src="assets/foto_muayayuk.jpeg" class="hero-photo" alt="">
                <div class="hero-badge">
                    <strong>Eternal Beauty</strong>
                    <small>Sentuhan rias yang lembut, elegan, dan personal untuk momen berharga.</small>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="section-pad reveal">
    <div class="container">
        <div class="row about-grid g-5">
            <div class="col-lg-6">
                <div class="about-image-wrap">
                    <img src="assets/foto_profile.jpeg" class="custom-shape" alt="Yayuk Makeover">
                </div>
            </div>

            <div class="col-lg-6">
                <span class="section-kicker">Tentang Kami</span>
                <h2 class="section-title display-5 mt-3">
                    Merajut Kenangan dalam Setiap Sentuhan
                </h2>
                <div class="animated-divider"></div>

                <p class="section-copy">
                    Perjalanan Yayuk Makeover tumbuh bersama ribuan senyum dan cerita bahagia dari para pasangan yang telah menjadi bagian dari keluarga kami.
                </p>
                <p class="section-copy">
                    Kami memahami bahwa pernikahan adalah momen sekali seumur hidup yang penuh dengan detail dan harapan.
                </p>
                <p class="section-copy mb-0">
                    Melalui diskusi yang mendalam dan sentuhan profesional, kita akan merajut sebuah kisah kecantikan yang terasa hangat di jiwa.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="soft-section section-pad reveal">
    <div class="container">
        <div class="why-shell">
            <div class="row align-items-end g-4 mb-4 mb-lg-5">
                <div class="col-lg-7">
                    <span class="section-kicker text-white">Mengapa Memilih Kami?</span>
                    <h2 class="why-title mt-3 mb-0">Detail rias yang tenang, matang, dan terasa seperti diri Anda.</h2>
                </div>
                <div class="col-lg-5">
                    <p class="mb-0 text-white-50">
                        Setiap tampilan dirancang lewat konsultasi, produk pilihan, dan pengalaman menangani berbagai kebutuhan acara.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="why-item reveal reveal-delay-1">
                        <span class="why-icon"><i class="bi bi-stars"></i></span>
                        <h5>TIM AHLI & BERPENGALAMAN</h5>
                        <p>Didukung oleh MUA profesional yang berdedikasi menciptakan tampilan impian Anda.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="why-item reveal reveal-delay-2">
                        <span class="why-icon"><i class="bi bi-brush"></i></span>
                        <h5>PRODUK PREMIUM</h5>
                        <p>Menggunakan produk makeup asli & berkualitas tinggi untuk hasil flawless.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="why-item reveal reveal-delay-3">
                        <span class="why-icon"><i class="bi bi-person-check"></i></span>
                        <h5>PERSONALISASI</h5>
                        <p>Konsultasi mendalam untuk menciptakan riasan sesuai karakter Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="gallery" class="section-pad reveal">
    <div class="container">
        <div class="gallery-intro">
            <span class="section-kicker">Gallery</span>
            <h2 class="section-title display-5 mt-3">
                Mengabadikan Keindahan di Setiap Momen Berharga
            </h2>
            <p class="section-copy mb-0">
                Karena setiap detail hari pernikahan Anda adalah kisah yang akan selalu dikenang.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <article class="gallery-card reveal reveal-delay-1">
                    <div class="gallery-img-wrap">
                        <img src="assets/fotomakeup_1.jpeg" class="gallery-img" alt="Gallery Makeup">
                    </div>
                    <div class="gallery-body">
                        <h3>Gallery Makeup</h3>
                        <a href="public/gallery_makeup.php" class="gallery-btn" aria-label="Lihat Gallery Makeup">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </article>
            </div>

            <div class="col-md-4">
                <article class="gallery-card reveal reveal-delay-2">
                    <div class="gallery-img-wrap">
                        <img src="assets/foto_dekor.jpeg" class="gallery-img" alt="Gallery Dekor">
                    </div>
                    <div class="gallery-body">
                        <h3>Gallery Dekor</h3>
                        <a href="public/gallery_dekor.php" class="gallery-btn" aria-label="Lihat Gallery Dekor">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </article>
            </div>

            <div class="col-md-4">
                <article class="gallery-card reveal reveal-delay-3">
                    <div class="gallery-img-wrap">
                        <img src="assets/fotocarnaval2.jpg" class="gallery-img" alt="Gallery Kostum">
                    </div>
                    <div class="gallery-body">
                        <h3>Gallery Kostum</h3>
                        <a href="public/gallery_kostum.php" class="gallery-btn" aria-label="Lihat Gallery Kostum">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/public/include/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const divider = document.querySelector('.animated-divider');
    const revealItems = document.querySelectorAll('.reveal');

    const revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.18 });

    revealItems.forEach(function (item) {
        revealObserver.observe(item);
    });

    if (!divider) return;

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            divider.classList.toggle('is-visible', entry.isIntersecting);
        });
    }, { threshold: 0.45 });

    observer.observe(divider);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
