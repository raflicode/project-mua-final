<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Edit User</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #004d8c;
            --accent-blue: #0056b3;
            --sidebar-width: 250px;
        }

        body { background-color: var(--primary-blue); font-family: sans-serif; overflow-x: hidden; }

        /* Sidebar & Layout */
        .sidebar { width: var(--sidebar-width); min-height: 100vh; color: white; padding-top: 20px; float: left; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 15px 25px; display: flex; align-items: center; border-radius: 40px 0 0 40px; transition: 0.3s; margin-bottom: 5px; }
        .nav-link.active { background-color: white; color: var(--primary-blue) !important; }
        .main-content { margin-left: var(--sidebar-width); background-color: #f0f2f5; min-height: 100vh; border-top-left-radius: 40px; padding: 30px; }

        /* Table & Card */
        .data-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .badge-role { background-color: #5d78ff; color: white; border-radius: 15px; padding: 5px 15px; font-weight: 400; }
        .badge-non { background-color: #c4c4c4; color: white; border-radius: 15px; padding: 5px 15px; min-width: 85px; display: inline-block; }

        /* MODAL CUSTOM STYLING (Sesuai Gambar) */
        .modal-content { border-radius: 25px; border: none; padding: 20px; }
        .modal-header { border-bottom: none; padding-bottom: 0; }
        .modal-title { color: var(--primary-blue); font-weight: bold; display: flex; align-items: center; gap: 10px; }
        .modal-footer { border-top: none; }
        
        .form-label { font-weight: 500; margin-bottom: 5px; }
        .form-control, .form-select {
            background-color: #f0f2f5;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px 15px;
        }

        .btn-batal { background-color: #ccc; color: #333; border: none; border-radius: 8px; padding: 8px 25px; }
        .btn-simpan { background-color: var(--primary-blue); color: white; border: none; border-radius: 8px; padding: 8px 25px; }
        
        .search-bar { background: white; border-radius: 30px; padding: 5px 20px; width: 400px; display: flex; align-items: center; }
        .search-bar input { border: none; outline: none; width: 100%; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="px-4 mb-5 mt-2"><h5>Yayuk <i>Makeover</i></h5></div>
        <nav class="nav flex-column">
            <a class="nav-link" href="#"><i class="bi bi-grid-fill me-3"></i> Dashboard</a>
            <a class="nav-link" href="#"><i class="bi bi-envelope-fill me-3"></i> Booking</a>
            <a class="nav-link" href="#"><i class="bi bi-headset me-3"></i> Data Layanan</a>
            <a class="nav-link active" href="#"><i class="bi bi-person-fill me-3"></i> Manajemen User</a>
            <a class="nav-link" href="#"><i class="bi bi-wallet2 me-3"></i> Pembayaran</a>
            <div style="margin-top: 150px;"><a class="nav-link" href="#"><i class="bi bi-box-arrow-left me-3"></i> Log Out</a></div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between mb-4">
            <div class="search-bar shadow-sm"><input type="text" placeholder="Search"><i class="bi bi-search text-muted"></i></div>
            <div class="bg-white p-2 px-3 rounded-pill shadow-sm d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name=Hotman+Paris" class="rounded-circle me-2" width="30">
                <small class="fw-bold">Hotman Paris</small>
            </div>
        </div>

        <h4 class="fw-bold text-primary mb-4"><i class="bi bi-person-fill me-2"></i> Manajemen User</h4>

        <!-- Tabel User -->
        <div class="data-card">
            <table class="table text-center align-middle">
                <thead>
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
                        <td><span class="badge badge-role">Admin</span></td>
                        <td><span class="badge badge-non">Non-aktif</span></td>
                        <td>
                            <!-- Trigger Modal Edit -->
                            <i class="bi bi-pencil-square text-primary me-2" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#editModal"></i>
                            <i class="bi bi-trash text-primary" style="cursor:pointer"></i>
                        </td>
                    </tr>
                    <!-- Baris lainnya ... -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL EDIT INFORMASI USER (Persis Gambar) -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-fill fs-4"></i> Edit Informasi User: Calvin
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="row g-4">
                            <!-- Baris 1 -->
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="Calvin">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" value="Vinzz">
                            </div>
                            <!-- Baris 2 -->
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-simpan">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>