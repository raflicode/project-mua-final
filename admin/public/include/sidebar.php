<?php
$page = $page ?? pathinfo($_SERVER['SCRIPT_NAME'] ?? '', PATHINFO_FILENAME);
?>

<style>
:root {
    --surface: #ffffff;
    --surface-soft: #fcfbfa;
    --surface-muted: #f4f1ee;
    --surface-strong: #ede9e4;
    --text-primary: #1e1a16;
    --text-secondary: #5c5852;
    --text-muted: #9c968f;
    --border: rgba(30, 26, 22, 0.08);
    --accent: #8c6f4c;
    --accent-soft: rgba(140, 111, 76, 0.08);
    --accent-hover: rgba(140, 111, 76, 0.12);
    --danger: #dc3545;
    --danger-soft: rgba(220, 53, 69, 0.08);
    --sidebar-width: 260px;
    --sidebar-collapsed-width: 80px;
}

@media (prefers-color-scheme: dark) {
    :root {
        --surface: #141414;
        --surface-soft: #1c1c1c;
        --surface-muted: #262626;
        --surface-strong: #333333;
        --text-primary: #f5f5f5;
        --text-secondary: #adaba8;
        --text-muted: #706e6b;
        --border: rgba(255, 255, 255, 0.06);
        --accent: #d4b37a;
        --accent-soft: rgba(212, 179, 122, 0.1);
        --accent-hover: rgba(212, 179, 122, 0.15);
        --danger: #ea5455;
        --danger-soft: rgba(234, 84, 85, 0.12);
    }
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: var(--sidebar-width);
    padding: 24px 16px;
    background: var(--surface);
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
    border-radius: 10px;
    background: var(--accent-soft);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: var(--accent);
}

.sidebar-brand .brand-title {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.sidebar-brand h5 {
    font-size: 0.95rem;
    font-weight: 700;
    margin: 0;
    color: var(--text-primary);
    white-space: nowrap;
    letter-spacing: -0.01em;
}

.sidebar-brand small {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--text-muted);
    white-space: nowrap;
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
    gap: 4px;
    flex: 1;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    min-height: 44px;
    background: transparent;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
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
    background: var(--surface-soft);
    color: var(--text-primary);
}

.sidebar-link:hover .sidebar-icon {
    color: var(--text-primary);
    transform: translateX(2px);
}

/* Active State */
.sidebar-link.active {
    background: var(--accent-soft);
    color: var(--accent);
    font-weight: 600;
}

.sidebar-link.active .sidebar-icon {
    color: var(--accent);
}

/* Logout khusus diletakkan di bawah */
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
    color: var(--danger);
}

.sidebar-link.logout-link:hover .sidebar-icon {
    color: var(--danger);
}

body[data-sidebar-state='collapsed'] .sidebar-link .sidebar-label {
    display: none;
}

body[data-sidebar-state='collapsed'] .sidebar-link {
    justify-content: center;
    padding: 10px 0;
}

body[data-sidebar-state='collapsed'] .sidebar-link .sidebar-icon {
    transform: none !important;
}

/* Offcanvas Mobile */
.offcanvas.offcanvas-start {
    width: 280px;
    background: var(--surface);
    border-right: 1px solid var(--border);
}

.offcanvas-body {
    padding: 24px 16px;
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