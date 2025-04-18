<?php
/**
 * Admin Sidebar Partial
 * File: app/views/admin/partials/sidebar.php
 */
?>
<aside class="admin-sidebar">
    <div class="sidebar-header">
        <a href="/admin" class="logo">
            <img src="/assets/images/logo-white.png" alt="Luxury Head Spa">
            <span class="brand-text">Admin Panel</span>
        </a>
    </div>
    
    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item <?php echo ($active_menu ?? '') === 'dashboard' ? 'active' : ''; ?>">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Bảng điều khiển</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo ($active_menu ?? '') === 'services' ? 'active' : ''; ?>">
                <a class="nav-link" href="/admin/services">
                    <i class="fas fa-spa"></i>
                    <span>Quản lý dịch vụ</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo ($active_menu ?? '') === 'bookings' ? 'active' : ''; ?>">
                <a class="nav-link" href="/admin/bookings">
                    <i class="fas fa-calendar-check"></i>
                    <span>Quản lý đặt lịch</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo ($active_menu ?? '') === 'blog' ? 'active' : ''; ?>">
                <a class="nav-link" href="/admin/blog">
                    <i class="fas fa-blog"></i>
                    <span>Quản lý bài viết</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo ($active_menu ?? '') === 'gallery' ? 'active' : ''; ?>">
                <a class="nav-link" href="/admin/gallery">
                    <i class="fas fa-images"></i>
                    <span>Thư viện ảnh</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo ($active_menu ?? '') === 'testimonials' ? 'active' : ''; ?>">
                <a class="nav-link" href="/admin/testimonials">
                    <i class="fas fa-comment-alt"></i>
                    <span>Đánh giá</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo ($active_menu ?? '') === 'staff' ? 'active' : ''; ?>">
                <a class="nav-link" href="/admin/staff">
                    <i class="fas fa-users"></i>
                    <span>Nhân viên</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo ($active_menu ?? '') === 'users' ? 'active' : ''; ?>">
                <a class="nav-link" href="/admin/users">
                    <i class="fas fa-user-shield"></i>
                    <span>Quản trị viên</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo ($active_menu ?? '') === 'settings' ? 'active' : ''; ?>">
                <a class="nav-link" href="/admin/settings">
                    <i class="fas fa-cog"></i>
                    <span>Cài đặt</span>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="sidebar-footer">
        <a href="/admin/logout" class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>
</aside>
