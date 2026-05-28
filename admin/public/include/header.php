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
    border-radius: 16px;
    padding: 12px 18px;
    border: 1px solid var(--topbar-border);
    box-shadow: 0 14px 40px rgba(91, 60, 37, 0.08);
    gap: 16px;
}

.topbar-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 0;
}

.topbar-toggle {
    border-radius: 12px;
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
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
    min-width: 0;
}

.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--topbar-text-main);
    letter-spacing: 0;
    line-height: 1.2;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.breadcrumb-nav {
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--topbar-text-sub);
    line-height: 1.2;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-left: auto;
}


@media (max-width: 991.98px) {
    .topbar {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-wrap: nowrap !important;
        padding: 10px 12px;
        gap: 10px;
        position: fixed !important;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 1055;
        border-radius: 0 !important;
        margin-bottom: 0 !important;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 14px 40px rgba(91, 60, 37, 0.08);
        backdrop-filter: blur(12px);
    }

    .main {
        padding-top: 72px !important;
    }

    .topbar-left {
        gap: 10px;
        flex: 1 1 0;
        min-width: 0;
    }

    .topbar-right {
        flex: 0 0 auto;
        width: auto;
        min-width: 0;
        margin-left: auto;
        justify-content: flex-end;
        align-items: center;
    }


    .breadcrumb-nav {
        display: none;
    }
}

@media (max-width: 380px) {
    .topbar {
        gap: 8px;
    }

    .topbar-toggle {
        width: 38px;
        height: 38px;
        flex-basis: 38px;
    }

    .page-title {
        font-size: 0.95rem;
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
    </div>
</div>
