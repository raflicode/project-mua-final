<?php
$page = $page ?? pathinfo($_SERVER['SCRIPT_NAME'] ?? '', PATHINFO_FILENAME);
?>

<style>
:root {
    --surface: #ffffff;
    --surface-soft: rgba(255, 248, 240, 0.18);
    --text-primary: #ffffff;
    --text-secondary: rgba(255, 248, 240, 0.96);
    --text-muted: rgba(255, 248, 240, 0.72);
    --border: rgba(255, 255, 255, 0.08);
    --accent-soft: rgba(255, 248, 240, 0.18);
    --danger-soft: rgba(234, 84, 85, 0.12);
    --sidebar-width: 280px;
    --sidebar-collapsed-width: 80px;
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: var(--sidebar-width);
    padding: 24px 18px;
    background: linear-gradient(180deg, #8b5e3c, #5c3a21);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1050;
}

body[data-sidebar-state='collapsed'] .sidebar {
    width: var(--sidebar-collapsed-width);
    padding: 24px 12px;
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 6px 10px;
    margin-bottom: 24px;
}

.sidebar-brand .brand-icon {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 12px;
    background: rgba(255, 248, 240, 0.16);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: var(--surface);
}

.sidebar-brand .brand-title {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.sidebar-brand h5 {
    font-size: 0.98rem;
    font-weight: 700;
    margin: 0;
    color: var(--surface);
    white-space: nowrap;
    letter-spacing: -0.01em;
}

.sidebar-brand small {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--text-secondary);
}

body[data-sidebar-state='collapsed'] .sidebar-brand {
    justify-content: center;
    padding: 6px 0;
}

body[data-sidebar-state='collapsed'] .sidebar-brand .brand-title {
    display: none;
}

.sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 6px;
    flex: 1;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 14px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.92rem;
    font-weight: 500;
    transition: all 0.2s ease;
    min-height: 46px;
    width: 100%;
}

.sidebar-icon {
    width: 20px;
    height: 20px;
    min-width: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    transition: all 0.2s ease;
}

.sidebar-link:hover {
    background: var(--accent-soft);
    color: var(--surface);
}

.sidebar-link:hover .sidebar-icon {
    color: var(--surface);
    transform: translateX(2px);
}

.sidebar-link.active {
    background: rgba(255, 255, 255, 0.18);
    color: var(--surface);
    font-weight: 600;
}

.sidebar-link.active .sidebar-icon {
    color: var(--surface);
}

.sidebar-footer-menu {
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}

.sidebar-link.logout-link {
    color: var(--text-secondary);
}

.sidebar-link.logout-link:hover {
    background: var(--danger-soft);
    color: #ffffff;
}

.sidebar-link.logout-link:hover .sidebar-icon {
    color: #ffffff;
}

body[data-sidebar-state='collapsed'] .sidebar-link .sidebar-label {
    display: none;
}

body[data-sidebar-state='collapsed'] .sidebar-link {
    justify-content: center;
    padding: 12px 0;
}

body[data-sidebar-state='collapsed'] .sidebar-link .sidebar-icon {
    transform: none !important;
}

.offcanvas.offcanvas-start {
    width: 280px;
    background: linear-gradient(180deg, #8b5e3c, #5c3a21);
    border-right: 1px solid rgba(255, 255, 255, 0.08);
}

.offcanvas-body {
    padding: 24px 18px;
    display: flex;
    flex-direction: column;
}

@media (max-width: 991.98px) {
    .sidebar {
        display: none !important;
    }
}
</style>

<div class="sidebar d-none d-lg-flex" id="adminSidebar">
    <div class="sidebar-brand">
        <!-- <span class="brand-icon"><i data-lucide="sparkles"></i></span> -->
        <div class="brand-title">
            <h5>Yayuk Makeover</h5>
            <small>Admin Panel</small>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="dashboard.php" class="sidebar-link <?= ($page === 'dashboard') ? 'active' : '' ?>">
            <span class="sidebar-icon"><i data-lucide="layout-dashboard"></i></span>
            <span class="sidebar-label">Dashboard</span>
        </a>

        <a href="booking.php" class="sidebar-link <?= ($page === 'booking') ? 'active' : '' ?>">
            <span class="sidebar-icon"><i data-lucide="notebook-tabs"></i></span>
            <span class="sidebar-label">Booking</span>
        </a>

        <a href="data_gallery.php" class="sidebar-link <?= ($page === 'gallery') ? 'active' : '' ?>">
            <span class="sidebar-icon"><i data-lucide="image"></i></span>
            <span class="sidebar-label">Data Gallery</span>
        </a>

        <a href="data_layanan.php" class="sidebar-link <?= ($page === 'layanan') ? 'active' : '' ?>">
            <span class="sidebar-icon"><i data-lucide="sparkles"></i></span>
            <span class="sidebar-label">Data Layanan</span>
        </a>

        <a href="penjadwalan.php" class="sidebar-link <?= ($page === 'penjadwalan') ? 'active' : '' ?>">
            <span class="sidebar-icon"><i data-lucide="calendar-days"></i></span>
            <span class="sidebar-label">Penjadwalan</span>
        </a>
    </div>

    <div class="sidebar-footer-menu">
        <a href="logout.php" class="sidebar-link logout-link">
            <span class="sidebar-icon"><i data-lucide="log-out"></i></span>
            <span class="sidebar-label">Logout</span>
        </a>
    </div>
</div>

<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header px-4 pt-4 pb-0">
        <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="sidebar-brand">
            <span class="brand-icon"><i data-lucide="sparkles"></i></span>
            <div class="brand-title">
                <h5>Yayuk Makeover</h5>
                <small>Admin Panel</small>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="dashboard.php" class="sidebar-link <?= ($page === 'dashboard') ? 'active' : '' ?>">
                <span class="sidebar-icon"><i data-lucide="layout-dashboard"></i></span>
                <span class="sidebar-label">Dashboard</span>
            </a>
            <a href="booking.php" class="sidebar-link <?= ($page === 'booking') ? 'active' : '' ?>">
                <span class="sidebar-icon"><i data-lucide="notebook-tabs"></i></span>
                <span class="sidebar-label">Booking</span>
            </a>
            <a href="data_gallery.php" class="sidebar-link <?= ($page === 'gallery') ? 'active' : '' ?>">
                <span class="sidebar-icon"><i data-lucide="image"></i></span>
                <span class="sidebar-label">Data Gallery</span>
            </a>
            <a href="data_layanan.php" class="sidebar-link <?= ($page === 'layanan') ? 'active' : '' ?>">
                <span class="sidebar-icon"><i data-lucide="sparkles"></i></span>
                <span class="sidebar-label">Data Layanan</span>
            </a>
            <a href="penjadwalan.php" class="sidebar-link <?= ($page === 'penjadwalan') ? 'active' : '' ?>">
                <span class="sidebar-icon"><i data-lucide="calendar-days"></i></span>
                <span class="sidebar-label">Penjadwalan</span>
            </a>
        </div>

        <div class="sidebar-footer-menu">
            <a href="logout.php" class="sidebar-link logout-link">
                <span class="sidebar-icon"><i data-lucide="log-out"></i></span>
                <span class="sidebar-label">Logout</span>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.replace({ 'stroke-width': 2, width: 18, height: 18 });
        }

        // Fitur collapse state body tetap dipertahankan jika sewaktu-waktu dipicu dari luar sidebar
        const stateKey = 'adminSidebarState';
        const body = document.body;
        const sidebar = document.getElementById('adminSidebar');
        const storedState = localStorage.getItem(stateKey) || 'expanded';

        if (body && sidebar) {
            body.dataset.sidebarState = storedState;
            sidebar.dataset.state = storedState;
        }
    });
</script>