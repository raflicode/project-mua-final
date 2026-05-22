<?php
session_start();

// Kita kumpulkan semua data foto dekorasi ke dalam array PHP agar sinkron dengan JavaScript lightbox
$dekor_photos = [
    ['src' => '../assets/fotodekor1.png', 'title' => 'Model Klasik Warm'],
    ['src' => '../assets/fotodekor2.png', 'title' => 'Model Modern White'],
    ['src' => '../assets/fotodekor3.png', 'title' => 'Model Rustic Elegan'],
    ['src' => '../assets/fotodekor4.png', 'title' => 'Model Modern Rustic'],
    ['src' => '../assets/fotodekor5.png', 'title' => 'Model Elegan Lux'],
    ['src' => '../assets/fotodekor6.jpeg', 'title' => 'Model Rustic Elegan'],
    ['src' => '../assets/fotodekor7.jpeg', 'title' => 'Model Rustic Elegan'],
    ['src' => '../assets/fotodekor8.jpeg', 'title' => 'Model Rustic Elegan'],
    ['src' => '../assets/fotodekor9.jpeg', 'title' => 'Model Rustic Elegan'],
    ['src' => '../assets/fotodekor10.jpeg', 'title' => 'Model Rustic Elegan'],
    ['src' => '../assets/fotodekor11.jpeg', 'title' => 'Model Rustic Elegan'],
    ['src' => '../assets/fotodekor12.jpeg', 'title' => 'Model Rustic Elegan'],
    ['src' => '../assets/fotodekor13.jpeg', 'title' => 'Dekor Outdoor 4 Meter'],
    ['src' => '../assets/fotodekor14.jpeg', 'title' => 'Dekor Outdoor 6 Meter'],
    ['src' => '../assets/fotodekor15.jpeg', 'title' => 'Dekor Outdoor 8 Meter'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dekor - Yayuk Makeover</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f6f0;
        }

        /* Judul */
        .judul h1 {
            font-family: 'Lobster', cursive;
            font-size: 70px;
            color: #513c2c;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .line {
            width: 150px;
            height: 3px;
            background: #513c2c;
            margin: auto;
            border-radius: 2px;
        }

        .sub-section-title {
            color: #513c2c;
            font-weight: 700;
            position: relative;
            padding-bottom: 8px;
        }

        /* Card Custom */
        .card-custom {
            border: none;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(81, 60, 44, 0.08);
            transition: 0.3s;
            background: #ffffff;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        .card-custom ul {
            padding-left: 0;
            list-style: none;
        }

        .card-custom ul li {
            margin-bottom: 8px;
            color: #555;
        }

        .card-custom ul li::before {
            content: "✓ ";
            font-weight: bold;
            color: #586842;
        }

        /* Tombol & Aksi */
        .btn-booking {
            height: 45px;
            border-radius: 30px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            background-color: #513c2c;
            border: none;
            color: white;
        }
        .btn-booking:hover {
            background-color: #36251b;
        }

        .btn-cart-icon {
            width: 45px;
            height: 45px;
            background-color: #d1beaa;
            color: #513c2c;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            border: none;
            flex-shrink: 0;
            font-size: 20px;
            transition: 0.2s;
        }
        .btn-cart-icon:hover {
            background-color: #513c2c;
            color: white;
        }

        /* Gambar */
        .img-paket-thumbnail {
            width: 100%;
            height: 360px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: transform 0.3s ease, opacity 0.2s;
        }
        .img-paket-thumbnail:hover {
            transform: scale(1.02);
            opacity: 0.95;
        }

        .btn-kembali {
            position: fixed;
            bottom: 20px;
            left: 20px;
            border-radius: 30px;
            padding: 10px 25px;
            background-color: #db5246;
            border: none;
            z-index: 999;
        }

        /* STYLING CUSTOM LIGHTBOX SEPERTI HALAMAN GALLERY */
        .lightbox { 
            display: none; 
            position: fixed; 
            inset: 0; 
            z-index: 2000; /* Di atas elemen apapun */
            background: rgba(0,0,0,0.92); 
            align-items: center; 
            justify-content: center; 
        }
        .lightbox.show { display: flex; }
        .lightbox-img { max-width: 90vw; max-height: 85vh; border-radius: 12px; object-fit: contain; }
        .lightbox-close { position: absolute; top: 16px; right: 20px; background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 50%; width: 42px; height: 42px; font-size: 1.3rem; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .lightbox-prev, .lightbox-next { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 50%; width: 46px; height: 46px; font-size: 1.3rem; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .lightbox-prev { left: 14px; }
        .lightbox-next { right: 14px; }
        .lightbox-counter { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); color: rgba(255,255,255,0.7); font-size: 0.8rem; }

        @media(max-width:768px){
            .judul h1{ font-size:55px; }
            .img-paket-thumbnail { height: 260px; }
        }
    </style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<div class="container py-5">

    <div class="text-center mb-5 judul">
        <h1>Dekor</h1>
        <div class="line mt-2"></div>
    </div>

    <div class="mb-5">
        <h3 class="sub-section-title mb-2"><i class="bi bi-house-door-fill me-2"></i> 1. Dekorasi Indoor (Pilihan Contoh Foto)</h3>
        <p class="text-muted small mb-4">Berikut beberapa contoh pilihan dekorasi dalam ruangan (Klik foto untuk memperbesar & geser)</p>
        
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3 text-center" onclick="openLightbox(0)">
                    <img src="<?= $dekor_photos[0]['src'] ?>" class="img-paket-thumbnail" alt="Indoor Model A">
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 text-center" onclick="openLightbox(1)">
                    <img src="<?= $dekor_photos[1]['src'] ?>" class="img-paket-thumbnail" alt="Indoor Model B">
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 text-center" onclick="openLightbox(2)">
                    <img src="<?= $dekor_photos[2]['src'] ?>" class="img-paket-thumbnail" alt="Indoor Model C">
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 text-center" onclick="openLightbox(3)">
                    <img src="<?= $dekor_photos[3]['src'] ?>" class="img-paket-thumbnail" alt="Indoor Model D">
                </div>
            </div>
        </div>

        <div class="card card-custom p-4">
            <h5 class="fw-bold text-dark mb-3">Detail Paket Dekorasi Indoor</h5>
            <p class="fw-semibold mb-2">Include :</p>
            <ul class="mb-4">
                <li>Makeup, Softlens, & Hairdo</li>
                <li>Set Panggung & Background Bunga Kapas/Sutra (Bebas Pilih Model Di Atas)</li>
                <li>Set Kursi Pelaminan Eksklusif</li>
                <li>Karpet Jalan & Lampu Sorot Panggung Standar</li>
            </ul>

            <div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-4">
                <span class="fw-bold fs-4" style="color: #513c2c;">Rp 1.000.000</span>
            </div>

            <div class="d-flex gap-2">
                <button onclick="addToCart('Dekor Indoor', 'dekor', 1000000, '../assets/foto_dekor.jpeg')" class="btn-cart-icon">🛒</button>
                <a href="booking.php?from=dekor&nama=Dekor+Indoor&harga=1000000" class="btn btn-booking flex-grow-1 btn-booking-trigger">
                    Booking 
                </a>
            </div>
        </div>
    </div>

    <hr class="my-5" style="border-top: 2px dashed #d1beaa;">

    <div>
        <h3 class="sub-section-title mb-2"><i class="bi bi-tree-fill me-2"></i> 2. Dekorasi Outdoor (Pilihan Ukuran Panggung)</h3>
        <p class="text-muted small mb-4">Pilih paket dekorasi luar ruangan dengan variasi ukuran panjang panggung yang paling pas untuk area acara Anda:</p>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-custom h-100 p-3">
                    <img src="<?= $dekor_photos[13]['src'] ?>" class="img-paket-thumbnail" alt="Dekor Outdoor 4 Meter" onclick="openLightbox(13)">
                    <div class="card-body p-1 d-flex flex-column">
                        <h6 class="fw-bold text-dark">Dekor Outdoor — Ukuran 4 Meter</h6>
                        <ul class="small my-2 flex-grow-1">
                            <li>Set Background Luar Ruangan 4m</li>
                            <li>Set Kursi Pelaminan & Gate</li>
                            <li>Lighting Sorot Taman</li>
                        </ul>
                        <div class="text-end mb-3">
                            <span class="fw-bold" style="font-size: 1.2rem; color: #513c2c;">Rp 2.000.000</span>
                        </div>
                        <div class="d-flex gap-2 mt-auto">
                            <button onclick="addToCart('Dekor Outdoor (4 Meter)', 'dekor', 2000000, '../assets/fotodekor13.jpeg')" class="btn-cart-icon">🛒</button>
                            <a href="booking.php?from=dekor&nama=Dekor+Outdoor+(4+Meter)&harga=2000000" class="btn btn-booking flex-grow-1 btn-booking-trigger">Booking 4m</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom h-100 p-3">
                    <img src="<?= $dekor_photos[14]['src'] ?>" class="img-paket-thumbnail" alt="Dekor Outdoor 6 Meter" onclick="openLightbox(14)">
                    <div class="card-body p-1 d-flex flex-column">
                        <h6 class="fw-bold text-dark">Dekor Outdoor — Ukuran 6 Meter</h6>
                        <ul class="small my-2 flex-grow-1">
                            <li>Set Background Luar Ruangan 6m</li>
                            <li>Set Kursi Pelaminan Mewah & Gate</li>
                            <li>Lighting Sorot Taman Tambahan</li>
                        </ul>
                        <div class="text-end mb-3">
                            <span class="fw-bold" style="font-size: 1.2rem; color: #513c2c;">Rp 3.000.000</span>
                        </div>
                        <div class="d-flex gap-2 mt-auto">
                            <button onclick="addToCart('Dekor Outdoor (6 Meter)', 'dekor', 3000000, '../assets/fotodekor14.jpeg')" class="btn-cart-icon">🛒</button>
                            <a href="booking.php?from=dekor&nama=Dekor+Outdoor+(6+Meter)&harga=3000000" class="btn btn-booking flex-grow-1 btn-booking-trigger">Booking 6m</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom h-100 p-3">
                    <img src="<?= $dekor_photos[7]['src'] ?>" class="img-paket-thumbnail" alt="Dekor Outdoor 8 Meter" onclick="openLightbox(7)">
                    <div class="card-body p-1 d-flex flex-column">
                        <h6 class="fw-bold text-dark">Dekor Outdoor — Ukuran 8 Meter</h6>
                        <ul class="small my-2 flex-grow-1">
                            <li>Set Background Luar Ruangan Full 8m</li>
                            <li>Set Kursi Pelaminan & Gate Premium</li>
                            <li>Lighting Sorot Taman Kategori Luas</li>
                        </ul>
                        <div class="text-end mb-3">
                            <span class="fw-bold" style="font-size: 1.2rem; color: #513c2c;">Rp 4.500.000</span>
                        </div>
                        <div class="d-flex gap-2 mt-auto">
                            <button onclick="addToCart('Dekor Outdoor (8 Meter)', 'dekor', 4500000, '../assets/fotodekor15.jpeg')" class="btn-cart-icon">🛒</button>
                            <a href="booking.php?from=dekor&nama=Dekor+Outdoor+(8+Meter)&harga=4500000" class="btn btn-booking flex-grow-1 btn-booking-trigger">Booking 8m</a>
                        </div>
                    </div>
                </div>
            </div>
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

<a href="service.php" class="btn btn-danger btn-kembali shadow">Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Parsing data array gambar dari PHP ke variabel JavaScript 
    const photos = <?= json_encode($dekor_photos) ?>;
    let current = 0;

    function openLightbox(i) { 
        current = i; 
        updateLightbox(); 
        document.getElementById('lightbox').classList.add('show'); 
        document.body.style.overflow = 'hidden'; 
    }

    function closeLightbox() { 
        document.getElementById('lightbox').classList.remove('show'); 
        document.body.style.overflow = ''; 
    }

    function closeLightboxOutside(e) { 
        if (e.target === document.getElementById('lightbox')) closeLightbox(); 
    }

    function changePhoto(d) { 
        current = (current + d + photos.length) % photos.length; 
        updateLightbox(); 
    }

    function updateLightbox() { 
        document.getElementById('lightboxImg').src = photos[current].src; 
        document.getElementById('lightboxCounter').textContent = (current + 1) + ' / ' + photos.length; 
    }

    // Navigasi via keyboard panah kiri, kanan dan tombol esc
    document.addEventListener('keydown', e => { 
        const lb = document.getElementById('lightbox'); 
        if (!lb.classList.contains('show')) return; 
        if (e.key === 'ArrowLeft') changePhoto(-1); 
        if (e.key === 'ArrowRight') changePhoto(1); 
        if (e.key === 'Escape') closeLightbox(); 
    });

    // Sistem Proteksi Login Tombol Booking
    const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;
    document.querySelectorAll('.btn-booking-trigger').forEach(btn => {
        btn.addEventListener('click', function(e){
            if (!isLoggedIn) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Login diperlukan',
                    text: 'Silakan login atau register terlebih dahulu sebelum melakukan booking.',
                    showCancelButton: true,
                    confirmButtonText: 'Login',
                    cancelButtonText: 'Register',
                    reverseButtons: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.php';
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = 'register.php';
                    }
                });
            }
        });
    });
</script>

<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>