
<?php
session_start();
?>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

.btn-booking {
    height: 45px; /* Samakan tinggi dengan tombol keranjang */
    border-radius: 30px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.btn-cart-icon {
    width: 45px;
    height: 45px;
    background-color: #212529;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    border: none;
    flex-shrink: 0; /* Agar tidak tertekan/gepeng */
}

.btn-cart-icon i {
    font-size: 18px; /* Ukuran besar kecilnya logo keranjang */
} 

/* Styling Gambar Paket */
.img-paket {
    width: 100%;
    height: 200px; /* Tinggi tetap agar card sejajar */
    object-fit: cover; /* Memotong gambar secara proporsional agar memenuhi area */
    border-radius: 12px;
    margin-bottom: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        <div class="row g-4">

    <div class="col-md-6">
        <div class="card card-custom h-100 p-3">
            <div class="card-body">
                <h5 class="mb-3">Makeup Graduation</h5>
                <img src="../assets/foto_makeup.jpeg" class="img-paket" alt="Makeup Graduation">
                
                <p class="fw-semibold">Include :</p>
                <ul>
                    <li>Makeup</li>
                    <li>Softlens</li>
                    <li>Hairdo</li>
                </ul>
            </div>
            <div class="d-flex gap-2 mt-auto">
                    <button onclick="addToCart('Makeup Graduation', 'makeup', 800000)" class="btn-cart-icon">
                    🛒
                    </button>
                    <a href="booking.php?from=makeup&nama=Makeup+Graduation&harga=800000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                    Booking
                </a>
            </div>
        </div>
    </div>

        <!-- Card 2 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Makeup Wedding</h5>
                    <img src="../assets/foto_makeup.jpeg" class="img-paket" alt="Makeup Graduation">
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                        <li>Teks 3</li>
                        <li>Teks 4</li>
                    </ul>
                </div>
                <div class="d-flex gap-2 mt-auto">
                    <button onclick="addToCart('Makeup Wedding', 'makeup', 1500000)" class="btn-cart-icon">
                    🛒
                    </button>
                    <a href="booking.php?from=makeup&nama=Makeup+Wedding&harga=1500000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                        Booking
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Makeup Carnaval</h5>
                    <img src="../assets/foto_makeup.jpeg" class="img-paket" alt="Makeup Graduation">
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Teks 1</li>
                        <li>Teks 2</li>
                        <li>Teks 3</li>
                        <li>Teks 4</li>
                    </ul>
                </div>
                <div class="d-flex gap-2 mt-auto">
                    <button onclick="addToCart('Makeup Carnava', 'makeup', 1000000)" class="btn-cart-icon">
                    🛒
                    </button>
                    <a href="booking.php?from=makeup&nama=Makeup+Carnaval&harga=1000000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                        Booking
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-3">
                <div class="card-body">
                    <h5 class="mb-4">Makeup Natural</h5>
                    <img src="../assets/foto_makeup.jpeg" class="img-paket" alt="Makeup Graduation">
                    <p class="fw-semibold">Include :</p>
                    <ul>
                        <li>Teks 5</li>
                        <li>Teks 6</li>
                        <li>Teks 7</li>
                        <li>Teks 8</li>
                    </ul>
                </div>
                <div class="d-flex gap-2 mt-auto">
                    <button onclick="addToCart('Makeup Natural', 'makeup', 2000000)" class="btn-cart-icon">
                    🛒
                    </button>
                    <a href="booking.php?from=makeup&nama=Makeup+Natural&harga=2000000" class="btn btn-dark btn-booking flex-grow-1 btn-booking-trigger">
                        Booking
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;
document.querySelectorAll('.btn-booking-trigger').forEach(btn => {
    btn.addEventListener('click', function(e){
        if (!isLoggedIn) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Login diperlukan',
                text: 'Silakan login atau register terlebih dahulu sebelum melakukan booking.',
                showCancelButton: true,
                confirmButtonText: 'Login',
                cancelButtonText: 'Register',
                reverseButtons: true,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = 'register.php';
                }
            });
        }
    });
});
</script>

<!-- Tombol Kembali -->
<a href="service.php" class="btn btn-danger btn-kembali shadow">
    kembali ↩
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'include/add_to_cart_script.php'; ?>
</body>
</html>
