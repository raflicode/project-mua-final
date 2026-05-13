<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
$isHome = preg_match('#/project-mua-final/?(index\.php)?$#', $currentPath);
$isService = preg_match('#/public/(service|makeup|kostum|dekor)\.php$#', $currentPath);
$isCart = preg_match('#/public/(keranjang|cart)\.php$#', $currentPath);
?>

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

  .transition-nav {
    transition: all 0.5s ease-in-out !important;
  }

  .navbar.bg-white {
    background-color: #ffffff !important;
    min-height: 64px;
    transition: all 0.3s ease;
  }

  .navbar .nav-link,
  .navbar .navbar-brand {
    color: #333 !important;
    transition: 0.3s;
  }

  .nav-scrolled {
    background-color: #ffffff !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
  }

  .nav-menu-link {
    position: relative;
    padding-inline: 2px !important;
    padding-bottom: 7px !important;
    color: #333333 !important;
    font-size: 1rem !important;
    font-weight: 500;
    line-height: 1.5;
    transition: color 0.25s ease;
  }

  .nav-menu-link::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 2px;
    border-radius: 999px;
    background: linear-gradient(90deg, #FED03A, #b5835a);
    transform: scaleX(0);
    transform-origin: center;
    transition: transform 0.25s ease;
  }

  .nav-menu-link:hover,
  .nav-menu-link.active {
    color: #b5835a !important;
  }

  .nav-menu-link:hover::after,
  .nav-menu-link.active::after {
    transform: scaleX(1);
  }

  .offcanvas-custom.offcanvas-top {
    height: 50vh;
    border-bottom: 2px solid #b5835a;
  }

  .offcanvas .nav-menu-link {
    display: inline-block;
    color: #ffffff !important;
    padding-bottom: 6px !important;
  }

  .offcanvas .nav-menu-link:hover,
  .offcanvas .nav-menu-link.active {
    color: #FED03A !important;
  }

  .profile-circle-icon {
    font-size: 1.8rem;
    color: black;
    transition: 0.3s;
    display: flex;
    align-items: center;
  }

  .profile-circle-icon:hover {
    color: #a7a6a6;
  }

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

  .dropdown-cart {
    position: relative;
    display: inline-block;
  }

  #cart-badge {
    padding: 0.35em 0.5em;
    line-height: 1;
    z-index: 10;
  }

  .cart-preview-box {
    position: absolute;
    top: 100%;
    right: 0;
    width: 360px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    padding: 15px;
    display: none;
    z-index: 9999;
    border: 1px solid #eee;
    margin-top: 10px;
  }

  .dropdown-cart:hover .cart-preview-box {
    display: block;
  }

  .preview-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
  }

  .preview-item img {
    width: 64px;
    height: 64px;
    object-fit: cover;
    border-radius: 8px;
  }

  .shadow-sm {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
  }
</style>

<nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top px-3 transition-nav bg-white navbar-light shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/project-mua-final/index.php">
      Yayuk <span style="font-style: italic; font-weight: 300; color: #FED03A;">Makeover</span>
    </a>

    <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="d-none d-lg-flex ms-auto align-items-center gap-4 text-dark">
      <a class="nav-link nav-menu-link <?= $isHome ? 'active' : ''; ?>" data-nav-page="home" href="/project-mua-final/index.php">Home</a>
      <a class="nav-link nav-menu-link <?= $isService ? 'active' : ''; ?>" data-nav-page="service" href="/project-mua-final/public/service.php">Service</a>
      <a class="nav-link nav-menu-link" data-nav-page="gallery" href="/project-mua-final/index.php#gallery">Gallery</a>

      <div class="dropdown-cart">
        <a class="nav-link nav-menu-link position-relative <?= $isCart ? 'active' : ''; ?>" data-nav-page="cart" href="/project-mua-final/public/keranjang.php">
          <i class="bi bi-cart3 fs-5"></i>
          <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">0</span>
        </a>
        <div class="cart-preview-box">
          <div id="cart-items-preview"></div>
          <div id="cart-preview-footer" style="display:none;">
            <a href="/project-mua-final/public/keranjang.php" class="btn btn-custom-gold w-100 mt-2">Lihat Keranjang</a>
          </div>
        </div>
      </div>

      <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>
        <div class="dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="profile-circle-icon">
              <i class="bi bi-person-circle"></i>
            </div>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
            <li>
              <div class="dropdown-header text-muted">Halo, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger fw-bold" href="/project-mua-final/public/logout.php">Logout</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a class="btn btn-custom-gold border-2 ms-2" href="/project-mua-final/public/login.php">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="offcanvas offcanvas-top bg-dark text-white offcanvas-custom" tabindex="-1" id="mobileMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav gap-3">
      <li><a class="nav-link nav-menu-link <?= $isHome ? 'active' : ''; ?>" data-nav-page="home" href="/project-mua-final/index.php">Home</a></li>
      <li><a class="nav-link nav-menu-link <?= $isService ? 'active' : ''; ?>" data-nav-page="service" href="/project-mua-final/public/service.php">Service</a></li>
      <li><a class="nav-link nav-menu-link" data-nav-page="gallery" href="/project-mua-final/index.php#gallery">Gallery</a></li>
      <li><a class="nav-link nav-menu-link <?= $isCart ? 'active' : ''; ?>" data-nav-page="cart" href="/project-mua-final/public/keranjang.php">Keranjang</a></li>
    </ul>

    <div class="border-top pt-3 mt-4">
      <?php if (isset($_SESSION['id_user'])): ?>
        <div class="d-flex align-items-center gap-3">
          <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
          <div>
            <div class="fw-bold"><?= htmlspecialchars($_SESSION['username']); ?></div>
            <small class="text-secondary"><?= htmlspecialchars($_SESSION['email'] ?? 'Member'); ?></small>
          </div>
        </div>
        <a href="/project-mua-final/public/logout.php" class="text-danger d-block mt-3 fw-bold">Logout</a>
      <?php else: ?>
        <a href="/project-mua-final/public/login.php" class="text-white">Login</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  window.addEventListener('scroll', function () {
    const navbar = document.getElementById('mainNavbar');
    if (!navbar) return;

    navbar.classList.toggle('nav-scrolled', window.pageYOffset > 50);
  });

  function updateActiveGalleryNav() {
    const isGallery = window.location.hash === '#gallery';
    const isHomePage = /\/project-mua-final\/(index\.php)?$/.test(window.location.pathname);

    if (!isHomePage) return;

    document.querySelectorAll('[data-nav-page]').forEach(function(link) {
      link.classList.remove('active');
    });

    document.querySelectorAll('[data-nav-page="' + (isGallery ? 'gallery' : 'home') + '"]').forEach(function(link) {
      link.classList.add('active');
    });
  }

  function addToCart(id, nama, harga, foto) {
    let cart = JSON.parse(localStorage.getItem('yayuk_cart')) || [];
    let foundIndex = cart.findIndex(item => item.id === id);

    if (foundIndex > -1) {
      cart[foundIndex].qty += 1;
    } else {
      cart.push({ id, nama, harga, foto, qty: 1 });
    }

    localStorage.setItem('yayuk_cart', JSON.stringify(cart));
    updateNavbarBadge();
    alert(nama + " berhasil ditambah ke keranjang!");
  }

  function updateNavbarBadge() {
    let cart = JSON.parse(localStorage.getItem('yayuk_cart')) || [];
    let totalItems = cart.reduce((sum, item) => sum + Number(item.qty), 0);

    const badge = document.getElementById('cart-badge');
    if (badge) {
      badge.innerText = totalItems;
      badge.style.display = totalItems > 0 ? 'inline-block' : 'none';
    }

    const previewContainer = document.getElementById('cart-items-preview');
    const previewFooter = document.getElementById('cart-preview-footer');
    if (!previewContainer || !previewFooter) return;

    if (cart.length > 0) {
      previewContainer.innerHTML = cart.slice(0, 3).map(item => `
        <div class="preview-item">
          <img src="${item.foto}" alt="${item.nama}">
          <div style="font-size: 13px;">
            <div class="fw-bold text-dark text-truncate" style="max-width: 180px;">${item.nama}</div>
            <div class="text-warning">${item.qty} x Rp ${Number(item.harga).toLocaleString('id-ID')}</div>
          </div>
        </div>
      `).join('');
      previewFooter.style.display = 'block';
    } else {
      previewContainer.innerHTML = '<p class="text-center text-muted p-2">Belum Ada Produk</p>';
      previewFooter.style.display = 'none';
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    updateActiveGalleryNav();
    updateNavbarBadge();
  });
  window.addEventListener('hashchange', updateActiveGalleryNav);
</script>
