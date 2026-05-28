<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);

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
<title>Makeup Wedding</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="../assets/admin-brown.css" rel="stylesheet">
<style>
.main-content {
    margin-left: 260px;
    min-height: 100vh;
}
</style>

</head>

<body class="bg-primary">

<div class="d-flex">

    <?php
    $page = 'booking';
    include 'include/sidebar.php';
    ?>

    <!-- Content -->
    <div class="flex-grow-1 bg-light rounded-start-5 p-4 main-content">

        <?php
        $page_title = 'Makeup Wedding';
        $breadcrumb = 'Admin / Makeup Wedding';
        include 'include/header.php';
        ?>

        <!-- Title -->
        <h5 class="fw-bold text-primary mb-3">
            <i class="bi bi-envelope-fill me-2"></i> Booking
        </h5>

        <!-- Quick Access -->
        <h6 class="fw-bold mb-3">QUICK ACCESS</h6>

        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <a href="makeup_wedding.php" class="text-decoration-none">
                    <div class="card text-center shadow-sm border-0 bg-primary text-white">
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
                    <div class="card text-center shadow-sm border-0">
                        <div class="card-body">Kostum</div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Table -->
        <h6 class="fw-bold mb-3">ALL FILES</h6>

        <div class="card shadow-sm rounded-4 border-0 p-3">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap modern-admin-table mb-0">

                    <thead>
                        <tr>
                            <th class="text-nowrap table-cell-wide">Paket</th>
                            <th class="text-nowrap table-cell-wide">Customer</th>
                            <th class="text-nowrap table-cell-date">Tanggal Booking</th>
                            <th class="text-nowrap table-cell-status">Status</th>
                            <th class="text-nowrap table-cell-wide">Alamat</th>
                            <th class="text-nowrap table-cell-phone">No. Telp</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($data_booking as $row): ?>
                        <tr>
                            <td class="text-nowrap align-middle"><?= $row['paket']; ?></td>
                            <td class="text-nowrap align-middle"><?= $row['customer']; ?></td>
                            <td class="text-nowrap align-middle"><?= $row['tgl']; ?></td>

                            <!-- Status -->
                            <td class="text-nowrap align-middle">
                                <?php if($row['status'] == 'Lunas'): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2">Lunas</span>
                                <?php elseif($row['status'] == 'Dp'): ?>
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">DP</span>
                                <?php else: ?>
                                    <span class="badge bg-primary rounded-pill px-3 py-2">Proses</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-nowrap align-middle"><span class="table-cell-truncate" title="<?= $row['alamat']; ?>"><?= $row['alamat']; ?></span></td>
                            <td class="text-nowrap align-middle"><?= $row['telp']; ?></td>
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
