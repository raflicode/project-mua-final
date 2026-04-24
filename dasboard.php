<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover — Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --gold-primary: #c8a96e; /* Warna Emas Utama */
            --text-dark: #333333;
            --text-muted: #777777;
        }
        
        body { font-family: 'Inter', sans-serif; color: var(--text-dark); background-color: #ffffff; overflow-x: hidden; }
        
        /* Font khusus untuk judul agar mirip desain */
        .playfair { font-family: 'Playfair Display', serif; }
        
        /* 1. HERO SECTION CUSTOM */
        .hero-section {
            position: relative;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), 
                        url('https://images.unsplash.com/photo-1591604466107-dd9ba3373468?q=80&w=1600') center/cover no-repeat;
            min-height: 80vh; /* Sedikit lebih pendek dari full screen */
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
        }
        
        .hero-title {
            font-size: 3.5rem; /* Ukuran besar */
            line-height: 1.2;
            font-weight: 700;
        }
        
        .hero-sub {
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.9;
        }
        
        .btn-booking {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 12px 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-booking:hover {
            background-color: white;
            color: black;
        }

        /* 2. ABOUT SECTION CUSTOM */
        .about-title {
            color: #b18e61; /* Warna coklat keemasan */
            font-weight: 700;
        }

        .decorative-line {
            width: 100px;
            height: 2px;
            background-color: #ddd;
            margin-bottom: 30px;
        }

        .about-text {
            color: var(--text-dark);
            line-height: 1.8;
            font-size: 0.95rem;
        }

        /* Gambar dengan sudut melengkung khusus (top-left & bottom-right) */
        .about-img {
            border-top-left-radius: 80px;
            border-bottom-right-radius: 80px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }

        /* 3. WHY CHOOSE US (Fitur) */
        .feature-icon {
            font-size: 3rem;
            color: #333;
            margin-bottom: 20px;
        }

        .feature-card h5 {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .feature-card p {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.7;
        }

        /* 4. GALLERY SECTION CUSTOM */
        .gallery-title {
            color: #b18e61;
            font-weight: 700;
        }

        .gallery-card {
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }

        .gallery-img {
            transition: transform 0.5s ease;
        }

        .gallery-card:hover .gallery-img {
            transform: scale(1.05); /* Sedikit zoom saat hover */
        }

        .gallery-label {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            color: white;
            padding: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* RESPONSIVE ADJUSTMENTS */
        @media (max-width: 768px) {
            .hero-title { font-size: 2.2rem; }
            .about-img { max-height: 400px; object-fit: cover; width: 100%; }
        }
    </style>
</head>
<body>

<?php require 'public/include/navbar.php'; ?>

<header class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="hero-title playfair mb-3">Keanggunan Abadi untuk Hari Istimewa Anda.</h1>
                <p class="hero-sub lead mb-5 fs-6">Riasan dan penataan rambut pengantin profesional dengan hasil akhir yang sempurna dan alami, menonjolkan kecantikan sejati Anda.</p>
                <a href="#" class="btn btn-booking rounded-0">Booking</a>
            </div>
        </div>
    </div>
</header>

<section id="about" class="py-5 my-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 order-2 order-lg-1">
                <h2 class="display-6 about-title playfair mb-1">Merajut Kenangan</h2>
                <h2 class="display-6 about-title playfair mb-3">dalam Setiap Sentuhan</h2>
                
                <div class="decorative-line"></div>
                
                <div class="about-text fw-light">
                    <p class="mb-3">Perjalanan Yayuk Makeover tumbuh bersama ribuan senyum dan cerita bahagia dari para pasangan yang telah menjadi bagian dari keluarga kami.</p>
                    <p class="mb-3">Kami memahami bahwa pernikahan adalah momen sekali seumur hidup yang penuh dengan detail dan harapan. Itulah mengapa kami menganggap setiap klien sebagai mitra dalam berkarya.</p>
                    <p>Melalui diskusi yang mendalam dan sentuhan profesional yang personal, kita akan merajut sebuah kisah kecantikan yang tidak hanya terlihat indah di mata, tetapi juga terasa hangat di jiwa, menciptakan kenangan abadi yang akan terus diceritakan hingga generasi mendatang.</p>
                </div>
            </div>
            <div class="col-lg-5 order-1 order-lg-2 text-center">
                <img src="assets/bg_log.jpeg" alt="MUA Yayuk" class="img-fluid about-img">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h6 class="text-uppercase fw-bold text-muted mb-2" style="letter-spacing: 2px;">MENGAPA MEMILIH KAMI?</h6>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4 feature-card">
                <div class="p-4 h-100 bg-white shadow-sm rounded">
                    <div class="feature-icon">💄</div>
                    <h5 class="mb-3">TIM AHLI & BERPENGALAMAN</h5>
                    <p class="mb-0">Didukung oleh tim MUA & penata gaya profesional yang berdedikasi menciptakan tampilan impian Anda dengan teknik terkini.</p>
                </div>
            </div>
            <div class="col-md-4 feature-card">
                <div class="p-4 h-100 bg-white shadow-sm rounded">
                    <div class="feature-icon">✨</div>
                    <h5 class="mb-3">PRODUK PREMIUM BERKUALITAS</h5>
                    <p class="mb-0">Kami hanya menggunakan produk makeup asli & berkualitas tinggi untuk hasil riasan yang flawless, tahan lama, dan aman untuk kulit.</p>
                </div>
            </div>
            <div class="col-md-4 feature-card">
                <div class="p-4 h-100 bg-white shadow-sm rounded">
                    <div class="feature-icon">👩‍💼</div>
                    <h5 class="mb-3">RIASAN PERSONALISASI (CUSTOM)</h5>
                    <p class="mb-0">Konsultasi mendalam untuk memahami gaya dan karakter Anda, menciptakan riasan yang benar-benar memancarkan kecantikan alami Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 my-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 gallery-title playfair mb-3">Mengabadikan Keindahan di Setiap Momen Berharga</h2>
            <p class="text-muted mx-auto" style="max-width: 650px;">Karena setiap detail hari pernikahan Anda adalah kisah yang akan selalu dikenang. Lihat bagaimana kami membantu pengantin memancarkan aura terbaik mereka.</p>
        </div>
        
        <div class="row g-3">
            <div class="col-md-4 col-6">
                <div class="card gallery-card rounded-0">
                    <img src="https://images.unsplash.com/photo-1591604466107-dd9ba3373468?w=500" class="card-img-top gallery-img rounded-0" alt="Gallery Makeup">
                    <div class="gallery-label">Gallery Makeup</div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="card gallery-card rounded-0">
                    <img src="https://images.unsplash.com/photo-1522413452208-996ff3f3e740?w=500" class="card-img-top gallery-img rounded-0" alt="Gallery Dekor">
                    <div class="gallery-label">Gallery Dekor</div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card gallery-card rounded-0">
                    <img src="https://images.unsplash.com/photo-1603189863062-df89a8c7a530?w=500" class="card-img-top gallery-img rounded-0" alt="Gallery Kostum">
                    <div class="gallery-label">Gallery Kostum</div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>