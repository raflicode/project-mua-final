<style>
/* Custom offcanvas agar tingginya setengah layar */
.offcanvas-custom.offcanvas-top {
    height: 50vh; /* vh = viewport height, 50 berarti 50% layar */
    border-bottom: 2px solid #b5835a; /* opsional: pemanis batas bawah */
}

.offcanvas-body {
    overflow-y: auto;
}
</style>

<nav class="navbar navbar-dark bg-black px-3">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">
      Yayuk <span style="font-style: italic; font-weight: 300;">Makeover</span>
    </a>

    <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="d-none d-lg-flex ms-auto align-items-center gap-4">
      <a class="nav-link text-white" href="../../project-mua/dasboard.php">Home</a>
      <a class="nav-link text-white" href="#">Service</a>
      <a class="nav-link text-white" href="#">Gallery</a>
      <a class="nav-link text-white" href="#">Keranjang</a>
      <a class="btn btn-outline-light ms-2" href="public/login.php">Login</a>
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
      <li><a class="nav-link text-white" href="../../dasboard.php">🏠 Home</a></li>
      <li><a class="nav-link text-white" href="#">💄 Service</a></li>
      <li><a class="nav-link text-white" href="#">🖼️ Gallery</a></li>
      <li><a class="nav-link text-white" href="#">🛒 Keranjang</a></li>
    </ul>

    <!-- Bagian user info di bawah menu masih manual harusnya otomatis saat login -->
    <div class="border-top pt-3 mt-4">
      <div class="fw-bold">Putri</div>
      <small class="text-secondary">user@gmail.com</small><br>
      <a href="#" class="text-danger small">Logout</a>
    </div>
  </div>
</div>