<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Manajemen User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* Memberikan space di kiri agar konten tidak tertutup sidebar fixed */
        .main-content {
            margin-left: 260px; /* Samakan dengan lebar sidebar */
            min-height: 100vh;
        }

        .warnacustom {
            background: linear-gradient(180deg, #4e73df, #224abe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block; /* Memastikan gradient ter-render dengan baik pada elemen block */
        }  

        /* --- STYLING MODAL CUSTOM POP-UP EDIT (SESUAI GAMBAR) --- */
        .modal-custom-edit .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            padding: 10px;
        }
        .modal-custom-edit .modal-header {
            border-bottom: none;
            padding-bottom: 5px;
        }
        .modal-custom-edit .modal-title {
            color: #0b5fa5;
            font-weight: 700;
            font-size: 1.35rem;
        }
        .modal-custom-edit .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
            font-size: 0.95rem;
        }
        .modal-custom-edit .form-control, 
        .modal-custom-edit .form-select {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            background-color: #fdfdfd;
        }
        .modal-custom-edit .form-control:focus,
        .modal-custom-edit .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(11, 95, 165, 0.15);
            border-color: #0b5fa5;
        }
        .modal-custom-edit .btn-batal {
            background-color: #cccccc;
            color: #333333;
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 20px;
            border: none;
        }
        .modal-custom-edit .btn-simpan {
            background-color: #005691;
            color: #ffffff;
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 22px;
            border: none;
        }
        .modal-custom-edit .btn-simpan:hover {
            background-color: #00406c;
        }
    </style>
</head>

<body class="bg-primary">

<div class="d-flex">

    <?php 
    $page = 'user'; // Set variabel aktif agar menu sidebar menyala
    include 'include/sidebar.php'; 
    ?>

    <div class="flex-grow-1 bg-light p-4 main-content">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div class="input-group w-50">
                <input type="text" class="form-control rounded-start-pill" placeholder="Search">
                <span class="input-group-text bg-white rounded-end-pill">
                    <i class="bi bi-search"></i>
                </span>
            </div>

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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold warnacustom">
                <i class="bi bi-person-fill me-2"></i> Manajemen User
            </h4>

            <button class="btn btn-outline-primary rounded-pill">
                <i class="bi bi-funnel me-2"></i> Filter 
                <i class="bi bi-chevron-down ms-2"></i>
            </button>
        </div>

        <div class="card shadow rounded-4 p-4">
            <div class="table-responsive"> 
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

                            <td>
                                <span class="badge bg-primary rounded-pill px-3">
                                    <?= $u[3] ?>
                                </span>
                            </td>

                            <td>
                                <?php if($u[4] == 'Aktif'): ?>
                                    <span class="badge bg-success rounded-pill px-3">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary rounded-pill px-3">Non-aktif</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="#" class="text-primary mx-1 btn-edit-user" 
                                   data-nama="<?= $u[0] ?>"
                                   data-username="<?= $u[1] ?>"
                                   data-email="<?= $u[2] ?>"
                                   data-role="<?= $u[3] ?>">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </a>
                                <a href="#" class="text-danger mx-1"><i class="bi bi-trash fs-5"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div class="modal fade modal-custom-edit" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2 fw-bold">
                    <i class="bi bi-person-fill warnacustom"></i> Edit Informasi User: <span id="modalTargetName"></span>
                </h5>
            </div>
            <div class="modal-body">
                <form action="actions/update_user.php" method="POST">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="inputNama" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" id="inputUsername" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="inputEmail" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role" id="selectRole" class="form-select">
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-simpan">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inisialisasi object Modal Bootstrap 5
        const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));

        // Ambil semua element tombol edit yang memiliki class .btn-edit-user
        document.querySelectorAll('.btn-edit-user').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah link '#' melompat ke atas halaman

                // Mengambil data dari atribut data-* baris yang di-klik
                const nama = this.getAttribute('data-nama');
                const username = this.getAttribute('data-username');
                const email = this.getAttribute('data-email');
                const role = this.getAttribute('data-role');

                // Mengisi value komponen dalam modal secara dinamis
                document.getElementById('modalTargetName').innerText = nama;
                document.getElementById('inputNama').value = nama;
                document.getElementById('inputUsername').value = username;
                document.getElementById('inputEmail').value = email;
                document.getElementById('selectRole').value = role;

                // Tampilkan pop-up modalnya
                editModal.show();
            });
        });
    });
</script>
</body>
</html>