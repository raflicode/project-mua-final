<style>
    /* Sidebar */
.sidebar{
    width:260px;
    height:100vh;
    position:fixed;
    background: #513c2c;
    color:white;
    padding-top:20px;
}

.sidebar h4{
    text-align:center;
    font-weight:bold;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    padding:14px 25px;
    color:white;
    text-decoration:none;
    transition:0.3s;
}

.sidebar a:hover,
.sidebar a.active{
    background:rgba(255,255,255,0.15);
    border-radius:10px;
}
</style>


<div class="sidebar d-flex flex-column">
    <h4>Yayuk Makeover</h4>

    <a href="dashboard.php" class="<?= ($page == 'dashboard') ? 'active' : '' ?>">
        <i class="bi bi-grid me-2"></i> Dashboard
    </a>

    <a href="../admin/public/booking.php" class="<?= ($page == 'booking') ? 'active' : '' ?>">
        <i class="bi bi-calendar me-2"></i> Booking
    </a>

    <a href="../admin/public/data_layanan.php" class="<?= ($page == 'layanan') ? 'active' : '' ?>">
        <i class="bi bi-folder me-2"></i> Data Layanan
    </a>

    <a href="manajemen_user.php" class="<?= ($page == 'user') ? 'active' : '' ?>">
        <i class="bi bi-people me-2"></i> Manajemen User
    </a>

    <a href="pembayaran.php" class="<?= ($page == 'pembayaran') ? 'active' : '' ?>">
        <i class="bi bi-cash me-2"></i> Pembayaran
    </a>

    <a href="laporan.php" class="<?= ($page == 'laporan') ? 'active' : '' ?>">
        <i class="bi bi-file-earmark-text me-2"></i> Laporan
    </a>    

    <div class="mt-auto mb-3">
        <a href="logout.php">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
</div>