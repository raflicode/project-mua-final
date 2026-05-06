<?php $page = 'booking'; ?>
<?php
$data_booking = [
    ["paket"=>"Makeup Birthday","customer"=>"Tegar","tgl"=>"05 Januari 2026","status"=>"Dp","alamat"=>"Jl. Mastrip blok 3","telp"=>"089766455"],
    ["paket"=>"Makeup Wedding","customer"=>"Rafli","tgl"=>"09 Januari 2026","status"=>"Lunas","alamat"=>"Jl. Mastrip blok 3","telp"=>"089766455"],
    ["paket"=>"Makeup Wisuda","customer"=>"Lidya","tgl"=>"16 Januari 2026","status"=>"Lunas","alamat"=>"Jl. Mastrip blok 3","telp"=>"089766455"],
    ["paket"=>"Kostum","customer"=>"Andyn","tgl"=>"28 Januari 2026","status"=>"Proses","alamat"=>"Jl. Mastrip blok 3","telp"=>"089766455"],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row vh-100">

        <!-- Sidebar -->
<div class="col-md-3 col-lg-2 bg-primary text-black d-flex flex-column p-3">
    <h5 class="text-center mb-4">Yayuk Makeover</h5>

    <!-- Dashboard (Pastikan filenya bernama dashboard.php) -->
    <a href="dashboard.php" 
       class="text-decoration-none mb-2 p-2 rounded d-flex align-items-center <?= ($page == 'dashboard') ? 'bg-light text-primary fw-bold' : 'text-white' ?>">
        <i class="bi bi-grid me-2"></i> Dashboard
    </a>

    <!-- Booking -->
    <a href="booking.php" 
       class="text-decoration-none mb-2 p-2 rounded d-flex align-items-center <?= ($page == 'booking') ? 'bg-light text-primary fw-bold' : 'text-white' ?>">
        <i class="bi bi-calendar me-2"></i> Booking
    </a>

    <!-- Data Layanan (Ganti # menjadi layanan.php) -->
    <a href="data_layanan.php" 
       class="text-decoration-none mb-2 p-2 rounded d-flex align-items-center text-white">
        <i class="bi bi-folder me-2"></i> Data Layanan
    </a>

    <!-- User (Ganti # menjadi user.php) -->
    <a href="manajemen_user.php" 
       class="text-decoration-none mb-2 p-2 rounded d-flex align-items-center text-white">
        <i class="bi bi-people me-2"></i> User
    </a>

    <!-- Pembayaran (Ganti # menjadi pembayaran.php) -->
    <a href="pembayaran.php" 
       class="text-decoration-none mb-2 p-2 rounded d-flex align-items-center text-white">
        <i class="bi bi-cash me-2"></i> Pembayaran
    </a>

    <div class="mt-auto">
        <a href="logout.php" class="text-white text-decoration-none p-2 d-block">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
</div>

        <!-- Content -->
        <div class="col-md-9 col-lg-10 p-4">

            <!-- Topbar -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="input-group w-25">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search">
                </div>

                <div class="d-flex align-items-center bg-white px-3 py-2 rounded shadow-sm">
                    <i class="bi bi-person-circle fs-5 me-2"></i>
                    <div>
                        <div class="fw-bold small">Hotman Paris</div>
                        <div class="text-muted small">Admin 1</div>
                    </div>
                </div>
            </div>

            <hr>

            <h5 class="fw-bold text-primary">
                <i class="bi bi-envelope-fill me-2"></i>Booking
            </h5>

            <!-- QUICK ACCESS -->
            <h6 class="fw-bold mt-4">QUICK ACCESS</h6>

            <div class="row g-3 mb-3">

                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">Makeup Wedding</div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">Dekor</div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">Kostum</div>
                        </div>
                    </a>
                </div>

            </div>

            <!-- TABLE -->
            <h6 class="fw-bold">ALL FILES</h6>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Paket</th>
                            <th>Customer</th>
                            <th>Tgl Booking</th>
                            <th>Status</th>
                            <th>Alamat</th>
                            <th>No.Telp</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($data_booking as $row): ?>
                        <tr>
                            <td><?= $row['paket']; ?></td>
                            <td><?= $row['customer']; ?></td>
                            <td><?= $row['tgl']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td><?= $row['alamat']; ?></td>
                            <td><?= $row['telp']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

</body>
</html>