<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = $page_title ?? (isset($page) ? ucfirst($page) : 'Dashboard');
$breadcrumb = $breadcrumb ?? 'Admin / ' . $page_title;
$admin_name = $_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Admin';
?>

<style>
:root {
    --topbar-bg: rgba(255, 255, 255, 0.92);
    --topbar-border: rgba(139, 107, 74, 0.16);
    --topbar-text-main: #362518;
    --topbar-text-sub: #705a44;
    --badge-bg: rgba(255, 255, 255, 0.94);
    --badge-border: rgba(139, 107, 74, 0.16);
    --avatar-bg: #8b5e3c;
    --avatar-text: #ffffff;
}

.topbar {
    width: 100%;
    background: var(--topbar-bg);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 18px;
    padding: 14px 20px;
    border: 1px solid var(--topbar-border);
    box-shadow: 0 14px 40px rgba(91, 60, 37, 0.08);
}

.topbar-left {
    display: flex;
    align-items: center;
    gap: 14px;
    flex: 1;
}

.topbar-toggle {
    border-radius: 14px;
    width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--topbar-border);
    background: rgba(255, 255, 255, 0.92);
    color: var(--topbar-text-main);
    transition: all 0.2s ease;
}

.topbar-toggle:hover {
    background: #ffffff;
}

.topbar-title {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--topbar-text-main);
    letter-spacing: -0.01em;
}

.breadcrumb-nav {
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--topbar-text-sub);
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 14px;
}

.admin-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--badge-bg);
    border: 1px solid var(--badge-border);
    padding: 8px 14px 8px 10px;
    border-radius: 30px;
}

.admin-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--avatar-bg);
    color: var(--avatar-text);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.admin-name {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--topbar-text-main);
    white-space: nowrap;
}

@media (max-width: 991.98px) {
    .topbar {
        padding: 12px 14px;
    }
}
</style>

<div class="topbar d-flex justify-content-between align-items-center mb-4">
    <div class="topbar-left">
        <button class="btn topbar-toggle d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas" aria-label="Buka menu">
            <i class="bi bi-list"></i>
        </button>
        <div class="topbar-title">
            <div class="page-title"><?php echo htmlspecialchars($page_title); ?></div>
            <div class="breadcrumb-nav"><?php echo htmlspecialchars($breadcrumb); ?></div>
        </div>
    </div>
    <div class="topbar-right">
        <div class="admin-badge">
            <div class="admin-avatar"><?php echo strtoupper(substr($admin_name, 0, 1)); ?></div>
            <div class="admin-name"><?php echo htmlspecialchars($admin_name); ?></div>
        </div>
    </div>
</div>