<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Data Layanan</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-primary">

<div class="d-flex">

    <!-- Sidebar -->
    <div class="bg-primary text-black vh-100 p-3" style="width:280px;">
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

                <div class="me-3">
                    <div class="fw-bold small">Hotman Paris</div>
                    <div class="text-muted" style="font-size: 12px;">Admin 1</div>
                </div>

                <i class="bi bi-chevron-down"></i>
            </div>
        </div>

        <!-- Title -->
        <h4 class="text-primary mb-4">
            <i class="bi bi-headset me-2"></i> Data Layanan
        </h4>

        <!-- Card -->
        <div class="card shadow rounded-4">

            <!-- Header -->
            <div class="card-header bg-primary text-white fw-bold text-uppercase">
                Paket Layanan
            </div>

            <!-- Body -->
            <div class="card-body p-4">

                <form action="" method="POST">

                    <div class="row">

                        <!-- Upload -->
                        <div class="col-md-4 text-center">
                            <div class="bg-light border rounded d-flex flex-column justify-content-center align-items-center mb-2" style="height:200px;">
                                <i class="bi bi-image fs-1 text-secondary"></i>
                                <i class="bi bi-plus-square fs-3 text-secondary"></i>
                            </div>
                            <span class="fw-bold">Edit</span>
                        </div>

                        <!-- Form -->
                        <div class="col-md-8">

                            <div class="mb-3 row align-items-center">
                                <label class="col-sm-3 col-form-label">Nama Paket :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_paket" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label class="col-sm-3 col-form-label">Harga :</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Deskripsi :</label>
                                <div class="col-sm-9">
                                    <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-danger px-4 rounded-pill">Hapus</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">Simpan</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>