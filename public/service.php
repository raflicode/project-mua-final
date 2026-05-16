<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yayuk Makeover - Pilih Paket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            color: #222;
            padding-top: 80px;
        }

        a { text-decoration: none; }

        .main-container {
            width: 100%;
            max-width: 1400px;
            margin: auto;
            padding: 24px 18px 70px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 45px;
        }

        .section-title h1 {
            font-size: 2.4rem;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 14px;
        }

        .section-title p {
            font-size: .95rem;
            color: #777;
            max-width: 650px;
            margin: auto;
        }

        .service-card {
            background: #fff;
            border-radius: 28px;
            padding: 20px;
            height: 100%;
            box-shadow: 0 10px 28px rgba(0,0,0,.06);
            transition: .25s;
            display: flex;
            flex-direction: column;
        }

        .service-card:hover,
        .wedding-card:hover {
            transform: translateY(-4px);
        }

        .service-img {
            width: 100%;
            height: 320px;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 18px;
            flex-shrink: 0;
            background: #f0f0f0;
        }

        .service-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .service-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .service-list,
        .wedding-card ul {
            padding-left: 18px;
            color: #666;
            margin-bottom: 24px;
            flex: 1;
        }

        .service-list li,
        .wedding-card ul li {
            margin-bottom: 8px;
            font-size: .92rem;
        }

        .service-bottom {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-book {
            flex: 1;
            min-height: 44px;
            border: none;
            border-radius: 999px;
            background: #111;
            color: #fff;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
        }

        .btn-book:hover {
            background: #333;
            color: #fff;
        }

        .btn-cart {
            width: 46px;
            min-width: 46px;
            height: 44px;
            border: none;
            border-radius: 14px;
            background: #f6b437;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            transition: .2s;
        }

        .btn-cart:hover { background: #e0a020; }

        .wedding-section { margin-top: 80px; }

        .wedding-title {
            text-align: center;
            margin-bottom: 35px;
        }

        .wedding-title h2 {
            font-size: 2rem;
            font-weight: 700;
        }

        .wedding-card {
            position: relative;
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            padding: 18px;
            height: 100%;
            box-shadow: 0 12px 30px rgba(0,0,0,.08);
            display: flex;
            flex-direction: column;
            transition: .25s;
        }

        .wedding-image {
            width: 100%;
            height: 280px;
            border-radius: 22px;
            overflow: hidden;
            margin-bottom: 20px;
            flex-shrink: 0;
            background: #f0f0f0;
        }

        .wedding-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .wedding-label {
            position: absolute;
            top: 28px;
            left: 28px;
            padding: 8px 18px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .08em;
            z-index: 1;
        }

        .silver-label { background: #e7e7e7; color: #666; }
        .gold-label { background: #f6b437; color: #fff; }

        .wedding-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .silver-card { border: 2px solid #ececec; }

        .gold-card {
            border: 2px solid #f6b437;
            box-shadow: 0 0 25px rgba(246,180,55,.25);
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
            box-shadow: 0 10px 25px rgba(0,0,0,.18);
        }

        .btn-kembali:hover {
            background: #d94333;
            color: white;
        }

        @media(max-width: 767px) {
            body { padding-top: 90px; }
            .section-title h1 { font-size: 2rem; }
            .service-img { height: 180px; }
            .wedding-image { height: 200px; }
            .main-container { padding: 20px 14px 80px; }
            .btn-kembali {
                left: 16px;
                bottom: 16px;
                padding: 9px 16px;
            }
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="main-container">
    <div class="section-title">
        <h1>Pilih paket yang sesuai <br>dengan tujuan Anda.</h1>
        <p>Pilih layanan terbaik dari Yayuk Makeover untuk membuat acara spesial Anda semakin elegan dan berkesan.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="service-card">
                <div class="service-img">
                    <img src="../assets/gallery_makeup/makeup_1.jpeg" alt="Makeup Wedding">
                </div>
                <h3 class="service-title">Makeup Wedding</h3>
                <ul class="service-list">
                    <li>Wedding Akad</li>
                    <li>Wedding Resepsi</li>
                    <li>Graduation</li>
                    <li>Natural look</li>
                    <li>Touch Up Wedding</li>
                </ul>
                <div class="service-bottom">
                    <a class="btn-book" href="makeup.php">Lihat Lebih Banyak</a>
                    <button class="btn-cart" type="button" onclick="addToCart('Makeup Wedding', 'makeup', 2500000)">
                        <i class="bi bi-bag-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="service-card">
                <div class="service-img">
                    <img src="../assets/gallery_makeup/makeup_1.jpeg" alt="Wedding Kostum">
                </div>
                <h3 class="service-title">Wedding Kostum</h3>
                <ul class="service-list">
                    <li>Kostum Wedding</li>
                    <li>Kostum Graduation</li>
                    <li>Baju Adat</li>
                    <li>Kostum Karnaval</li>
                    <li>Aksesoris Lengkap</li>
                </ul>
                <div class="service-bottom">
                    <a class="btn-book" href="kostum.php">Lihat Lebih Banyak</a>
                    <button class="btn-cart" type="button" onclick="addToCart('Wedding Kostum', 'kostum', 4000000)">
                        <i class="bi bi-bag-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="service-card">
                <div class="service-img">
                    <img src="../assets/gallery_makeup/makeup_1.jpeg" alt="Dekor/Terop">
                </div>
                <h3 class="service-title">Dekor/Terop</h3>
                <ul class="service-list">
                    <li>Outdoor</li>
                    <li>Indoor</li>
                    <li>Dekor Pelaminan</li>
                    <li>Photo Booth</li>
                    <li>Lighting Wedding</li>
                </ul>
                <div class="service-bottom">
                    <a class="btn-book" href="dekor.php">Lihat Lebih Banyak</a>
                    <button class="btn-cart" type="button" onclick="addToCart('Dekor/Terop', 'dekor', 6500000)">
                        <i class="bi bi-bag-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="wedding-section">
        <div class="wedding-title">
            <h2>Paket Wedding</h2>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="wedding-card silver-card">
                    <div class="wedding-label silver-label">SILVER</div>
                    <div class="wedding-image">
                        <img src="../assets/gallery_makeup/makeup_1.jpeg" alt="Paket Silver">
                    </div>
                    <h3>Paket Silver</h3>
                    <ul>
                        <li>Makeup Wedding</li>
                        <li>Kostum Wedding</li>
                        <li>Dekor Basic</li>
                        <li>Hairdo Elegant</li>
                    </ul>
                    <div class="service-bottom">
                        <a class="btn-book" href="paket_silver.php">Booking</a>
                        <button class="btn-cart" type="button" onclick="addToCart('Paket Silver', 'paket', 10000000)">
                            <i class="bi bi-bag-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="wedding-card gold-card">
                    <div class="wedding-label gold-label">GOLD</div>
                    <div class="wedding-image">
                        <img src="../assets/gallery_makeup/makeup_1.jpeg" alt="Paket Gold">
                    </div>
                    <h3>Paket Gold</h3>
                    <ul>
                        <li>Makeup Premium</li>
                        <li>Kostum Exclusive</li>
                        <li>Dekor Full Wedding</li>
                        <li>Photo Booth + Lighting</li>
                    </ul>
                    <div class="service-bottom">
                        <a class="btn-book" href="paket_gold.php">Booking</a>
                        <button class="btn-cart" type="button" onclick="addToCart('Paket Gold', 'paket', 18000000)">
                            <i class="bi bi-bag-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="javascript:history.back()" class="btn btn-kembali">Kembali</a>

<div class="modal fade" id="modalAuth" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <h5 class="mb-3">Belum Login</h5>
            <p>Kamu harus login atau register dulu sebelum booking</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="login.php" class="btn btn-dark">Login</a>
                <a href="register.php" class="btn btn-primary">Register</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

    document.querySelectorAll('.btn-booking-trigger').forEach(btn => {
        btn.addEventListener('click', function () {
            if (!isLoggedIn) {
                new bootstrap.Modal(document.getElementById('modalAuth')).show();
                return;
            }

            window.location.href = this.dataset.href;
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.navbar *').forEach(el => {
            if (el.children.length === 0 && el.textContent.trim().toLowerCase().includes('yayuk')) {
                const parent = el.closest('.nav-item, .navbar-brand, li, a, span, div');
                if (parent) parent.remove();
            }
        });

        document.querySelectorAll(
            '.navbar-toggler, [data-bs-toggle="dropdown"] .bi-three-dots, [data-bs-toggle="dropdown"] .bi-three-dots-vertical'
        ).forEach(el => {
            const parent = el.closest('.nav-item, button, .dropdown') || el;
            parent.remove();
        });
    });

    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 10);
    });
</script>
<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>
