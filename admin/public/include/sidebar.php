<?php
$page = $page ?? pathinfo($_SERVER['SCRIPT_NAME'] ?? '', PATHINFO_FILENAME);
?>

<style>
:root {
    --surface: #ffffff;
    --surface-soft: rgba(255, 248, 240, 0.18);
    --text-primary: #f3e2d2;
    --text-secondary: #d7b99e;
    --text-muted: #a97e62;
    --border: rgba(255, 255, 255, 0.08);
    --accent-soft: rgba(255, 248, 240, 0.10);
    --danger-soft: rgba(234, 84, 85, 0.12);
    --active-bg: rgba(180, 130, 60, 0.45);
    --active-text: #d9a040;
    --sidebar-width: 280px;
    --sidebar-collapsed-width: 80px;
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: var(--sidebar-width);
    padding: 28px 18px 20px;
    background: linear-gradient(180deg, #4a2e1a 0%, #3b2212 60%, #2e1a0e 100%);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1050;
    overflow-y: auto;
    scrollbar-width: none;
}

.sidebar::-webkit-scrollbar { display: none; }

body[data-sidebar-state='collapsed'] .sidebar {
    width: var(--sidebar-collapsed-width);
    padding: 24px 12px;
}

/* ── Brand ── */
.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 6px 10px;
    margin-bottom: 28px;
}

.sidebar-brand .brand-icon {
    width: 44px;
    height: 44px;
    min-width: 44px;
    border-radius: 50%;
    background: rgba(255, 248, 240, 0.13);
    border: 1.5px solid rgba(255, 248, 240, 0.22);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.sidebar-brand .brand-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.sidebar-brand .brand-title {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.sidebar-brand h5 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0;
    color: var(--surface);
    white-space: nowrap;
    letter-spacing: -0.01em;
}

.sidebar-brand small {
    font-size: 0.72rem;
    font-weight: 400;
    color: var(--text-muted);
    letter-spacing: 0.01em;
}

body[data-sidebar-state='collapsed'] .sidebar-brand {
    justify-content: center;
    padding: 6px 0;
}

body[data-sidebar-state='collapsed'] .sidebar-brand .brand-title {
    display: none;
}

/* ── Section Label ── */
.sidebar-section-label {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    color: var(--text-muted);
    padding: 0 14px;
    margin-bottom: 6px;
    margin-top: 4px;
    text-transform: uppercase;
    white-space: nowrap;
}

body[data-sidebar-state='collapsed'] .sidebar-section-label {
    display: none;
}

/* ── Menu ── */
.sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 3px;
    flex: 1;
}

.sidebar-menu-group {
    display: flex;
    flex-direction: column;
    gap: 3px;
    margin-bottom: 10px;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 11px 14px;
    border-radius: 12px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.93rem;
    font-weight: 500;
    transition: all 0.2s ease;
    min-height: 46px;
    width: 100%;
    position: relative;
}

.sidebar-icon {
    width: 22px;
    height: 22px;
    min-width: 22px;
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
}

.sidebar-link.active {
    background: var(--active-bg);
    color: var(--active-text);
    font-weight: 600;
}

.sidebar-link.active .sidebar-icon {
    color: var(--active-text);
}

/* ── Footer ── */
.sidebar-footer-menu {
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}

.sidebar-footer-copyright {
    text-align: center;
    font-size: 0.70rem;
    color: var(--text-muted);
    padding: 12px 0 2px;
    white-space: nowrap;
}

body[data-sidebar-state='collapsed'] .sidebar-footer-copyright {
    display: none;
}

.sidebar-link.logout-link {
    color: var(--text-secondary);
}

.sidebar-link.logout-link:hover {
    background: var(--danger-soft);
    color: #ff8a8a;
}

.sidebar-link.logout-link:hover .sidebar-icon {
    color: #ff8a8a;
}

/* ── Collapsed state ── */
body[data-sidebar-state='collapsed'] .sidebar-link .sidebar-label {
    display: none;
}

body[data-sidebar-state='collapsed'] .sidebar-link {
    justify-content: center;
    padding: 12px 0;
}

/* ── Offcanvas (mobile) ── */
.offcanvas.offcanvas-start {
    width: 280px;
    background: linear-gradient(180deg, #4a2e1a 0%, #3b2212 60%, #2e1a0e 100%);
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

<!-- Desktop Sidebar -->
<div class="sidebar d-none d-lg-flex" id="adminSidebar">
    <div class="sidebar-brand">
        <span class="brand-icon"><img src="../assets/logo.png" alt="Yayuk Makeover Logo"></span>
        <div class="brand-title">
            <h5>Yayuk Makeover</h5>
            <small>Admin Panel</small>
        </div>
    </div>

    <div class="sidebar-menu">
        <!-- MENU UTAMA -->
        <div class="sidebar-menu-group">
            <div class="sidebar-section-label">Menu Utama</div>

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

            <a href="data_layanan.php" class="sidebar-link <?= in_array($page, ['data_layanan', 'layanan'], true) ? 'active' : '' ?>">
                <span class="sidebar-icon"><i data-lucide="sparkles"></i></span>
                <span class="sidebar-label">Data Layanan</span>
            </a>

            <a href="penjadwalan.php" class="sidebar-link <?= in_array($page, ['penjadwalan', 'kalender_pesanan'], true) ? 'active' : '' ?>">
                <span class="sidebar-icon"><i data-lucide="calendar-days"></i></span>
                <span class="sidebar-label">Penjadwalan</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer-menu">
        <a href="logout.php" class="sidebar-link logout-link">
            <span class="sidebar-icon"><i data-lucide="log-out"></i></span>
            <span class="sidebar-label">Logout</span>
        </a>
        <div class="sidebar-footer-copyright">© 2026 Not Found</div>
    </div>
</div>

<!-- Mobile Offcanvas -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header px-4 pt-4 pb-0">
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="sidebar-brand">
            <span class="brand-icon"><img src="../assets/logo.png" alt="Yayuk Makeover Logo"></span>
            <div class="brand-title">
                <h5>Yayuk Makeover</h5>
                <small>Admin Panel</small>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="sidebar-menu-group">
                <div class="sidebar-section-label">Menu Utama</div>

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
                <a href="data_layanan.php" class="sidebar-link <?= in_array($page, ['data_layanan', 'layanan'], true) ? 'active' : '' ?>">
                    <span class="sidebar-icon"><i data-lucide="sparkles"></i></span>
                    <span class="sidebar-label">Data Layanan</span>
                </a>
                <a href="penjadwalan.php" class="sidebar-link <?= in_array($page, ['penjadwalan', 'kalender_pesanan'], true) ? 'active' : '' ?>">
                    <span class="sidebar-icon"><i data-lucide="calendar-days"></i></span>
                    <span class="sidebar-label">Penjadwalan</span>
                </a>
            </div>
        </div>

        <div class="sidebar-footer-menu">
            <a href="logout.php" class="sidebar-link logout-link">
                <span class="sidebar-icon"><i data-lucide="log-out"></i></span>
                <span class="sidebar-label">Logout</span>
            </a>
            <div class="sidebar-footer-copyright">© 2025 Yayuk Makeover</div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.replace({ 'stroke-width': 1.8, width: 18, height: 18 });
        }

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