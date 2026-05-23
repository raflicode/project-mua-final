<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

function dekorImagePath(?string $path): string
{
    if (!$path) {
        return '../assets/fotodekor1.png';
    }

    if (preg_match('#^(https?://|/)#', $path)) {
        return $path;
    }

    return '../' . ltrim($path, '/');
}

function dekorIncludes(?string $deskripsi): array
{
    if (!$deskripsi) {
        return ['Layanan dekorasi siap untuk booking.'];
    }

    $items = [];
    foreach (preg_split('/\r\n|\n|;/', $deskripsi) as $part) {
        $part = trim($part);
        if ($part !== '') {
            $items[] = $part;
        }
    }

    return $items ?: ['Layanan dekorasi siap untuk booking.'];
}

function formatRupiah($value): string
{
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
}

$stmt = $pdo->query("SELECT id_layanan, nama_layanan, harga_dasar, foto_layanan, deskripsi FROM layanan WHERE is_active = 1 AND kategori_layanan = 'dekor' ORDER BY nama_layanan ASC");
$dekorRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$dekorData = [];
foreach ($dekorRows as $row) {
    $dekorData[] = [
        'jenis' => $row['nama_layanan'],
        'variasi' => [[
            'id' => (int) $row['id_layanan'],
            'nama' => $row['nama_layanan'],
            'foto' => dekorImagePath($row['foto_layanan'] ?? ''),
            'harga' => formatRupiah($row['harga_dasar']),
            'harga_value' => (float) $row['harga_dasar'],
            'include' => dekorIncludes($row['deskripsi'] ?? ''),
        ]],
    ];
}
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
*{ box-sizing:border-box; }
body{ font-family:'Poppins',sans-serif; background:#efefef; color:#222; }
.page-wrap{ padding-top:95px; padding-bottom:80px; }
.judul h1{ font-family:'Lobster',cursive; font-size:70px; color:#b85a00; text-shadow:3px 3px 6px rgba(0,0,0,.25); }
.line{ width:220px; height:2px; background:#b85a00; margin:auto; }
.card-custom{ border:none; border-radius:18px; overflow:hidden; background:#fff; box-shadow:0 5px 15px rgba(0,0,0,.12); transition:.3s; height:100%; cursor:pointer; }
.card-custom:hover{ transform:translateY(-5px); }
.card-body{ display:flex; flex-direction:column; height:100%; }
.img-paket-wrap{ width:100%; aspect-ratio:16/10; overflow:hidden; border-radius:12px; margin-bottom:14px; background:#f3f3f3; }
.img-paket-wrap img{ width:100%; height:100%; object-fit:cover; display:block; }
.include-ol{ padding-left:20px; margin-bottom:14px; color:#555; font-size:.88rem; flex-grow:1; }
.include-ol li{ margin-bottom:5px; }
.harga-label{ font-size:.75rem; color:#999; margin-bottom:2px; }
.harga-text{ font-weight:700; color:#b85a00; font-size:1rem; }
.variant-count{ display:inline-block; background:#fff3e0; color:#b85a00; border:1px solid #f0c080; border-radius:20px; padding:3px 12px; font-size:.72rem; margin-bottom:12px; }
.modal-dekor .modal-dialog{ max-width:760px; }
.modal-dekor .modal-content{ border:none; border-radius:24px; overflow:hidden; }
.modal-dekor .modal-header{ background:#b85a00; border:none; padding:16px 18px; flex-direction:column; align-items:stretch; }
.modal-level2-bar{ display:flex; align-items:center; justify-content:center; gap:8px; }
.var-btn{ width:30px; height:30px; border:none; border-radius:50%; background:rgba(255,255,255,.18); color:#fff; cursor:pointer; }
.var-label{ flex:1; text-align:center; color:#fff; font-size:.85rem; font-weight:600; }
.counter2{ color:rgba(255,255,255,.7); font-size:.7rem; }
.modal-dekor .modal-body{ padding:24px; }
.modal-content-wrap{ display:grid; grid-template-columns:1fr 1fr; gap:24px; align-items:start; }
.variant-dots{ display:flex; justify-content:center; gap:6px; margin-bottom:12px; }
.variant-dot{ width:8px; height:8px; border-radius:50%; background:#ddd; }
.variant-dot.active{ background:#b85a00; transform:scale(1.2); }
.modal-img-wrap{ width:100%; aspect-ratio:1/1; overflow:hidden; border-radius:16px; background:#f3f3f3; position:relative; }
.modal-img-wrap img{ width:100%; height:100%; object-fit:cover; }
.foto-nav{ position:absolute; top:50%; transform:translateY(-50%); width:36px; height:36px; border:none; border-radius:50%; background:rgba(0,0,0,.35); color:#fff; z-index:10; }
.foto-prev{ left:10px; }
.foto-next{ right:10px; }
.modal-var-name{ font-size:1.15rem; font-weight:700; margin-bottom:10px; }
.modal-include-label{ font-size:.92rem; font-weight:600; margin-bottom:6px; }
.modal-include-ol{ padding-left:20px; font-size:.9rem; color:#444; margin-bottom:18px; }
.modal-harga-label{ font-size:.78rem; color:#999; }
.modal-harga-val{ font-size:1.2rem; color:#b85a00; font-weight:700; }
.modal-dekor .modal-footer{ border:none; padding:0 24px 20px; gap:10px; }
.nav-btn:hover{ background:rgba(255,255,255,.35); }
.btn-kembali{ position:fixed; bottom:20px; left:20px; border-radius:30px; padding:10px 20px; z-index:1000; }
@media(max-width:992px){ .modal-dekor .modal-dialog{ max-width:650px; } }
@media(max-width:768px){ .judul h1{ font-size:54px; } }
@media(max-width:576px){
    .modal-dekor .modal-dialog{ width:86%; max-width:360px; margin:.75rem auto; }
    .modal-dekor .modal-content{ border-radius:18px; max-height:88vh; }
    .modal-dekor .modal-header{ padding:11px 12px; }
    .modal-level2-bar{ gap:6px; }
    .var-btn{ width:26px; height:26px; }
    .var-label{ font-size:.76rem; }
    .counter2{ font-size:.64rem; }
    .modal-content-wrap{ grid-template-columns:1fr; gap:12px; }
    .modal-dekor .modal-body{ padding:12px; }
    .modal-img-wrap{ max-height:38vh; aspect-ratio:1/1; border-radius:12px; }
    .foto-nav{ width:30px; height:30px; }
    .variant-dots{ margin-bottom:8px; }
    .modal-var-name{ font-size:.95rem; margin-bottom:6px; }
    .modal-include-label{ font-size:.82rem; margin-bottom:4px; }
    .modal-include-ol{ font-size:.78rem; margin-bottom:10px; }
    .modal-harga-label{ font-size:.7rem; }
    .modal-harga-val{ font-size:1rem; }
    .modal-dekor .modal-footer{ padding:0 12px 12px; }
    .modal-dekor .modal-footer .btn{ padding:7px 10px; font-size:.84rem; }
}
</style>
</head>
<body>
<?php include 'include/navbar.php'; ?>
<main class="page-wrap">
<div class="container">
<div class="text-center mb-5 judul">
    <h1>Dekorasi & Terop</h1>
    <div class="line mt-2"></div>
</div>
<?php if (empty($dekorData)): ?>
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-inbox display-5 text-muted"></i>
        <h5 class="mt-3">Belum ada layanan dekor aktif</h5>
        <p class="text-muted mb-0">Admin dapat menambahkan layanan dekor dari halaman Data Layanan.</p>
    </div>
</div>
<?php else: ?>
<div class="row g-4" id="dekorGrid"></div>
<?php endif; ?>
</div>
</main>
<div class="modal fade modal-dekor" id="modalDekor" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
    <div class="modal-level2-bar">
        <button class="var-btn" id="btnPrev2" onclick="navigasi2(-1)"><i class="bi bi-chevron-left"></i></button>
        <div class="var-label" id="varLabel"></div>
        <div class="counter2" id="counter2"></div>
        <button class="var-btn" id="btnNext2" onclick="navigasi2(1)"><i class="bi bi-chevron-right"></i></button>
    </div>
</div>
<div class="modal-body">
    <div class="variant-dots" id="variantDots"></div>
    <div class="modal-content-wrap">
        <div class="modal-img-wrap">
            <button class="foto-nav foto-prev" onclick="navigasi2(-1)"><i class="bi bi-chevron-left"></i></button>
            <button class="foto-nav foto-next" onclick="navigasi2(1)"><i class="bi bi-chevron-right"></i></button>
            <img id="modalImg" src="" alt="">
        </div>
        <div>
            <div class="modal-var-name" id="modalVarName"></div>
            <div class="modal-include-label">Include :</div>
            <ol class="modal-include-ol" id="modalInclude"></ol>
            <div class="modal-harga-label">Harga</div>
            <div class="modal-harga-val" id="modalHarga"></div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-dark flex-grow-1" id="btnKeranjang"><i class="bi bi-cart3"></i> Keranjang</button>
    <button type="button" class="btn btn-warning flex-grow-1" id="modalBookingBtn">Booking</button>
</div>
</div>
</div>
</div>
<a href="service.php" class="btn btn-danger btn-kembali shadow">Kembali</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;
const dekorData = <?= json_encode($dekorData, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

let idxDekor = 0;
let idxVariasi = 0;
let bsModal = null;

function renderCards(){
    const grid = document.getElementById('dekorGrid');
    if (!grid) return;
    grid.innerHTML = dekorData.map((d, i) => {
        const first = d.variasi[0];
        return `
        <div class="col-md-6">
            <div class="card card-custom p-3" onclick="bukaModal(${i})">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">${d.jenis}</h5>
                    <span class="variant-count">${d.variasi.length} variasi tersedia</span>
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
        </div>`;
    }).join('');
}

function bukaModal(i){
    idxDekor = i;
    idxVariasi = 0;
    renderModal();
    if (!bsModal) {
        bsModal = new bootstrap.Modal(document.getElementById('modalDekor'));
    }
    bsModal.show();
}

function renderModal(){
    const dekor = dekorData[idxDekor];
    const varian = dekor.variasi[idxVariasi];
    document.getElementById('varLabel').textContent = varian.nama;
    document.getElementById('counter2').textContent = `${idxVariasi + 1}/${dekor.variasi.length}`;
    const imgEl = document.getElementById('modalImg');
    imgEl.src = varian.foto;
    imgEl.onerror = function(){ this.src = 'https://placehold.co/600x400?text=Gambar+Dekorasi'; };
    document.getElementById('modalVarName').textContent = varian.nama;
    document.getElementById('modalHarga').textContent = varian.harga;
    document.getElementById('modalInclude').innerHTML = varian.include.map(x => `<li>${x}</li>`).join('');
    document.getElementById('variantDots').innerHTML = dekor.variasi.map((_, i) => `<div class="variant-dot ${i === idxVariasi ? 'active' : ''}"></div>`).join('');
}

function navigasi2(arah){
    const dekor = dekorData[idxDekor];
    const next = idxVariasi + arah;
    if (next < 0 || next >= dekor.variasi.length) return;
    idxVariasi = next;
    renderModal();
}

function getPriceValue(priceText){
    return Number(String(priceText).replace(/[^0-9]/g, '')) || 0;
}

document.getElementById('modalBookingBtn').addEventListener('click', () => {
    const selected = dekorData[idxDekor].variasi[idxVariasi];
    const harga = getPriceValue(selected.harga);
    if (!isLoggedIn) {
        Swal.fire({ icon: 'warning', title: 'Login diperlukan', text: 'Silakan login terlebih dahulu' });
        return;
    }
    window.location.href = `booking.php?from=dekor&id=${encodeURIComponent(selected.id)}&layanan=${encodeURIComponent(selected.nama)}&harga=${harga}`;
});

document.getElementById('btnKeranjang').addEventListener('click', () => {
    const selected = dekorData[idxDekor].variasi[idxVariasi];
    addToCart(selected.nama, 'dekor', getPriceValue(selected.harga), selected.foto, selected.id);
});

renderCards();
</script>
<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>