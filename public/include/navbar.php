<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$navbarCartCount = 0;
$navbarCartItems = [];

if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != '') {
  if (!isset($pdo) || !$pdo instanceof PDO) {
    require __DIR__ . '/../../config/koneksi.php';
  }

  if (!function_exists('navbarTableHasColumn')) {
    function navbarTableHasColumn(PDO $pdo, string $table, string $column): bool
    {
      $stmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = ?
          AND COLUMN_NAME = ?
      ");
      $stmt->execute([$table, $column]);
      return (int) $stmt->fetchColumn() > 0;
    }
  }

  if (!function_exists('navbarCartImagePath')) {
    function navbarCartImagePath(array $item): string
    {
      $name = strtolower($item['nama_layanan'] ?? '');
      $type = strtolower($item['tipe_layanan'] ?? '');

      if ($type === 'paket' || strpos($name, 'paket') !== false) {
        return '';
      }

      if (!empty($item['foto'])) {
        return $item['foto'];
      }

      $hasName = function (string $needle) use ($name): bool {
        return strpos($name, $needle) !== false;
      };

      if ($type === 'kostum') {
        if ($hasName('graduation')) return '../assets/fotograduation.jpeg';
        if ($hasName('pahlawan')) return '../assets/fotopahlawan.jpeg';
        if ($hasName('wedding')) return '../assets/gallery_kostum/foto_resepsi.jpeg';
        if ($hasName('baju adat jawa')) return '../assets/gallery_kostum/kostum_4.jpeg';
        if ($hasName('baju adat sunda')) return '../assets/adatjawa.jpeg';
        if ($hasName('baju adat bali')) return '../assets/gallery_kostum/kostum_5.jpeg';
        if ($hasName('baju adat madura')) return '../assets/adatmadura.jpeg';
        if ($hasName('baju adat') || $hasName('kostum')) return '../assets/gallery_kostum/foto_carnaval.jpeg';
      }

      if ($type === 'makeup') return '../assets/foto_makeup.jpeg';
      if ($type === 'dekor') return '../assets/foto_dekor.jpeg';

      return '../assets/gallery_kostum/kostum_4.jpeg';
    }
  }

  if (!function_exists('navbarCartImageUrl')) {
    function navbarCartImageUrl(string $foto): string
    {
      $foto = str_replace('\\', '/', $foto);

      if ($foto === '') return '';
      if (preg_match('/^(https?:)?\/\///', $foto)) return $foto;
      if (strpos($foto, '/') === 0) return $foto;
      if (strpos($foto, '../assets/') === 0) return BASE_PATH . '/' . str_replace('../', '', $foto);
      if (strpos($foto, 'assets/') === 0) return BASE_PATH . '/' . $foto;

      return BASE_PATH . '/assets/' . preg_replace('/^(\.\.\/|\.\/)+(/', '', $foto);
    }
  }

  try {
    $cartCountStmt = $pdo->prepare("SELECT SUM(kuantitas) AS total FROM keranjang WHERE id_user = ?");
    $cartCountStmt->execute([$_SESSION['id_user']]);
    $navbarCartCount = (int) ($cartCountStmt->fetch()['total'] ?? 0);

    $fotoSelect = navbarTableHasColumn($pdo, 'keranjang', 'foto') ? 'foto' : "NULL AS foto";
    $cartItemsStmt = $pdo->prepare("
      SELECT id_keranjang, nama_layanan, tipe_layanan, {$fotoSelect}, harga, kuantitas
      FROM keranjang
      WHERE id_user = ?
      ORDER BY created_at DESC
      LIMIT 5
    ");
    $cartItemsStmt->execute([$_SESSION['id_user']]);
    $navbarCartItems = $cartItemsStmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    $navbarCartCount = 0;
    $navbarCartItems = [];
  }
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_PATH; ?>/assets/css/mua-theme.css">

<style>
  .btn-custom-gold {
    border-color: #b5835a !important;
    color: #b5835a !important;
    background: rgba(255, 250, 244, 0.72) !important;
    border-radius: 999px !important;
    font-weight: 700;
    padding: 9px 20px;
  }

  .btn-custom-gold:hover {
    background-color: #b5835a !important;
    border-color: #b5835a !important;
    color: #ffffff !important;
    box-shadow: 0 14px 30px rgba(181, 131, 90, 0.24);
    transform: translateY(-2px);
  }

  .transition-nav {
    top: 14px;
    transition: all 0.35s ease-in-out !important;
    background-color: transparent;
    animation: navDrop 0.7s ease both;
  }

  .navbar .container-fluid {
    max-width: 1180px;
    min-height: 66px;
    padding: 10px 16px;
    border: 1px solid rgba(165, 132, 89, 0.2);
    border-radius: 999px;
    background: rgba(255, 250, 244, 0.78);
    backdrop-filter: blur(18px);
    box-shadow: 0 18px 44px rgba(73, 55, 40, 0.12);
    transition: all 0.35s ease;
  }

  .navbar .nav-link,
  .navbar .navbar-brand {
    color: #3b3028 !important;
    transition: color 0.25s ease, transform 0.25s ease, background 0.25s ease;
  }

  .navbar .nav-link:not(.dropdown-toggle) {
    position: relative;
    padding: 9px 13px;
    border-radius: 999px;
    font-size: 0.94rem;
    font-weight: 600;
  }

  .navbar .nav-link:not(.dropdown-toggle)::after {
    content: '';
    position: absolute;
    width: 5px;
    height: 5px;
    bottom: 4px;
    left: 50%; /* Memulai garis dari tengah */
    background-color: #b5835a; /* Warna garis hitam */
    border-radius: 50%;
    opacity: 0;
    transition: all 0.25s ease; /* Efek animasi halus */
    transform: translate(-50%, 6px);
  }

  .navbar .nav-link:not(.dropdown-toggle):hover {
    color: #b5835a !important;
    background: rgba(181, 131, 90, 0.09);
    text-decoration: none;
    transform: translateY(-1px);
  }

  .navbar .nav-link:not(.dropdown-toggle):hover::after {
    opacity: 1;
    transform: translate(-50%, 0);
  }

  .navbar .nav-link.dropdown-toggle:hover {
    color: #b5835a !important;
    text-decoration: none;
  }

  .nav-scrolled {
    top: 8px;
    background-color: transparent !important;
  }

  .nav-scrolled .container-fluid {
    min-height: 58px;
    background-color: rgba(255, 250, 244, 0.94) !important;
    box-shadow: 0 14px 34px rgba(73, 55, 40, 0.13) !important;
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
    background:
      linear-gradient(135deg, rgba(123, 93, 63, 0.98), rgba(165, 132, 89, 0.98)),
      #a58459 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.24);
    border-radius: 0 0 28px 28px;
    height: auto;
    max-height: 82vh;
  }

  .offcanvas-header,
  .offcanvas-body {
    background: transparent !important;
  }

  .offcanvas-body {
    overflow-y: auto;
  }

  .profile-circle-icon {
    width: 42px;
    height: 42px;
    justify-content: center;
    border: 1px solid rgba(165, 132, 89, 0.22);
    border-radius: 50%;
    background: rgba(255, 250, 244, 0.72);
    font-size: 1.55rem;
    color: #3b3028;
    transition: 0.25s;
    display: flex;
    align-items: center;
  }

  .profile-circle-icon:hover {
    color: #b5835a;
  }

  .navbar-brand {
    font-family: 'Playfair Display', serif;
    font-size: 1.42rem;
    letter-spacing: 0;
    padding-left: 8px;
  }

  .navbar-brand span {
    font-style: italic;
    font-weight: 300;
    color: #b5835a !important;
  }

  .brand-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    margin-left: 6px;
    border-radius: 50%;
    background: #FED03A;
    box-shadow: 0 0 0 5px rgba(254, 208, 58, 0.18);
  }

  .navbar-toggler {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(181, 131, 90, 0.12);
  }

  .navbar-toggler:focus {
    box-shadow: 0 0 0 4px rgba(181, 131, 90, 0.16);
  }

  .dropdown-menu-custom {
    border: 1px solid rgba(165, 132, 89, 0.22);
    border-radius: 18px;
    background: #fffaf4;
    box-shadow: 0 18px 40px rgba(73, 55, 40, 0.12);
  }

  .account-box {
    background: rgba(255,255,255,0.08);
    padding: 14px 16px;
    border-radius: 18px;
  }

  .account-icon {
    width: 50px;
    height: 50px;
    background: #f1f1f1;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #777;
    font-size: 1.5rem;
  }

  .logout-icon {
    color: #ff3b30;
    font-size: 1.6rem;
    transition: 0.3s;
  }

  .logout-icon:hover {
    color: white;
  }

  /* --- TAMBAHAN CSS UNTUK HOVER DROPDOWN KERANJANG ALA SHOPEE --- */
  @media (min-width: 992px) {
    .nav-cart-preview-trigger {
      position: relative;
    }
    /* Memunculkan dropdown saat pembungkus di-hover */
    .nav-cart-preview-trigger:hover .dropdown-cart-menu {
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
      top: 100%;
      right: 0;
      left: auto;
      width: 320px;
      max-height: 400px;
      margin-top: 0;
      overflow-y: auto;
      z-index: 2000;
    }

    .nav-item-gallery-cart .dropdown-cart-menu {
      left: 0;
      right: auto;
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

  .mobile-menu-link {
    padding: 12px 14px !important;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.08);
    font-weight: 600;
  }

  .mobile-menu-link:hover {
    background: rgba(255, 255, 255, 0.15);
  }

  @keyframes navDrop {
    from {
      opacity: 0;
      transform: translateY(-16px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @media (max-width: 991.98px) {
    .transition-nav {
      top: 10px;
      padding-left: 12px !important;
      padding-right: 12px !important;
    }

    .navbar .container-fluid {
      min-height: 58px;
      padding: 8px 12px;
    }

    .navbar-brand {
      font-size: 1.22rem;
      padding-left: 4px;
    }
  }
</style>

<nav id="mainNavbar" class="navbar fixed-top px-3 transition-nav">
  <div class="container-fluid">

    <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= BASE_PATH; ?>/index.php">
      Yayuk <span class="ms-1">Makeover</span><span class="brand-dot"></span>
    </a>

    <button class="navbar-toggler border-0 d-lg-none"
      type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#mobileMenu"
      aria-label="Buka menu">

      <span class="navbar-toggler-icon"></span>

    </button>

    <div class="d-none d-lg-flex ms-auto align-items-center gap-4 text-dark">

      <a class="nav-link" href="<?= BASE_PATH; ?>/index.php">Home</a>

      <a class="nav-link" href="<?= BASE_PATH; ?>/public/service.php">
        Service
      </a>

      <a class="nav-link" href="<?= BASE_PATH; ?>/index.php#gallery">
        Gallery
      </a>

      <!-- Modifikasi: Pembungkus Dropdown Keranjang -->
      <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>
        <div class="nav-cart-preview-trigger nav-item-cart">
          <a class="nav-link position-relative" href="<?= BASE_PATH; ?>/public/keranjang.php">
            <i class="bi bi-cart3"></i> Keranjang
            <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="<?= $navbarCartCount > 0 ? 'display:inline-block;' : 'display:none;'; ?> font-size:0.7rem;"><?= $navbarCartCount > 0 ? $navbarCartCount : ''; ?></span>
          </a>
          
          <!-- Box Dropdown List Barang (Shopee Style) -->
          <ul class="dropdown-menu dropdown-menu-custom dropdown-cart-menu p-2">
            <div id="cart-items-preview-container" class="cart-items-preview-container">
              <?php if (!empty($navbarCartItems)): ?>
                <?php foreach ($navbarCartItems as $cartItem): ?>
                  <?php
                    $cartItemName = $cartItem['nama_layanan'] ?? '';
                    $cartItemFoto = navbarCartImageUrl(navbarCartImagePath($cartItem));
                    $cartItemQty = (int) ($cartItem['kuantitas'] ?? 1);
                    $cartItemPrice = number_format((float) ($cartItem['harga'] ?? 0), 0, ',', '.');
                  ?>
                  <div class="cart-item-preview">
                    <?php if ($cartItemFoto !== ''): ?>
                      <img src="<?= htmlspecialchars($cartItemFoto, ENT_QUOTES, 'UTF-8'); ?>" class="cart-item-img" alt="<?= htmlspecialchars($cartItemName, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php endif; ?>
                    <div class="cart-item-info">
                      <div class="cart-item-title" title="<?= htmlspecialchars($cartItemName, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($cartItemName, ENT_QUOTES, 'UTF-8'); ?></div>
                      <div class="cart-item-price"><small><?= $cartItemQty; ?>x</small> Rp <?= $cartItemPrice; ?></div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="text-center py-4 text-muted"><i class="bi bi-cart-x d-block fs-4 mb-1"></i><small>Keranjang masih kosong</small></div>
              <?php endif; ?>
            </div>
            <li><hr class="dropdown-divider"></li>
            <li class="text-center p-1">
              <a href="<?= BASE_PATH; ?>/public/keranjang.php" class="btn btn-sm btn-custom-gold w-100 py-1" style="font-size: 0.8rem;">Lihat Keranjang Belanja</a>
            </li>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>

        <div class="dropdown">

          <a class="nav-link dropdown-toggle d-flex align-items-center border-0"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">

            <div class="profile-circle-icon">
              <i class="bi bi-person-circle"></i>
            </div>

          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">

            <li>
              <div class="dropdown-header text-muted">
                Hallo,
                <strong>
                  <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>
                </strong>
              </div>
            </li>
<a href="<?= BASE_PATH; ?>/public/riwayat_pesanan.php" class="dropdown-item">
    <i class="bi bi-clock-history me-2"></i>Riwayat Pesanan
</a>
            <li><hr class="dropdown-divider"></li>

            <li>
              <a class="dropdown-item text-danger fw-bold"
                href="<?= BASE_PATH; ?>/actions/logout.php">

                Logout

              </a>
            </li>

          </ul>

        </div>

      <?php else: ?>

        <a class="btn btn-custom-gold border-2 ms-2"
          href="<?= BASE_PATH; ?>/public/login.php">

          Login

        </a>

      <?php endif; ?>

    </div>
  </div>
</nav>

<div class="offcanvas offcanvas-top text-white offcanvas-custom"
  tabindex="-1"
  id="mobileMenu">

  <div class="offcanvas-header">

    <h5 class="offcanvas-title">Menu</h5>

    <button type="button"
      class="btn-close btn-close-white"
      data-bs-dismiss="offcanvas"
      aria-label="Tutup menu">
    </button>

  </div>

  <div class="offcanvas-body">

    <ul class="navbar-nav gap-3">

      <li>
        <a class="nav-link text-white mobile-menu-link"
          href="<?= BASE_PATH; ?>/index.php">

          <i class="bi bi-house-door me-2"></i>Home

        </a>
      </li>

      <li>
        <a class="nav-link text-white mobile-menu-link"
          href="<?= BASE_PATH; ?>/public/service.php">

          <i class="bi bi-brush me-2"></i>Service

        </a>
      </li>

      <li>
        <a class="nav-link text-white mobile-menu-link"
          href="<?= BASE_PATH; ?>/index.php#gallery">

          <i class="bi bi-images me-2"></i>Gallery

        </a>
      </li>

      <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>

        <li>

          <a class="nav-link text-white position-relative mobile-menu-link"
            href="<?= BASE_PATH; ?>/public/keranjang.php">

            <i class="bi bi-cart3 me-2"></i>Keranjang

            <span id="cart-count-mobile"
              class="badge bg-danger position-absolute top-0 start-100 translate-middle"
              style="<?= $navbarCartCount > 0 ? 'display:inline-block;' : 'display:none;'; ?> font-size:0.7rem;">
              <?= $navbarCartCount > 0 ? $navbarCartCount : ''; ?>
            </span>

          </a>

        </li>

        <li>

          <a class="nav-link text-white mobile-menu-link"
            href="<?= BASE_PATH; ?>/public/riwayat_pesanan.php">

            <i class="bi bi-clock-history me-2"></i>Riwayat Pesanan

          </a>

        </li>

      <?php endif; ?>

    </ul>

    <div class="mobile-account border-top pt-3 mt-4">

      <?php if (isset($_SESSION['id_user'])): ?>

        <div class="account-box d-flex justify-content-between align-items-center">

          <div class="d-flex align-items-center gap-3">

            <div class="account-icon">
              <i class="bi bi-person-fill"></i>
            </div>

            <div>

              <div class="fw-bold text-white">
                <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>
              </div>

              <small class="text-white-50">
                <?= htmlspecialchars($_SESSION['email'] ?? 'Member', ENT_QUOTES, 'UTF-8'); ?>
              </small>

            </div>

          </div>

          <a href="<?= BASE_PATH; ?>/actions/logout.php"
            class="logout-icon">

            <i class="bi bi-box-arrow-right"></i>

          </a>

        </div>

      <?php else: ?>

        <a href="<?= BASE_PATH; ?>/public/login.php"
          class="btn btn-light">

          Login

        </a>

      <?php endif; ?>

    </div>

  </div>
</div>

<script>
  const basePath = '<?= BASE_PATH; ?>';
  
  window.onscroll = function () {

    var navbar = document.getElementById('mainNavbar');

    if (window.pageYOffset > 50) {
      navbar.classList.add('nav-scrolled');
    } else {
      navbar.classList.remove('nav-scrolled');
    }
  };

  // Modifikasi: Ambil data jumlah sekaligus list item belanjaan
  function resolveCartImageUrl(foto) {
    if (!foto) {
      return '';
    }

    if (/^(https?:)?\/\//.test(foto)) {
      return foto;
    }

    const normalized = String(foto).replace(/\\/g, '/');

    if (normalized.startsWith('/')) {
      return normalized;
    }

    if (normalized.startsWith('../assets/')) {
      return basePath + '/' + normalized.replace('../', '');
    }

    if (normalized.startsWith('assets/')) {
      return basePath + '/' + normalized;
    }

    return basePath + '/assets/' + normalized.replace(/^(\.\.\/|\.\/)+/, '');
  }

  function escapeCartText(text) {
    const div = document.createElement('div');
    div.textContent = text || '';
    return div.innerHTML;
  }

  function setCartBadgeCount(count) {
    const total = Number(count || 0);
    const cartElements = document.querySelectorAll('#cart-count, #cart-count-mobile');

    cartElements.forEach(el => {
      if (total > 0) {
        el.innerText = total;
        el.style.display = 'inline-block';
      } else {
        el.innerText = '';
        el.style.display = 'none';
      }
    });
  }

  function renderCartPreview(items) {
    const previewContainers = document.querySelectorAll('.cart-items-preview-container');
    if (!previewContainers.length) {
      return;
    }

    let htmlContent = '<div class="text-center py-4 text-muted"><i class="bi bi-cart-x d-block fs-4 mb-1"></i><small>Keranjang masih kosong</small></div>';

    if (items && items.length > 0) {
      htmlContent = '';
      items.forEach(item => {
        const type = String(item.tipe_layanan || '').toLowerCase();
        const name = String(item.nama_layanan || '').toLowerCase();
        const imgUrl = (type === 'paket' || name.includes('paket')) ? '' : resolveCartImageUrl(item.foto);
        const itemName = escapeCartText(item.nama_layanan);
        const itemQty = Number(item.qty || item.kuantitas || 1);
        const itemPrice = Number(item.harga || 0);
        const imageHtml = imgUrl ? `<img src="${imgUrl}" class="cart-item-img" alt="${itemName}">` : '';

        htmlContent += `
          <div class="cart-item-preview">
            ${imageHtml}
            <div class="cart-item-info">
              <div class="cart-item-title" title="${itemName}">${itemName}</div>
              <div class="cart-item-price"><small>${itemQty}x</small> Rp ${itemPrice.toLocaleString('id-ID')}</div>
            </div>
          </div>
        `;
      });
    }

    previewContainers.forEach(container => {
      container.innerHTML = htmlContent;
    });
  }

  function updateCartCount() {

    fetch(new URL('../actions/get_cart_count.php', window.location.href))

      .then(response => response.json())

      .then(data => {
        // 1. Update Badge Angka
        setCartBadgeCount(data.cart_count);

        // 2. Render List Item di Dropdown (Shopee Style)
        renderCartPreview(data.items || []);
      })
      .catch(error => console.log('Error fetching cart data:', error));
  }

  document.addEventListener('DOMContentLoaded', updateCartCount);

  window.updateCartNavbar = updateCartCount;
  window.setCartBadgeCount = setCartBadgeCount;
</script>
