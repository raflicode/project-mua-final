<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/project-mua-final/assets/css/mua-theme.css">

<style>
  .btn-custom-gold {
    border-color: #b5835a !important;
    color: #b5835a !important;
  }

  .btn-custom-gold:hover {
    background-color: #b5835a !important;
    border-color: #b5835a !important;
    color: #ffffff !important;
  }

  .transition-nav {
    transition: all 0.5s ease-in-out !important;
    background-color: rgba(247, 242, 235, 0.72);
    backdrop-filter: blur(14px);
  }

  .navbar .nav-link,
  .navbar .navbar-brand {
    color: #3b3028 !important;
    transition: 0.3s;
  }

  .navbar .nav-link:hover {
    color: #b5835a !important;
    text-decoration: none;
  }

  .nav-scrolled {
    background-color: rgba(255, 250, 244, 0.94) !important;
    box-shadow: 0 12px 32px rgba(73, 55, 40, 0.11) !important;
  }

  .nav-scrolled .nav-link,
  .nav-scrolled .navbar-brand {
    color: #3b3028 !important;
  }

  .nav-scrolled .btn-outline-dark {
    color: #a58459 !important;
    border-color: #a58459 !important;
  }

  .offcanvas-custom.offcanvas-top {
    height: auto;
    min-height: 48vh;
    background: #a58459 !important;
    border-bottom: 2px solid #b5835a;
  }

  .profile-circle-icon {
    font-size: 1.8rem;
    color: #3b3028;
    transition: 0.3s;
    display: flex;
    align-items: center;
  }

  .profile-circle-icon:hover {
    color: #b5835a;
  }

  .navbar-brand {
    font-family: 'Playfair Display', serif;
    font-size: 1.35rem;
  }

  .dropdown-menu-custom {
    border: 1px solid rgba(165, 132, 89, 0.22);
    border-radius: 18px;
    background: #fffaf4;
    box-shadow: 0 18px 40px rgba(73, 55, 40, 0.12);
  }

  /* --- TAMBAHAN CSS UNTUK HOVER DROPDOWN KERANJANG ALA SHOPEE --- */
  @media (min-width: 992px) {
    .nav-item-cart {
      position: relative;
    }
    /* Memunculkan dropdown saat pembungkus di-hover */
    .nav-item-cart:hover .dropdown-cart-menu {
      display: block;
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    .dropdown-cart-menu {
      display: block;
      opacity: 0;
      visibility: hidden;
      transform: translateY(10px);
      transition: all 0.3s ease;
      position: absolute;
      right: 0;
      left: auto;
      width: 320px;
      max-height: 400px;
      overflow-y: auto;
      z-index: 1000;
    }
  }

  .cart-item-preview {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 15px;
    transition: background 0.2s;
  }

  .cart-item-preview:hover {
    background-color: rgba(181, 131, 90, 0.08);
  }

  .cart-item-img {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border-radius: 6px;
  }

  .cart-item-info {
    flex: 1;
    min-width: 0;
  }

  .cart-item-title {
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 2px;
    color: #3b3028;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .cart-item-price {
    font-size: 0.8rem;
    color: #b5835a;
  }
</style>

<nav id="mainNavbar" class="navbar fixed-top px-3 transition-nav">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/project-mua-final/index.php">
      Yayuk <span style="font-style: italic; font-weight: 300; color: #FED03A;">Makeover</span>
    </a>

    <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#mobileMenu" aria-label="Buka menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="d-none d-lg-flex ms-auto align-items-center gap-4 text-dark">
      <a class="nav-link" href="/project-mua-final/index.php">Home</a>
      <a class="nav-link" href="/project-mua-final/public/service.php">Service</a>
      <a class="nav-link" href="/project-mua-final/index.php#gallery">Gallery</a>

      <!-- Modifikasi: Pembungkus Dropdown Keranjang -->
      <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>
        <div class="nav-item-cart">
          <a class="nav-link position-relative" href="/project-mua-final/public/keranjang.php">
            <i class="bi bi-cart3"></i> Keranjang
            <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="display:none; font-size:0.7rem;"></span>
          </a>
          
          <!-- Box Dropdown List Barang (Shopee Style) -->
          <ul class="dropdown-menu dropdown-menu-custom dropdown-cart-menu p-2">
            <div id="cart-items-preview-container">
              <div class="text-center py-3 text-muted"><small>Memuat keranjang...</small></div>
            </div>
            <li><hr class="dropdown-divider"></li>
            <li class="text-center p-1">
              <a href="/project-mua-final/public/keranjang.php" class="btn btn-sm btn-custom-gold w-100 py-1" style="font-size: 0.8rem;">Lihat Keranjang Belanja</a>
            </li>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>
        <div class="dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center border-0" href="#" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <div class="profile-circle-icon">
              <i class="bi bi-person-circle"></i>
            </div>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
            <li>
              <div class="dropdown-header text-muted">Halo, <strong><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></strong></div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger fw-bold" href="/project-mua-final/actions/logout.php">Logout</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a class="btn btn-custom-gold border-2 ms-2" href="/project-mua-final/public/login.php">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="offcanvas offcanvas-top text-white offcanvas-custom" tabindex="-1" id="mobileMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Tutup menu"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav gap-3">
      <li><a class="nav-link text-white" href="/project-mua-final/index.php"><i class="bi bi-house-door me-2"></i>Home</a></li>
      <li><a class="nav-link text-white" href="/project-mua-final/public/service.php"><i class="bi bi-brush me-2"></i>Service</a></li>
      <li><a class="nav-link text-white" href="/project-mua-final/index.php#gallery"><i class="bi bi-images me-2"></i>Gallery</a></li>
      <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>
        <li>
          <a class="nav-link text-white position-relative" href="/project-mua-final/public/keranjang.php">
            <i class="bi bi-cart3 me-2"></i>Keranjang
            <span id="cart-count-mobile" class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="display:none; font-size:0.7rem;"></span>
          </a>
        </li>
      <?php endif; ?>
    </ul>

    <div class="border-top pt-3 mt-4">
      <?php if (isset($_SESSION['id_user'])): ?>
        <div class="d-flex align-items-center gap-3">
          <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
          <div>
            <div class="fw-bold"><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></div>
            <small class="text-white-50"><?= htmlspecialchars($_SESSION['email'] ?? 'Member', ENT_QUOTES, 'UTF-8'); ?></small>
          </div>
        </div>
        <a href="/project-mua-final/actions/logout.php" class="text-white d-block mt-3 fw-bold">Logout</a>
      <?php else: ?>
        <a href="/project-mua-final/public/login.php" class="btn btn-light">Login</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  window.onscroll = function () {
    var navbar = document.getElementById('mainNavbar');

    if (window.pageYOffset > 50) {
      navbar.classList.add('nav-scrolled');
    } else {
      navbar.classList.remove('nav-scrolled');
    }
  };

  // Modifikasi: Ambil data jumlah sekaligus list item belanjaan
  function updateCartCount() {
    fetch('/project-mua-final/actions/get_cart_count.php')
      .then(response => response.json())
      .then(data => {
        // 1. Update Badge Angka
        const cartElements = document.querySelectorAll('#cart-count, #cart-count-mobile');
        cartElements.forEach(el => {
          if (data.cart_count > 0) {
            el.innerText = data.cart_count;
            el.style.display = 'inline-block';
          } else {
            el.style.display = 'none';
          }
        });

        // 2. Render List Item di Dropdown (Shopee Style)
        const previewContainer = document.getElementById('cart-items-preview-container');
        if (previewContainer) {
          if (data.items && data.items.length > 0) {
            let htmlContent = '';
            data.items.forEach(item => {
              // Menangani fallback jika gambar kosong
              let imgUrl = item.foto ? '/project-mua-final/assets/img/' + item.foto : '/project-mua-final/assets/img/default-service.jpg';
              
              htmlContent += `
                <div class="cart-item-preview">
                  <img src="${imgUrl}" class="cart-item-img" alt="${item.nama_layanan}">
                  <div class="cart-item-info">
                    <div class="cart-item-title" title="${item.nama_layanan}">${item.nama_layanan}</div>
                    <div class="cart-item-price"><small>${item.qty || 1}x</small> Rp ${Number(item.harga).toLocaleString('id-ID')}</div>
                  </div>
                </div>
              `;
            });
            previewContainer.innerHTML = htmlContent;
          } else {
            previewContainer.innerHTML = '<div class="text-center py-4 text-muted"><i class="bi bi-cart-x d-block fs-4 mb-1"></i><small>Keranjang masih kosong</small></div>';
          }
        }
      })
      .catch(error => console.log('Error fetching cart data:', error));
  }

  document.addEventListener('DOMContentLoaded', updateCartCount);
  window.updateCartNavbar = updateCartCount;
</script>