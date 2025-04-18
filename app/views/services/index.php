<?php
/**
 * Services/Index View - Trang danh sách dịch vụ
 * File: app/views/services/index.php
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
                    <h1>Dịch vụ</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dịch vụ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section section-padding">
    <div class="container">
        <div class="section-header text-center">
            <span class="subtitle">Dịch vụ của chúng tôi</span>
            <h2>Dịch vụ chăm sóc tóc cao cấp</h2>
            <p>Trải nghiệm các dịch vụ chăm sóc tóc và da đầu đẳng cấp tại Luxury Head Spa</p>
        </div>
        
        <!-- Categories Filter -->
        <div class="services-filter text-center">
            <a href="/dich-vu" class="filter-btn <?php echo empty($current_category) ? 'active' : ''; ?>">Tất cả</a>
            
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <?php
                    $catName = ucfirst(str_replace('_', ' ', $cat['category'])); 
                    $catSlug = str_replace('_', '-', $cat['category']);
                    $isActive = ($current_category == $cat['category']) ? 'active' : '';
                    ?>
                    <a href="/dich-vu?category=<?php echo $cat['category']; ?>" class="filter-btn <?php echo $isActive; ?>"><?php echo $catName; ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Services List -->
        <div class="row">
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?>
                <div class="col-lg-3 col-md-6" data-aos="fade-up">
                    <div class="service-card">
                        <div class="service-img">
                            <img src="/assets/images/services/<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?>" class="img-fluid">
                            <div class="service-overlay">
                                <a href="/dich-vu/<?php echo $service['slug']; ?>" class="btn-link">Xem chi tiết</a>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3><a href="/dich-vu/<?php echo $service['slug']; ?>"><?php echo $service['name']; ?></a></h3>
                            <p><?php echo $service['short_description']; ?></p>
                            <div class="service-meta">
                                <span class="price"><?php echo number_format($service['price'], 0, ',', '.'); ?>đ</span>
                                <span class="duration"><i class="far fa-clock"></i> <?php echo $service['duration']; ?> phút</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Không tìm thấy dịch vụ nào.
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination-wrapper">
            <nav aria-label="Phân trang dịch vụ">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="/dich-vu?<?php echo (!empty($current_category) ? 'category=' . $current_category . '&' : ''); ?>page=<?php echo $current_page - 1; ?>" aria-label="Trang trước">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                        <a class="page-link" href="/dich-vu?<?php echo (!empty($current_category) ? 'category=' . $current_category . '&' : ''); ?>page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="/dich-vu?<?php echo (!empty($current_category) ? 'category=' . $current_category . '&' : ''); ?>page=<?php echo $current_page + 1; ?>" aria-label="Trang sau">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Booking CTA Section -->
<section class="booking-cta-section parallax-bg" style="background-image: url('/assets/images/booking-cta-bg.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="booking-cta-content" data-aos="fade-up">
                    <h2>Đặt lịch ngay hôm nay</h2>
                    <p>Trải nghiệm dịch vụ chăm sóc tóc và da đầu đẳng cấp tại Luxury Head Spa. Đội ngũ chuyên gia của chúng tôi sẽ mang đến cho bạn trải nghiệm thư giãn tuyệt vời và mái tóc khỏe đẹp.</p>
                    <a href="/dat-lich" class="btn btn-primary">Đặt lịch ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-choose-us-section section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="why-choose-images">
                    <div class="row">
                        <div class="col-6">
                            <img src="/assets/images/why-choose/why-1.jpg" alt="Luxury Head Spa" class="img-fluid rounded mb-4">
                            <img src="/assets/images/why-choose/why-3.jpg" alt="Luxury Head Spa" class="img-fluid rounded">
                        </div>
                        <div class="col-6 mt-5">
                            <img src="/assets/images/why-choose/why-2.jpg" alt="Luxury Head Spa" class="img-fluid rounded mb-4">
                            <img src="/assets/images/why-choose/why-4.jpg" alt="Luxury Head Spa" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="why-choose-content">
                    <div class="section-header">
                        <span class="subtitle">Vì sao chọn chúng tôi</span>
                        <h2>Chất lượng dịch vụ là ưu tiên hàng đầu</h2>
                    </div>
                    <p>Tại Luxury Head Spa, chúng tôi cam kết mang đến cho khách hàng trải nghiệm dịch vụ đẳng cấp với những giá trị cốt lõi:</p>
                    
                    <div class="why-choose-items">
                        <div class="why-choose-item">
                            <div class="icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="content">
                                <h4>Chuyên gia giàu kinh nghiệm</h4>
                                <p>Đội ngũ chuyên gia của chúng tôi được đào tạo bài bản tại Hàn Quốc và Nhật Bản với hơn 10 năm kinh nghiệm trong ngành.</p>
                            </div>
                        </div>
                        
                        <div class="why-choose-item">
                            <div class="icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div class="content">
                                <h4>Nguyên liệu thiên nhiên</h4>
                                <p>Chúng tôi sử dụng 100% thảo dược thiên nhiên và sản phẩm cao cấp, an toàn cho mọi loại da đầu, kể cả da nhạy cảm.</p>
                            </div>
                        </div>
                        
                        <div class="why-choose-item">
                            <div class="icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="content">
                                <h4>Công nghệ tiên tiến</h4>
                                <p>Áp dụng công nghệ và thiết bị hiện đại nhất từ Hàn Quốc và Nhật Bản trong điều trị và chăm sóc tóc.</p>
                            </div>
                        </div>
                        
                        <div class="why-choose-item">
                            <div class="icon">
                                <i class="fas fa-smile"></i>
                            </div>
                            <div class="content">
                                <h4>Không gian sang trọng</h4>
                                <p>Không gian thiết kế sang trọng, tạo cảm giác thư giãn tuyệt đối cho khách hàng trong suốt quá trình trải nghiệm dịch vụ.</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="/gioi-thieu" class="btn btn-primary mt-4">Tìm hiểu thêm</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
    /* Services Filter */
    .services-filter {
        margin-bottom: 40px;
    }
    
    .filter-btn {
        display: inline-block;
        padding: 8px 20px;
        margin: 0 5px 10px;
        background-color: #f8f9fa;
        color: #333;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .filter-btn:hover, .filter-btn.active {
        background-color: #38a89d;
        color: #fff;
        text-decoration: none;
    }
    
    /* Pagination */
    .pagination-wrapper {
        margin-top: 50px;
    }
    
    .page-link {
        color: #38a89d;
        border-color: #e9ecef;
        margin: 0 5px;
        border-radius: 5px;
        padding: 10px 15px;
    }
    
    .page-item.active .page-link {
        background-color: #38a89d;
        border-color: #38a89d;
    }
    
    .page-link:hover {
        background-color: rgba(56, 168, 157, 0.1);
        color: #38a89d;
        border-color: #e9ecef;
    }
    
    /* Booking CTA Section */
    .booking-cta-section {
        padding: 100px 0;
        position: relative;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    
    .booking-cta-section .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }
    
    .booking-cta-content {
        position: relative;
        color: #fff;
    }
    
    .booking-cta-content h2 {
        font-size: 36px;
        margin-bottom: 20px;
        color: #fff;
    }
    
    .booking-cta-content p {
        font-size: 18px;
        margin-bottom: 30px;
        color: rgba(255, 255, 255, 0.8);
    }
    
    /* Why Choose Us Section */
    .why-choose-us-section {
        background-color: #f8f9fa;
    }
    
    .why-choose-images img {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .why-choose-images img:hover {
        transform: translateY(-5px);
    }
    
    .why-choose-items {
        margin-top: 30px;
    }
    
    .why-choose-item {
        display: flex;
        margin-bottom: 25px;
    }
    
    .why-choose-item .icon {
        min-width: 60px;
        height: 60px;
        background-color: rgba(56, 168, 157, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38a89d;
        font-size: 24px;
        margin-right: 20px;
    }
    
    .why-choose-item .content h4 {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .why-choose-item .content p {
        font-size: 15px;
        margin-bottom: 0;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .booking-cta-content h2 {
            font-size: 30px;
        }
        
        .why-choose-images {
            margin-bottom: 40px;
        }
    }
    
    @media (max-width: 767px) {
        .booking-cta-content h2 {
            font-size: 26px;
        }
        
        .booking-cta-content p {
            font-size: 16px;
        }
        
        .filter-btn {
            padding: 6px 15px;
            margin: 0 3px 8px;
            font-size: 14px;
        }
    }
</style>

<?php
// Include footer
include_once dirname(__DIR__) . '/templates/footer.php';
?>
