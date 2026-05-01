<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>


<style>
  /* Custom offcanvas agar tingginya setengah layar */
  .offcanvas-custom.offcanvas-top {
    height: 50vh;
    /* vh = viewport height, 50 berarti 50% layar */
    border-bottom: 2px solid #b5835a;
    /* opsional: pemanis batas bawah */
  }

  .offcanvas-body {
    overflow-y: auto;
  }
</style>

<nav class="navbar navbar-dark bg-black px-3 fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">
      Yayuk <span style="font-style: italic; font-weight: 300;">Makeover</span>
    </a>

    <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#mobileMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="d-none d-lg-flex ms-auto align-items-center gap-4">
      <a class="nav-link text-white" href="../../project-mua-final/dasboard.php">Home</a>
      <a class="nav-link text-white" href="../../project-mua-final/public/service.php">Service</a>
      <a class="nav-link text-white" href="../../project-mua-final/dasboard.php#gallery">Gallery</a>
      <a class="nav-link text-white" href="#">Keranjang</a>

      <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != ''): ?>
        <span class="text-white">Halo, <?= $_SESSION['username']; ?></span>
        <a class="btn btn-outline-light ms-2" href="../project-mua/public/logout.php">Logout</a>
      <?php else: ?>
        <a class="btn btn-outline-light ms-2" href="/project-mua/public/login.php">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="offcanvas offcanvas-top bg-dark text-white offcanvas-custom " tabindex="-1" id="mobileMenu">

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

    <!-- Bagian user info di bawah menu masih manual harusnya otomatis saat login -->
    <div class="border-top pt-3 mt-4">
      <?php if (isset($_SESSION['id_user'])): ?>
        <div class="fw-bold"><?= $_SESSION['username']; ?></div>
        <small class="text-secondary"><?= $_SESSION['email'] ?? 'Tidak ada email'; ?></small><br>
        <a href="../logout.php" class="text-danger small">Logout</a>
      <?php else: ?>
        <a href="/project-mua-final/public/login.php" class="text-white">Login</a>
      <?php endif; ?>
      <a href="#" class="text-danger small">Logout</a>
    </div>
  </div>
</div>