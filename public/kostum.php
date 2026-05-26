<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

function kostumImagePath(?string $path): string
{
    if (!$path) {
        return '../assets/gallery_kostum/foto_akad.jpeg';
    }

    if (preg_match('#^(https?://|/)#', $path)) {
        return $path;
    }

    return '../' . ltrim($path, '/');
}

function kostumIncludes(?string $deskripsi): array
{
    if (!$deskripsi) {
        return ['Layanan kostum siap untuk booking.'];
    }

    $items = [];
    foreach (preg_split('/\r\n|\n|;/', $deskripsi) as $part) {
        $part = trim($part);
        if ($part !== '') {
            $items[] = $part;
        }
    }

    return $items ?: ['Layanan kostum siap untuk booking.'];
}

function formatRupiah($value): string
{
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kostum - Yayuk Makeover</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>

*{ box-sizing:border-box; }

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

/* CARD - Disesuaikan dengan style dekor/makeup */
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
.card-custom:hover{ transform:translateY(-5px); }
.card-custom .card-body{ display:flex; flex-direction:column; height:100%; }

.img-paket-wrap{
    width:100%;
    aspect-ratio:4/5;
    overflow:hidden;
    border-radius:12px;
    margin-bottom:14px;
    background:#f3f3f3;
}
.img-paket-wrap img{ width:100%; height:100%; object-fit:cover; display:block; }

.include-ol{ padding-left:20px; margin-bottom:14px; color:#555; font-size:.88rem; flex-grow:1; }
.include-ol li{ margin-bottom:5px; }

.harga-label{ font-size:.75rem; color:#999; margin-bottom:2px; }
.harga-text{ font-weight:700; color:#b85a00; font-size:1rem; }

.variant-count{
    display:inline-block;
    background:#fff3e0; color:#b85a00;
    border:1px solid #f0c080;
    border-radius:20px;
    padding:4px 12px;
    font-size:.72rem;
    margin-bottom:12px;
}

/* MODAL - Format baru sama seperti dekor.php */
.modal-kostum .modal-dialog{ max-width:760px; }
.modal-kostum .modal-content{ border:none; border-radius:24px; overflow:hidden; }
.modal-kostum .modal-header{
    background:#a88656;
    border:none;
    padding:16px 18px;
    flex-direction:column;
    align-items:stretch;
}

.modal-kostum .modal-title{
    color:#fff;
    font-weight:700;
}
.modal-level2-bar{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
}
.var-btn{
    width:30px; height:30px;
    border:none; border-radius:50%;
    background:rgba(255,255,255,.18);
    color:#fff;
    cursor:pointer;
}
.var-label{
    flex:1; text-align:center;
    color:#fff;
    font-size:.85rem;
    font-weight:600;
}
.counter2{
    color:rgba(255,255,255,.7);
    font-size:.7rem;
}

/* Body & Layout */
.modal-kostum .modal-body{ padding:24px; }
.modal-content-wrap{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
    align-items:start;
}
.variant-dots{
    display:flex;
    justify-content:center;
    gap:6px;
    margin-bottom:12px;
}
.variant-dot{
    width:8px; height:8px;
    border-radius:50%;
    background:#ddd;
}
.variant-dot.active{ background:#b85a00; transform:scale(1.2); }

.modal-img-wrap{
    width:100%;
    aspect-ratio:1/1;
    overflow:hidden;
    border-radius:16px;
    background:#f3f3f3;
    position:relative;
}
.modal-img-wrap img{ width:100%; height:100%; object-fit:cover; }

.foto-nav{
    position:absolute;
    top:50%; transform:translateY(-50%);
    width:36px; height:36px;
    border:none; border-radius:50%;
    background:rgba(0,0,0,.35);
    color:#fff; z-index:10;
}
.foto-prev{ left:10px; }
.foto-next{ right:10px; }

.modal-var-name{ font-size:1.15rem; font-weight:700; margin-bottom:10px; }
.modal-harga-label{ font-size:.78rem; color:#999; margin-bottom:2px; }
.modal-harga-val{ font-size:1.2rem; color:#b85a00; font-weight:700; margin-bottom:14px; }
.modal-include-label{ font-size:.92rem; font-weight:600; margin-bottom:6px; }
.modal-include-ol{ padding-left:20px; font-size:.9rem; color:#444; margin-bottom:4px; }

.modal-kostum .modal-footer{ border:none; padding:0 24px 20px; gap:10px; }
.modal-kostum .modal-footer .btn-dark{ background:#a88656; border:none; border-radius:30px; color:#fff; height:45px; font-weight:600; }
.modal-kostum .modal-footer .btn-dark:hover{ background:#967447; }
.modal-kostum .modal-footer .btn-warning{ background:#a88656; color:#fff; border:none; border-radius:30px; font-weight:600; height:45px; }
.modal-kostum .modal-footer .btn-warning:hover{ background:#967447; color:#fff; }

.btn-kembali{
    position:fixed;
    bottom:20px; left:20px;
    border-radius:30px;
    padding:10px 20px;
    z-index:1000
}

/* RESPONSIVE */
@media(max-width:992px){ .modal-kostum .modal-dialog{ max-width:650px; } }
@media(max-width:768px){ .judul h1{ font-size:54px; } }
@media(max-width:576px){
    .modal-kostum .modal-dialog{ width:86%; max-width:360px; margin:.75rem auto; }
    .modal-kostum .modal-content{ border-radius:18px; max-height:88vh; }
    .modal-kostum .modal-header{ padding:11px 14px; }
    .modal-title{ font-size:.98rem; }
    .modal-content-wrap{ grid-template-columns:1fr; gap:12px; }
    .modal-kostum .modal-body{ padding:12px; }
    .modal-img-wrap{ max-height:38vh; aspect-ratio:1/1; border-radius:12px; }
    .foto-nav{ width:30px; height:30px; }
    .modal-var-name{ font-size:.95rem; margin-bottom:6px; }
    .modal-include-label{ font-size:.82rem; margin-bottom:4px; }
    .modal-include-ol{ font-size:.78rem; margin-bottom:10px; }
    .modal-harga-label{ font-size:.7rem; }
    .modal-harga-val{ font-size:1rem; }
    .modal-kostum .modal-footer{ padding:0 12px 12px; }
    .modal-kostum .modal-footer .btn{ padding:7px 10px; font-size:.84rem; }
}
</style>
</head>
<body>
<?php include 'include/navbar.php'; ?>
<main class="page-wrap">
<div class="container">

    <div class="text-center mb-5 judul">
        <h1>Kostum</h1>
        <div class="line mt-2"></div>
    </div>

    <div class="row g-4" id="kostumGrid"></div>

</div>
</main>

<!-- MODAL -->
<div class="modal fade modal-kostum" id="modalKostum" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
<div class="modal-content">

    <!-- HEADER: nama kostum + tombol tutup saja -->
    <div class="modal-header">
        <h5 class="modal-title" id="modalJudul"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>

    <!-- BODY -->
    <div class="modal-body">

        <!-- Dots variasi -->
        <div class="variant-dots" id="variantDots"></div>

        <div class="modal-content-wrap">

            <!-- FOTO + panah kiri kanan -->
            <div>
                <div class="modal-img-wrap" id="fotoWrap">
                    <button class="foto-nav foto-prev" id="btnFotoPrev" onclick="navigasi2(-1)">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="foto-nav foto-next" id="btnFotoNext" onclick="navigasi2(1)">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                    <img id="modalImg" src="" alt="">
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

    <!-- FOOTER -->
    <div class="modal-footer justify-content-stretch">
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

<a href="service.php" class="btn btn-danger btn-kembali shadow">Kembali</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

const kostumData = [
    {
        jenis:'Kostum Akad',
        variasi:[
            {
                nama:'Akad Modern',
                foto:'../assets/gallery_kostum/fotoakad.jpeg',
                harga:'Rp 6.000.000',
                include:['Makeup(inc:soflens,hijab/hairdo & retouch)','Baju akad & Resepsi "couple"','Baju penerima tamu 4 pasang','Bucket bunga','Dekorasi 4m']
            },
            {
                nama:'Akad Modern 2',
                foto:'../assets/gallery_kostum/akad_1.jpeg',
                harga:'Rp 8.500.000',
                include:['Makeup(inc:soflens,hijab/hairdo & retouch)','Baju akad & Resepsi "couple"','Baju penerima tamu 4 pasang','Bucket bunga','Dekorasi 4m']
            }
        ]
    },
    {
        jenis:'Kostum Resepsi',
        variasi:[
            {
                nama:'Resepsi 1',
                foto:'../assets/gallery_kostum/fotoresepsi.jpeg',
                harga:'Rp 4.500.000',
                include:['Gaun resepsi putih','Veil panjang','Aksesoris lengkap','Custom fitting']
            },
            {
                nama:'Resepsi 2',
                foto:'../assets/gallery_kostum/resepsi_1.jpeg',
                harga:'Rp 8.500.000',
                include:['Kebaya akad','Kain bawahan','Aksesoris premium','Custom fitting']
            }
        ]
    },
    {
        jenis:'Kostum Graduation',
        variasi:[
            {
                nama:'Kebaya Wisuda',
                foto:'../assets/gallery_kostum/wisuda_1.jpeg',
                harga:'Rp 2.500.000',
                include:['Kebaya wisuda','Baju','Rok/kebaya']
            }
        ]
    },
    {
        jenis:'Kostum Adat Indonesia',
        variasi:[
            {
                nama:'Adat Jawa',
                foto:'../assets/gallery_kostum/adat_jawa.jpeg',
                harga:'Rp 5.100.000',
                include:['Kebaya jawa','Jarik','Sanggul','Custom fitting']
            },
            {
                nama:'Adat Bali',
                foto:'../assets/gallery_kostum/adat_bali1.jpeg',
                harga:'Rp 5.300.000',
                include:['Kebaya bali','Selendang','Kamen','Custom fitting']
            },
            {
                nama:'Adat Sulawesi',
                foto:'../assets/gallery_kostum/adat_sulawesi.jpeg',
                harga:'Rp 5.300.000',
                include:['Baju Bodo','Selendang','Sarung sutra','Custom fitting']
            },
            {
                nama:'Adat NTT',
                foto:'../assets/gallery_kostum/adat_ntt.jpeg',
                harga:'Rp 5.300.000',
                include:['Tenun ikat NTT','Sarung tenun','Aksesoris manik','Custom fitting']
            },
            {
                nama:'Adat Kalimantan',
                foto:'../assets/gallery_kostum/adat_kalimantan.jpeg',
                harga:'Rp 5.300.000',
                include:['Baju king/sapei','Kain pelangi','Mahkota bulu enggang','Custom fitting']
            }
        ]
    },
    {
        jenis:'Kostum Carnaval',
        variasi:[
            {
                nama:'Carnaval',
                foto:'../assets/gallery_kostum/Carnaval.jpeg',
                harga:'Rp 2.500.000',
                include:['Kostum karnaval','Headpiece','Aksesoris glitter']
            }
        ]
    },
    {
        jenis:'Jas & Setelan',
        variasi:[
            {
                nama:'Jas Formal',
                foto:'../assets/gallery_kostum/jas.jpeg',
                harga:'Rp 2.000.000',
                include:['Jas atasan formal','Kemeja','Dasi']
            },
            {
                nama:'Jas Formal Set',
                foto:'../assets/gallery_kostum/jas_set.jpeg',
                harga:'Rp 5.300.000',
                include:['Jas formal','Celana','Kemeja','Dasi','Custom fitting']
            }
        ]
    }
];

let idxKostum  = 0;
let idxVariasi = 0;
let bsModal    = null;

function renderCards(){
    document.getElementById('kostumGrid').innerHTML = kostumData.map((k,i) => {
        const f = k.variasi[0];
        return `
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom p-3" onclick="bukaModal(${i})">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">${k.jenis}</h5>
                    <span class="variant-count">${k.variasi.length} variasi tersedia</span>
                    <div class="img-paket-wrap"><img src="${f.foto}"></div>
                    <p class="fw-semibold mb-1">Include :</p>
                    <ol class="include-ol">${f.include.map(x=>`<li>${x}</li>`).join('')}</ol>
                    <div class="harga-label">Mulai dari</div>
                    <div class="harga-text">${f.harga}</div>
                </div>
            </div>
        </div>`;
    }).join('');
}

function bukaModal(i){
    idxKostum  = i;
    idxVariasi = 0;
    renderModal();
    if(!bsModal){
        bsModal = new bootstrap.Modal(document.getElementById('modalKostum'));
        setupSwipe();
    }
    bsModal.show();
}

function renderModal(){
    const k = kostumData[idxKostum];
    const v = k.variasi[idxVariasi];

    document.getElementById('modalJudul').textContent       = k.jenis;
    document.getElementById('modalImg').src                 = v.foto;
    document.getElementById('modalImg').alt                 = v.nama;
    document.getElementById('modalVarName').textContent     = v.nama;
    document.getElementById('modalHarga').textContent       = v.harga;
    document.getElementById('modalInclude').innerHTML       = v.include.map(x=>`<li>${x}</li>`).join('');
    document.getElementById('btnFotoPrev').disabled         = idxVariasi === 0;
    document.getElementById('btnFotoNext').disabled         = idxVariasi === k.variasi.length - 1;
    document.getElementById('variantDots').innerHTML        = k.variasi.map((_,di) =>
        `<div class="variant-dot ${di===idxVariasi?'active':''}" onclick="jumpVariasi(${di})"></div>`
    ).join('');
}

function navigasi2(arah){
    const k    = kostumData[idxKostum];
    const next = idxVariasi + arah;
    if(next < 0 || next >= k.variasi.length) return;
    idxVariasi = next;
    const img  = document.getElementById('modalImg');
    img.style.opacity = '0';
    setTimeout(()=>{ renderModal(); img.style.opacity = '1'; }, 150);
}

function jumpVariasi(i){
    idxVariasi = i;
    const img  = document.getElementById('modalImg');
    img.style.opacity = '0';
    setTimeout(()=>{ renderModal(); img.style.opacity = '1'; }, 150);
}

function setupSwipe(){
    const wrap = document.getElementById('fotoWrap');
    let startX = 0, startY = 0;
    wrap.addEventListener('touchstart', e=>{ startX=e.touches[0].clientX; startY=e.touches[0].clientY; },{ passive:true });
    wrap.addEventListener('touchend', e=>{
        const dx = startX - e.changedTouches[0].clientX;
        const dy = Math.abs(startY - e.changedTouches[0].clientY);
        if(Math.abs(dx) > 40 && dy < 60) navigasi2(dx > 0 ? 1 : -1);
    });
}

document.getElementById('modalBookingBtn').addEventListener('click',()=>{
    if(!isLoggedIn){
        Swal.fire({ icon:'warning', title:'Login diperlukan', text:'Silakan login terlebih dahulu.' });
    } else {
        const v = kostumData[idxKostum].variasi[idxVariasi];

const harga = Number(String(v.harga).replace(/[^0-9]/g,''));

window.location.href =
    './booking.php?' +
    'nama=' + encodeURIComponent(v.nama) +
    '&harga=' + harga +
    '&foto=' + encodeURIComponent(v.foto) +
    '&source_page=kostum';
    }
});

document.getElementById('btnKeranjang').addEventListener('click',()=>{
    const v   = kostumData[idxKostum].variasi[idxVariasi];
    const num = Number(v.harga_value || String(v.harga).replace(/[^0-9]/g,''));
    const id  = v.id || null;
    if(typeof addToCart === 'function'){
        addToCart(v.nama, 'kostum', num, v.foto, id);
    } else {
        let cart = JSON.parse(localStorage.getItem('yayuk_cart')) || [];
        const fallbackId = id || `${idxKostum}-${idxVariasi}`;
        const idx = cart.findIndex(i=>i.id===fallbackId);
        if(idx > -1) cart[idx].qty += 1;
        else cart.push({ id:fallbackId, nama:v.nama, harga:num, foto:v.foto, qty:1 });
        localStorage.setItem('yayuk_cart', JSON.stringify(cart));
        alert(v.nama + ' berhasil ditambah ke keranjang!');
    }
});

renderCards();
</script>
<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>
