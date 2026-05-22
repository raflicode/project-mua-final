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
<div class="topbar d-flex justify-content-between align-items-center mb-4">
    <div class="topbar-left">
        <div>
            <div class="page-title"><?php echo htmlspecialchars($page_title); ?></div>
            <div class="breadcrumb-nav"><?php echo htmlspecialchars($breadcrumb); ?></div>
        </div>
    </div>
    <div class="topbar-right">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari..." id="searchInput" oninput="if(typeof filterTable === 'function') filterTable();">
        </div>
        <div class="admin-badge">
            <div class="admin-avatar"><?php echo strtoupper(substr($admin_name, 0, 1)); ?></div>
            <div class="admin-name"><?php echo htmlspecialchars($admin_name); ?></div>
        </div>
    </div>
</div>
