<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Manajemen User</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-primary">

<div class="d-flex">

    <!-- Sidebar -->
        <?php include 'include/sidebar.php'; ?>

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
                     class="rounded-circle me-2" width="30">

                <div class="me-3 small">
                    <div class="fw-bold">Hotman Paris</div>
                    <div class="text-muted" style="font-size:12px;">Admin 1</div>
                </div>

                <i class="bi bi-chevron-down"></i>
            </div>
        </div>

        <!-- Title & Filter -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-person-fill me-2"></i> Manajemen User
            </h4>

            <button class="btn btn-outline-primary rounded-pill">
                <i class="bi bi-funnel me-2"></i> Filter 
                <i class="bi bi-chevron-down ms-2"></i>
            </button>
        </div>

        <!-- Table Card -->
        <div class="card shadow rounded-4 p-4">

            <table class="table text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-start">Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
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

                        <!-- Role -->
                        <td>
                            <span class="badge bg-primary rounded-pill px-3">
                                <?= $u[3] ?>
                            </span>
                        </td>

                        <!-- Status -->
                        <td>
                            <?php if($u[4] == 'Aktif'): ?>
                                <span class="badge bg-success rounded-pill px-3">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary rounded-pill px-3">Non-aktif</span>
                            <?php endif; ?>
                        </td>

                        <!-- Aksi -->
                        <td>
                            <i class="bi bi-pencil-square text-primary mx-1"></i>
                            <i class="bi bi-trash text-danger mx-1"></i>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>