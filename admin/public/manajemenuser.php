<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Edit User</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-primary">

<div class="d-flex">

    <!-- Sidebar -->
    <div class="bg-primary text-white vh-100 p-3" style="width:250px;">
        <?php include 'include/sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 bg-light rounded-start-5 p-4">

        <!-- Top Bar -->
        <div class="d-flex justify-content-between mb-4">

            <!-- Search -->
            <div class="input-group w-50">
                <input type="text" class="form-control rounded-start-pill" placeholder="Search">
                <span class="input-group-text bg-white rounded-end-pill">
                    <i class="bi bi-search"></i>
                </span>
            </div>

            <!-- Profile -->
            <div class="bg-white px-3 py-2 rounded-pill shadow-sm d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name=Hotman+Paris" class="rounded-circle me-2" width="30">
                <small class="fw-bold">Hotman Paris</small>
            </div>
        </div>

        <!-- Title -->
        <h4 class="fw-bold text-primary mb-4">
            <i class="bi bi-person-fill me-2"></i> Manajemen User
        </h4>

        <!-- Table -->
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
                    <tr>
                        <td class="text-start">Calvin</td>
                        <td>Vinzz</td>
                        <td><u>calvinn@gmail.com</u></td>

                        <!-- Role -->
                        <td>
                            <span class="badge bg-primary rounded-pill px-3">Admin</span>
                        </td>

                        <!-- Status -->
                        <td>
                            <span class="badge bg-secondary rounded-pill px-3">Non-aktif</span>
                        </td>

                        <!-- Aksi -->
                        <td>
                            <i class="bi bi-pencil-square text-primary me-2" 
                               style="cursor:pointer"
                               data-bs-toggle="modal" 
                               data-bs-target="#editModal"></i>

                            <i class="bi bi-trash text-danger" style="cursor:pointer"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title text-primary fw-bold">
                    <i class="bi bi-person-fill me-2"></i> Edit Informasi User: Calvin
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="Calvin">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="Vinzz">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="calvinn@gmail.com">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select class="form-select">
                                <option selected>Admin</option>
                                <option>User</option>
                                <option>Staff</option>
                            </select>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="button" class="btn btn-primary rounded-pill px-4">
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>