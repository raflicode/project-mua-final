<!-- BOOTSTRAP CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* custom offcanvas biar gak full */
.offcanvas-custom {
  width: 260px; /* lebar sidebar */
}

.offcanvas-body {
  height: 60vh; /* tinggi cuma setengah layar */
  overflow-y: auto;
}
</style>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-black px-3">
  <div class="container-fluid">

    <!-- BRAND -->
    <a class="navbar-brand fw-bold" href="#">
      Yayuk <span style="font-style: italic; font-weight: 300;">Makeover</span>
    </a>

    <!-- HAMBURGER (MOBILE) -->
    <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU DESKTOP -->
    <div class="d-none d-lg-flex ms-auto align-items-center gap-4">
      <a class="nav-link text-white" href="#">Home</a>
      <a class="nav-link text-white" href="#">Service</a>
      <a class="nav-link text-white" href="#">Gallery</a>
      <a class="nav-link text-white" href="#">Keranjang</a>
      <a class="btn btn-outline-light ms-2" href="#">Login</a>
    </div>

  </div>
</nav>

<!-- MOBILE SIDEBAR (OFFCANVAS) -->
<div class="offcanvas offcanvas-end bg-dark text-white offcanvas-custom" tabindex="-1" id="mobileMenu">

  <!-- HEADER -->
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>

  <!-- BODY -->
  <div class="offcanvas-body d-flex flex-column justify-content-between">

    <!-- MENU -->
    <ul class="navbar-nav gap-3">
      <li><a class="nav-link text-white" href="#">🏠 Home</a></li>
      <li><a class="nav-link text-white" href="#">💄 Service</a></li>
      <li><a class="nav-link text-white" href="#">🖼️ Gallery</a></li>
      <li><a class="nav-link text-white" href="#">🛒 Keranjang</a></li>
    </ul>

    <!-- PROFILE -->
    <div class="border-top pt-3 mt-4">
      <div class="fw-bold">Putri</div>
      <small class="text-secondary">user@gmail.com</small><br>
      <a href="#" class="text-danger small">Logout</a>
    </div>

  </div>
</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>