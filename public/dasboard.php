<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Eternal Beauty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; color: #4a4a4a; }
        h1, h2, h3, .serif { font-family: 'Playfair Display', serif; }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('assets/foto_muayayuk.jpeg');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            border-radius: 0 0 20px 20px;
            margin: 0 15px;
        }

        .btn-booking {
            border: 2px solid white;
            color: white;
            padding: 10px 40px;
            border-radius: 30px;
            text-transform: uppercase;
            background: rgba(255,255,255,0.1);
            transition: 0.3s;
        }

        .btn-booking:hover {
            background: white;
            color: #333333;
        }

        .custom-shape {
    /* Format: Top-Left | Top-Right | Bottom-Right | Bottom-Left */
    border-radius: 150px 0px 150px 0px; 
    object-fit: cover;
    border: 10px solid #f8f9fa;
}

        /* Gallery Cards */
        .gallery-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .gallery-card:hover { transform: translateY(-10px); }
        .gallery-img { height: 400px; object-fit: cover; }
        
        .section-title { color: #b5835a; }
    </style>
</head>
<body>
  <?php include 'public/include/navbar.php'; ?>

    <header class="hero-section shadow">
        <div class="container">
            <h1 class="display-4 fw-bold">Keanggunan Abadi untuk Hari Istimewa Anda.</h1>
            <p class="lead mb-4">Riasan dan penataan rambut pengantin profesional dengan hasil akhir<br>yang sempurna dan alami untuk menonjolkan kecantikan sejati Anda.</p>
            <a href="#booking" class="btn btn-booking">Booking</a>
        </div>
    </header>
    <section class="py-5 container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <h2 class="section-title h1 mb-4">Merajut Kenangan <br> dalam Setiap Sentuhan</h2>
                <hr style="width: 100px; border: 2px solid #b5835a; opacity: 1;">
                <p class="mt-4">Perjalanan Yayuk Makeover tumbuh bersama ribuan senyum dan cerita bahagia dari para pasangan yang telah menjadi bagian dari keluarga kami.</p>
                <p>Kami memahami bahwa pernikahan adalah momen sekali seumur hidup yang penuh dengan detail dan harapan. Itulah mengapa kami menganggap setiap klien sebagai mitra dalam berkarya.</p>
                <p>Melalui diskusi yang mendalam dan sentuhan profesional, kita akan merajut sebuah kisah kecantikan yang tidak hanya terlihat indah di mata, tetapi juga terasa hangat di jiwa.</p>
            </div>
            <div class="col-lg-5 text-center">
                <img src="assets/bg_log.jpeg" class="img-fluid custom-shape shadow-lg" alt="Yayuk">
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container text-center">
            <h3 class="fw-bold mb-5">MENGAPA MEMILIH KAMI?</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <i class="bi bi-stars fs-1 text-muted mb-3"></i>
                    <h5 class="fw-bold">TIM AHLI & BERPENGALAMAN</h5>
                    <p class="small text-muted">Didukung oleh MUA & penata gaya profesional yang berdedikasi menciptakan tampilan impian Anda dengan teknik terkini.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-brush fs-1 text-muted mb-3"></i>
                    <h5 class="fw-bold">PRODUK PREMIUM BERKUALITAS</h5>
                    <p class="small text-muted">Kami hanya menggunakan produk makeup asli & berkualitas tinggi untuk hasil riasan yang flawless, tahan lama, dan aman untuk kulit.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-person-check fs-1 text-muted mb-3"></i>
                    <h5 class="fw-bold">RIASAN PERSONALISASI (CUSTOM)</h5>
                    <p class="small text-muted">Konsultasi mendalam untuk memahami gaya dan karakter Anda, menciptakan riasan yang benar-benar memancarkan kecantikan alami Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 container text-center">
        <h2 class="section-title h1">Mengabadikan Keindahan di Setiap Momen Berharga</h2>
        <p class="text-muted mb-5">Karena setiap detail hari pernikahan Anda adalah kisah yang akan selalu dikenang.</p>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card gallery-card shadow-sm">
                    <img src="assets/foto_makeup.jpeg" class="card-img-top gallery-img" alt="Gallery Makeup">
                    <div class="card-body">
                        <h6 class="fw-bold">Gallery Makeup</h6>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-4">LIHAT</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card gallery-card shadow-sm">
                    <img src="assets/foto_dekor.jpeg" class="card-img-top gallery-img" alt="Gallery Dekor">
                    <div class="card-body">
                        <h6 class="fw-bold">Gallery Dekor</h6>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-4">LIHAT</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card gallery-card shadow-sm">
                    <img src="assets/foto_kostum.jpeg" class="card-img-top gallery-img" alt="Gallery Kostum">
                    <div class="card-body">
                        <h6 class="fw-bold">Gallery Kostum</h6>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-4">LIHAT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 border-top">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <p class="text-muted small mb-0">&copy; Yayuk Makeover 2026</p>
            <div class="social-icons">
                <a href="#" class="text-muted me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-muted me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-muted"><i class="bi bi-twitter-x"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>