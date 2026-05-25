<?php
$page = $page ?? pathinfo($_SERVER['SCRIPT_NAME'] ?? '', PATHINFO_FILENAME);
?>

<style>
* {
    box-sizing: border-box;
}

.sidebar {
    width: 260px !important;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: linear-gradient(180deg, #5c4033, #3d2b1f) !important;
    color: white;
    display: flex;
    flex-direction: column;
    z-index: 100;
    overflow-y: auto;
    padding-top: 0 !important;
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 20px 25px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    margin-bottom: 10px;
}

.sidebar-brand .brand-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(212, 175, 55, 0.3);
    border: 1px solid #d4af37;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #d4af37;
    flex-shrink: 0;
}

.sidebar-brand h5 {
    font-weight: bold;
    font-size: 15px;
    margin: 0;
    line-height: 1.3;
    color: #fff8f0;
}

.sidebar-brand small {
    font-size: 11px;
    opacity: 0.75;
    display: block;
}

.sidebar-section {
    padding: 6px 20px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.55;
    font-weight: bold;
    margin-top: 10px;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 25px;
    color: rgba(255,255,255,0.8) !important;
    text-decoration: none;
    font-size: 14px;
    transition: background 0.2s, color 0.2s;
    border-radius: 0;
}

.sidebar a i {
    font-size: 17px;
    width: 20px;
    flex-shrink: 0;
}

.sidebar a:hover,
.sidebar a.active {
    background: rgba(212, 175, 55, 0.2) !important;
    color: #ffd700 !important;
    border-radius: 10px;
    margin: 0 10px;
    padding: 12px 15px;
}

.sidebar-footer {
    margin-top: auto;
    padding: 15px 25px;
    border-top: 1px solid rgba(255,255,255,0.1);
    font-size: 12px;
    opacity: 0.5;
    text-align: center;
}
</style>

<div class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-stars"></i>
        </div>
        <div>
            <h5>Yayuk Makeover</h5>
            <small>Beauty & Decoration</small>
        </div>
    </div>

    <div class="sidebar-section">Menu Utama</div>

    <a href="dashboard.php" class="<?= ($page === 'dashboard') ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="booking.php" class="<?= ($page === 'booking') ? 'active' : '' ?>">
        <i class="bi bi-calendar-check"></i>
        Booking
    </a>

    <a href="penjadwalan.php" class="<?= ($page === 'penjadwalan') ? 'active' : '' ?>">
        <i class="bi bi-people"></i>
        Penjadwalan
    </a>

    <a href="data_layanan.php" class="<?= ($page === 'data_layanan' || $page === 'layanan') ? 'active' : '' ?>">
        <i class="bi bi-bag-heart"></i>
        Data Layanan
    </a>

    <a href="data_gallery.php" class="<?= ($page === 'data_gallery' || $page === 'gallery') ? 'active' : '' ?>">
        <i class="bi bi-images"></i>
        Data Gallery
    </a>

    <a href="logout.php">
        <i class="bi bi-box-arrow-left"></i>
        Logout
    </a>

    <div class="sidebar-footer">
        &copy; 2025 Yayuk Makeover
    </div>
</div>
