<?php
require_once __DIR__ . '/../../config/auth.php';
require_login(['admin']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Pembayaran</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="../assets/admin-brown.css" rel="stylesheet">
    <link href="../assets/admin-layout.css" rel="stylesheet">
</head>

<body>
    <?php
    $page = 'pembayaran';
    include 'include/sidebar.php';
    ?>

    <div class="main">

            <?php
            $page_title = 'Pembayaran';
            $breadcrumb = 'Admin / Pembayaran';
            include 'include/header.php';
            ?>

        <div class="content">
            <div class="content-header">
                <div>
                    <h2>Pembayaran</h2>
                    <p>Pantau status pembayaran dan nominal transaksi pelanggan.</p>
                </div>
            </div>

        <!-- Table Card -->
        <div class="admin-card">

            <table class="table text-center mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Jenis Pesanan</th>
                        <th>Tanggal Bayar</th>
                        <th>Status Pembayaran</th>
                        <th>Nominal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $data_bayar = [
                        ["Valentino Rosi", "Makeup Artist", "12-8-2026", "Lunas", "Rp 1.500.000"],
                        ["Marques", "Makeup Party", "12-6-2026", "Lunas", "Rp 1.000.000"],
                        ["Feby Guys", "Dekoration", "19-7-2026", "Pending", "Rp 800.000"],
                        ["Difarom", "Kostum", "8-2-2026", "Pending", "Rp 2.500.000"],
                        ["Mahendra", "Makeup Birthday", "1-9-2026", "Lunas", "Rp 3.500.000"],
                        ["Ajeng Febria", "Makeup Artist", "2-8-2026", "Pending", "Rp 400.000"],
                        ["Adalah Pokoknya", "Kostum", "30-2-2026", "Lunas", "Rp 1.800.000"],
                    ];

                    foreach ($data_bayar as $row) :
                    ?>
                    <tr>
                        <td><?= $row[0] ?></td>
                        <td><?= $row[1] ?></td>
                        <td><?= $row[2] ?></td>

                        <!-- Status -->
                        <td>
                            <?php if($row[3] == 'Lunas'): ?>
                                <span class="badge bg-success rounded-pill px-3">Lunas</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                            <?php endif; ?>
                        </td>

                        <td class="fw-bold"><?= $row[4] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-end p-3">
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
