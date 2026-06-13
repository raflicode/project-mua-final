<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../config/service_catalog.php';

$makeupDataFromDB = fetch_catalog_by_category(
    $pdo,
    'makeup',
    '../assets/foto_makeup.jpeg',
    'Layanan makeup siap untuk booking.'
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Makeup - Yayuk Makeover</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>

* { box-sizing: border-box; }

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
    text-shadow: 3px 3px 6px rgba(0,0,0,.25);
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
    box-shadow: 0 5px 15px rgba(0,0,0,.12);
    transition: .3s;
    height: 100%;
    cursor: pointer;
}
.card-custom:hover { transform: translateY(-5px); }
.card-custom .card-body { display: flex; flex-direction: column; height: 100%; }

.img-paket-wrap {
    width: 100%;
    aspect-ratio: 4/5;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 14px;
    background: #f3f3f3;
}
.img-paket-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }

.include-ol { padding-left: 20px; margin-bottom: 14px; color: #555; font-size: .88rem; flex-grow: 1; }
.include-ol li { margin-bottom: 5px; }

.harga-label { font-size: .75rem; color: #999; margin-bottom: 2px; }
.harga-text { font-weight: 700; color: #b85a00; font-size: 1rem; }

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

/* MODAL */
.modal-makeup .modal-dialog { max-width: 760px; }
.modal-makeup .modal-content { border: none; border-radius: 24px; overflow: hidden; }
.modal-makeup .modal-header {
    background: #a88656;
    border: none;
    padding: 16px 18px;
    flex-direction: column;
    align-items: stretch;
}

.modal-makeup .modal-title {
    color: #fff;
    font-weight: 700;
}

/* Body & Layout */
.modal-makeup .modal-body { padding: 24px; }
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
    cursor: pointer;
}
.variant-dot.active { background: #b85a00; transform: scale(1.2); }

.modal-img-wrap {
    width: 100%;
    aspect-ratio: 1/1;
    overflow: hidden;
    border-radius: 16px;
    background: #f3f3f3;
    position: relative;
}
.modal-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity .15s;
}

.foto-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: rgba(0,0,0,.35);
    color: #fff;
    z-index: 10;
}
.foto-prev { left: 10px; }
.foto-next { right: 10px; }

.modal-var-name { font-size: 1.15rem; font-weight: 700; margin-bottom: 10px; }
.modal-harga-label { font-size: .78rem; color: #999; margin-bottom: 2px; }
.modal-harga-val { font-size: 1.2rem; color: #b85a00; font-weight: 700; margin-bottom: 14px; }
.modal-include-label { font-size: .92rem; font-weight: 600; margin-bottom: 6px; }
.modal-include-ol { padding-left: 20px; font-size: .9rem; color: #444; margin-bottom: 4px; }

.modal-makeup .modal-footer { border: none; padding: 0 24px 20px; gap: 10px; }
.modal-makeup .modal-footer .btn-dark {
    background: #a88656;
    border: none;
    border-radius: 30px;
    color: #fff;
    height: 45px;
    font-weight: 600;
}
.modal-makeup .modal-footer .btn-dark:hover { background: #967447; }
.modal-makeup .modal-footer .btn-warning {
    background: #a88656;
    color: #fff;
    border: none;
    border-radius: 30px;
    font-weight: 600;
    height: 45px;
}
.modal-makeup .modal-footer .btn-warning:hover { background: #967447; color: #fff; }

.btn-kembali {
    position: fixed;
    bottom: 20px;
    left: 20px;
    border-radius: 30px;
    padding: 10px 20px;
    z-index: 1000;
}

/* RESPONSIVE */
@media(max-width:992px) { .modal-makeup .modal-dialog { max-width: 650px; } }
@media(max-width:768px) { .judul h1 { font-size: 54px; } }
@media(max-width:576px) {
    .modal-makeup .modal-dialog { width: 86%; max-width: 360px; margin: .75rem auto; }
    .modal-makeup .modal-content { border-radius: 18px; max-height: 88vh; }
    .modal-makeup .modal-header { padding: 11px 14px; }
    .modal-title { font-size: .98rem; }
    .modal-content-wrap { grid-template-columns: 1fr; gap: 12px; }
    .modal-makeup .modal-body { padding: 12px; }
    .modal-img-wrap { max-height: 38vh; aspect-ratio: 1/1; border-radius: 12px; }
    .foto-nav { width: 30px; height: 30px; }
    .modal-var-name { font-size: .95rem; margin-bottom: 6px; }
    .modal-include-label { font-size: .82rem; margin-bottom: 4px; }
    .modal-include-ol { font-size: .78rem; margin-bottom: 10px; }
    .modal-harga-label { font-size: .7rem; }
    .modal-harga-val { font-size: 1rem; }
    .modal-makeup .modal-footer { padding: 0 12px 12px; }
    .modal-makeup .modal-footer .btn { padding: 7px 10px; font-size: .84rem; }
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

    <div class="row g-4" id="makeupGrid"></div>

</div>
</main>

<!-- MODAL -->
<div class="modal fade modal-makeup" id="modalMakeup" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title" id="modalJudul"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <!-- Dots variasi -->
        <div class="variant-dots" id="variantDots"></div>

        <div class="modal-content-wrap">

            <!-- FOTO -->
            <div>
                <div class="modal-img-wrap" id="fotoWrap">
                    <button class="foto-nav foto-prev" id="btnFotoPrev" onclick="navigasi(-1)">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="foto-nav foto-next" id="btnFotoNext" onclick="navigasi(1)">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                    <img id="modalImg" src="" alt="" decoding="async">
                </div>
            </div>

            <!-- INFO variasi -->
            <div>
                <div class="modal-var-name" id="modalVarName"></div>
                <div class="modal-include-label">Include :</div>
                <ol class="modal-include-ol" id="modalInclude"></ol>
                <div class="modal-harga-label">Harga</div>
                <div class="modal-harga-val" id="modalHarga"></div>
            </div>

        </div>
    </div>

    <div class="modal-footer justify-content-stretch">
        <button type="button" class="btn btn-dark flex-grow-1" id="btnKeranjang">
            <i class="bi bi-cart3"></i> Keranjang
        </button>
        <button type="button" class="btn btn-warning flex-grow-1" id="modalBookingBtn">
            Cek Ketersediaan Jadwal
        </button>
    </div>

</div>
</div>
</div>

<a href="service.php" class="btn btn-danger btn-kembali shadow">Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

const makeupData = <?php echo json_encode($makeupDataFromDB, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

let idxPaket   = 0;
let idxVariasi = 0;
let bsModal    = null;

function renderCards() {
    if (makeupData.length === 0) {
        document.getElementById('makeupGrid').innerHTML = `
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox display-5 text-muted"></i>
                    <h5 class="mt-3">Belum ada layanan makeup aktif</h5>
                    <p class="text-muted mb-0">Admin dapat menambahkan layanan makeup dari halaman Data Layanan.</p>
                </div>
            </div>
        </div>`;
        return;
    }

    document.getElementById('makeupGrid').innerHTML = makeupData.map((k, i) => {
        const f = k.variasi[0];
        return `
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom p-3" onclick="bukaModal(${i})">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">${k.jenis}</h5>
                    <span class="variant-count">${k.variasi.length} variasi tersedia</span>
                    <div class="img-paket-wrap"><img src="${f.foto}" alt="${k.jenis}" loading="lazy" decoding="async"></div>
                    <p class="fw-semibold mb-1">Include :</p>
                    <ol class="include-ol">${f.include.map(x => `<li>${x}</li>`).join('')}</ol>
                    <div class="harga-label">Mulai dari</div>
                    <div class="harga-text">${f.harga}</div>
                </div>
            </div>
        </div>`;
    }).join('');
}

function bukaModal(i) {
    idxPaket   = i;
    idxVariasi = 0;
    renderModal();
    if (!bsModal) {
        bsModal = new bootstrap.Modal(document.getElementById('modalMakeup'));
        setupSwipe();
    }
    bsModal.show();
}

function renderModal() {
    const k = makeupData[idxPaket];
    const v = k.variasi[idxVariasi];

    document.getElementById('modalJudul').textContent   = k.jenis;
    document.getElementById('modalImg').src             = v.foto;
    document.getElementById('modalImg').alt             = v.nama;
    document.getElementById('modalVarName').textContent = v.nama;
    document.getElementById('modalHarga').textContent   = v.harga;
    document.getElementById('modalInclude').innerHTML   = v.include.map(x => `<li>${x}</li>`).join('');
    document.getElementById('btnFotoPrev').disabled     = idxVariasi === 0;
    document.getElementById('btnFotoNext').disabled     = idxVariasi === k.variasi.length - 1;
    document.getElementById('variantDots').innerHTML    = k.variasi.map((_, di) =>
        `<div class="variant-dot ${di === idxVariasi ? 'active' : ''}" onclick="jumpVariasi(${di})"></div>`
    ).join('');
}

function navigasi(arah) {
    const k    = makeupData[idxPaket];
    const next = idxVariasi + arah;
    if (next < 0 || next >= k.variasi.length) return;
    idxVariasi = next;
    const img  = document.getElementById('modalImg');
    img.style.opacity = '0';
    setTimeout(() => { renderModal(); img.style.opacity = '1'; }, 150);
}

function jumpVariasi(i) {
    idxVariasi = i;
    const img  = document.getElementById('modalImg');
    img.style.opacity = '0';
    setTimeout(() => { renderModal(); img.style.opacity = '1'; }, 150);
}

function setupSwipe() {
    const wrap = document.getElementById('fotoWrap');
    let startX = 0, startY = 0;
    wrap.addEventListener('touchstart', e => {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    }, { passive: true });
    wrap.addEventListener('touchend', e => {
        const dx = startX - e.changedTouches[0].clientX;
        const dy = Math.abs(startY - e.changedTouches[0].clientY);
        if (Math.abs(dx) > 40 && dy < 60) navigasi(dx > 0 ? 1 : -1);
    });
}

document.getElementById('modalBookingBtn').addEventListener('click', () => {
    if (!isLoggedIn) {
        Swal.fire({
            icon: 'warning',
            title: 'Login diperlukan',
            text: 'Silakan login terlebih dahulu.',
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
        const v = makeupData[idxPaket].variasi[idxVariasi];

const harga = Number(String(v.harga).replace(/[^0-9]/g,''));

window.location.href =
    './penjadwalan.php?' +
    'from=makeup' +
    '&tipe=makeup' +
    '&id=' + encodeURIComponent(v.id || '') +
    '&layanan=' + encodeURIComponent(v.nama) +
    '&harga=' + harga +
    '&foto=' + encodeURIComponent(v.foto);
    }
});

document.getElementById('btnKeranjang').addEventListener('click', () => {
    const v   = makeupData[idxPaket].variasi[idxVariasi];
    const num = v.harga_value || Number(String(v.harga).replace(/[^0-9]/g, ''));
    const id  = v.id || null;
    if (typeof addToCart === 'function') {
        addToCart(v.nama, 'makeup', num, v.foto, id);
    } else {
        let cart = JSON.parse(localStorage.getItem('yayuk_cart')) || [];
        const fallbackId = id || `${idxPaket}-${idxVariasi}`;
        const idx = cart.findIndex(i => i.id === fallbackId);
        if (idx > -1) cart[idx].qty += 1;
        else cart.push({ id: fallbackId, nama: v.nama, harga: num, foto: v.foto, qty: 1 });
        localStorage.setItem('yayuk_cart', JSON.stringify(cart));
        alert(v.nama + ' berhasil ditambah ke keranjang!');
    }
});

renderCards();
</script>
<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>
