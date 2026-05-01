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
</head>

<body class="bg-primary">

<div class="d-flex">

    <!-- Sidebar -->
    <div class="bg-primary text-white vh-100 p-3" ">
        <?php include 'include/sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 bg-light rounded-start-5 p-4">

        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <!-- Search -->
            <div class="input-group w-50">
                <input type="text" class="form-control rounded-start-pill" placeholder="Search">
                <span class="input-group-text bg-white rounded-end-pill">
                    <i class="bi bi-search"></i>
                </span>
            </div>

            <!-- Profile -->
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm">
                <img src="https://ui-avatars.com/api/?name=Hotman+Paris&background=random" 
                     class="rounded-circle me-2" width="35">

                <div class="me-3 small">
                    <div class="fw-bold">Hotman Paris</div>
                    <div class="text-muted" style="font-size:12px;">Admin 1</div>
                </div>

                <i class="bi bi-chevron-down"></i>
            </div>
        </div>

        <!-- Title -->
        <h4 class="fw-bold text-primary mb-4">
            <i class="bi bi-cash-stack me-2"></i> Pembayaran
        </h4>

        <!-- Table Card -->
        <div class="card shadow rounded-4 overflow-hidden">

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
                        ["Yanti Sartika", "Makeup Artist", "12-8-2026", "Lunas", "Rp 1.500.000"],
                        ["Humairoh", "Makeup Party", "12-6-2026", "Lunas", "Rp 1.000.000"],
                        ["Feby Kurnia", "Dekoration", "19-7-2026", "Pending", "Rp 800.000"],
                        ["Fanesa", "Kostum", "8-2-2026", "Pending", "Rp 2.500.000"],
                        ["Tika Anggraini", "Makeup Birthday", "1-9-2026", "Lunas", "Rp 3.500.000"],
                        ["Ajeng Febria", "Makeup Artist", "2-8-2026", "Pending", "Rp 400.000"],
                        ["Ayu Rofalda", "Kostum", "30-2-2026", "Lunas", "Rp 1.800.000"],
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