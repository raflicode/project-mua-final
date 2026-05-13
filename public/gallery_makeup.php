
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Makeup</title>

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
        <img src="assets/foto_muayayuk.jpeg" alt="Wedding">

        <div class="hero-overlay">
            <div>
                <h2 class="hero-title">
                    Keanggunan Abadi untuk Hari Istimewa Anda.
                </h2>

                <p class="hero-desc">
                    Riasan dan penataan rambut pengantin profesional dengan hasil akhir
                    yang sempurna dan alami yang menonjolkan kecantikan sejati Anda.
                </p>
            </div>
        </div>
    </div>

    <!-- Gallery -->
    <section class="mt-5">
        <h4 class="section-title">Galerry Makeup</h4>

        <div class="row g-3">

            <!-- Card 1 -->
            <div class="col-4">
                <div class="gallery-card">
                    <img src="assets/foto_makeup.jpeg" class="gallery-img" alt="Makeup">

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan makeup dengan natural.
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-4">
                <div class="gallery-card">
                    <div class="gallery-placeholder">
                        <i class="bi bi-image"></i>
                        <small>Image</small>
                    </div>

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan makeup dengan natural.
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-4">
                <div class="gallery-card">
                    <div class="gallery-placeholder">
                        <i class="bi bi-image"></i>
                        <small>Image</small>
                    </div>

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan makeup dengan natural.
                    </p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-4">
                <div class="gallery-card">
                    <div class="gallery-placeholder">
                        <i class="bi bi-image"></i>
                        <small>Image</small>
                    </div>

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan makeup dengan natural.
                    </p>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-4">
                <div class="gallery-card">
                    <div class="gallery-placeholder">
                        <i class="bi bi-image"></i>
                        <small>Image</small>
                    </div>

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan makeup dengan natural.
                    </p>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-4">
                <div class="gallery-card">
                    <div class="gallery-placeholder">
                        <i class="bi bi-image"></i>
                        <small>Image</small>
                    </div>

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan makeup dengan natural.
                    </p>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="col-4">
                <div class="gallery-card">
                    <div class="gallery-placeholder">
                        <i class="bi bi-image"></i>
                        <small>Image</small>
                    </div>

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan makeup dengan natural.
                    </p>
                </div>
            </div>

            <!-- Card 8 -->
            <div class="col-4">
                <div class="gallery-card">
                    <div class="gallery-placeholder">
                        <i class="bi bi-image"></i>
                        <small>Image</small>
                    </div>

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan makeup dengan natural.
                    </p>
                </div>
            </div>

            <!-- Card 9 -->
            <div class="col-4">
                <div class="gallery-card">
                    <div class="gallery-placeholder">
                        <i class="bi bi-image"></i>
                        <small>Image</small>
                    </div>

                    <h6 class="blog-title">Blog Posts</h6>
                    <p class="blog-desc">
                        Menawarkan makeup dengan natural.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <div class="footer d-flex justify-content-between align-items-center">
        <p class="footer-text mb-0">@Yayuk Makeover 2025</p>

        <div class="social-icons">
            <i class="bi bi-facebook"></i>
            <i class="bi bi-instagram"></i>
            <i class="bi bi-twitter"></i>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```
