<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Manajemen User</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #004d8c;
            --accent-blue: #5d78ff;
            --light-gray: #f8f9fa;
            --sidebar-width: 250px;
        }

        body {
            background-color: var(--primary-blue);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Layout Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            color: white;
            padding-top: 20px;
            float: left;
        }

        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 25px;
            display: flex;
            align-items: center;
            border-radius: 40px 0 0 40px;
            margin-bottom: 5px;
            transition: 0.3s;
        }

        .nav-link i { font-size: 1.3rem; margin-right: 15px; width: 25px; }

        .nav-link:hover, .nav-link.active {
            background-color: white;
            color: var(--primary-blue) !important;
        }

        /* Main Content Container with curve */
        .main-content {
            margin-left: var(--sidebar-width);
            background-color: #f0f2f5;
            min-height: 100vh;
            border-top-left-radius: 40px;
            padding: 30px;
        }

        /* Top Bar */
        .search-bar {
            background: white;
            border-radius: 30px;
            padding: 5px 20px;
            width: 450px;
            display: flex;
            align-items: center;
        }

        .search-bar input { border: none; outline: none; width: 100%; padding: 5px; }

        /* Table Styling */
        .data-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .table thead th {
            border-bottom: 2px solid #eee;
            font-weight: 600;
            color: #333;
            padding-bottom: 15px;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 15px 8px;
            color: #444;
            border-bottom: 1px solid #f1f1f1;
        }

        /* Badges */
        .badge-role { background-color: #5d78ff; color: white; border-radius: 15px; padding: 5px 15px; font-weight: 400; }
        .badge-aktif { background-color: #00d832; color: white; border-radius: 15px; padding: 5px 15px; font-weight: 400; min-width: 85px; display: inline-block; text-align: center; }
        .badge-non { background-color: #c4c4c4; color: white; border-radius: 15px; padding: 5px 15px; font-weight: 400; min-width: 85px; display: inline-block; text-align: center; }

        .action-icons i { cursor: pointer; margin: 0 5px; font-size: 1.1rem; color: var(--primary-blue); }

        .btn-filter {
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 5px 20px;
            color: var(--primary-blue);
            background: white;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="px-4 mb-5 mt-2">
            <h5 class="fw-bold">Yayuk <span class="fst-italic fw-normal">Makeover</span></h5>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link" href="#"><i class="bi bi-grid-fill"></i> Dashboard</a>
            <a class="nav-link" href="#"><i class="bi bi-envelope-fill"></i> Booking</a>
            <a class="nav-link" href="#"><i class="bi bi-headset"></i> Data Layanan</a>
            <a class="nav-link active" href="#"><i class="bi bi-person-fill"></i> Manajemen User</a>
            <a class="nav-link" href="#"><i class="bi bi-wallet2"></i> Pembayaran</a>
            
            <div style="margin-top: 180px;">
                <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Log Out</a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="search-bar shadow-sm">
                <input type="text" placeholder="Search">
                <i class="bi bi-search text-muted"></i>
            </div>
            
            <div class="d-flex align-items-center bg-white p-2 px-3 rounded-pill shadow-sm">
                <img src="https://ui-avatars.com/api/?name=Hotman+Paris&background=random" class="rounded-circle me-2" width="30">
                <div class="me-3" style="line-height: 1.2;">
                    <small class="fw-bold d-block">Hotman Paris</small>
                    <small class="text-muted" style="font-size: 0.7rem;">Admin 1</small>
                </div>
                <i class="bi bi-chevron-down small"></i>
            </div>
        </div>

        <!-- Title & Filter -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary"><i class="bi bi-person-fill me-2"></i> Manajemen User</h4>
            <button class="btn btn-filter shadow-sm"><i class="bi bi-funnel me-2"></i> Filter <i class="bi bi-chevron-down ms-2"></i></button>
        </div>

        <!-- Data Table -->
        <div class="data-card">
            <table class="table table-borderless text-center">
                <thead>
                    <tr>
                        <th class="text-start border-primary border-bottom-0"><span class="border-bottom border-primary border-3 pb-2">Nama</span></th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Contoh Data Array untuk simulasi loop PHP
                    $users = [
                        ["Calvin", "Vinzz", "calvinn@gmail.com", "Admin", "Non-aktif"],
                        ["Rafli", "Fliiy", "raflii@gmail.com", "Admin", "Non-aktif"],
                        ["Tegar", "Garzain", "tegar76@gmail.com", "Admin", "Aktif"],
                        ["Andyn", "Andyn16", "andyn89@gmail.com", "Admin", "Non-aktif"],
                        ["Lidya", "Lidya09", "lidya12@gmail.com", "Admin", "Aktif"],
                        ["Puput", "Putri", "puputaja@gmail.com", "Admin", "Aktif"],
                        ["Alex", "Aleiix7", "alexia@gmail.com", "Admin", "Non-aktif"],
                        ["Putra", "Put77", "putrabaik@gmail.com", "Admin", "Non-aktif"],
                        ["Yanto", "Tooo", "yanto@gmail.com", "Admin", "Non-aktif"],
                        ["Bagus", "Sambagus", "bagus69@gmail.com", "Admin", "Non-aktif"],
                    ];

                    foreach ($users as $u) :
                    ?>
                    <tr>
                        <td class="text-start"><?= $u[0] ?></td>
                        <td><?= $u[1] ?></td>
                        <td><u><?= $u[2] ?></u></td>
                        <td><span class="badge badge-role"><?= $u[3] ?></span></td>
                        <td>
                            <span class="<?= $u[4] == 'Aktif' ? 'badge-aktif' : 'badge-non' ?>">
                                <?= $u[4] ?>
                            </span>
                        </td>
                        <td class="action-icons">
                            <i class="bi bi-pencil-square"></i>
                            <i class="bi bi-trash"></i>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>