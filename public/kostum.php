<?php
session_start();
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
    aspect-ratio:4/5;
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

.modal-kostum .modal-dialog{
    max-width:520px;
}

.modal-kostum .modal-content{
    border:none;
    border-radius:22px;
    overflow:hidden;
}

.modal-kostum .modal-header{
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

.modal-kostum .modal-body{
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
    aspect-ratio:4/5;
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

.modal-kostum .modal-footer{
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

<div class="modal-include-label">
Include :
</div>

<ol class="modal-include-ol" id="modalInclude"></ol>

<div class="modal-harga-label">
Harga
</div>

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

const kostumData = [

{
    jenis:'Kostum Akad',
    variasi:[
        {
            nama:'Akad Modern',
            foto:'../assets/gallery_kostum/foto_akad.jpeg',
            harga:'Rp 3.500.000',
            include:[
                'Baju akad modern',
                'Selendang akad',
                'Aksesoris kepala',
                'Custom fitting'
            ]
        },
        {
            nama:'Akad Kebaya',
            foto:'../assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 4.000.000',
            include:[
                'Kebaya akad',
                'Kain bawahan',
                'Aksesoris premium',
                'Custom fitting'
            ]
        }
    ]
},

{
    jenis:'Kostum Resepsi',
    variasi:[
        {
            nama:'Resepsi Putih',
            foto:'../assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 4.500.000',
            include:[
                'Gaun resepsi putih',
                'Veil panjang',
                'Aksesoris lengkap',
                'Custom fitting'
            ]
        }
    ]
},
/* =========================
   KOSTUM GRADUATION
========================= */

{
    jenis:'Kostum Graduation',
    variasi:[

        {
            nama:'Kebaya Wisuda Putih',
            foto:'assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 2.500.000',
            include:[
                'Kebaya putih elegan',
                'Rok batik',
                'Aksesoris wisuda',
                'Free steam'
            ]
        },

        {
            nama:'Kebaya Wisuda Nude',
            foto:'assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 2.700.000',
            include:[
                'Kebaya nude premium',
                'Rok satin',
                'Selendang',
                'Free steam'
            ]
        },

        {
            nama:'Dress Graduation',
            foto:'assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 3.200.000',
            include:[
                'Dress graduation',
                'Inner premium',
                'Aksesoris simple',
                'Custom fitting'
            ]
        },

        {
            nama:'Set Toga Wisuda',
            foto:'assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 1.500.000',
            include:[
                'Toga wisuda',
                'Topi toga',
                'Selempang',
                'Free steam'
            ]
        },

        {
            nama:'Jas Graduation',
            foto:'assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 2.300.000',
            include:[
                'Jas formal',
                'Kemeja putih',
                'Dasi',
                'Celana formal'
            ]
        }

    ]
},
{
    jenis:'Kostum Adat Indonesia',
    variasi:[

        {
            nama:'Adat Jawa',
            foto:'../assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 5.100.000',
            include:[
                'Kebaya hitam',
                'Jarik batik',
                'Sanggul jawa',
                'Custom fitting'
            ]
        },

        {
            nama:'Adat Kalimantan',
            foto:'../assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 5.200.000',
            include:[
                'Baju dayak merah',
                'Mahkota bulu',
                'Aksesoris manik',
                'Custom fitting'
            ]
        },

        {
            nama:'Adat Sulawesi',
            foto:'../assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 5.000.000',
            include:[
                'Baju bodo hijau',
                'Sarung sutra',
                'Aksesoris kepala',
                'Custom fitting'
            ]
        },

        {
            nama:'Adat Bali',
            foto:'../assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 5.300.000',
            include:[
                'Kebaya bali',
                'Selendang bali',
                'Kamen bali',
                'Custom fitting'
            ]
        }

    ]
},

/* =========================
   JAS & SETELAN
========================= */

{
    jenis:'Jas & Setelan',
    variasi:[

        {
            nama:'Jas Hitam',
            foto:'assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 1.800.000',
            include:[
                'Jas formal hitam',
                'Kemeja putih',
                'Dasi',
                'Free steam'
            ]
        },

        {
            nama:'Jas Lengkap + Celana',
            foto:'assets/gallery_kostum/kostum_2.jpeg',
            harga:'Rp 2.800.000',
            include:[
                'Jas hitam',
                'Celana formal',
                'Kemeja putih',
                'Dasi lengkap'
            ]
        }

    ]
}

];

let idxKostum = 0;
let idxVariasi = 0;
let bsModal = null;

function renderCards(){

    const grid = document.getElementById('kostumGrid');

    grid.innerHTML = kostumData.map((k,i)=>{

        const first = k.variasi[0];

        return `
        <div class="col-md-6">

            <div class="card card-custom p-3" onclick="bukaModal(${i})">

                <div class="card-body">

                    <h5 class="fw-bold mb-2">${k.jenis}</h5>

                    <span class="variant-count">
                        ${k.variasi.length} variasi tersedia
                    </span>

                    <div class="img-paket-wrap">
                        <img src="${first.foto}">
                    </div>

                    <p class="fw-semibold mb-1">
                        Include :
                    </p>

                    <ol class="include-ol">
                        ${first.include.map(x=>`<li>${x}</li>`).join('')}
                    </ol>

                    <div class="harga-label">
                        Mulai dari
                    </div>

                    <div class="harga-text">
                        ${first.harga}
                    </div>

                </div>

            </div>

        </div>
        `;

    }).join('');

}

function bukaModal(i){

    idxKostum = i;
    idxVariasi = 0;

    renderModal();

    if(!bsModal){
        bsModal = new bootstrap.Modal(document.getElementById('modalKostum'));
    }

    bsModal.show();
}

function renderModal(){

    const kostum = kostumData[idxKostum];
    const varian = kostum.variasi[idxVariasi];

    document.getElementById('modalJudul').textContent = kostum.jenis;
    document.getElementById('counter1').textContent = `${idxKostum+1}/${kostumData.length}`;

    document.getElementById('varLabel').textContent = varian.nama;
    document.getElementById('counter2').textContent = `${idxVariasi+1}/${kostum.variasi.length}`;

    document.getElementById('modalImg').src = varian.foto;

    document.getElementById('modalVarName').textContent = varian.nama;

    document.getElementById('modalHarga').textContent = varian.harga;

    document.getElementById('modalInclude').innerHTML =
        varian.include.map(x=>`<li>${x}</li>`).join('');

    document.getElementById('variantDots').innerHTML =
        kostum.variasi.map((_,i)=>
            `<div class="variant-dot ${i===idxVariasi?'active':''}"></div>`
        ).join('');

}

function hargaKeAngka(harga){
    return String(harga).replace(/[^\d]/g, '');
}

function navigasi1(arah){

    const next = idxKostum + arah;

    if(next < 0 || next >= kostumData.length) return;

    idxKostum = next;
    idxVariasi = 0;

    renderModal();

}

function navigasi2(arah){

    const kostum = kostumData[idxKostum];

    const next = idxVariasi + arah;

    if(next < 0 || next >= kostum.variasi.length) return;

    idxVariasi = next;

    renderModal();

}

document.getElementById('modalBookingBtn').addEventListener('click',()=>{

    if(!isLoggedIn){

        Swal.fire({
            icon:'warning',
            title:'Login diperlukan',
            text:'Silakan login terlebih dahulu'
        });

    }else{

        const kostum = kostumData[idxKostum];
        const varian = kostum.variasi[idxVariasi];
        const nama = `${kostum.jenis} - ${varian.nama}`;
        const harga = hargaKeAngka(varian.harga);
        const foto = varian.foto;

        window.location.href = `booking.php?from=kostum&nama=${encodeURIComponent(nama)}&harga=${harga}&foto=${encodeURIComponent(foto)}`;

    }

});

renderCards();

</script>

</body>
</html>
