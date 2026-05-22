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
    ['src' => '../assets/4meter.png', 'title' => 'Dekor Outdoor 4 Meter'],
    ['src' => '../assets/6meter.jpg', 'title' => 'Dekor Outdoor 6 Meter'],
    ['src' => '../assets/foto8m.jpg', 'title' => 'Dekor Outdoor 8 Meter'],
];
>>>>>>> d396eaa (backup dekor sebelum pull)
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dekorasi & Terop - Yayuk Makeover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
*{
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#efefef;
    color:#222;
}

.page-wrap{
    padding-top:95px;
    padding-bottom:80px;
}

.judul h1{
    font-family:'Lobster',cursive;
    font-size:70px;
    color:#b85a00;
    text-shadow:3px 3px 6px rgba(0,0,0,.25);
}

.line{
    width:220px;
    height:2px;
    background:#b85a00;
    margin:auto;
}

/* CARD */
.card-custom{
    border:none;
    border-radius:18px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 5px 15px rgba(0,0,0,.12);
    transition:.3s;
    height:100%;
    cursor:pointer;
}

.card-custom:hover{
    transform:translateY(-5px);
}

.card-body{
    display:flex;
    flex-direction:column;
    height:100%;
}

.img-paket-wrap{
    width:100%;
    aspect-ratio:16/10; /* Dekorasi menggunakan landscape agar terlihat lebih luas */
    overflow:hidden;
    border-radius:12px;
    margin-bottom:14px;
    background:#f3f3f3;
}

.img-paket-wrap img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.include-ol{
    padding-left:20px;
    margin-bottom:14px;
    color:#555;
    font-size:.88rem;
    flex-grow:1;
}

.include-ol li{
    margin-bottom:5px;
}

.harga-label{
    font-size:.75rem;
    color:#999;
    margin-bottom:2px;
}

.harga-text{
    font-weight:700;
    color:#b85a00;
    font-size:1rem;
}

.variant-count{
    display:inline-block;
    background:#fff3e0;
    color:#b85a00;
    border:1px solid #f0c080;
    border-radius:20px;
    padding:3px 12px;
    font-size:.72rem;
    margin-bottom:12px;
}

/* MODAL */
.modal-dekor .modal-dialog{
    max-width:550px;
}

.modal-dekor .modal-content{
    border:none;
    border-radius:22px;
    overflow:hidden;
}

.modal-dekor .modal-header{
    background:#b85a00;
    border:none;
    padding:16px 18px;
    flex-direction:column;
    align-items:stretch;
}

.modal-level1{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
}

.modal-title{
    color:#fff;
    font-size:1.1rem;
    font-weight:700;
    text-align:center;
}

.counter1{
    text-align:center;
    color:rgba(255,255,255,.75);
    font-size:.72rem;
    margin-top:3px;
}

.nav-btn{
    width:34px;
    height:34px;
    border:none;
    border-radius:50%;
    background:rgba(255,255,255,.18);
    color:#fff;
    cursor:pointer;
    transition:.2s;
}

.nav-btn:hover{
    background:rgba(255,255,255,.35);
}

.modal-level2-bar{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin-top:12px;
    padding-top:10px;
    border-top:1px solid rgba(255,255,255,.25);
}

.var-btn{
    width:28px;
    height:28px;
    border:none;
    border-radius:50%;
    background:rgba(255,255,255,.18);
    color:#fff;
    cursor:pointer;
}

.var-label{
    flex:1;
    text-align:center;
    color:#fff;
    font-size:.82rem;
    font-weight:600;
}

.counter2{
    color:rgba(255,255,255,.7);
    font-size:.7rem;
}

.modal-dekor .modal-body{
    padding:18px 20px 8px;
}

.variant-dots{
    display:flex;
    justify-content:center;
    gap:6px;
    margin-bottom:10px;
}

.variant-dot{
    width:8px;
    height:8px;
    border-radius:50%;
    background:#ddd;
}

.variant-dot.active{
    background:#b85a00;
    transform:scale(1.25);
}

.modal-img-wrap{
    width:100%;
    aspect-ratio:16/10;
    overflow:hidden;
    border-radius:14px;
    margin-bottom:14px;
    background:#f3f3f3;
    position:relative;
}

.modal-img-wrap img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.foto-nav{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    width:34px;
    height:34px;
    border:none;
    border-radius:50%;
    background:rgba(0,0,0,.35);
    color:#fff;
    z-index:10;
}

.foto-prev{
    left:10px;
}

.foto-next{
    right:10px;
}

.modal-var-name{
    font-size:1rem;
    font-weight:700;
    margin-bottom:6px;
}

.modal-include-label{
    font-size:.88rem;
    font-weight:600;
    margin-bottom:6px;
}

.modal-include-ol{
    padding-left:20px;
    font-size:.88rem;
    color:#444;
    margin-bottom:14px;
}

.modal-harga-label{
    font-size:.75rem;
    color:#999;
}

.modal-harga-val{
    font-size:1.08rem;
    color:#b85a00;
    font-weight:700;
}

.modal-dekor .modal-footer{
    border:none;
    padding:0 20px 18px;
    gap:10px;
}

.btn-kembali{
    position:fixed;
    bottom:20px;
    left:20px;
    border-radius:30px;
    padding:10px 20px;
    z-index:1000;
}

@media(max-width:768px){
    .judul h1{
        font-size:54px;
    }
}
</style>
</head>
<body>

<?php include 'include/navbar.php'; ?>

<<<<<<< HEAD
<main class="page-wrap">
<div class="container">
=======
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
                <a href="booking.php?from=dekor&nama=Dekor+Indoor&harga=1000000&foto=<?= urlencode($dekor_photos[0]['src']) ?>" class="btn btn-booking flex-grow-1 btn-booking-trigger">
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
                            <button onclick="addToCart('Dekor Outdoor (4 Meter)', 'dekor', 2000000, '../assets/4meter.png ')" class="btn-cart-icon">🛒</button>
                            <a href="booking.php?from=dekor&nama=Dekor+Outdoor+(4+Meter)&harga=2000000&foto=<?= urlencode($dekor_photos[13]['src']) ?>" class="btn btn-booking flex-grow-1 btn-booking-trigger">Booking 4m</a>
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
                            <button onclick="addToCart('Dekor Outdoor (6 Meter)', 'dekor', 3000000, '../assets/6meter.jpg')" class="btn-cart-icon">🛒</button>
                            <a href="booking.php?from=dekor&nama=Dekor+Outdoor+(6+Meter)&harga=3000000&foto=<?= urlencode($dekor_photos[14]['src']) ?>" class="btn btn-booking flex-grow-1 btn-booking-trigger">Booking 6m</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom h-100 p-3">
                    <img src="<?= $dekor_photos[14]['src'] ?>" class="img-paket-thumbnail" alt="Dekor Outdoor 8 Meter" onclick="openLightbox(14)">
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
                            <button onclick="addToCart('Dekor Outdoor (8 Meter)', 'dekor', 4500000, '../assets/foto8m.jpg')" class="btn-cart-icon">🛒</button>
                            <a href="booking.php?from=dekor&nama=Dekor+Outdoor+(8+Meter)&harga=4500000&foto=<?= urlencode($dekor_photos[14]['src']) ?>" class="btn btn-booking flex-grow-1 btn-booking-trigger">Booking 8m</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> (ba


<div class="text-center mb-5 judul">
    <h1>Dekorasi & Terop</h1>
    <div class="line mt-2"></div>
</div>

<div class="row g-4" id="dekorGrid"></div>

</div>
</main>

<div class="modal fade modal-dekor" id="modalDekor" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
<div class="modal-content">

<div class="modal-header">
    <div class="modal-level1">
        <button class="nav-btn" id="btnPrev1" onclick="navigasi1(-1)">
            <i class="bi bi-chevron-left"></i>
        </button>
        <div style="flex:1;">
            <div class="modal-title" id="modalJudul"></div>
            <div class="counter1" id="counter1"></div>
        </div>
        <button class="nav-btn" id="btnNext1" onclick="navigasi1(1)">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <div class="modal-level2-bar">
        <button class="var-btn" id="btnPrev2" onclick="navigasi2(-1)">
            <i class="bi bi-chevron-left"></i>
        </button>
        <div class="var-label" id="varLabel"></div>
        <div class="counter2" id="counter2"></div>
        <button class="var-btn" id="btnNext2" onclick="navigasi2(1)">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>

<div class="modal-body">
    <div class="variant-dots" id="variantDots"></div>
    <div class="modal-img-wrap">
        <button class="foto-nav foto-prev" id="fotoPrev" onclick="navigasi2(-1)">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="foto-nav foto-next" id="fotoNext" onclick="navigasi2(1)">
            <i class="bi bi-chevron-right"></i>
        </button>
        <img id="modalImg" src="" alt="">
    </div>

    <div class="modal-var-name" id="modalVarName"></div>
    <div class="modal-include-label">Include :</div>
    <ol class="modal-include-ol" id="modalInclude"></ol>

    <div class="modal-harga-label">Harga</div>
    <div class="modal-harga-val" id="modalHarga"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-dark flex-grow-1" id="btnKeranjang">
        🛒 Keranjang
    </button>
    <button type="button" class="btn btn-warning flex-grow-1" id="modalBookingBtn">
        Booking
    </button>
</div>

</div>
</div>
</div>

<a href="service.php" class="btn btn-danger btn-kembali shadow">
    Kembali
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

const dekorData = [
{
    jenis: 'Dekorasi Indoor (Gedung)',
    variasi: [
        {
            nama: 'Dekor 1',
            foto: '../assets/fotodekor1.png',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Full bunga segar (Fresh Flower)',
                'Lighting panggung premium & spotlamp',
                'Karpet jalan + 4 buah standing flower',
                'Gate masuk dekoratif',
                'Set meja & kursi akad di gedung'
            ]
        },
        {
            nama: 'Dekor 2',
            foto: '../assets/fotodekor2.png',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },
        {
            nama: 'Dekor 3',
            foto: '../assets/fotodekor3.png',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },
        {
            nama: 'Dekor 4',
            foto: '../assets/fotodekor4.png',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },
        {
            nama: 'Dekor 5',
            foto: '../assets/fotodekor5.png',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },
        {
            nama: 'Dekor 6',
            foto: '../assets/fotodekor6.jpeg',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },
        {
            nama: 'Dekor 7',
            foto: '../assets/fotodekor7.jpeg',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },{
            nama: 'Dekor 8',
            foto: '../assets/fotodekor8.jpeg',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },
        {
            nama: 'Dekor 9',
            foto: '../assets/fotodekor9.jpeg',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },
        {
            nama: 'Dekor 10',
            foto: '../assets/fotodekor10.jpeg',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },
        {
            nama: 'Dekor 11',
            foto: '../assets/fotodekor11.jpeg',
            harga: 'Rp 1.000.000',
            include: [
                'Pelaminan ukuran 4 meter',
                'Kombinasi bunga segar & artificial premium',
                'Mini garden depan panggung',
                'Karpet panggung & karpet jalan',
                'Lighting standar panggung',
                'Kotak amplop (peminjaman)'
            ]
        },
    ]
},
{
    jenis: 'Dekorasi Outdoor (Halaman/Taman)',
    variasi: [
        {
            nama: 'Dekor 4 meter',
            foto: '../assets/fotodekor11.jpeg',
            harga: 'Rp 2.000.000',
            include: [
                'Background panggung kayu/vintage backdrop 4 meter',
                'Full pampas grass & kombinasi bunga segar',
                'Lampu gantung dekoratif (Fairylights)',
                'Welcome signage kayu estetik',
                'Set kursi pelaminan kayu / rotan',
                'Gate masuk model segitiga/lingkar daun'
            ]
        },
        {
            nama: 'Dekor 6 meter',
            foto: '../assets/fotodekor12.jpeg',
            harga: 'Rp 3.000.000',
            include: [
                'Background panggung kayu/vintage backdrop 6 meter',
                'Full pampas grass & kombinasi bunga segar',
                'Lampu gantung dekoratif (Fairylights)',
                'Welcome signage kayu estetik',
                'Set kursi pelaminan kayu / rotan',
                'Gate masuk model segitiga/lingkar daun'
            ]
        },
        {
            nama: 'Dekor 8 meter',
            foto: '../assets/fotodekor13.jpeg',
            harga: 'Rp 4.500.000',
            include: [
                'Background panggung kayu/vintage backdrop 8 meter',
                'Full pampas grass & kombinasi bunga segar',
                'Lampu gantung dekoratif (Fairylights)',
                'Welcome signage kayu estetik',
                'Set kursi pelaminan kayu / rotan',
                'Gate masuk model segitiga/lingkar daun'
            ]
        },
    ]
},
];

let idxDekor = 0;
let idxVariasi = 0;
let bsModal = null;

function renderCards(){
    const grid = document.getElementById('dekorGrid');
    grid.innerHTML = dekorData.map((d, i) => {
        const first = d.variasi[0];
        return `
        <div class="col-md-6">
            <div class="card card-custom p-3" onclick="bukaModal(${i})">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">${d.jenis}</h5>
                    <span class="variant-count">
                        ${d.variasi.length} variasi tersedia
                    </span>
                    <div class="img-paket-wrap">
                        <img src="${first.foto}" alt="${first.nama}" onerror="this.src='https://placehold.co/600x400?text=Gambar+Dekorasi'">
                    </div>
                    <p class="fw-semibold mb-1">Include :</p>
                    <ol class="include-ol">
                        ${first.include.map(x => `<li>${x}</li>`).join('')}
                    </ol>
                    <div class="harga-label">Mulai dari</div>
                    <div class="harga-text">${first.harga}</div>
                </div>
            </div>
        </div>
        `;
    }).join('');
}

function bukaModal(i){
    idxDekor = i;
    idxVariasi = 0;
    renderModal();

    if(!bsModal){
        bsModal = new bootstrap.Modal(document.getElementById('modalDekor'));
    }
    bsModal.show();
}

function renderModal(){
    const dekor = dekorData[idxDekor];
    const varian = dekor.variasi[idxVariasi];

    document.getElementById('modalJudul').textContent = dekor.jenis;
    document.getElementById('counter1').textContent = `${idxDekor+1}/${dekorData.length}`;

    document.getElementById('varLabel').textContent = varian.nama;
    document.getElementById('counter2').textContent = `${idxVariasi+1}/${dekor.variasi.length}`;

    const imgEl = document.getElementById('modalImg');
    imgEl.src = varian.foto;
    imgEl.onerror = function() {
        this.src = 'https://placehold.co/600x400?text=Gambar+Dekorasi';
    };

    document.getElementById('modalVarName').textContent = varian.nama;
    document.getElementById('modalHarga').textContent = varian.harga;

    document.getElementById('modalInclude').innerHTML = 
        varian.include.map(x => `<li>${x}</li>`).join('');

    document.getElementById('variantDots').innerHTML = 
        dekor.variasi.map((_, i) => 
            `<div class="variant-dot ${i === idxVariasi ? 'active' : ''}"></div>`
        ).join('');
}

function navigasi1(arah){
    const next = idxDekor + arah;
    if(next < 0 || next >= dekorData.length) return;
    idxDekor = next;
    idxVariasi = 0;
    renderModal();
}

function navigasi2(arah){
    const dekor = dekorData[idxDekor];
    const next = idxVariasi + arah;
    if(next < 0 || next >= dekor.variasi.length) return;
    idxVariasi = next;
    renderModal();
}

function getPriceValue(priceText){
    return Number(priceText.replace(/[^0-9]/g, '')) || 0;
}

document.getElementById('modalBookingBtn').addEventListener('click', () => {
    const selected = dekorData[idxDekor].variasi[idxVariasi];
    const harga = getPriceValue(selected.harga);
    if(!isLoggedIn){
        Swal.fire({
            icon: 'warning',
            title: 'Login diperlukan',
            text: 'Silakan login terlebih dahulu'
        });
    } else {
        window.location.href = `booking.php?from=dekor&layanan=${encodeURIComponent(selected.nama)}&harga=${harga}`;
    }
});

// Penanganan klik keranjang belanja
document.getElementById('btnKeranjang').addEventListener('click', () => {
    const selected = dekorData[idxDekor].variasi[idxVariasi];
    addToCart(selected.nama, 'dekor', getPriceValue(selected.harga), selected.foto);
});

renderCards();
</script>
<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>