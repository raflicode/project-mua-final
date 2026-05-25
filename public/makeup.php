<?php
session_start();

// Struktur data diperbarui agar mendukung sub-paket/variasi di dalam satu kategori makeup
$makeupPackages = [
    [
        'id' => 'graduation',
        'name' => 'Makeup Graduation',
        'variants' => [
            [
                'price' => 150000,
                'image' => '../assets/fotomakeup_6.png',
                'includes' => ['Bulu Mata', 'Softlens', 'Moisturizer Wardah', 'Hairdo Natural', 'Hijabdo', 'Bedak Inez dan Reflon', 'Moisturizer Wardah', 'Primer Maybelin mix Latulip']
            ],
            [
                'price' => 200000,
                'image' => '../assets/fotogradu2..jpg', // Ganti dengan path foto kedua
                'includes' => ['Bulu Mata', 'Softlens', 'Serum Make over', 'Hairdo Natural', 'Hijabdo', 'Foundation Make over mix L+ Pro', 'Bedak Ultima, Makeover, Revlon', 'Primer Make over']
            ]
        ]
    ],
    [
        'id' => 'wedding',
        'name' => 'Makeup Natural',
        'variants' => [
            [
                'price' => 150000,
                'image' => '../assets/fotonatural1.jpg',
                'includes' => ['Bulu Mata', 'Softlens', 'Moisturizer Wardah', 'Hairdo Natural', 'Hijabdo', 'Bedak Inez dan Reflon', 'Moisturizer Wardah', 'Primer Maybelin mix Latulip']
            ],
            [
                'price' => 200000,
                'image' => '../assets/fotolamaran2.jpg',
                'includes' => ['Bulu Mata', 'Softlens', 'Serum Make over', 'Hairdo Natural', 'Hijabdo', 'Foundation Make over mix L+ Pro', 'Bedak Ultima, Makeover, Revlon', 'Primer Make over']
            ]
        ]
    ],
    [
        'id' => 'Makeup',
        'name' => 'Makeup Carnaval',
        'variants' => [
            [
                'price' => 150000,
                'image' => '../assets/fotocarnaval2.jpg',
                'includes' => ['Bulu Mata', 'Softlens', 'Moisturizer Wardah', 'Hairdo Natural', 'Hijabdo', 'Bedak Inez dan Reflon', 'Moisturizer Wardah', 'Primer Maybelin mix Latulip']
            ],
            [
                'price' => 200000,
                'image' => '../assets/fotocarnaval.jpg',
                'includes' => ['Bulu Mata', 'Softlens', 'Serum Make over', 'Hairdo Natural', 'Hijabdo', 'Foundation Make over mix L+ Pro', 'Bedak Ultima, Makeover, Revlon', 'Primer Make over']
            ]
        ]
    ],
    [
        'id' => 'natural',
        'name' => 'Makeup Flawless',
        'variants' => [
            [
                'price' => 150000,
                'image' => '../assets/fotoflawless1.jpg',
                'includes' => ['Bulu Mata', 'Softlens', 'Moisturizer Wardah', 'Hairdo Natural', 'Hijabdo', 'Bedak Inez dan Reflon', 'Moisturizer Wardah', 'Primer Maybelin mix Latulip']
            ],
            [
                'price' => 200000,
                'image' => '../assets/fotolamaran1.jpg',
                'includes' => ['Bulu Mata', 'Softlens', 'Serum Make over', 'Hairdo Natural', 'Hijabdo', 'Foundation Make over mix L+ Pro', 'Bedak Ultima, Makeover, Revlon', 'Primer Make over']
            ]
        ]
    ],
    [
        'id' => 'makeup',
        'name' => 'Makeup Engagement',
        'variants' => [
            [
                'price' => 150000,
                'image' => '../assets/fotolamaran1.jpg',
                'includes' => ['Bulu Mata', 'Softlens', 'Moisturizer Wardah', 'Hairdo Natural', 'Hijabdo', 'Bedak Inez dan Reflon', 'Moisturizer Wardah', 'Primer Maybelin mix Latulip']
            ],
            [
                'price' => 200000,
                'image' => '../assets/fotolamaran2.jpg',
                'includes' => ['Bulu Mata', 'Softlens', 'Serum Make over', 'Hairdo Natural', 'Hijabdo', 'Foundation Make over mix L+ Pro', 'Bedak Ultima, Makeover, Revlon', 'Primer Make over']
            ]
        ]
    ],
    [
        'id' => 'engagement',
        'name' => 'Makeup Pre-wedding',
        'variants' => [
            [
                'price' => 300000,
                'image' => '../assets/fotoprew.jpg',
                'includes' => ['Bulu Mata', 'Softlens', 'Moisturizer Wardah', 'Hairdo Natural', 'Hijabdo', 'Bedak Inez dan Reflon', 'Moisturizer Wardah', 'Primer Maybelin mix Latulip']
            ],
        ]
    ],
    [
        'id' => 'Makeup',
        'name' => 'Makeup Akad',
        'variants' => [
            [
                'price' => 6000000,
                'image' => '../assets/fotomakeup_1.jpeg',
                'includes' => ['Makeup (inc: softlens, hijab/hair do & retouch)', 'Fresh Melati', 'Baju akad & Resepsi "couple"', 'Baju penerima Tamu 4', 'Bucket bunga', 'Dekorasi 4m']
            ],
            [
                'price' => 8500000,
                'image' => '../assets/fotomakeup_3.jpeg',
                'includes' => ['Makeup (inc: softlens, hijab/hair do & retouch)', 'Fresh Melati', 'Baju akad & Resepsi "couple"', 'Baju penerima Tamu 4 tamu manten', 'Baju adat jawa couple', 'BVaju adat jawa orang tua 4', 'Baju adat jawa kemb ar mayang', 'Baju adat jawa joko bagus dalang', 'Perlengkapan temu manten', 'Bucket bunga', 'Dekorasi 6m']
            ]
        ]
    ],
    [
        'id' => 'Makeup',
        'name' => 'Makeup Resepsi',
        'variants' => [
            [
                'price' => 6000000,
                'image' => '../assets/fotomakeup_2.jpeg',
                'includes' => ['Makeup (inc: softlens, hijab/hair do & retouch)', 'Fresh Melati', 'Baju akad & Resepsi "couple"', 'Baju penerima Tamu 4', 'Bucket bunga', 'Dekorasi 4m']
            ],
            [
                'price' => 8500000,
                'image' => '../assets/fotomakeup_5.jpeg',
                'includes' => ['Makeup (inc: softlens, hijab/hair do & retouch)', 'Fresh Melati', 'Baju akad & Resepsi "couple"', 'Baju penerima Tamu 4 tamu manten', 'Baju adat jawa couple', 'BVaju adat jawa orang tua 4', 'Baju adat jawa kemb ar mayang', 'Baju adat jawa joko bagus dalang', 'Perlengkapan temu manten', 'Bucket bunga', 'Dekorasi 6m']
            ]
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Makeup - Yayuk Makeover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
* {
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: #efefef;
    color: #222;
}

.page-wrap {
    padding-top: 95px;
    padding-bottom: 80px;
}

.makeup-container {
    max-width: 1480px;
}

.judul h1 {
    font-family: 'Lobster', cursive;
    font-size: 70px;
    color: #b85a00;
    text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.25);
}

.line {
    width: 220px;
    height: 2px;
    background: #b85a00;
    margin: auto;
}

/* Card clickable style */
.card-clickable {
    cursor: pointer;
}

.card-custom {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
    transition: 0.3s;
    height: 100%;
    padding: 18px !important;
}

.card-custom:hover {
    transform: translateY(-5px);
}

.card-custom .card-body {
    display: flex;
    flex-direction: column;
    min-height: 100%;
}

.card-custom h5 {
    min-height: 48px;
    line-height: 1.35;
}

.img-paket-wrap {
    width: 100%;
    aspect-ratio: 4 / 5;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 14px;
    background: #f3f3f3;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.img-paket {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Button & Modal custom style */
.btn-booking {
    height: 45px;
    border-radius: 30px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.btn-cart-icon {
    width: 45px;
    height: 45px;
    background-color: #212529;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    border: none;
    flex-shrink: 0;
}

.btn-kembali {
    position: fixed;
    bottom: 20px;
    left: 20px;
    border-radius: 30px;
    padding: 10px 20px;
    z-index: 1030;
}

/* Modal Carousel Styling */
.carousel-item img {
    width: 100%;
    aspect-ratio: 4 / 5;
    object-fit: cover;
    border-radius: 12px;
}

.price-tag {
    font-size: 24px;
    color: #b85a00;
    font-weight: 700;
}

@media (max-width: 576px) {
    .judul h1 {
        font-size: 3.9rem;
    }

    .card-custom h5 {
        min-height: auto;
    }
}

@media (min-width: 992px) {
    body {
        padding: 30px;
    }
}
</style>
</head>

<body>
<?php include 'include/navbar.php'; ?>

<main class="page-wrap">
<div class="container-fluid makeup-container px-3 px-md-4 px-xl-5">
    <div class="text-center mb-5 judul">
        <h1>Makeup</h1>
        <div class="line mt-2"></div>
    </div>

    <div class="row g-4">
        <?php foreach ($makeupPackages as $index => $package): ?>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-custom h-100 card-clickable" onclick="openPackageModal(<?= $index ?>)">
                    <div class="card-body p-0">
                        <h5 class="mb-3 fw-bold"><?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <div class="img-paket-wrap">
                            <img src="<?= htmlspecialchars($package['variants'][0]['image'], ENT_QUOTES, 'UTF-8'); ?>" class="img-paket" alt="<?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <p class="text-muted mb-1">Mulai dari</p>
                        <p class="fw-bold text-success mb-2">Rp <?= number_format($package['variants'][0]['price'], 0, ',', '.'); ?></p>
                        <span class="text-primary fw-semibold mt-auto" style="font-size: 0.9rem;">Lihat Detail & Opsi <i class="bi bi-arrow-right-short"></i></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</main>

<div class="modal fade" id="makeupModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="makeupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="makeupModalLabel">Nama Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div id="variantCarousel" class="carousel slide" data-bs-ride="false" data-bs-touch="true">
                            <div class="carousel-inner" id="carouselItemsContainer">
                                </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#variantCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#variantCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-12 mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-secondary" id="variantLabel">Opsi 1</span>
                            <div class="price-tag" id="modalPrice">Rp 0</div>
                        </div>
                        
                        <p class="fw-semibold mb-2">Include :</p>
                        <ul id="modalIncludes" class="ps-0" style="list-style: none;">
                            </ul>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer d-flex justify-content-between align-items-center border-0 pt-0">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark btn-sm rounded-circle" id="prevPackageBtn" title="Paket Sebelumnya">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="btn btn-outline-dark btn-sm rounded-circle" id="nextPackageBtn" title="Paket Selanjutnya">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                
                <div class="d-flex gap-2 flex-grow-1 justify-content-end" style="max-width: 75%;">
                    <button id="modalCartBtn" class="btn-cart-icon" type="button">
                        <i class="bi bi-cart3"></i>
                    </button>
                    <a id="modalBookingBtn" href="#" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                        Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="service.php" class="btn btn-danger btn-kembali shadow">
    Kembali
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Oper data dari PHP ke JavaScript
const packagesData = <?= json_encode($makeupPackages); ?>;
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

let currentPackageIndex = 0;
let currentVariantIndex = 0;

// Inisialisasi Modal dan Carousel Bootstrap
const makeupModal = new bootstrap.Modal(document.getElementById('makeupModal'));
const carouselEl = document.getElementById('variantCarousel');
const bsCarousel = new bootstrap.Carousel(carouselEl);

// Fungsi membuka modal berdasarkan index paket utama
function openPackageModal(packageIndex) {
    currentPackageIndex = packageIndex;
    currentVariantIndex = 0; // reset ke variasi pertama setiap ganti paket utama
    renderModalContent();
    makeupModal.show();
}

// Fungsi merender data ke dalam modal secara dinamis
function renderModalContent() {
    const pkg = packagesData[currentPackageIndex];
    
    // Set Judul Paket Utama
    document.getElementById('makeupModalLabel').innerText = pkg.name;
    
    // Bangun elemen slider/carousel gambar
    const container = document.getElementById('carouselItemsContainer');
    container.innerHTML = '';
    
    pkg.variants.forEach((variant, index) => {
        const div = document.createElement('div');
        div.className = `carousel-item ${index === 0 ? 'active' : ''}`;
        div.innerHTML = `<img src="${variant.image}" alt="${pkg.name} opsi ${index + 1}">`;
        container.appendChild(div);
    });
    
    // Reset carousel ke slide pertama
    bsCarousel.to(0);
    
    // Update data teks (harga & include) berdasarkan variasi pertama
    updateVariantDetails(0);
}

// Fungsi update khusus bagian variasi (saat swipe/geser foto)
function updateVariantDetails(variantIndex) {
    currentVariantIndex = variantIndex;
    const pkg = packagesData[currentPackageIndex];
    const variant = pkg.variants[variantIndex];
    
    // Update Label Opsi ke-berapa
    document.getElementById('variantLabel').innerText = `Opsi ${variantIndex + 1} dari ${pkg.variants.length}`;
    
    // Update Harga (Format Rupiah)
    const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(variant.price);
    document.getElementById('modalPrice').innerText = formattedPrice;
    
    // Update List Include
    const includesList = document.getElementById('modalIncludes');
    includesList.innerHTML = '';
    variant.includes.forEach(inc => {
        const li = document.createElement('li');
        li.className = 'mb-1 text-muted';
        li.innerHTML = `<span class="text-success fw-bold">✓</span> ${inc}`;
        includesList.appendChild(li);
    });
    
    // Update Event Onclick Tombol Add To Cart
    const cartBtn = document.getElementById('modalCartBtn');
    cartBtn.onclick = function() {
        addToCart(pkg.name + ` (Opsi ${variantIndex + 1})`, 'makeup', variant.price, variant.image);
    };
    
    // Update Link Href Tombol Booking
    const bookingBtn = document.getElementById('modalBookingBtn');
    bookingBtn.href = `booking.php?from=makeup&nama=${encodeURIComponent(pkg.name + ' - Opsi ' + (variantIndex + 1))}&harga=${variant.price}&foto=${encodeURIComponent(variant.image)}`;
}

// Event Listener saat carousel di-swipe / di-geser oleh user
carouselEl.addEventListener('slide.bs.carousel', function (e) {
    updateVariantDetails(e.to);
});

// Sistem Navigasi NEXT / PREV antar Paket Utama di Footer Modal
document.getElementById('prevPackageBtn').addEventListener('click', () => {
    if (currentPackageIndex > 0) {
        currentPackageIndex--;
    } else {
        currentPackageIndex = packagesData.length - 1; // loop ke paling akhir
    }
    renderModalContent();
});

document.getElementById('nextPackageBtn').addEventListener('click', () => {
    if (currentPackageIndex < packagesData.length - 1) {
        currentPackageIndex++;
    } else {
        currentPackageIndex = 0; // loop ke paling awal
    }
    renderModalContent();
});

// Interseptor Validasi Login untuk Tombol Booking di dalam modal
document.getElementById('modalBookingBtn').addEventListener('click', function(e) {
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
</script>

<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>