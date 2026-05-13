<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!-- Link Icon ini ditaruh di sini supaya otomatis terbawa ke file mana pun yang meng-include navbar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
  .btn-custom-gold {
    border-color: #b5835a !important;
    color: #b5835a !important;
  }

  .btn-custom-gold:hover {
    background-color: #b5835a !important;
    border-color: #b5835a !important;
    color: white !important;
  }

  /* 1. Pastikan transisi dipasang di class utama */
  .transition-nav {
    transition: all 0.5s ease-in-out !important;
    background-color: transparent;
    /* Awalnya transparan */

  }

  /* 2. Warna teks default saat di atas (Putih agar kontras dengan hero image) */
  .navbar .nav-link,
  .navbar .navbar-brand {
    color: black !important;
    transition: 0.3s;
  }

  /* 3. Class saat di-scroll (Warna background putih, teks jadi gelap) */
  .nav-scrolled {
    background-color: #ffffff !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
  }

  /* Paksa teks jadi hitam/gelap saat background putih muncul */
  .nav-scrolled .nav-link,
  .nav-scrolled .navbar-brand {
    color: #333 !important;
  }

  /* Tombol login menyesuaikan warna emas kamu saat scroll */
  .nav-scrolled .btn-outline-dark {
    color: #A58459 !important;
    border-color: #A58459 !important;
  }

  .offcanvas-custom.offcanvas-top {
    height: 50vh;
    border-bottom: 2px solid #b5835a;
  }

  /* Container Icon Profile */
  .profile-circle-icon {
    font-size: 1.8rem;
    color: black;
    transition: 0.3s;
    display: flex;
    align-items: center;
  }

  .profile-circle-icon:hover {
    color: #a7a6a6;
    /* Warna ungu pas di hover biar senada sama login */
  }

  /* Styling Dropdown Box */
  .dropdown-menu-custom {
    background-color: #ffffff;
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    margin-top: 10px !important;
  }

  .dropdown-item-custom {
    color: #333 !important;
    font-size: 14px;
    padding: 8px 20px;
  }

  .dropdown-item-custom:hover {
    background-color: #f8f9fa;
  }
</style>

<style>
.nav-link i {
        font-size: 1.5rem;
        color: #333;
    }
    #cart-badge {
        padding: 0.35em 0.5em;
        line-height: 1;
        z-index: 10;
    }

/* Memastikan posisi dropdown relatif terhadap icon */
.dropdown-cart {
    position: relative;
    display: inline-block;
}

/* Kotak preview yang akan muncul */
.cart-preview-box {
    position: absolute;
    top: 100%; /* Muncul tepat di bawah navbar */
    right: 0;
    width: 500px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    padding: 15px;
    display: none; /* Sembunyikan dulu */
    z-index: 9999;
    border: 1px solid #eee;
    margin-top: 10px;
}

.cart-preview-box img {
        width: 100px !important; /* Ukuran gambar diperbesar */
        height: 100px !important;
        border-radius: 8px;
    }

/* Munculkan kotak saat kursor diarahkan ke area keranjang */
.dropdown-cart:hover .cart-preview-box {
    display: block;
}


/* Gaya item di dalam preview */
.preview-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
}

.preview-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
}

.navbar.bg-white {
        background-color: #ffffff !important; /* Memastikan warna putih bersih */
        transition: all 0.3s ease;
    }

    /* Mengatur warna teks link agar gelap (karena background putih) */
    .navbar-light .nav-link {
        color: #333333 !important;
        font-weight: 500;
    }

    /* Warna saat kursor diarahkan ke menu (hover) */
    .navbar-light .nav-link:hover {
        color: #FED03A !important; /* Warna gold khas Yayuk Makeover */
    }

    /* Tambahkan bayangan halus agar navbar terpisah dari konten bawah */
    .shadow-sm {
        box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
    }
</style>

<nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top px-3 transition-nav bg-white navbar-light shadow-sm">
  <div class=" container-fluid ">
    <a class=" navbar-brand fw-bold" href="/project-mua-final/index.php">
  Yayuk <span style="font-style: italic; font-weight: 300; color: #FED03A;">Makeover</span>
  </a>

  <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas"
    data-bs-target="#mobileMenu">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="d-none d-lg-flex ms-auto align-items-center gap-4 text-dark">

    <a class="nav-link ]" href="/project-mua-final/index.php">Home</a>
    <a class="nav-link " href="/project-mua-final/public/service.php">Service</a>
    <a class="nav-link " href="/project-mua-final/index.php#gallery">Gallery</a>
    <a class="nav-link " href="/project-mua-final/public/cart.php">Keranjang</a>


    <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>
      <!-- DROPDRON PROFILE -->
      <div class="dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center border-0" href="#" role="button"
          data-bs-toggle="dropdown" aria-expanded="false">
          <!-- Icon Vector Umum (Kepala & Badan) -->
          <div class="profile-circle-icon">
            <i class="bi bi-person-circle"></i>
          </div>
        </a>

        

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
          <li>
            <div class="dropdown-header text-muted">Halo, <strong><?= $_SESSION['username']; ?></strong></div>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <!-- Link Logout Backend Kamu -->
          <li><a class="dropdown-item text-danger fw-bold" href="../project-mua-final/public/logout.php">Logout</a></li>
        </ul>
      </div>
    <?php else: ?>
      <a class="btn btn-custom-gold border-2 ms-2" href="/project-mua-final/public/login.php">Login</a> <?php endif; ?>
  </div>
  </div>
</nav>

<!-- OFF CANVAS (MOBILE) -->
<div class="offcanvas offcanvas-top bg-dark text-white offcanvas-custom" tabindex="-1" id="mobileMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav gap-3">
      <li><a class="nav-link text-white" href="../../project-mua-final/dasboard.php">🏠 Home</a></li>
      <li><a class="nav-link text-white" href="../../project-mua-final/public/service.php">💄 Service</a></li>
      <li><a class="nav-link text-white" href="../../project-mua-final/dasboard.php#gallery">🖼️ Gallery</a></li>
      <li><a class="nav-link text-white" href="../../project-mua-final/public/cart.php">🛒 Keranjang</a></li>
    </ul>

    <div class="border-top pt-3 mt-4">
      <?php if (isset($_SESSION['id_user'])): ?>
        <div class="d-flex align-items-center gap-3">
          <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
          <div>
            <div class="fw-bold"><?= $_SESSION['username']; ?></div>
            <small class="text-secondary"><?= $_SESSION['email'] ?? 'Member'; ?></small>
          </div>
        </div>
        <a href="../project-mua-final/public/logout.php" class="text-danger d-block mt-3 fw-bold">Logout</a>
      <?php else: ?>
        <a href="/project-mua-final/public/login.php" class="text-white">Login</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  window.onscroll = function () {
    var navbar = document.getElementById('mainNavbar');

    // Jika user scroll lebih dari 50px ke bawah
    if (window.pageYOffset > 50) {
      navbar.classList.add('nav-scrolled');
    } else {
      // Jika balik lagi ke posisi paling atas
      navbar.classList.remove('nav-scrolled');
    }
  };
</script>

<script>
function addToCart(id, nama, harga, foto) {
    let cart = JSON.parse(localStorage.getItem('yayuk_cart')) || [];
    let foundIndex = cart.findIndex(item => item.id === id);

    if (foundIndex > -1) {
        cart[foundIndex].qty += 1;
    } else {
        cart.push({ id, nama, harga, foto, qty: 1 });
    }

    localStorage.setItem('yayuk_cart', JSON.stringify(cart));

    // --- PENTING: Panggil fungsi ini agar angka di navbar langsung berubah ---
    updateNavbarBadge(); 
    // ------------------------------------------------------------------------

    alert(nama + " berhasil ditambah ke keranjang!");
}

// Fungsi ini harus ada di file yang sama atau di navbar.php yang di-include
function updateNavbarBadge() {
    let cart = JSON.parse(localStorage.getItem('yayuk_cart')) || [];
    let totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
    const badge = document.getElementById('cart-badge');
    
    if (badge) {
        badge.innerText = totalItems;
        badge.style.display = totalItems > 0 ? 'inline-block' : 'none';
    }
}

// Tetap jalankan ini agar saat pindah halaman angkanya tidak hilang
document.addEventListener('DOMContentLoaded', updateNavbarBadge);
</script>

<script>
function updateNavbarBadge() {
    let cart = JSON.parse(localStorage.getItem('yayuk_cart')) || [];
    let totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
    
    // Update Badge Angka
    const badge = document.getElementById('cart-badge');
    if (badge) {
        badge.innerText = totalItems;
        badge.style.display = totalItems > 0 ? 'inline-block' : 'none';
    }

    // Update Isi Kotak Preview
    const previewContainer = document.getElementById('cart-items-preview');
    const previewFooter = document.getElementById('cart-preview-footer');
    
    if (cart.length > 0) {
        let html = "";
        cart.slice(0, 3).forEach(item => { // Tampilkan 3 produk terakhir saja
            html += `
                <div class="preview-item">
                    <img src="${item.foto}">
                    <div style="font-size: 13px;">
                        <div class="fw-bold text-dark text-truncate" style="max-width: 180px;">${item.nama}</div>
                        <div class="text-warning">${item.qty} x Rp ${item.harga.toLocaleString('id-ID')}</div>
                    </div>
                </div>`;
        });
        previewContainer.innerHTML = html;
        previewFooter.style.display = 'block';
    } else {
        previewContainer.innerHTML = '<p class="text-center text-muted p-2">Belum Ada Produk</p>';
        previewFooter.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', updateNavbarBadge);
</script>