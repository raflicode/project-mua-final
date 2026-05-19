<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Layanan | Yayuk Makeover</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:       #F5F0E8;
            --cream-dark:  #EDE5D8;
            --cream-deep:  #E0D5C5;
            --brown-light: #C4A882;
            --brown:       #8B6B4A;
            --brown-dark:  #5C3D1E;
            --brown-deep:  #3B2410;
            --text-main:   #2C1A0E;
            --text-muted:  #7A6352;
            --white:       #FFFDF9;
            --accent:      #D4956A;
            --accent-soft: #F0DBC8;
            --sidebar-w:   240px;
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family:'DM Sans',sans-serif;
            background:var(--cream);
            color:var(--text-main);
            min-height:100vh;
            display:flex;
        }

        /* SIDEBAR */
        .sidebar {
            width:var(--sidebar-w);
            min-height:100vh;
            background:var(--brown-dark);
            display:flex;
            flex-direction:column;
            position:fixed;
            top:0; left:0;
            z-index:100;
        }
        .sidebar-logo {
            padding:28px 24px 20px;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }
        .sidebar-logo .brand {
            font-family:'Playfair Display',serif;
            font-size:1.1rem;
            font-weight:700;
            color:var(--cream);
        }
        .sidebar-logo .brand span { color:var(--brown-light); }
        .sidebar-logo .sub {
            font-size:0.7rem;
            color:var(--brown-light);
            letter-spacing:2px;
            text-transform:uppercase;
            margin-top:2px;
        }
        .sidebar-nav { flex:1; padding:16px 0; }
        .nav-label {
            font-size:0.65rem;
            letter-spacing:2px;
            text-transform:uppercase;
            color:rgba(255,255,255,0.3);
            padding:12px 24px 6px;
        }
        .nav-item a {
            display:flex;
            align-items:center;
            gap:12px;
            padding:11px 24px;
            color:rgba(255,255,255,0.65);
            text-decoration:none;
            font-size:0.875rem;
            border-left:3px solid transparent;
            transition:all 0.2s;
        }
        .nav-item a:hover { color:var(--cream); background:rgba(255,255,255,0.06); }
        .nav-item a.active {
            color:var(--cream);
            background:rgba(196,168,130,0.15);
            border-left-color:var(--brown-light);
            font-weight:500;
        }
        .nav-item a i { font-size:1rem; width:18px; text-align:center; }
        .sidebar-footer { padding:16px 24px; border-top:1px solid rgba(255,255,255,0.08); }
        .logout-btn {
            display:flex;
            align-items:center;
            gap:10px;
            color:rgba(255,255,255,0.5);
            text-decoration:none;
            font-size:0.85rem;
            transition:color 0.2s;
        }
        .logout-btn:hover { color:#e07b6e; }

        /* MAIN */
        .main { margin-left:var(--sidebar-w); flex:1; min-height:100vh; display:flex; flex-direction:column; }

        /* TOPBAR */
        .topbar {
            background:var(--white);
            border-bottom:1px solid var(--cream-deep);
            padding:14px 32px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            position:sticky;
            top:0;
            z-index:50;
        }
        .page-title {
            font-family:'Playfair Display',serif;
            font-size:1.2rem;
            font-weight:600;
            color:var(--brown-dark);
        }
        .breadcrumb-nav { font-size:0.78rem; color:var(--text-muted); }
        .topbar-right { display:flex; align-items:center; gap:16px; }
        .search-box {
            display:flex;
            align-items:center;
            background:var(--cream);
            border:1px solid var(--cream-deep);
            border-radius:10px;
            padding:7px 14px;
            gap:8px;
        }
        .search-box input {
            border:none;
            background:transparent;
            font-size:0.82rem;
            color:var(--text-main);
            outline:none;
            width:180px;
            font-family:'DM Sans',sans-serif;
        }
        .search-box input::placeholder { color:var(--text-muted); }
        .search-box i { color:var(--text-muted); font-size:0.9rem; }
        .admin-badge {
            display:flex;
            align-items:center;
            gap:10px;
            background:var(--cream);
            border:1px solid var(--cream-deep);
            border-radius:10px;
            padding:6px 14px 6px 8px;
        }
        .admin-avatar {
            width:30px; height:30px;
            border-radius:50%;
            background:var(--brown);
            display:flex; align-items:center; justify-content:center;
            color:var(--cream);
            font-size:0.75rem; font-weight:600;
        }
        .admin-name { font-size:0.82rem; font-weight:500; color:var(--text-main); }

        /* CONTENT */
        .content { padding:32px; flex:1; }

        .content-header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:28px;
        }
        .content-header h2 {
            font-family:'Playfair Display',serif;
            font-size:1.6rem;
            font-weight:600;
            color:var(--brown-dark);
        }
        .content-header p { font-size:0.85rem; color:var(--text-muted); }

        .btn-tambah {
            display:flex;
            align-items:center;
            gap:8px;
            background:var(--brown-dark);
            color:var(--cream);
            border:none;
            border-radius:12px;
            padding:10px 20px;
            font-size:0.85rem;
            font-weight:600;
            cursor:pointer;
            font-family:'DM Sans',sans-serif;
            transition:background 0.2s;
        }
        .btn-tambah:hover { background:var(--brown-deep); }

        /* CATEGORY TABS */
        .category-tabs {
            display:flex;
            gap:8px;
            margin-bottom:24px;
        }
        .cat-tab {
            display:flex;
            align-items:center;
            gap:8px;
            padding:9px 20px;
            border-radius:12px;
            border:1.5px solid var(--cream-deep);
            background:var(--white);
            color:var(--text-muted);
            font-size:0.85rem;
            font-weight:500;
            cursor:pointer;
            transition:all 0.2s;
        }
        .cat-tab.active, .cat-tab:hover {
            background:var(--brown-dark);
            color:var(--cream);
            border-color:var(--brown-dark);
        }
        .cat-tab .dot {
            width:8px; height:8px;
            border-radius:50%;
        }

        /* CARDS GRID */
        .cards-grid {
            display:grid;
            grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));
            gap:20px;
            margin-bottom:32px;
        }

        .layanan-card {
            background:var(--white);
            border-radius:20px;
            border:1.5px solid var(--cream-deep);
            overflow:hidden;
            transition:all 0.22s;
        }
        .layanan-card:hover {
            border-color:var(--brown-light);
            box-shadow:0 8px 28px rgba(139,107,74,0.13);
            transform:translateY(-3px);
        }

        .card-img-area {
            width:100%;
            height:180px;
            background:var(--cream-dark);
            position:relative;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .card-img-area img {
            width:100%;
            height:100%;
            object-fit:cover;
            object-position:top;
        }
        .card-img-area .no-img {
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:8px;
            color:var(--brown-light);
        }
        .card-img-area .no-img i { font-size:2rem; }
        .card-img-area .no-img span { font-size:0.75rem; }

        .card-img-area .upload-overlay {
            position:absolute;
            inset:0;
            background:rgba(92,61,30,0.5);
            display:flex;
            align-items:center;
            justify-content:center;
            opacity:0;
            transition:opacity 0.2s;
            cursor:pointer;
            color:#fff;
            font-size:0.82rem;
            gap:6px;
        }
        .card-img-area:hover .upload-overlay { opacity:1; }

        .cat-ribbon {
            position:absolute;
            top:12px; left:12px;
            padding:4px 12px;
            border-radius:20px;
            font-size:0.68rem;
            font-weight:700;
            letter-spacing:1px;
            text-transform:uppercase;
        }
        .ribbon-makeup  { background:#D4956A; color:#fff; }
        .ribbon-kostum  { background:#8B6B4A; color:#fff; }
        .ribbon-dekor   { background:#5C3D1E; color:#fff; }

        .card-body-area {
            padding:18px 18px 14px;
        }
        .card-paket-name {
            font-family:'Playfair Display',serif;
            font-size:1rem;
            font-weight:600;
            color:var(--brown-dark);
            margin-bottom:4px;
        }
        .card-harga {
            font-size:0.9rem;
            font-weight:600;
            color:var(--brown);
            margin-bottom:8px;
        }
        .card-desc {
            font-size:0.8rem;
            color:var(--text-muted);
            line-height:1.5;
            margin-bottom:14px;
            display:-webkit-box;
            -webkit-line-clamp:2;
            -webkit-box-orient:vertical;
            overflow:hidden;
        }
        .card-actions {
            display:flex;
            gap:8px;
            border-top:1px solid var(--cream-deep);
            padding-top:14px;
        }
        .btn-edit-card {
            flex:1;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:6px;
            padding:9px;
            border-radius:10px;
            background:var(--cream);
            border:1px solid var(--cream-deep);
            color:var(--brown-dark);
            font-size:0.8rem;
            font-weight:600;
            cursor:pointer;
            font-family:'DM Sans',sans-serif;
            transition:all 0.2s;
        }
        .btn-edit-card:hover { background:var(--brown-dark); color:var(--cream); border-color:var(--brown-dark); }
        .btn-del-card {
            width:36px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:10px;
            background:var(--cream);
            border:1px solid var(--cream-deep);
            color:#b94040;
            font-size:0.9rem;
            cursor:pointer;
            transition:all 0.2s;
        }
        .btn-del-card:hover { background:#fdecea; border-color:#f5bcbc; }

        /* MODAL */
        .modal-overlay {
            display:none;
            position:fixed;
            inset:0;
            background:rgba(44,26,14,0.45);
            z-index:200;
            align-items:center;
            justify-content:center;
        }
        .modal-overlay.show { display:flex; }

        .modal-box {
            background:var(--white);
            border-radius:24px;
            width:100%;
            max-width:520px;
            max-height:90vh;
            overflow-y:auto;
            padding:32px;
            position:relative;
            box-shadow:0 24px 60px rgba(44,26,14,0.25);
        }

        .modal-close {
            position:absolute;
            top:18px; right:18px;
            width:32px; height:32px;
            border-radius:50%;
            border:none;
            background:var(--cream);
            color:var(--text-muted);
            font-size:1rem;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            transition:background 0.2s;
        }
        .modal-close:hover { background:var(--cream-deep); }

        .modal-title {
            font-family:'Playfair Display',serif;
            font-size:1.3rem;
            font-weight:600;
            color:var(--brown-dark);
            margin-bottom:6px;
        }
        .modal-sub {
            font-size:0.82rem;
            color:var(--text-muted);
            margin-bottom:24px;
        }

        .form-group { margin-bottom:18px; }
        .form-label {
            display:block;
            font-size:0.8rem;
            font-weight:600;
            color:var(--text-main);
            margin-bottom:6px;
        }
        .form-control-custom {
            width:100%;
            padding:10px 14px;
            border:1.5px solid var(--cream-deep);
            border-radius:10px;
            font-size:0.88rem;
            font-family:'DM Sans',sans-serif;
            color:var(--text-main);
            background:var(--cream);
            outline:none;
            transition:border-color 0.2s;
        }
        .form-control-custom:focus { border-color:var(--brown-light); background:var(--white); }
        textarea.form-control-custom { resize:vertical; min-height:90px; }

        .harga-wrap {
            display:flex;
            align-items:center;
            border:1.5px solid var(--cream-deep);
            border-radius:10px;
            overflow:hidden;
            background:var(--cream);
            transition:border-color 0.2s;
        }
        .harga-wrap:focus-within { border-color:var(--brown-light); background:var(--white); }
        .harga-prefix {
            padding:10px 12px;
            font-size:0.85rem;
            font-weight:600;
            color:var(--brown);
            background:var(--cream-deep);
            border-right:1.5px solid var(--cream-deep);
            white-space:nowrap;
        }
        .harga-wrap input {
            flex:1;
            border:none;
            background:transparent;
            padding:10px 14px;
            font-size:0.88rem;
            font-family:'DM Sans',sans-serif;
            color:var(--text-main);
            outline:none;
        }

        .select-custom {
            width:100%;
            padding:10px 14px;
            border:1.5px solid var(--cream-deep);
            border-radius:10px;
            font-size:0.88rem;
            font-family:'DM Sans',sans-serif;
            color:var(--text-main);
            background:var(--cream);
            outline:none;
            cursor:pointer;
            appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%237A6352' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat:no-repeat;
            background-position:right 14px center;
        }
        .select-custom:focus { border-color:var(--brown-light); }

        /* Upload area */
        .upload-area {
            border:2px dashed var(--cream-deep);
            border-radius:14px;
            padding:24px;
            text-align:center;
            cursor:pointer;
            transition:all 0.2s;
            position:relative;
        }
        .upload-area:hover { border-color:var(--brown-light); background:var(--accent-soft); }
        .upload-area input[type="file"] {
            position:absolute;
            inset:0;
            opacity:0;
            cursor:pointer;
        }
        .upload-area i { font-size:1.8rem; color:var(--brown-light); margin-bottom:8px; display:block; }
        .upload-area p { font-size:0.8rem; color:var(--text-muted); }
        .upload-area .file-name { font-size:0.78rem; color:var(--brown); margin-top:6px; font-weight:600; }

        .modal-actions {
            display:flex;
            gap:10px;
            margin-top:24px;
        }
        .btn-simpan {
            flex:1;
            padding:11px;
            background:var(--brown-dark);
            color:var(--cream);
            border:none;
            border-radius:12px;
            font-size:0.88rem;
            font-weight:600;
            cursor:pointer;
            font-family:'DM Sans',sans-serif;
            transition:background 0.2s;
        }
        .btn-simpan:hover { background:var(--brown-deep); }
        .btn-hapus-modal {
            padding:11px 20px;
            background:#fdecea;
            color:#b94040;
            border:1px solid #f5bcbc;
            border-radius:12px;
            font-size:0.88rem;
            font-weight:600;
            cursor:pointer;
            font-family:'DM Sans',sans-serif;
            transition:all 0.2s;
        }
        .btn-hapus-modal:hover { background:#f9d0d0; }

        /* EMPTY */
        .empty-cat {
            text-align:center;
            padding:60px 20px;
            color:var(--text-muted);
            background:var(--white);
            border-radius:20px;
            border:1.5px dashed var(--cream-deep);
        }
        .empty-cat i { font-size:2.5rem; opacity:0.3; margin-bottom:10px; display:block; }
        .empty-cat p { font-size:0.88rem; }

        /* TOAST */
        .toast-msg {
            position:fixed;
            bottom:28px; right:28px;
            background:var(--brown-dark);
            color:var(--cream);
            padding:12px 22px;
            border-radius:12px;
            font-size:0.85rem;
            font-weight:500;
            z-index:999;
            opacity:0;
            transform:translateY(10px);
            transition:all 0.3s;
            pointer-events:none;
        }
        .toast-msg.show { opacity:1; transform:translateY(0); }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="brand">Yayuk <span>Makeover</span></div>
        <div class="sub">Admin Panel</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <div class="nav-item"><a href="admin_dashboard.php"><i class="bi bi-grid-1x2"></i> Dashboard</a></div>
        <div class="nav-item"><a href="admin_booking.php"><i class="bi bi-calendar-check"></i> Booking</a></div>
        <div class="nav-item"><a href="admin_layanan.php" class="active"><i class="bi bi-stars"></i> Data Layanan</a></div>
        <div class="nav-label">Pengguna</div>
        <div class="nav-item"><a href="admin_user.php"><i class="bi bi-people"></i> Manajemen User</a></div>
        <div class="nav-item"><a href="admin_pembayaran.php"><i class="bi bi-credit-card"></i> Pembayaran</a></div>
    </nav>
    <div class="sidebar-footer">
        <a href="logout.php" class="logout-btn"><i class="bi bi-box-arrow-left"></i> Log Out</a>
    </div>
</aside>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            <div class="page-title">Data Layanan</div>
            <div class="breadcrumb-nav">Admin / Data Layanan</div>
        </div>
        <div class="topbar-right">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Cari layanan..." id="searchInput" oninput="renderCards()">
            </div>
            <div class="admin-badge">
                <div class="admin-avatar">A</div>
                <div class="admin-name">Admin</div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="content-header">
            <div>
                <h2>Paket Layanan</h2>
                <p>Kelola layanan Makeup, Kostum, dan Dekor</p>
            </div>
            <button class="btn-tambah" onclick="openModal()">
                <i class="bi bi-plus-lg"></i> Tambah Layanan
            </button>
        </div>

        <!-- CATEGORY TABS -->
        <div class="category-tabs">
            <div class="cat-tab active" onclick="setKategori('semua', this)">
                <span class="dot" style="background:var(--brown-light)"></span> Semua
            </div>
            <div class="cat-tab" onclick="setKategori('makeup', this)">
                <span class="dot" style="background:#D4956A"></span> Makeup
            </div>
            <div class="cat-tab" onclick="setKategori('kostum', this)">
                <span class="dot" style="background:#8B6B4A"></span> Kostum
            </div>
            <div class="cat-tab" onclick="setKategori('dekor', this)">
                <span class="dot" style="background:#5C3D1E"></span> Dekor
            </div>
        </div>

        <!-- CARDS -->
        <div class="cards-grid" id="cardsGrid"></div>
        <div id="emptyState" class="empty-cat" style="display:none;">
            <i class="bi bi-inbox"></i>
            <p>Belum ada layanan di kategori ini.<br>Klik <strong>Tambah Layanan</strong> untuk mulai.</p>
        </div>

    </div>
</div>

<!-- MODAL TAMBAH / EDIT -->
<div class="modal-overlay" id="modalOverlay" onclick="closeOnBg(event)">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal()"><i class="bi bi-x"></i></button>
        <div class="modal-title" id="modalTitle">Tambah Layanan</div>
        <div class="modal-sub" id="modalSub">Isi detail paket layanan baru</div>

        <input type="hidden" id="editId">

        <div class="form-group">
            <label class="form-label">Kategori</label>
            <select class="select-custom" id="formKategori">
                <option value="makeup">Makeup</option>
                <option value="kostum">Kostum</option>
                <option value="dekor">Dekor</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Nama Paket</label>
            <input type="text" class="form-control-custom" id="formNama" placeholder="Contoh: Makeup Wedding Premium">
        </div>

        <div class="form-group">
            <label class="form-label">Harga</label>
            <div class="harga-wrap">
                <span class="harga-prefix">Rp</span>
                <input type="number" id="formHarga" placeholder="2500000">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control-custom" id="formDeskripsi" placeholder="Deskripsi singkat layanan..."></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Foto Layanan</label>
            <div class="upload-area" id="uploadArea">
                <input type="file" accept="image/*" onchange="previewFile(this)">
                <i class="bi bi-cloud-upload"></i>
                <p>Klik atau drag foto ke sini</p>
                <div class="file-name" id="fileName"></div>
            </div>
        </div>

        <div class="modal-actions">
            <button class="btn-hapus-modal" id="btnHapusModal" onclick="hapusLayanan()" style="display:none;">
                <i class="bi bi-trash"></i> Hapus
            </button>
            <button class="btn-simpan" onclick="simpanLayanan()">
                <i class="bi bi-check2"></i> Simpan
            </button>
        </div>
    </div>
</div>

<!-- TOAST -->
<div class="toast-msg" id="toastMsg"></div>

<script>
// ===== DATA (ganti dengan fetch PHP/MySQL) =====
let layananData = [
    { id:1, kategori:'makeup', nama:'Makeup Graduation', harga:800000,  deskripsi:'Makeup wisuda natural & tahan lama cocok untuk foto dan acara resmi.', foto:'' },
    { id:2, kategori:'makeup', nama:'Makeup Wedding',    harga:1500000, deskripsi:'Full coverage makeup pernikahan lengkap dengan hairdo dan softlens.', foto:'' },
    { id:3, kategori:'makeup', nama:'Makeup Carnaval',   harga:1000000, deskripsi:'Makeup artistik untuk karnaval dengan glitter dan riasan bold.', foto:'' },
    { id:4, kategori:'makeup', nama:'Makeup Natural',    harga:600000,  deskripsi:'Riasan ringan sehari-hari dengan kesan segar dan bersih.', foto:'' },
    { id:5, kategori:'kostum', nama:'Kostum Wedding',    harga:4000000, deskripsi:'Gaun pengantin custom size dengan aksesoris lengkap.', foto:'' },
    { id:6, kategori:'kostum', nama:'Kostum Graduation', harga:1200000, deskripsi:'Kostum wisuda modern dan elegan untuk hari spesial.', foto:'' },
    { id:7, kategori:'kostum', nama:'Kostum Karnaval',   harga:900000,  deskripsi:'Kostum tema karnaval dengan desain mencolok dan unik.', foto:'' },
    { id:8, kategori:'dekor',  nama:'Dekor Pelaminan',   harga:6500000, deskripsi:'Dekorasi pelaminan lengkap dengan standing flower & photo booth.', foto:'' },
    { id:9, kategori:'dekor',  nama:'Dekor Terop',       harga:3500000, deskripsi:'Terop dan dekorasi tamu untuk acara outdoor maupun indoor.', foto:'' },
];
let nextId = 10;

let currentKat = 'semua';

const ribbonClass = { makeup:'ribbon-makeup', kostum:'ribbon-kostum', dekor:'ribbon-dekor' };

function fmt(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }

function setKategori(kat, el) {
    currentKat = kat;
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    renderCards();
}

function renderCards() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const grid   = document.getElementById('cardsGrid');
    const empty  = document.getElementById('emptyState');

    const filtered = layananData.filter(l => {
        const katMatch  = currentKat === 'semua' || l.kategori === currentKat;
        const srchMatch = l.nama.toLowerCase().includes(search) || l.deskripsi.toLowerCase().includes(search);
        return katMatch && srchMatch;
    });

    if (filtered.length === 0) {
        grid.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    grid.innerHTML = filtered.map(l => `
        <div class="layanan-card">
            <div class="card-img-area">
                ${l.foto
                    ? `<img src="${l.foto}" alt="${l.nama}">`
                    : `<div class="no-img"><i class="bi bi-image"></i><span>Belum ada foto</span></div>`
                }
                <span class="cat-ribbon ${ribbonClass[l.kategori]}">${l.kategori}</span>
                <div class="upload-overlay"><i class="bi bi-camera"></i> Ganti foto</div>
            </div>
            <div class="card-body-area">
                <div class="card-paket-name">${l.nama}</div>
                <div class="card-harga">${fmt(l.harga)}</div>
                <div class="card-desc">${l.deskripsi || '-'}</div>
                <div class="card-actions">
                    <button class="btn-edit-card" onclick="openModal(${l.id})">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button class="btn-del-card" onclick="konfirmasiHapus(${l.id})" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

function openModal(id) {
    document.getElementById('fileName').textContent = '';
    if (id) {
        const l = layananData.find(x => x.id === id);
        if (!l) return;
        document.getElementById('modalTitle').textContent  = 'Edit Layanan';
        document.getElementById('modalSub').textContent    = 'Perbarui detail paket layanan';
        document.getElementById('editId').value            = id;
        document.getElementById('formKategori').value      = l.kategori;
        document.getElementById('formNama').value          = l.nama;
        document.getElementById('formHarga').value         = l.harga;
        document.getElementById('formDeskripsi').value     = l.deskripsi;
        document.getElementById('btnHapusModal').style.display = 'block';
    } else {
        document.getElementById('modalTitle').textContent  = 'Tambah Layanan';
        document.getElementById('modalSub').textContent    = 'Isi detail paket layanan baru';
        document.getElementById('editId').value            = '';
        document.getElementById('formKategori').value      = currentKat !== 'semua' ? currentKat : 'makeup';
        document.getElementById('formNama').value          = '';
        document.getElementById('formHarga').value         = '';
        document.getElementById('formDeskripsi').value     = '';
        document.getElementById('btnHapusModal').style.display = 'none';
    }
    document.getElementById('modalOverlay').classList.add('show');
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('show');
}

function closeOnBg(e) {
    if (e.target === document.getElementById('modalOverlay')) closeModal();
}

function previewFile(input) {
    if (input.files && input.files[0]) {
        document.getElementById('fileName').textContent = '📎 ' + input.files[0].name;
    }
}

function simpanLayanan() {
    const id       = document.getElementById('editId').value;
    const kategori = document.getElementById('formKategori').value;
    const nama     = document.getElementById('formNama').value.trim();
    const harga    = document.getElementById('formHarga').value;
    const deskripsi= document.getElementById('formDeskripsi').value.trim();

    if (!nama || !harga) { toast('Nama dan harga wajib diisi!'); return; }

    if (id) {
        const idx = layananData.findIndex(x => x.id == id);
        if (idx > -1) {
            layananData[idx] = { ...layananData[idx], kategori, nama, harga: Number(harga), deskripsi };
            toast('Layanan berhasil diperbarui ✓');
        }
    } else {
        layananData.push({ id: nextId++, kategori, nama, harga: Number(harga), deskripsi, foto:'' });
        toast('Layanan berhasil ditambahkan ✓');
    }

    closeModal();
    renderCards();
}

function hapusLayanan() {
    const id = document.getElementById('editId').value;
    konfirmasiHapus(id);
}

function konfirmasiHapus(id) {
    if (!confirm('Yakin hapus layanan ini?')) return;
    layananData = layananData.filter(x => x.id != id);
    closeModal();
    renderCards();
    toast('Layanan dihapus');
}

function toast(msg) {
    const el = document.getElementById('toastMsg');
    el.textContent = msg;
    el.classList.add('show');
    setTimeout(() => el.classList.remove('show'), 2800);
}

// INIT
renderCards();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>