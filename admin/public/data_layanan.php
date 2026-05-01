<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayuk Makeover - Data Layanan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #004d8c;
            --sidebar-width: 280px;
            --bg-light: #f0f2f5;
        }

        body {
            background-color: var(--primary-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            color: white;
            padding: 20px 0;
            float: left;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-radius: 50px 0 0 50px;
            margin-bottom: 5px;
        }

        .nav-link i {
            font-size: 1.5rem;
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }

        .nav-link:hover, .nav-link.active {
            background-color: white;
            color: var(--primary-dark);
        }

        /* Main Content area with curved corner */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            background-color: var(--bg-light);
            min-height: 100vh;
            border-top-left-radius: 40px;
            padding: 30px;
        }

        /* Search & Profile Bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .search-box {
            background: white;
            border-radius: 30px;
            padding: 5px 20px;
            width: 400px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .search-box input {
            border: none;
            outline: none;
            width: 100%;
            padding: 5px 10px;
        }

        /* Card Container */
        .content-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-header-blue {
            background-color: #5d78ff;
            color: white;
            padding: 15px 25px;
            font-weight: bold;
            font-size: 1.2rem;
            text-transform: uppercase;
        }

        .card-body-custom {
            padding: 40px;
        }

        /* Form Styling */
        .image-placeholder {
            width: 200px;
            height: 200px;
            background-color: #e9ecef;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #adb5bd;
            cursor: pointer;
        }

        .form-label-custom {
            min-width: 120px;
            font-weight: 500;
        }

        .form-control-custom {
            border: 1px solid #ced4da;
            border-radius: 0;
            padding: 8px;
        }

        .btn-action {
            border-radius: 20px;
            padding: 8px 30px;
            min-width: 110px;
        }

        .btn-hapus { background-color: #ff6b6b; color: white; border: none; }
        .btn-simpan { background-color: #5d78ff; color: white; border: none; }

        .brand-text {
            padding: 0 30px 40px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand-text">
            <h4 class="m-0">Yayuk <i>Makeover</i></h4>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link" href="#"><i class="bi bi-grid-fill"></i> Dashboard</a>
            <a class="nav-link" href="#"><i class="bi bi-envelope-fill"></i> Booking</a>
            <a class="nav-link active" href="#"><i class="bi bi-headset"></i> Data Layanan</a>
            <a class="nav-link" href="#"><i class="bi bi-person-fill"></i> Manajemen User</a>
            <a class="nav-link" href="#"><i class="bi bi-wallet2"></i> Pembayaran</a>
            
            <div style="margin-top: 150px;">
                <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Log Out</a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <div class="top-bar">
            <div class="search-box">
                <input type="text" placeholder="Search">
                <i class="bi bi-search text-muted"></i>
            </div>
            
            <div class="d-flex align-items-center bg-white p-2 px-3 rounded-pill shadow-sm">
                <img src="https://ui-avatars.com/api/?name=Hotman+Paris&background=random" class="rounded-circle me-2" width="35">
                <div class="me-3">
                    <div class="fw-bold" style="font-size: 0.85rem;">Hotman Paris</div>
                    <div class="text-muted" style="font-size: 0.7rem;">Admin 1</div>
                </div>
                <i class="bi bi-chevron-down small"></i>
            </div>
        </div>

        <h4 class="mb-4 text-primary d-flex align-items-center">
            <i class="bi bi-headset me-2"></i> Data Layanan
        </h4>

        <div class="content-card">
            <div class="card-header-blue">
                Paket Layanan
            </div>
            <div class="card-body-custom">
                <form action="" method="POST">
                    <div class="row">
                        <!-- Image Upload Section -->
                        <div class="col-md-4 d-flex flex-column align-items-center">
                            <div class="image-placeholder mb-2">
                                <i class="bi bi-image mb-2" style="font-size: 4rem;"></i>
                                <i class="bi bi-plus-square fs-3"></i>
                            </div>
                            <span class="fw-bold">Edit</span>
                        </div>

                        <!-- Form Input Section -->
                        <div class="col-md-8">
                            <div class="mb-3 d-flex align-items-center">
                                <label class="form-label-custom">Nama Paket :</label>
                                <input type="text" name="nama_paket" class="form-control form-control-custom">
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label class="form-label-custom">Harga :</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 rounded-0 fw-bold">Rp</span>
                                    <input type="number" name="harga" class="form-control form-control-custom border-start-0">
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-start">
                                <label class="form-label-custom mt-1">Deskripsi :</label>
                                <textarea name="deskripsi" class="form-control form-control-custom" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end mt-4 gap-3">
                        <button type="button" class="btn btn-action btn-hapus shadow-sm">Hapus</button>
                        <button type="submit" class="btn btn-action btn-simpan shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>