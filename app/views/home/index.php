<?php
/**
 * Home/Index View - Trang chủ
 * File: app/views/home/index.php
 */

// Include header
include_once dirname(__DIR__) . '/templates/header.php';
?>

<!-- Hero Slider Section -->
<section class="hero-slider">
    <?php if (!empty($banners)): ?>
    <div class="slider">
        <?php foreach ($banners as $banner): ?>
        <div class="slider-item">
            <div class="slider-bg" style="background-image: url('/assets/images/slider/<?php echo $banner['image']; ?>');">
                <div class="container">
                    <div class="slider-content" data-aos="fade-up">
                        <h1><?php echo $banner['title']; ?></h1>
                        <p><?php echo $banner['description']; ?></p>
                        <?php if (!empty($banner['button_text']) && !empty($banner['button_link'])): ?>
                        <a href="<?php echo $banner['button_link']; ?>" class="btn btn-primary"><?php echo $banner['button_text']; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="slider">
        <div class="slider-item">
            <div class="slider-bg" style="background-image: url('/assets/images/slider/default-banner.jpg');">
                <div class="container">
                    <div class="slider-content" data-aos="fade-up">
                        <h1>Head Spa cao cấp tiêu chuẩn Hàn-Nhật</h1>
                        <p>Trải nghiệm dịch vụ chăm sóc tóc và da đầu đẳng cấp với các sản phẩm thảo dược thiên nhiên</p>
                        <a href="/dat-lich" class="btn btn-primary">Đặt lịch ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>

<!-- Intro Section -->
<section class="intro-section section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="intro-image">
                    <img src="/assets/images/intro-image.jpg" alt="Luxury Head Spa" class="img-fluid">
                    <div class="experience-box">
                        <span class="years">10+</span>
                        <span class="text">Năm kinh nghiệm</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="intro-content">
                    <div class="section-header">
                        <span class="subtitle">Chào mừng đến với</span>
                        <h2>Luxury Head Spa</h2>
                    </div>
                    <p class="intro-text">Luxury Head Spa là trung tâm chăm sóc tóc và da đầu cao cấp hàng đầu tại Việt Nam, mang đến trải nghiệm Head Spa đẳng cấp chuẩn Hàn-Nhật.</p>
                    <p>Với đội ngũ chuyên gia có hơn 10 năm kinh nghiệm, được đào tạo bài bản tại Hàn Quốc và Nhật Bản, chúng tôi tự hào mang đến các dịch vụ chăm sóc toàn diện từ gội đầu dưỡng sinh, trị rụng tóc, trị gàu, đến các liệu pháp phục hồi tóc chuyên sâu.</p>
                    <div class="features">
                        <div class="feature-item">
                            <div class="icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div class="content">
                                <h4>Nguyên liệu thiên nhiên</h4>
                                <p>Sử dụng 100% thảo dược tự nhiên, an toàn cho da đầu nhạy cảm</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="icon">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <div class="content">
                                <h4>Công nghệ tiên tiến</h4>
                                <p>Áp dụng công nghệ và thiết bị hiện đại từ Hàn Quốc và Nhật Bản</p>
                            </div>
                        </div>
                    </div>
                    <a href="/gioi-thieu" class="btn btn-secondary">Tìm hiểu thêm</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Dịch vụ của chúng tôi</span>
            <h2>Dịch vụ nổi bật</h2>
            <p>Trải nghiệm các dịch vụ chăm sóc tóc và da đầu đẳng cấp của Luxury Head Spa</p>
        </div>
        
        <div class="row">
            <?php if (!empty($featured_services)): ?>
                <?php foreach ($featured_services as $service): ?>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $loop * 100; ?>">
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
                <div class="col-12 text-center">
                    <p>Không có dịch vụ nổi bật.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="/dich-vu" class="btn btn-primary">Xem tất cả dịch vụ</a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-choose-section section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="why-choose-content">
                    <div class="section-header">
                        <span class="subtitle">Vì sao chọn chúng tôi</span>
                        <h2>Luxury Head Spa - Spa tóc đẳng cấp</h2>
                    </div>
                    
                    <div class="choose-items">
                        <div class="choose-item">
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="content">
                                <h4>Chuyên gia giàu kinh nghiệm</h4>
                                <p>Đội ngũ chuyên gia có hơn 10 năm kinh nghiệm, được đào tạo bài bản tại Hàn Quốc và Nhật Bản.</p>
                            </div>
                        </div>
                        
                        <div class="choose-item">
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="content">
                                <h4>Thành phần thiên nhiên</h4>
                                <p>Sử dụng các sản phẩm thảo dược tự nhiên, không hóa chất độc hại, an toàn cho da đầu nhạy cảm.</p>
                            </div>
                        </div>
                        
                        <div class="choose-item">
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="content">
                                <h4>Công nghệ hiện đại</h4>
                                <p>Áp dụng công nghệ và thiết bị hiện đại từ Hàn Quốc và Nhật Bản trong điều trị và chăm sóc tóc.</p>
                            </div>
                        </div>
                        
                        <div class="choose-item">
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="content">
                                <h4>Không gian sang trọng</h4>
                                <p>Không gian thiết kế sang trọng, tạo cảm giác thư giãn tuyệt đối trong suốt quá trình trải nghiệm dịch vụ.</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="/dat-lich" class="btn btn-primary mt-4">Đặt lịch ngay</a>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="why-choose-image">
                    <div class="image-grid">
                        <div class="grid-item">
                            <img src="/assets/images/why-choose/image-1.jpg" alt="Luxury Head Spa" class="img-fluid">
                        </div>
                        <div class="grid-item">
                            <img src="/assets/images/why-choose/image-2.jpg" alt="Luxury Head Spa" class="img-fluid">
                        </div>
                        <div class="grid-item">
                            <img src="/assets/images/why-choose/image-3.jpg" alt="Luxury Head Spa" class="img-fluid">
                        </div>
                        <div class="grid-item">
                            <img src="/assets/images/why-choose/image-4.jpg" alt="Luxury Head Spa" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Counter Section -->
<section class="counter-section parallax-bg" style="background-image: url('/assets/images/counter-bg.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="counter-number">
                        <span class="counter">5000</span>+
                    </div>
                    <h4>Khách hàng hài lòng</h4>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="counter-number">
                        <span class="counter">10</span>+
                    </div>
                    <h4>Năm kinh nghiệm</h4>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="counter-number">
                        <span class="counter">15</span>+
                    </div>
                    <h4>Chuyên gia</h4>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="counter-item">
                    <div class="counter-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <div class="counter-number">
                        <span class="counter">20</span>+
                    </div>
                    <h4>Dịch vụ cao cấp</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Experts Section -->
<section class="experts-section section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Đội ngũ chuyên gia</span>
            <h2>Các chuyên gia của chúng tôi</h2>
            <p>Gặp gỡ đội ngũ chuyên gia giàu kinh nghiệm, được đào tạo bài bản tại Hàn Quốc và Nhật Bản</p>
        </div>
        
        <div class="row">
            <?php if (!empty($featured_staff)): ?>
                <?php foreach ($featured_staff as $staff): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $loop * 100; ?>">
                    <div class="expert-card">
                        <div class="expert-img">
                            <img src="/assets/images/staff/<?php echo $staff['image']; ?>" alt="<?php echo $staff['name']; ?>" class="img-fluid">
                            <div class="expert-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="expert-content">
                            <h3><?php echo $staff['name']; ?></h3>
                            <span class="position"><?php echo $staff['position']; ?></span>
                            <p><?php echo $staff['bio']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>Không có thông tin chuyên gia.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="/gioi-thieu#team" class="btn btn-secondary">Xem tất cả chuyên gia</a>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="testimonial-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Đánh giá từ khách hàng</span>
            <h2>Khách hàng nói gì về chúng tôi</h2>
            <p>Những trải nghiệm và cảm nhận thực tế từ khách hàng đã sử dụng dịch vụ tại Luxury Head Spa</p>
        </div>
        
        <div class="testimonial-carousel" data-aos="fade-up">
            <?php if (!empty($testimonials)): ?>
                <?php foreach ($testimonials as $testimonial): ?>
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <div class="rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?php echo ($i <= $testimonial['rating']) ? 'filled' : ''; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="quote"><?php echo $testimonial['content']; ?></p>
                        <div class="testimonial-author">
                            <?php if (!empty($testimonial['image'])): ?>
                            <div class="author-img">
                                <img src="/assets/images/testimonials/<?php echo $testimonial['image']; ?>" alt="<?php echo $testimonial['name']; ?>">
                            </div>
                            <?php else: ?>
                            <div class="author-img">
                                <img src="/assets/images/testimonials/default-avatar.jpg" alt="<?php echo $testimonial['name']; ?>">
                            </div>
                            <?php endif; ?>
                            <div class="author-info">
                                <h4><?php echo $testimonial['name']; ?></h4>
                                <span><?php echo $testimonial['service_name']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <div class="rating">
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                        </div>
                        <p class="quote">Trải nghiệm dịch vụ Head Spa tại đây thực sự tuyệt vời. Nhân viên chuyên nghiệp, sản phẩm chất lượng và không gian thư giãn. Tóc tôi đã có sự thay đổi rõ rệt sau liệu trình điều trị rụng tóc.</p>
                        <div class="testimonial-author">
                            <div class="author-img">
                                <img src="/assets/images/testimonials/default-avatar.jpg" alt="Khách hàng">
                            </div>
                            <div class="author-info">
                                <h4>Nguyễn Thanh Hà</h4>
                                <span>Trị rụng tóc chuyên sâu</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="/danh-gia" class="btn btn-primary">Xem tất cả đánh giá</a>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Thư viện ảnh</span>
            <h2>Không gian & Kết quả điều trị</h2>
            <p>Khám phá không gian sang trọng và những kết quả điều trị thực tế tại Luxury Head Spa</p>
        </div>
        
        <div class="gallery-filter text-center" data-aos="fade-up">
            <button class="active" data-filter="*">Tất cả</button>
            <button data-filter=".spa_interior">Không gian Spa</button>
            <button data-filter=".before_after">Trước & Sau</button>
            <button data-filter=".service">Dịch vụ</button>
        </div>
        
        <div class="gallery-grid" data-aos="fade-up">
            <div class="gallery-item spa_interior">
                <img src="/assets/images/gallery/spa-1.jpg" alt="Luxury Head Spa" class="img-fluid">
                <div class="gallery-overlay">
                    <a href="/assets/images/gallery/spa-1.jpg" class="gallery-popup">
                        <i class="fas fa-search-plus"></i>
                    </a>
                </div>
            </div>
            
            <div class="gallery-item before_after">
                <img src="/assets/images/gallery/before-after-1.jpg" alt="Trước & Sau" class="img-fluid">
                <div class="gallery-overlay">
                    <a href="/assets/images/gallery/before-after-1.jpg" class="gallery-popup">
                        <i class="fas fa-search-plus"></i>
                    </a>
                </div>
            </div>
            
            <div class="gallery-item service">
                <img src="/assets/images/gallery/service-1.jpg" alt="Dịch vụ" class="img-fluid">
                <div class="gallery-overlay">
                    <a href="/assets/images/gallery/service-1.jpg" class="gallery-popup">
                        <i class="fas fa-search-plus"></i>
                    </a>
                </div>
            </div>
            
            <div class="gallery-item spa_interior">
                <img src="/assets/images/gallery/spa-2.jpg" alt="Luxury Head Spa" class="img-fluid">
                <div class="gallery-overlay">
                    <a href="/assets/images/gallery/spa-2.jpg" class="gallery-popup">
                        <i class="fas fa-search-plus"></i>
                    </a>
                </div>
            </div>
            
            <div class="gallery-item before_after">
                <img src="/assets/images/gallery/before-after-2.jpg" alt="Trước & Sau" class="img-fluid">
                <div class="gallery-overlay">
                    <a href="/assets/images/gallery/before-after-2.jpg" class="gallery-popup">
                        <i class="fas fa-search-plus"></i>
                    </a>
                </div>
            </div>
            
            <div class="gallery-item service">
                <img src="/assets/images/gallery/service-2.jpg" alt="Dịch vụ" class="img-fluid">
                <div class="gallery-overlay">
                    <a href="/assets/images/gallery/service-2.jpg" class="gallery-popup">
                        <i class="fas fa-search-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="/thu-vien-anh" class="btn btn-secondary">Xem thêm ảnh</a>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="blog-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Tin tức & Mẹo chăm sóc tóc</span>
            <h2>Bài viết mới nhất</h2>
            <p>Cập nhật những kiến thức chuyên sâu về chăm sóc tóc và da đầu từ chuyên gia</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="/assets/images/blog/blog-1.jpg" alt="Blog" class="img-fluid">
                        <div class="blog-date">
                            <span class="day">15</span>
                            <span class="month">Th4</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="fas fa-user"></i> Admin</span>
                            <span><i class="fas fa-comments"></i> 3 Bình luận</span>
                        </div>
                        <h3><a href="/blog/5-nguyen-nhan-gay-rung-toc-o-nu-gioi">5 nguyên nhân gây rụng tóc ở nữ giới và cách khắc phục</a></h3>
                        <p>Tìm hiểu nguyên nhân phổ biến gây rụng tóc ở phụ nữ và các phương pháp điều trị hiệu quả...</p>
                        <a href="/blog/5-nguyen-nhan-gay-rung-toc-o-nu-gioi" class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="/assets/images/blog/blog-2.jpg" alt="Blog" class="img-fluid">
                        <div class="blog-date">
                            <span class="day">10</span>
                            <span class="month">Th4</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="fas fa-user"></i> Admin</span>
                            <span><i class="fas fa-comments"></i> 5 Bình luận</span>
                        </div>
                        <h3><a href="/blog/loi-ich-cua-head-spa-han-quoc">Lợi ích của Head Spa Hàn Quốc đối với sức khỏe tóc và tinh thần</a></h3>
                        <p>Khám phá những lợi ích tuyệt vời mà liệu pháp Head Spa Hàn Quốc mang lại cho sức khỏe tóc và tinh thần...</p>
                        <a href="/blog/loi-ich-cua-head-spa-han-quoc" class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="/assets/images/blog/blog-3.jpg" alt="Blog" class="img-fluid">
                        <div class="blog-date">
                            <span class="day">05</span>
                            <span class="month">Th4</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="fas fa-user"></i> Admin</span>
                            <span><i class="fas fa-comments"></i> 2 Bình luận</span>
                        </div>
                        <h3><a href="/blog/cach-cham-soc-toc-nhuom">Cách chăm sóc tóc nhuộm để giữ màu lâu và tóc khỏe đẹp</a></h3>
                        <p>Những bí quyết giúp giữ màu tóc nhuộm lâu phai và duy trì mái tóc chắc khỏe, bóng mượt...</p>
                        <a href="/blog/cach-cham-soc-toc-nhuom" class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="/blog" class="btn btn-primary">Xem tất cả bài viết</a>
        </div>
    </div>
</section>

<!-- Booking Section -->
<section class="booking-section section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="booking-content">
                    <div class="section-header">
                        <span class="subtitle">Đặt lịch ngay</span>
                        <h2>Trải nghiệm dịch vụ Head Spa đẳng cấp</h2>
                    </div>
                    <p>Đặt lịch ngay hôm nay để trải nghiệm dịch vụ Head Spa đẳng cấp tại Luxury Head Spa. Đội ngũ chuyên gia của chúng tôi sẽ tư vấn và cung cấp liệu trình phù hợp nhất với tình trạng tóc và da đầu của bạn.</p>
                    <ul class="booking-features">
                        <li><i class="fas fa-check"></i> Đặt lịch nhanh chóng, tiện lợi</li>
                        <li><i class="fas fa-check"></i> Tư vấn miễn phí từ chuyên gia</li>
                        <li><i class="fas fa-check"></i> Linh hoạt thời gian, phù hợp với lịch trình của bạn</li>
                        <li><i class="fas fa-check"></i> Nhận ưu đãi đặc biệt khi đặt lịch online</li>
                    </ul>
                    <a href="/dat-lich" class="btn btn-primary">Đặt lịch ngay</a>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="booking-form-wrapper">
                    <form action="/dat-lich/quick" method="POST" class="booking-form">
                        <input type="hidden" name="csrf_token" value="<?php echo isset($csrf_token) ? $csrf_token : ''; ?>">
                        <h3>Đặt lịch nhanh</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Họ và tên" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="tel" name="phone" class="form-control" placeholder="Số điện thoại" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        
                        <div class="form-group">
                            <select name="service_id" class="form-control" required>
                                <option value="">Chọn dịch vụ</option>
                                <?php if (!empty($featured_services)): ?>
                                    <?php foreach ($featured_services as $service): ?>
                                    <option value="<?php echo $service['id']; ?>"><?php echo $service['name']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <option value="other">Dịch vụ khác</option>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="date" name="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="time" class="form-control" required>
                                        <option value="">Chọn giờ</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                        <option value="19:00">19:00</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <textarea name="notes" class="form-control" placeholder="Ghi chú (nếu có)"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Đặt lịch ngay</button>
                        
                        <p class="form-note">* Chúng tôi sẽ liên hệ xác nhận lịch hẹn qua số điện thoại của bạn</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include_once dirname(__DIR__) . '/templates/footer.php';
?>
