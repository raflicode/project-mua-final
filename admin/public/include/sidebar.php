<?php
$page = $page ?? pathinfo($_SERVER['SCRIPT_NAME'] ?? '', PATHINFO_FILENAME);
?>

<style>
:root {
    --surface: #ffffff;
    --surface-soft: #f7f6f5;
    --surface-muted: #f2efec;
    --surface-strong: #f0ebe3;
    --text-primary: #1e1a16;
    --text-secondary: #6f6b63;
    --text-muted: #958e84;
    --border: rgba(30, 26, 22, 0.12);
    --accent: #8c6f4c;
    --accent-soft: rgba(140, 111, 76, 0.12);
    --shadow: 0 32px 80px rgba(21, 16, 11, 0.08);
    --sidebar-width: 270px;
    --sidebar-collapsed-width: 90px;
}

@media (prefers-color-scheme: dark) {
    :root {
        --surface: #171717;
        --surface-soft: #202020;
        --surface-muted: #252525;
        --surface-strong: #2f2f2f;
        --text-primary: #f7f7f7;
        --text-secondary: #c1bdb6;
        --text-muted: #9b968f;
        --border: rgba(255, 255, 255, 0.08);
        --accent: #d4b37a;
        --accent-soft: rgba(212, 179, 122, 0.16);
        --shadow: 0 32px 80px rgba(0, 0, 0, 0.22);
    }
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: var(--sidebar-width);
    padding: 28px 18px 20px;
    background: var(--surface);
    border-right: 1px solid var(--border);
    box-shadow: inset -1px 0 0 rgba(31, 23, 15, 0.04);
    display: flex;
    flex-direction: column;
    gap: 18px;
    transition: width 0.28s ease, padding 0.28s ease, box-shadow 0.28s ease;
    z-index: 1050;
}

body[data-sidebar-state='collapsed'] .sidebar {
    width: var(--sidebar-collapsed-width);
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 18px;
    transition: padding 0.28s ease;
}

.sidebar-brand .brand-icon {
    width: 42px;
    height: 42px;
    border-radius: 14px;
    background: var(--surface-muted);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: var(--accent);
}

.sidebar-brand .brand-title {
    display: flex;
    flex-direction: column;
    gap: 3px;
    min-width: 0;
}

.sidebar-brand h5 {
    font-size: 0.95rem;
    font-weight: 700;
    margin: 0;
    color: var(--text-primary);
    white-space: nowrap;
}

.sidebar-brand small {
    font-size: 0.74rem;
    color: var(--text-muted);
    white-space: nowrap;
}

body[data-sidebar-state='collapsed'] .sidebar-brand {
    justify-content: center;
}

body[data-sidebar-state='collapsed'] .sidebar-brand .brand-title {
    display: none;
}

.sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.sidebar-link,
.sidebar-item,
.submenu-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 14px;
    border-radius: 16px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.94rem;
    transition: all 0.22s ease;
    min-height: 48px;
    background: transparent;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.sidebar-icon {
    width: 44px;
    height: 44px;
    min-width: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: var(--surface-muted);
    color: var(--text-secondary);
    transition: background 0.22s ease, color 0.22s ease;
}

.sidebar-link:hover,
.sidebar-item:hover,
.submenu-item:hover,
.sidebar-accordion:hover {
    background: var(--surface-soft);
    color: var(--text-primary);
}

.sidebar-link:hover .sidebar-icon,
.sidebar-item:hover .sidebar-icon,
.submenu-item:hover .sidebar-icon {
    background: var(--surface-strong);
}

.sidebar-link.active,
.sidebar-link.active .sidebar-icon {
    color: var(--accent);
}

.sidebar-link.active {
    background: var(--accent-soft);
}

.sidebar-link.active .sidebar-icon {
    background: var(--accent);
    color: #fff;
}

.sidebar-section {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.18em;
    color: var(--text-muted);
    padding: 0 14px;
}

.sidebar-submenu {
    display: grid;
    gap: 6px;
    padding-left: 20px;
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.24s ease;
}

.sidebar-submenu.show {
    max-height: 240px;
}

.sidebar-accordion {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    border-radius: 16px;
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--text-secondary);
    transition: background 0.22s ease, color 0.22s ease;
}

.sidebar-accordion .sidebar-label {
    display: flex;
    align-items: center;
    gap: 14px;
}

.sidebar-accordion .chevron {
    transition: transform 0.24s ease;
}

.sidebar-accordion.open .chevron {
    transform: rotate(90deg);
}

.submenu-item {
    padding-left: 18px;
    font-size: 0.88rem;
    background: transparent;
    color: var(--text-secondary);
}

.submenu-item.active {
    color: var(--accent);
}

.sidebar-footer {
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid var(--border);
    font-size: 0.8rem;
    color: var(--text-muted);
}

.sidebar-collapse-wrap {
    padding: 0 14px;
}

.sidebar-collapse-toggle {
    width: 100%;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: transparent;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 12px 14px;
    color: var(--text-secondary);
    transition: all 0.22s ease;
}

.sidebar-collapse-toggle:hover {
    background: var(--surface-soft);
    color: var(--text-primary);
}

body[data-sidebar-state='collapsed'] .sidebar-collapse-toggle {
    justify-content: center;
}

body[data-sidebar-state='collapsed'] .sidebar-collapse-toggle .sidebar-label {
    display: none;
}

.offcanvas.offcanvas-start {
    width: min(92%, 340px);
    background: var(--surface);
}

.offcanvas-body {
    padding: 0;
}

.offcanvas .sidebar-content {
    padding: 22px 18px 20px;
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

        <a href="#" class="sidebar-link">
            <span class="sidebar-icon"><i data-lucide="message-square"></i></span>
            <span class="sidebar-label">Chat</span>
        </a>

        <a href="#" class="sidebar-link">
            <span class="sidebar-icon"><i data-lucide="calendar"></i></span>
            <span class="sidebar-label">Calendar</span>
        </a>

        <button type="button" class="sidebar-accordion" id="tasksToggle" aria-expanded="false">
            <span class="sidebar-label"><span class="sidebar-icon"><i data-lucide="check-square"></i></span>Tasks</span>
            <span class="chevron"><i data-lucide="chevron-right"></i></span>
        </button>
        <div class="sidebar-submenu" id="tasksSubmenu">
            <a href="#" class="submenu-item">In Progress</a>
            <a href="#" class="submenu-item">Paused</a>
            <a href="#" class="submenu-item">Bugs</a>
            <a href="#" class="submenu-item">Done</a>
        </div>

        <a href="#" class="sidebar-link">
            <span class="sidebar-icon"><i data-lucide="settings"></i></span>
            <span class="sidebar-label">Settings</span>
        </a>
    </div>

    <div class="sidebar-collapse-wrap">
        <button type="button" class="sidebar-collapse-toggle" id="sidebarCollapseToggle" aria-label="Toggle sidebar">
            <span class="sidebar-icon"><i data-lucide="chevrons-left"></i></span>
            <span class="sidebar-label">Collapse</span>
        </button>
    </div>

    <div class="sidebar-footer">Premium SaaS Admin</div>
</div>

<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="sidebar-content">
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
                <a href="#" class="sidebar-link">
                    <span class="sidebar-icon"><i data-lucide="message-square"></i></span>
                    <span class="sidebar-label">Chat</span>
                </a>
                <a href="#" class="sidebar-link">
                    <span class="sidebar-icon"><i data-lucide="calendar"></i></span>
                    <span class="sidebar-label">Calendar</span>
                </a>
                <button type="button" class="sidebar-accordion" id="tasksToggleMobile" aria-expanded="false">
                    <span class="sidebar-label"><span class="sidebar-icon"><i data-lucide="check-square"></i></span>Tasks</span>
                    <span class="chevron"><i data-lucide="chevron-right"></i></span>
                </button>
                <div class="sidebar-submenu" id="tasksSubmenuMobile">
                    <a href="#" class="submenu-item">In Progress</a>
                    <a href="#" class="submenu-item">Paused</a>
                    <a href="#" class="submenu-item">Bugs</a>
                    <a href="#" class="submenu-item">Done</a>
                </div>
                <a href="#" class="sidebar-link">
                    <span class="sidebar-icon"><i data-lucide="settings"></i></span>
                    <span class="sidebar-label">Settings</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.replace({ 'stroke-width': 1.8, width: 20, height: 20 });
        }

        const stateKey = 'adminSidebarState';
        const body = document.body;
        const collapseButton = document.getElementById('sidebarCollapseToggle');
        const sidebar = document.getElementById('adminSidebar');
        const storedState = localStorage.getItem(stateKey) || 'expanded';

        if (body && sidebar) {
            body.dataset.sidebarState = storedState;
            sidebar.dataset.state = storedState;
        }

        if (collapseButton) {
            collapseButton.addEventListener('click', function () {
                const nextState = body.dataset.sidebarState === 'collapsed' ? 'expanded' : 'collapsed';
                body.dataset.sidebarState = nextState;
                sidebar.dataset.state = nextState;
                localStorage.setItem(stateKey, nextState);
            });
        }

        const setupTaskToggle = function(toggleId, submenuId) {
            const toggle = document.getElementById(toggleId);
            const submenu = document.getElementById(submenuId);
            if (!toggle || !submenu) return;
            toggle.addEventListener('click', function () {
                const open = submenu.classList.toggle('show');
                toggle.classList.toggle('open', open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        };

        setupTaskToggle('tasksToggle', 'tasksSubmenu');
        setupTaskToggle('tasksToggleMobile', 'tasksSubmenuMobile');
    });
</script>
