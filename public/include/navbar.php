<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!-- Link Icon ini ditaruh di sini supaya otomatis terbawa ke file mana pun yang meng-include navbar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
  .offcanvas-custom.offcanvas-top {
    height: 50vh;
    border-bottom: 2px solid #b5835a;
  }

  /* Container Icon Profile */
  .profile-circle-icon {
    font-size: 1.8rem;
    color: white;
    transition: 0.3s;
    display: flex;
    align-items: center;
  }

  .profile-circle-icon:hover {
    color: #949494; /* Warna ungu pas di hover biar senada sama login */
  }

  /* Styling Dropdown Box */
  .dropdown-menu-custom {
    background-color: #ffffff;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
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

<nav class="navbar navbar-dark bg-black px-3 fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/project-mua/index.php">
      Yayuk <span style="font-style: italic; font-weight: 300;">Makeover</span>
    </a>

    <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="d-none d-lg-flex ms-auto align-items-center gap-4">
      <a class="nav-link text-white" href="/project-mua/index.php">Home</a>
      <a class="nav-link text-white" href="/project-mua/public/service.php">Service</a>
      <a class="nav-link text-white" href="/project-mua/index.php#gallery">Gallery</a>
      <a class="nav-link text-white" href="#">Keranjang</a>

      <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>
        <!-- DROPDRON PROFILE -->
        <div class="dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             <!-- Icon Vector Umum (Kepala & Badan) -->
             <div class="profile-circle-icon">
                <i class="bi bi-person-circle"></i>
             </div>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
            <li><div class="dropdown-header text-muted">Halo, <strong><?= $_SESSION['username']; ?></strong></div></li>
            <li><hr class="dropdown-divider"></li>
            <!-- Link Logout Backend Kamu -->
            <li><a class="dropdown-item text-danger fw-bold" href="../project-mua/public/logout.php">Logout</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a class="btn btn-outline-light ms-2" href="/project-mua/public/login.php">Login</a>
      <?php endif; ?>
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
      <li><a class="nav-link text-white" href="#">🛒 Keranjang</a></li>
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
        <a href="../project-mua/public/logout.php" class="text-danger d-block mt-3 fw-bold">Logout</a>
      <?php else: ?>
        <a href="/project-mua/public/login.php" class="text-white">Login</a>
      <?php endif; ?>
    </div>
  </div>
</div>