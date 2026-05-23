<?php
session_start();

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
                'image' => '../assets/fotogradu2..jpg',
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
        'id' => 'carnaval',
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
        'id' => 'flawless',
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
        'id' => 'engagement',
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
        'id' => 'prewedding',
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
        'id' => 'akad',
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
                'includes' => ['Makeup (inc: softlens, hijab/hair do & retouch)', 'Fresh Melati', 'Baju akad & Resepsi "couple"', 'Baju penerima Tamu 4 tamu manten', 'Baju adat jawa couple', 'Baju adat jawa orang tua 4', 'Baju adat jawa kembar mayang', 'Baju adat jawa joko bagus dalang', 'Perlengkapan temu manten', 'Bucket bunga', 'Dekorasi 6m']
            ]
        ]
    ],
    [
        'id' => 'resepsi',
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
                'includes' => ['Makeup (inc: softlens, hijab/hair do & retouch)', 'Fresh Melati', 'Baju akad & Resepsi "couple"', 'Baju penerima Tamu 4 tamu manten', 'Baju adat jawa couple', 'Baju adat jawa orang tua 4', 'Baju adat jawa kembar mayang', 'Baju adat jawa joko bagus dalang', 'Perlengkapan temu manten', 'Bucket bunga', 'Dekorasi 6m']
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

/* CARD */
.card-custom {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
    transition: 0.3s;
    height: 100%;
    cursor: pointer;
}

.card-custom:hover {
    transform: translateY(-5px);
}

.card-custom .card-body {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.img-paket-wrap {
    width: 100%;
    aspect-ratio: 4 / 5;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 14px;
    background: #f3f3f3;
}

.img-paket-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.harga-label {
    font-size: .75rem;
    color: #999;
    margin-bottom: 2px;
}

.harga-text {
    font-weight: 700;
    color: #b85a00;
    font-size: 1rem;
}

.variant-count {
    display: inline-block;
    background: #fff3e0;
    color: #b85a00;
    border: 1px solid #f0c080;
    border-radius: 20px;
    padding: 4px 12px;
    font-size: .72rem;
    margin-bottom: 12px;
}

/* =========================
   MODAL — landscape 2 kolom
========================= */

.modal-makeup .modal-dialog {
    max-width: 760px;
}

.modal-makeup .modal-content {
    border: none;
    border-radius: 24px;
    overflow: hidden;
}

.modal-makeup .modal-header {
    background: #a88656;
    border: none;
    padding: 16px 18px;
    flex-direction: column;
    align-items: stretch;
}

.modal-level2-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.var-btn {
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, .18);
    color: #fff;
    cursor: pointer;
}

.var-label {
    flex: 1;
    text-align: center;
    color: #fff;
    font-size: .85rem;
    font-weight: 600;
}

.counter2 {
    color: rgba(255, 255, 255, .7);
    font-size: .7rem;
}

.modal-makeup .modal-body {
    padding: 24px;
}

/* Grid landscape 2 kolom */
.modal-content-wrap {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    align-items: start;
}

.variant-dots {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-bottom: 12px;
}

.variant-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ddd;
}

.variant-dot.active {
    background: #b85a00;
    transform: scale(1.2);
}

.modal-img-wrap {
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    border-radius: 16px;
    background: #f3f3f3;
    position: relative;
}

.modal-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.foto-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: rgba(0, 0, 0, .35);
    color: #fff;
    z-index: 10;
}

.foto-prev { left: 10px; }
.foto-next { right: 10px; }

.modal-var-name {
    font-size: 1.15rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.modal-harga-label {
    font-size: .78rem;
    color: #999;
    margin-bottom: 2px;
}

.modal-harga-val {
    font-size: 1.2rem;
    color: #b85a00;
    font-weight: 700;
    margin-bottom: 14px;
}

.modal-include-label {
    font-size: .92rem;
    font-weight: 600;
    margin-bottom: 6px;
}

.modal-include-ol {
    padding-left: 20px;
    font-size: .9rem;
    color: #444;
    margin-bottom: 4px;
}

.modal-makeup .modal-footer {
    border: none;
    padding: 0 24px 20px;
    gap: 10px;
}

.modal-makeup .modal-footer .btn-dark {
    background: #a88656;
    border: none;
    border-radius: 30px;
    color: #fff;
    height: 45px;
    font-weight: 600;
}

.modal-makeup .modal-footer .btn-dark:hover {
    background: #967447;
}

.modal-makeup .modal-footer .btn-warning {
    background: #a88656;
    color: #fff;
    border: none;
    border-radius: 30px;
    font-weight: 600;
    height: 45px;
}

.modal-makeup .modal-footer .btn-warning:hover {
    background: #967447;
    color: #fff;
}

.btn-kembali {
    position: fixed;
    bottom: 20px;
    left: 20px;
    border-radius: 30px;
    padding: 10px 20px;
    z-index: 1030;
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 992px) {
    .modal-makeup .modal-dialog {
        max-width: 650px;
    }
}

@media (max-width: 768px) {
    .judul h1 {
        font-size: 54px;
    }
}

@media (max-width: 576px) {

    .modal-makeup .modal-dialog {
        width: 86%;
        max-width: 360px;
        margin: .75rem auto;
    }

    .modal-makeup .modal-content {
        border-radius: 18px;
        max-height: 88vh;
    }

    .modal-makeup .modal-header {
        padding: 11px 12px;
    }

    .modal-level2-bar {
        gap: 6px;
    }

    .var-btn {
        width: 26px;
        height: 26px;
    }

    .var-label {
        font-size: .76rem;
    }

    .counter2 {
        font-size: .64rem;
    }

    .modal-content-wrap {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .modal-makeup .modal-body {
        padding: 12px;
        overflow-y: auto;
    }

    .modal-img-wrap {
        max-height: 38vh;
        aspect-ratio: 1 / 1;
        border-radius: 12px;
    }

    .foto-nav {
        width: 30px;
        height: 30px;
    }

    .variant-dots {
        margin-bottom: 8px;
    }

    .modal-var-name {
        font-size: .95rem;
        margin-bottom: 6px;
    }

    .modal-include-label {
        font-size: .82rem;
        margin-bottom: 4px;
    }

    .modal-include-ol {
        font-size: .78rem;
        margin-bottom: 8px;
    }

    .modal-harga-val {
        font-size: 1rem;
    }

    .modal-makeup .modal-footer {
        padding: 0 12px 12px;
    }

    .modal-makeup .modal-footer .btn {
        padding: 7px 10px;
        font-size: .84rem;
    }
}
</style>
</head>

<body>
<?php include 'include/navbar.php'; ?>

<main class="page-wrap">
<div class="container">

    <div class="text-center mb-5 judul">
        <h1>Makeup</h1>
        <div class="line mt-2"></div>
    </div>

    <div class="row g-4">
        <?php foreach ($makeupPackages as $index => $package): ?>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-custom p-3" onclick="bukaModal(<?= $index ?>)">
                <div class="card-body p-0">
                    <h5 class="fw-bold mb-2"><?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8') ?></h5>
                    <span class="variant-count">
                        <?= count($package['variants']) ?> variasi tersedia
                    </span>
                    <div class="img-paket-wrap">
                        <img src="<?= htmlspecialchars($package['variants'][0]['image'], ENT_QUOTES, 'UTF-8') ?>"
                             alt="<?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8') ?>"
                             onerror="this.src='https://placehold.co/400x500?text=Foto'">
                    </div>
                    <div class="harga-label">Mulai dari</div>
                    <div class="harga-text">Rp <?= number_format($package['variants'][0]['price'], 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>
</main>

<!-- MODAL — landscape 2 kolom -->
<div class="modal fade modal-makeup" id="modalMakeup" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
    <div class="modal-level2-bar">
        <button class="var-btn" onclick="navigasi2(-1)">
            <i class="bi bi-chevron-left"></i>
        </button>
        <div class="var-label" id="varLabel"></div>
        <div class="counter2" id="counter2"></div>
        <button class="var-btn" onclick="navigasi2(1)">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>

<div class="modal-body">
    <div class="variant-dots" id="variantDots"></div>

    <div class="modal-content-wrap">

        <div class="modal-img-wrap">
            <button class="foto-nav foto-prev" onclick="navigasi2(-1)">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="foto-nav foto-next" onclick="navigasi2(1)">
                <i class="bi bi-chevron-right"></i>
            </button>
            <img id="modalImg" src="" alt="">
        </div>

        <div>
            <div class="modal-var-name" id="modalVarName"></div>
            <div class="modal-harga-label">Harga</div>
            <div class="modal-harga-val" id="modalHarga"></div>
            <div class="modal-include-label">Include :</div>
            <ol class="modal-include-ol" id="modalInclude"></ol>
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-dark flex-grow-1" id="btnKeranjang">
        <i class="bi bi-cart3"></i> Keranjang
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
const packagesData = <?= json_encode($makeupPackages) ?>;
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

let idxPaket = 0;
let idxVariasi = 0;
let bsModal = null;

function bukaModal(i) {
    idxPaket = i;
    idxVariasi = 0;
    renderModal();
    if (!bsModal) {
        bsModal = new bootstrap.Modal(document.getElementById('modalMakeup'));
    }
    bsModal.show();
}

function renderModal() {
    const pkg = packagesData[idxPaket];
    const varian = pkg.variants[idxVariasi];

    // Header: nama variasi + counter
    document.getElementById('varLabel').textContent = pkg.name + ' — Opsi ' + (idxVariasi + 1);
    document.getElementById('counter2').textContent = `${idxVariasi + 1}/${pkg.variants.length}`;

    // Foto
    const imgEl = document.getElementById('modalImg');
    imgEl.src = varian.image;
    imgEl.onerror = function () {
        this.src = 'https://placehold.co/400x500?text=Foto';
    };

    // Detail
    document.getElementById('modalVarName').textContent = pkg.name + ' (Opsi ' + (idxVariasi + 1) + ')';
    document.getElementById('modalHarga').textContent = 'Rp ' + Number(varian.price).toLocaleString('id-ID');

    document.getElementById('modalInclude').innerHTML =
        varian.includes.map(x => `<li>${x}</li>`).join('');

    // Dots
    document.getElementById('variantDots').innerHTML =
        pkg.variants.map((_, i) =>
            `<div class="variant-dot ${i === idxVariasi ? 'active' : ''}"></div>`
        ).join('');
}

function navigasi2(arah) {
    const pkg = packagesData[idxPaket];
    const next = idxVariasi + arah;
    if (next < 0 || next >= pkg.variants.length) return;
    idxVariasi = next;
    renderModal();
}

document.getElementById('btnKeranjang').addEventListener('click', () => {
    const pkg = packagesData[idxPaket];
    const varian = pkg.variants[idxVariasi];
    const nama = pkg.name + ' (Opsi ' + (idxVariasi + 1) + ')';
    addToCart(nama, 'makeup', varian.price, varian.image);
});

document.getElementById('modalBookingBtn').addEventListener('click', () => {
    const pkg = packagesData[idxPaket];
    const varian = pkg.variants[idxVariasi];
    const nama = pkg.name + ' - Opsi ' + (idxVariasi + 1);

    if (!isLoggedIn) {
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
    } else {
        window.location.href = `booking.php?from=makeup&layanan=${encodeURIComponent(nama)}&harga=${varian.price}&foto=${encodeURIComponent(varian.image)}`;
    }
});
</script>

<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>