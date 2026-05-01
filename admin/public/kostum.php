```php id="p5ez6j"
<?php
echo "<h1>Halaman Kostum</h1>";
?>
```
<?php
$data_booking = [
    ["paket"=>"Kostum Party","customer"=>"Tegar","tgl"=>"05 Januari 2026","status"=>"Dp","alamat"=>"Jl. Mastrip blok 3","telp"=>"089766455"],
    ["paket"=>"Kostum Wedding","customer"=>"Rafli","tgl"=>"09 Januari 2026","status"=>"Lunas","alamat"=>"Jl. Mastrip blok 3","telp"=>"089766455"],
    ["paket"=>"Kostum Tradisional","customer"=>"Lidya","tgl"=>"16 Januari 2026","status"=>"Lunas","alamat"=>"Jl. Mastrip blok 3","telp"=>"089766455"],
    ["paket"=>"Kostum Wedding","customer"=>"Andyn","tgl"=>"28 Januari 2026","status"=>"Proses","alamat"=>"Jl. Mastrip blok 3","telp"=>"089766455"],
    
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Halaman Kostum</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#dcdcdc;
    font-family:Arial, Helvetica, sans-serif;
}

.wrapper{
    width:930px;
    height:650px;
    margin:10px auto;
    background:#0b5c98;
    padding:8px;
    display:flex;
}

/* Sidebar */
.sidebar{
    width:215px;
    background:#0b5c98;
    position:relative;
    overflow:hidden;
}

.sidebar::before{
    content:'';
    position:absolute;
    left:0;
    top:0;
    width:60px;
    height:100%;
    background:#4e6dd8;
    border-radius:0 22px 22px 0;
}

.logo{
    position:relative;
    color:#fff;
    font-size:20px;
    font-style:italic;
    font-weight:600;
    margin:22px 0 35px 85px;
}

.menu{
    position:relative;
    z-index:2;
}

.menu a{
    display:flex;
    align-items:center;
    color:#fff;
    text-decoration:none;
    font-size:16px;
    padding:14px 20px;
    margin-bottom:3px;
}

.menu a i{
    width:40px;
    font-size:22px;
}

.menu a.active{
    background:#ececec;
    color:#0b5c98;
    border-radius:30px 0 0 30px;
}

.logout{
    position:absolute;
    bottom:18px;
    width:100%;
}

/* Content */
.content{
    flex:1;
    background:#ececec;
    border-radius:15px;
    padding:16px 18px;
}

/* Topbar */
.search-box{
    width:230px;
}

.search-box input{
    border:none;
    background:#e6e6e6;
    height:36px;
    border-radius:20px;
}

.search-box .input-group-text{
    border:none;
    background:#e6e6e6;
    border-radius:20px 0 0 20px;
}

.profile{
    background:#fff;
    border-radius:8px;
    padding:6px 10px;
    font-size:11px;
    min-width:120px;
}

.small-text{
    font-size:10px;
    color:#888;
}

hr{
    margin:10px 0 12px;
}

/* Title */
.title{
    color:#0b5c98;
    font-size:18px;
    font-weight:700;
}

.subtitle{
    margin:18px 0 14px;
    font-size:14px;
    font-weight:700;
}

/* Folder */
.folder-link{
    text-decoration:none;
}

.folder-box{
    height:108px;
    background:#d3d3d3;
    border-radius:15px;
    position:relative;
    box-shadow:0 2px 4px rgba(0,0,0,.15);
}

.folder-box::before{
    content:'';
    position:absolute;
    top:0;
    left:28px;
    width:48px;
    height:14px;
    background:#d3d3d3;
    border-radius:0 0 8px 8px;
}

.folder-box.active{
    background:#0b5c98;
}

.folder-box.active::before{
    background:#0b5c98;
}

.folder-text{
    position:absolute;
    top:22px;
    left:14px;
    font-size:14px;
    color:#444;
}

.folder-box.active .folder-text{
    color:#fff;
}

/* Table */
.table-title{
    margin:16px 0 8px;
    font-size:14px;
    font-weight:700;
}

.table-head{
    background:#005792;
    color:#fff;
    padding:8px 0;
    font-size:14px;
}

.row-data{
    background:#ececec;
    border:1px solid #aaa;
    border-radius:8px;
    padding:10px 0;
    margin-top:8px;
    font-size:14px;
    color:#555;
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="logo">Yayuk Makeover</div>

        <div class="menu">
            <a href="#"><i class="bi bi-grid-fill"></i>Dashboard</a>
            <a href="#" class="active"><i class="bi bi-envelope-fill"></i>Booking</a>
            <a href="#"><i class="bi bi-headset"></i>Data Layanan</a>
            <a href="#"><i class="bi bi-person-fill"></i>Manajemen User</a>
            <a href="#"><i class="bi bi-cash-coin"></i>Pembayaran</a>
        </div>

        <div class="menu logout">
            <a href="#"><i class="bi bi-box-arrow-right"></i>Log Out</a>
        </div>

    </div>

    <!-- Content -->
    <div class="content">

        <!-- Topbar -->
        <div class="d-flex justify-content-between align-items-center">
            <div class="input-group search-box">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
            </div>

            <div class="profile d-flex align-items-center">
                <i class="bi bi-person-circle fs-5 me-2"></i>
                <div>
                    <div class="fw-bold">Hotman Paris</div>
                    <div class="small-text">Admin 1</div>
                </div>
                <i class="bi bi-chevron-down ms-auto"></i>
            </div>
        </div>

        <hr>

        <!-- Title -->
        <div class="title">
            <i class="bi bi-envelope-fill me-2"></i>Booking
        </div>

        <!-- Quick Access -->
        <div class="subtitle">QUICK ACCESS</div>

        <div class="row mb-3">

            <div class="col-4">
                <a href="makeup-wedding.php" class="folder-link">
                    <div class="folder-box">
                        <div class="folder-text">Makeup Wedding</div>
                    </div>
                </a>
            </div>

            <div class="col-4">
                <a href="dekor.php" class="folder-link">
                    <div class="folder-box">
                        <div class="folder-text">Dekor</div>
                    </div>
                </a>
            </div>

            <div class="col-4">
                <a href="kostum.php" class="folder-link">
                    <div class="folder-box active">
                        <div class="folder-text">Kostum</div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Table -->
        <div class="table-title">ALL FILES</div>

        <div class="container-fluid p-0">

            <div class="row text-center table-head">
                <div class="col">Paket</div>
                <div class="col">Customer</div>
                <div class="col">Tggl Booking</div>
                <div class="col">Status</div>
                <div class="col">Alamat</div>
                <div class="col">No.Telp</div>
            </div>

            <?php foreach($data_booking as $row): ?>
            <div class="row text-center row-data align-items-center">
                <div class="col"><?= $row['paket']; ?></div>
                <div class="col"><?= $row['customer']; ?></div>
                <div class="col"><?= $row['tgl']; ?></div>
                <div class="col"><?= $row['status']; ?></div>
                <div class="col"><?= $row['alamat']; ?></div>
                <div class="col"><?= $row['telp']; ?></div>
            </div>
            <?php endforeach; ?>

        </div>

    </div>

</div>

</body>
</html>