<?php session_start(); ?>

<?php
// halaman_kostum.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Makeup - Yayuk Makeover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Lobster&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins', sans-serif;
    background:#efefef;
}

/* Judul */
.judul h1{
    font-family:'Lobster', cursive;
    font-size:70px;
    color:#b85a00;
    text-shadow:3px 3px 6px rgba(0,0,0,0.25);
}

.line{
    width:220px;
    height:2px;
    background:#b85a00;
    margin:auto;
}

/* Card */
.card-custom{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.12);
    transition:0.3s;
}

.card-custom:hover{
    transform:translateY(-5px);
}

.card-custom ul{
    padding-left:0;
    list-style:none;
}

.card-custom ul li{
    margin-bottom:8px;
    color:#666;
}

.card-custom ul li::before{
    content:"✓ ";
    font-weight:bold;
    color:black;
}

.btn-booking{
    border-radius:30px;
    font-weight:600;
}

/* Tombol kembali */
.btn-kembali{
    position:fixed;
    bottom:20px;
    left:20px;
    border-radius:30px;
    padding:10px 20px;
}

/* Responsive */
@media(max-width:768px){
    .judul h1{
        font-size:55px;
    }
}
</style>
</head>

<body>

<!-- Navbar Include -->
<?php include 'include/navbar.php'; ?>

<div class="container py-5">

    <!-- Judul -->
    <div class="text-center mb-5 judul">
        <h1>Makeup</h1>
        <div class="line mt-2"></div>
    </div>

    <!-- Card Produk -->
    <div class="row g-4">

        <!-- Card 1 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Kostum Baju Adat</h5>
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Makeup</li>
                        <li>Softlens</li>
                        <li>Hairdo</li>
                    </ul>
                </div>
                <a href="#" class="btn btn-dark btn-booking w-100 btn-booking-trigger">
                Booking
                </a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Kostum Wedding</h5>
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                        <li>Teks 3</li>
                        <li>Teks 4</li>
                    </ul>
                </div>
                <a href="#" class="btn btn-dark btn-booking w-100 btn-booking-trigger">
                    Booking
                </a>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Kostum Graduation</h5>
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                        <li>Teks 3</li>
                        <li>Teks 4</li>
                    </ul>
                </div>
                <a href="#" class="btn btn-dark btn-booking w-100 btn-booking-trigger">
                    Booking
                </a>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Kostum Kebaya</h5>
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Teks 5</li>
                        <li>Teks 6</li>
                        <li>Teks 7</li>
                        <li>Teks 8</li>
                    </ul>
                </div>
                <a href="#" class="btn btn-dark btn-booking w-100 btn-booking-trigger">
                    Booking
                </a>
            </div>
        </div>

    </div>

</div>

<!-- Modal Login/Register -->
<div class="modal fade" id="modalAuth" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <h5 class="mb-3">Belum Login</h5>
      <p>Kamu harus login atau register dulu sebelum booking</p>
      
      <div class="d-flex justify-content-center gap-2">
        <a href="login.php" class="btn btn-dark">Login</a>
        <a href="register.php" class="btn btn-primary">Register</a>
      </div>
    </div>
  </div>
</div>

<script>
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

document.querySelectorAll('.btn-booking-trigger').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();

        if(!isLoggedIn){
            let modal = new bootstrap.Modal(document.getElementById('modalAuth'));
            modal.show();
        } else {
            window.location.href = "booking.php";
        }
    });
});
</script>

<!-- Tombol Kembali -->
<a href="index.php" class="btn btn-danger btn-kembali shadow">
    kembali ↩
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
```
