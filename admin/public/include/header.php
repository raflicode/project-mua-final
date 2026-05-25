<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Page title and breadcrumb can be provided by the including page.
$page_title = $page_title ?? (isset($page) ? ucfirst($page) : 'Dashboard');
$breadcrumb = $breadcrumb ?? 'Admin / ' . $page_title;
$admin_name = $_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Admin';
?>

<!-- Topbar (shared header for admin) -->
<style>
.topbar {
    width: min(92%, 860px);
    margin: 0 auto 24px;
    background: rgba(255, 255, 255, 0.96);
    border-radius: 22px;
    padding: 18px 22px;
    border: 1px solid rgba(142, 125, 109, 0.16);
    box-shadow: 0 24px 60px rgba(24, 18, 12, 0.08);
    gap: 18px;
}
.topbar-left {
    display: flex;
    align-items: center;
    gap: 16px;
    flex: 1;
}
.topbar-toggle {
    border-radius: 14px;
    width: 44px;
    height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(142, 125, 109, 0.14);
    color: #6d5543;
}
.topbar-title {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.page-title {
    font-size: 1.08rem;
    font-weight: 700;
    color: #2f1f11;
}
.breadcrumb-nav {
    font-size: 0.82rem;
    color: #7f6754;
}
.topbar-right {
    display: flex;
    align-items: center;
    gap: 14px;
}
.admin-badge {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: rgba(140, 111, 76, 0.12);
    border: 1px solid rgba(140, 111, 76, 0.18);
    padding: 10px 14px;
    border-radius: 999px;
}
.admin-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #8c724f;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.95rem;
}
.admin-name {
    font-size: 0.92rem;
    font-weight: 600;
    color: #40312a;
    white-space: nowrap;
}
@media (max-width: 991.98px) {
    .topbar {
        width: min(98%, 860px);
        flex-wrap: wrap;
        padding: 14px 16px;
    }
    .topbar-right {
        width: 100%;
        justify-content: space-between;
    }
}
</style>
<div class="topbar d-flex justify-content-between align-items-center mb-4">
    <div class="topbar-left">
        <button class="btn btn-outline-secondary topbar-toggle d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas" aria-label="Buka menu">
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
