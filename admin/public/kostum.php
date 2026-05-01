<?php
$data_booking = [
    ["paket"=>"Makeup Wedding","customer"=>"Rafli","tgl"=>"09 Januari 2026","status"=>"Lunas","alamat"=>"Jl. Mastrip","telp"=>"089766455"],
    ["paket"=>"Makeup Birthday","customer"=>"Tegar","tgl"=>"05 Januari 2026","status"=>"Dp","alamat"=>"Jl. Mastrip","telp"=>"089766455"],
    ["paket"=>"Makeup Artist","customer"=>"Andyn","tgl"=>"28 Januari 2026","status"=>"Proses","alamat"=>"Jl. Mastrip","telp"=>"089766455"],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Halaman Kostum</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-primary">

<div class="d-flex">

    <!-- Sidebar -->
    <div class="bg-primary text-white vh-100 p-3" style="width:260px;">
        <?php include 'include/sidebar.php'; ?>
    </div>

    <!-- Content -->
    <div class="flex-grow-1 bg-light rounded-start-5 p-4">

        <!-- Topbar -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- Search -->
            <div class="input-group w-25">
                <span class="input-group-text bg-white rounded-start-pill">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control rounded-end-pill" placeholder="Search">
            </div>

            <!-- Profile -->
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-person-circle fs-5 me-2"></i>
                <div>
                    <div class="fw-bold small">Hotman Paris</div>
                    <div class="text-muted" style="font-size:12px;">Admin 1</div>
                </div>
                <i class="bi bi-chevron-down ms-2"></i>
            </div>
        </div>

        <!-- Title -->
        <h5 class="fw-bold text-primary mb-3">
            <i class="bi bi-envelope-fill me-2"></i> Booking
        </h5>

        <!-- Quick Access -->
        <h6 class="fw-bold mb-3">QUICK ACCESS</h6>

        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <a href="makeup_wedding.php" class="text-decoration-none">
                    <div class="card text-center shadow-sm border-0">
                        <div class="card-body">Makeup Wedding</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="dekor.php" class="text-decoration-none">
                    <div class="card text-center shadow-sm border-0">
                        <div class="card-body">Dekor</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="kostum.php" class="text-decoration-none">
                    <div class="card text-center shadow-sm border-0 bg-primary text-white">
                        <div class="card-body">Kostum</div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Table -->
        <h6 class="fw-bold mb-3">ALL FILES</h6>

        <div class="card shadow rounded-4 p-3">

            <div class="table-responsive">
                <table class="table table-hover text-center align-middle mb-0">

                    <thead class="table-primary">
                        <tr>
                            <th>Paket</th>
                            <th>Customer</th>
                            <th>Tanggal Booking</th>
                            <th>Status</th>
                            <th>Alamat</th>
                            <th>No. Telp</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($data_booking as $row): ?>
                        <tr>
                            <td><?= $row['paket']; ?></td>
                            <td><?= $row['customer']; ?></td>
                            <td><?= $row['tgl']; ?></td>

                            <!-- Status -->
                            <td>
                                <?php if($row['status'] == 'Lunas'): ?>
                                    <span class="badge bg-success">Lunas</span>
                                <?php elseif($row['status'] == 'Dp'): ?>
                                    <span class="badge bg-warning text-dark">DP</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Proses</span>
                                <?php endif; ?>
                            </td>

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