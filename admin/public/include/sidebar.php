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
        <i class="bi bi-people me-2"></i> User
    </a>

    <a href="pembayaran.php" class="<?= ($page == 'pembayaran') ? 'active' : '' ?>">
        <i class="bi bi-cash me-2"></i> Pembayaran
    </a>

    <div class="mt-auto mb-3">
        <a href="logout.php">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
</div>