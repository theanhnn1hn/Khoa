<?php
/**
 * Admin Header Partial
 * File: app/views/admin/partials/header.php
 */
?>
<header class="admin-header">
    <div class="header-left">
        <button class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h4 class="page-title"><?php echo $page_title ?? 'Admin Panel'; ?></h4>
    </div>
    
    <div class="header-right">
        <div class="dropdown user-menu">
            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                <img src="/assets/images/admin-avatar.jpg" alt="Admin" class="user-avatar">
                <span class="user-name"><?php echo $_SESSION['user_name'] ?? 'Admin'; ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="/admin/profile"><i class="fas fa-user me-2"></i> Hồ sơ</a></li>
                <li><a class="dropdown-item" href="/admin/settings"><i class="fas fa-cog me-2"></i> Cài đặt</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/admin/logout"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</header>
