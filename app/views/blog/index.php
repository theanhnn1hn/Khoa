<?php
/**
 * Blog/Index View - Trang danh sách bài viết
 * File: app/views/blog/index.php
 */

// Include header
include_once dirname(__DIR__) . '/templates/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content">
                    <h1>Blog</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Posts Section -->
<?php if (!empty($featured_posts)): ?>
<section class="featured-posts-section section-padding-sm">
    <div class="container">
        <div class="row">
            <?php foreach ($featured_posts as $key => $post): ?>
                <?php if ($key === 0): ?>
                    <!-- Main Featured Post -->
                    <div class="col-lg-6 mb-4">
                        <div class="main-featured-post" data-aos="fade-up">
                            <div class="featured-post-img">
                                <a href="/blog/<?php echo $post['slug']; ?>">
                                    <img src="/assets/images/blog/<?php echo $post['image'] ?: 'default.jpg'; ?>" alt="<?php echo $post['title']; ?>" class="img-fluid">
                                </a>
                                <div class="post-category">
                                    <span>Nổi bật</span>
                                </div>
                            </div>
                            <div class="featured-post-content">
                                <h2><a href="/blog/<?php echo $post['slug']; ?>"><?php echo $post['title']; ?></a></h2>
                                <div class="post-meta">
                                    <span class="post-author"><i class="far fa-user"></i> <?php echo $post['author_name']; ?></span>
                                    <span class="post-date"><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                                    <span class="post-comments"><i class="far fa-comments"></i> <?php echo isset($post['comment_count']) ? $post['comment_count'] : 0; ?> bình luận</span>
                                </div>
                                <p class="post-excerpt"><?php echo $post['excerpt'] ?: substr(strip_tags($post['content']), 0, 200) . '...'; ?></p>
                                <a href="/blog/<?php echo $post['slug']; ?>" class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sub Featured Posts -->
                    <div class="col-lg-6">
                        <div class="row">
                <?php else: ?>
                            <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo ($key - 1) * 100; ?>">
                                <div class="sub-featured-post">
                                    <div class="featured-post-img">
                                        <a href="/blog/<?php echo $post['slug']; ?>">
                                            <img src="/assets/images/blog/<?php echo $post['image'] ?: 'default.jpg'; ?>" alt="<?php echo $post['title']; ?>" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="featured-post-content">
                                        <h3><a href="/blog/<?php echo $post['slug']; ?>"><?php echo $post['title']; ?></a></h3>
                                        <div class="post-meta">
                                            <span class="post-date"><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php endif; ?>
            <?php endforeach; ?>
                        </div>
                    </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Blog List Section -->
<section class="blog-list-section section-padding">
    <div class="container">
        <div class="row">
            <!-- Blog Posts -->
            <div class="col-lg-8">
                <?php if (!empty($posts)): ?>
                    <div class="row">
                        <?php foreach ($posts as $post): ?>
                            <div class="col-md-6 mb-4" data-aos="fade-up">
                                <div class="blog-card">
                                    <div class="blog-img">
                                        <a href="/blog/<?php echo $post['slug']; ?>">
                                            <img src="/assets/images/blog/<?php echo $post['image'] ?: 'default.jpg'; ?>" alt="<?php echo $post['title']; ?>" class="img-fluid">
                                        </a>
                                        <div class="blog-date">
                                            <span class="day"><?php echo date('d', strtotime($post['created_at'])); ?></span>
                                            <span class="month"><?php echo date('m', strtotime($post['created_at'])); ?></span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        <div class="blog-meta">
                                            <span><i class="fas fa-user"></i> <?php echo isset($post['author_name']) ? $post['author_name'] : 'Admin'; ?></span>
                                            <span><i class="fas fa-comments"></i> <?php echo isset($post['comment_count']) ? $post['comment_count'] : 0; ?> Bình luận</span>
                                        </div>
                                        <h3><a href="/blog/<?php echo $post['slug']; ?>"><?php echo $post['title']; ?></a></h3>
                                        <p><?php echo $post['excerpt'] ?: substr(strip_tags($post['content']), 0, 120) . '...'; ?></p>
                                        <a href="/blog/<?php echo $post['slug']; ?>" class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                        <div class="pagination-wrapper" data-aos="fade-up">
                            <nav aria-label="Blog pagination">
                                <ul class="pagination justify-content-center">
                                    <?php if ($current_page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="/blog?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                            <a class="page-link" href="/blog?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($current_page < $total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="/blog?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="no-posts-found" data-aos="fade-up">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4>Không tìm thấy bài viết</h4>
                            <p>Hiện tại chưa có bài viết nào. Vui lòng quay lại sau.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <!-- Search Widget -->
                    <div class="sidebar-widget search-widget" data-aos="fade-up">
                        <h3 class="widget-title">Tìm kiếm</h3>
                        <div class="widget-content">
                            <form action="/blog/search" method="GET" class="search-form">
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa..." required>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Categories Widget -->
                    <?php if (!empty($categories)): ?>
                    <div class="sidebar-widget categories-widget" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="widget-title">Danh mục</h3>
                        <div class="widget-content">
                            <ul class="categories-list">
                                <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="/blog/danh-muc/<?php echo $category['slug']; ?>">
                                        <i class="fas fa-angle-right"></i> <?php echo $category['name']; ?>
                                        <span class="count"><?php echo isset($category['post_count']) ? $category['post_count'] : '0'; ?></span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Popular Posts Widget -->
                    <?php if (!empty($popular_posts)): ?>
                    <div class="sidebar-widget popular-posts-widget" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="widget-title">Bài viết phổ biến</h3>
                        <div class="widget-content">
                            <div class="popular-posts">
                                <?php foreach ($popular_posts as $post): ?>
                                <div class="popular-post-item">
                                    <div class="post-image">
                                        <a href="/blog/<?php echo $post['slug']; ?>">
                                            <img src="/assets/images/blog/<?php echo $post['image'] ?: 'default-thumb.jpg'; ?>" alt="<?php echo $post['title']; ?>" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="post-info">
                                        <h4><a href="/blog/<?php echo $post['slug']; ?>"><?php echo $post['title']; ?></a></h4>
                                        <div class="post-meta">
                                            <span><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                                            <span><i class="far fa-eye"></i> <?php echo number_format($post['views']); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Newsletter Widget -->
                    <div class="sidebar-widget newsletter-widget" data-aos="fade-up" data-aos-delay="300">
                        <h3 class="widget-title">Đăng ký nhận bài viết mới</h3>
                        <div class="widget-content">
                            <p>Đăng ký để nhận thông báo khi có bài viết mới về chăm sóc tóc và da đầu.</p>
                            <form action="/newsletter/subscribe" method="POST" class="newsletter-form">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email của bạn" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Tags Widget -->
                    <div class="sidebar-widget tags-widget" data-aos="fade-up" data-aos-delay="400">
                        <h3 class="widget-title">Thẻ phổ biến</h3>
                        <div class="widget-content">
                            <div class="tags-cloud">
                                <a href="/blog/search?keyword=tóc+rụng">Tóc rụng</a>
                                <a href="/blog/search?keyword=gàu">Gàu</a>
                                <a href="/blog/search?keyword=head+spa">Head Spa</a>
                                <a href="/blog/search?keyword=nhuộm+tóc">Nhuộm tóc</a>
                                <a href="/blog/search?keyword=tóc+hư+tổn">Tóc hư tổn</a>
                                <a href="/blog/search?keyword=dưỡng+tóc">Dưỡng tóc</a>
                                <a href="/blog/search?keyword=massage+đầu">Massage đầu</a>
                                <a href="/blog/search?keyword=mẹo+chăm+sóc+tóc">Mẹo chăm sóc tóc</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section parallax-bg" style="background-image: url('/assets/images/blog-cta-bg.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="cta-content" data-aos="fade-up">
                    <h2>Bạn muốn có mái tóc khỏe đẹp?</h2>
                    <p>Đặt lịch ngay để trải nghiệm dịch vụ chăm sóc tóc và da đầu chuyên nghiệp tại Luxury Head Spa.</p>
                    <a href="/dat-lich" class="btn btn-primary">Đặt lịch ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
    /* Featured Posts Section */
    .section-padding-sm {
        padding: 50px 0;
    }
    
    .main-featured-post {
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        background-color: var(--white-color);
        height: 100%;
    }
    
    .featured-post-img {
        position: relative;
        overflow: hidden;
    }
    
    .featured-post-img img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        transition: var(--transition);
    }
    
    .main-featured-post:hover .featured-post-img img,
    .sub-featured-post:hover .featured-post-img img {
        transform: scale(1.1);
    }
    
    .post-category {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1;
    }
    
    .post-category span {
        background-color: var(--primary-color);
        color: var(--white-color);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .featured-post-content {
        padding: 20px;
    }
    
    .main-featured-post .featured-post-content h2 {
        font-size: 22px;
        margin-bottom: 10px;
    }
    
    .main-featured-post .featured-post-content h2 a {
        color: var(--dark-color);
        transition: var(--transition);
    }
    
    .main-featured-post .featured-post-content h2 a:hover {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .post-meta {
        margin-bottom: 15px;
    }
    
    .post-meta span {
        font-size: 14px;
        color: var(--gray-color);
        margin-right: 15px;
    }
    
    .post-meta span i {
        margin-right: 5px;
        color: var(--primary-color);
    }
    
    .post-excerpt {
        font-size: 15px;
        margin-bottom: 15px;
    }
    
    .read-more {
        font-size: 15px;
        font-weight: 500;
        color: var(--primary-color);
    }
    
    .read-more i {
        margin-left: 5px;
        transition: var(--transition);
    }
    
    .read-more:hover {
        color: var(--primary-hover);
        text-decoration: none;
    }
    
    .read-more:hover i {
        margin-left: 10px;
    }
    
    .sub-featured-post {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        background-color: var(--white-color);
        height: 100%;
    }
    
    .sub-featured-post .featured-post-img img {
        height: 200px;
    }
    
    .sub-featured-post .featured-post-content h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .sub-featured-post .featured-post-content h3 a {
        color: var(--dark-color);
        transition: var(--transition);
    }
    
    .sub-featured-post .featured-post-content h3 a:hover {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    /* Blog List Section */
    .blog-card {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        background-color: var(--white-color);
        transition: var(--transition);
        height: 100%;
    }
    
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--box-shadow-hover);
    }
    
    .blog-img {
        position: relative;
        overflow: hidden;
    }
    
    .blog-img img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: var(--transition);
    }
    
    .blog-card:hover .blog-img img {
        transform: scale(1.1);
    }
    
    .blog-date {
        position: absolute;
        bottom: 0;
        left: 20px;
        background-color: var(--primary-color);
        color: var(--white-color);
        padding: 10px 15px;
        text-align: center;
        border-radius: 5px 5px 0 0;
        transform: translateY(50%);
    }
    
    .blog-date .day {
        font-size: 20px;
        font-weight: 700;
        display: block;
        line-height: 1;
    }
    
    .blog-date .month {
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }
    
    .blog-content {
        padding: 30px 20px 20px;
    }
    
    .blog-content h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .blog-content h3 a {
        color: var(--dark-color);
        transition: var(--transition);
    }
    
    .blog-content h3 a:hover {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .blog-content p {
        font-size: 14px;
        margin-bottom: 15px;
    }
    
    /* Pagination */
    .pagination-wrapper {
        margin-top: 50px;
    }
    
    .pagination .page-link {
        color: var(--primary-color);
        border-color: var(--light-gray);
        margin: 0 5px;
        border-radius: 5px;
        padding: 10px 15px;
    }
    
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .pagination .page-link:hover {
        background-color: rgba(56, 168, 157, 0.1);
        color: var(--primary-color);
        border-color: var(--light-gray);
    }
    
    /* Blog Sidebar */
    .blog-sidebar {
        position: sticky;
        top: 100px;
    }
    
    .sidebar-widget {
        background-color: var(--white-color);
        border-radius: var(--border-radius);
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: var(--box-shadow);
    }
    
    .widget-title {
        font-size: 20px;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .widget-title:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background-color: var(--primary-color);
    }
    
    /* Search Widget */
    .search-form .input-group {
        border-radius: var(--border-radius);
        overflow: hidden;
    }
    
    /* Categories Widget */
    .categories-list {
        list-style: none;
    }
    
    .categories-list li {
        margin-bottom: 10px;
        border-bottom: 1px solid var(--light-gray);
        padding-bottom: 10px;
    }
    
    .categories-list li:last-child {
        margin-bottom: 0;
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .categories-list li a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--dark-color);
        transition: var(--transition);
    }
    
    .categories-list li a:hover {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .categories-list li a i {
        margin-right: 5px;
        font-size: 12px;
        color: var(--primary-color);
    }
    
    .categories-list li a .count {
        background-color: var(--light-color);
        color: var(--dark-color);
        font-size: 12px;
        padding: 2px 8px;
        border-radius: 20px;
        transition: var(--transition);
    }
    
    .categories-list li a:hover .count {
        background-color: var(--primary-color);
        color: var(--white-color);
    }
    
    /* Popular Posts Widget */
    .popular-post-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .popular-post-item:last-child {
        margin-bottom: 0;
    }
    
    .popular-post-item .post-image {
        width: 80px;
        height: 80px;
        border-radius: 5px;
        overflow: hidden;
        margin-right: 15px;
    }
    
    .popular-post-item .post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .popular-post-item .post-info h4 {
        font-size: 15px;
        margin-bottom: 5px;
        line-height: 1.4;
    }
    
    .popular-post-item .post-info h4 a {
        color: var(--dark-color);
        transition: var(--transition);
    }
    
    .popular-post-item .post-info h4 a:hover {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .popular-post-item .post-meta {
        margin-bottom: 0;
    }
    
    .popular-post-item .post-meta span {
        font-size: 12px;
    }
    
    /* Newsletter Widget */
    .newsletter-widget p {
        margin-bottom: 15px;
    }
    
    /* Tags Widget */
    .tags-cloud {
        display: flex;
        flex-wrap: wrap;
    }
    
    .tags-cloud a {
        display: inline-block;
        background-color: var(--light-color);
        color: var(--dark-color);
        padding: 5px 15px;
        margin: 0 8px 10px 0;
        border-radius: 20px;
        font-size: 13px;
        transition: var(--transition);
    }
    
    .tags-cloud a:hover {
        background-color: var(--primary-color);
        color: var(--white-color);
        text-decoration: none;
    }
    
    /* CTA Section */
    .cta-section {
        padding: 100px 0;
        position: relative;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    
    .cta-section .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }
    
    .cta-content {
        position: relative;
        color: var(--white-color);
    }
    
    .cta-content h2 {
        font-size: 36px;
        margin-bottom: 20px;
        color: var(--white-color);
    }
    
    .cta-content p {
        font-size: 18px;
        margin-bottom: 30px;
        color: rgba(255, 255, 255, 0.8);
    }
    
    /* No Posts Found */
    .no-posts-found {
        padding: 50px 0;
    }
    
    /* Responsive Styles */
    @media (max-width: 991px) {
        .blog-sidebar {
            margin-top: 50px;
            position: static;
        }
        
        .main-featured-post, .sub-featured-post {
            margin-bottom: 30px;
        }
    }
    
    @media (max-width: 767px) {
        .cta-content h2 {
            font-size: 28px;
        }
        
        .cta-content p {
            font-size: 16px;
        }
        
        .blog-date {
            padding: 5px 10px;
        }
        
        .blog-date .day {
            font-size: 16px;
        }
        
        .blog-date .month {
            font-size: 12px;
        }
        
        .blog-content {
            padding: 20px 15px 15px;
        }
        
        .blog-content h3 {
            font-size: 16px;
        }
        
        .popular-post-item .post-image {
            width: 60px;
            height: 60px;
        }
        
        .popular-post-item .post-info h4 {
            font-size: 14px;
        }
    }
</style>

<?php
// Include footer
include_once dirname(__DIR__) . '/templates/footer.php';
?>
