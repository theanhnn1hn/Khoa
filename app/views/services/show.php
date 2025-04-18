<?php
/**
 * Services/Show View - Trang chi tiết dịch vụ
 * File: app/views/services/show.php
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
                    <h1><?php echo $service['name']; ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="/dich-vu">Dịch vụ</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $service['name']; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Detail Section -->
<section class="service-detail-section section-padding">
    <div class="container">
        <?php
        // Hiển thị thông báo flash nếu có
        $flashMessage = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
        if ($flashMessage) {
            echo '<div class="alert alert-' . $flashMessage['type'] . ' alert-dismissible fade show" role="alert">';
            echo $flashMessage['message'];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>';
            echo '</div>';
            unset($_SESSION['flash']);
        }
        ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="service-detail-content">
                    <!-- Service Images Slider -->
                    <div class="service-slider">
                        <div class="main-slider">
                            <div class="slider-item">
                                <img src="/assets/images/services/<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?>" class="img-fluid">
                            </div>
                            
                            <?php if (!empty($gallery)): ?>
                                <?php foreach ($gallery as $item): ?>
                                <div class="slider-item">
                                    <img src="/assets/images/gallery/<?php echo $item['image']; ?>" alt="<?php echo $service['name']; ?>" class="img-fluid">
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="thumbnail-slider">
                            <div class="slider-item">
                                <img src="/assets/images/services/<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?>" class="img-fluid">
                            </div>
                            
                            <?php if (!empty($gallery)): ?>
                                <?php foreach ($gallery as $item): ?>
                                <div class="slider-item">
                                    <img src="/assets/images/gallery/<?php echo $item['image']; ?>" alt="<?php echo $service['name']; ?>" class="img-fluid">
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Service Title & Price -->
                    <div class="service-title-price">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2><?php echo $service['name']; ?></h2>
                                <div class="service-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= round($average_rating)): ?>
                                            <i class="fas fa-star"></i>
                                        <?php elseif ($i - 0.5 <= $average_rating): ?>
                                            <i class="fas fa-star-half-alt"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <span>(<?php echo number_format($average_rating, 1); ?>/5)</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="service-price">
                                    <span class="price"><?php echo number_format($service['price'], 0, ',', '.'); ?>đ</span>
                                    <span class="duration"><i class="far fa-clock"></i> <?php echo $service['duration']; ?> phút</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Service Description -->
                    <div class="service-description">
                        <h3>Mô tả dịch vụ</h3>
                        <div class="description-content">
                            <?php echo $service['description']; ?>
                        </div>
                    </div>
                    
                    <!-- Service Process -->
                    <div class="service-process">
                        <h3>Quy trình thực hiện</h3>
                        <div class="process-steps">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="process-item">
                                        <div class="step-number">1</div>
                                        <div class="step-content">
                                            <h4>Tư vấn và kiểm tra</h4>
                                            <p>Chuyên gia sẽ kiểm tra tình trạng tóc và da đầu, tư vấn giải pháp phù hợp với nhu cầu của bạn.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="process-item">
                                        <div class="step-number">2</div>
                                        <div class="step-content">
                                            <h4>Làm sạch sơ bộ</h4>
                                            <p>Gội đầu nhẹ nhàng với sản phẩm chuyên dụng để làm sạch bụi bẩn, dầu thừa trên tóc và da đầu.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="process-item">
                                        <div class="step-number">3</div>
                                        <div class="step-content">
                                            <h4>Thực hiện dịch vụ chính</h4>
                                            <p>Áp dụng các sản phẩm đặc trị và kỹ thuật chuyên nghiệp theo từng loại dịch vụ cụ thể.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="process-item">
                                        <div class="step-number">4</div>
                                        <div class="step-content">
                                            <h4>Massage thư giãn</h4>
                                            <p>Massage đầu, vai, gáy với kỹ thuật bấm huyệt giúp lưu thông máu, giảm căng thẳng.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="process-item">
                                        <div class="step-number">5</div>
                                        <div class="step-content">
                                            <h4>Hoàn thiện</h4>
                                            <p>Sấy tạo kiểu nhẹ nhàng và tư vấn chăm sóc tóc tại nhà sau khi sử dụng dịch vụ.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Service Benefits -->
                    <div class="service-benefits">
                        <h3>Lợi ích</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="benefits-list">
                                    <li><i class="fas fa-check-circle"></i> Làm sạch sâu da đầu, loại bỏ bụi bẩn, dầu thừa</li>
                                    <li><i class="fas fa-check-circle"></i> Kích thích tuần hoàn máu, tăng cường sức khỏe nang tóc</li>
                                    <li><i class="fas fa-check-circle"></i> Cung cấp dưỡng chất, nuôi dưỡng tóc từ gốc đến ngọn</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="benefits-list">
                                    <li><i class="fas fa-check-circle"></i> Giảm căng thẳng, mệt mỏi, đau đầu, mất ngủ</li>
                                    <li><i class="fas fa-check-circle"></i> Phòng ngừa và giảm thiểu các vấn đề về tóc và da đầu</li>
                                    <li><i class="fas fa-check-circle"></i> Mang lại cảm giác thư giãn, thoải mái</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Customer Reviews -->
                    <div class="customer-reviews">
                        <h3>Đánh giá từ khách hàng</h3>
                        
                        <?php if (!empty($testimonials)): ?>
                            <div class="reviews-list">
                                <?php foreach ($testimonials as $testimonial): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <?php if (!empty($testimonial['image'])): ?>
                                            <div class="reviewer-img">
                                                <img src="/assets/images/testimonials/<?php echo $testimonial['image']; ?>" alt="<?php echo $testimonial['name']; ?>">
                                            </div>
                                            <?php else: ?>
                                            <div class="reviewer-img">
                                                <img src="/assets/images/testimonials/default-avatar.jpg" alt="<?php echo $testimonial['name']; ?>">
                                            </div>
                                            <?php endif; ?>
                                            <div class="reviewer-meta">
                                                <h4><?php echo $testimonial['name']; ?></h4>
                                                <div class="review-date"><?php echo date('d/m/Y', strtotime($testimonial['created_at'])); ?></div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $testimonial['rating']): ?>
                                                    <i class="fas fa-star"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <p><?php echo $testimonial['content']; ?></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="no-reviews">
                                <p>Chưa có đánh giá nào cho dịch vụ này.</p>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Review Form -->
                        <div class="review-form-wrapper">
                            <h4>Gửi đánh giá của bạn</h4>
                            <form action="/dich-vu/add-testimonial" method="POST" class="review-form" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                                
                                <div class="form-group">
                                    <label for="name">Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Đánh giá <span class="text-danger">*</span></label>
                                    <div class="rating-select">
                                        <div class="rate">
                                            <input type="radio" id="star5" name="rating" value="5" required checked />
                                            <label for="star5" title="5 sao">5 stars</label>
                                            <input type="radio" id="star4" name="rating" value="4" required />
                                            <label for="star4" title="4 sao">4 stars</label>
                                            <input type="radio" id="star3" name="rating" value="3" required />
                                            <label for="star3" title="3 sao">3 stars</label>
                                            <input type="radio" id="star2" name="rating" value="2" required />
                                            <label for="star2" title="2 sao">2 stars</label>
                                            <input type="radio" id="star1" name="rating" value="1" required />
                                            <label for="star1" title="1 sao">1 star</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="content">Nội dung đánh giá <span class="text-danger">*</span></label>
                                    <textarea id="content" name="content" class="form-control" rows="4" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="image">Hình ảnh (nếu có)</label>
                                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                    <small class="form-text text-muted">Hình ảnh trước và sau khi sử dụng dịch vụ (nếu có)</small>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                </div>
                                
                                <p class="review-note">
                                    <i class="fas fa-info-circle"></i> Đánh giá của bạn sẽ được hiển thị sau khi được phê duyệt
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="service-sidebar">
                    <!-- Booking Widget -->
                    <div class="sidebar-widget booking-widget">
                        <h3>Đặt lịch ngay</h3>
                        <div class="widget-content">
                            <div class="service-info">
                                <div class="info-item">
                                    <i class="fas fa-tag"></i>
                                    <div class="info-content">
                                        <h4>Giá dịch vụ</h4>
                                        <p><?php echo number_format($service['price'], 0, ',', '.'); ?>đ</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="far fa-clock"></i>
                                    <div class="info-content">
                                        <h4>Thời gian</h4>
                                        <p><?php echo $service['duration']; ?> phút</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-certificate"></i>
                                    <div class="info-content">
                                        <h4>Chuyên gia</h4>
                                        <p>Đội ngũ chuyên gia giàu kinh nghiệm</p>
                                    </div>
                                </div>
                            </div>
                            
                            <form action="/dich-vu/quick-book" method="POST" class="booking-form">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                                <button type="submit" class="btn btn-primary btn-block">Đặt lịch ngay</button>
                            </form>
                            
                            <div class="contact-info">
                                <p>Hoặc liên hệ trực tiếp:</p>
                                <div class="contact-phone">
                                    <i class="fas fa-phone-alt"></i>
                                    <a href="tel:+84901234567">0901 234 567</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="sidebar-widget categories-widget">
                        <h3>Danh mục dịch vụ</h3>
                        <div class="widget-content">
                            <ul class="categories-list">
                                <li class="<?php echo ($service['category'] == 'head_spa') ? 'active' : ''; ?>">
                                    <a href="/dich-vu?category=head_spa">
                                        <i class="fas fa-angle-right"></i> Head Spa
                                    </a>
                                </li>
                                <li class="<?php echo ($service['category'] == 'treatment') ? 'active' : ''; ?>">
                                    <a href="/dich-vu?category=treatment">
                                        <i class="fas fa-angle-right"></i> Điều trị
                                    </a>
                                </li>
                                <li class="<?php echo ($service['category'] == 'color') ? 'active' : ''; ?>">
                                    <a href="/dich-vu?category=color">
                                        <i class="fas fa-angle-right"></i> Nhuộm & Phủ bạc
                                    </a>
                                </li>
                                <li class="<?php echo ($service['category'] == 'massage') ? 'active' : ''; ?>">
                                    <a href="/dich-vu?category=massage">
                                        <i class="fas fa-angle-right"></i> Massage
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Related Services Widget -->
                    <?php if (!empty($related_services)): ?>
                    <div class="sidebar-widget related-services-widget">
                        <h3>Dịch vụ liên quan</h3>
                        <div class="widget-content">
                            <ul class="related-services-list">
                                <?php foreach ($related_services as $related): ?>
                                <li>
                                    <div class="related-service-item">
                                        <div class="service-img">
                                            <a href="/dich-vu/<?php echo $related['slug']; ?>">
                                                <img src="/assets/images/services/<?php echo $related['image']; ?>" alt="<?php echo $related['name']; ?>" class="img-fluid">
                                            </a>
                                        </div>
                                        <div class="service-info">
                                            <h4><a href="/dich-vu/<?php echo $related['slug']; ?>"><?php echo $related['name']; ?></a></h4>
                                            <div class="service-meta">
                                                <span class="price"><?php echo number_format($related['price'], 0, ',', '.'); ?>đ</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Consultation Widget -->
                    <div class="sidebar-widget consultation-widget">
                        <div class="widget-content">
                            <div class="consultation-content">
                                <i class="fas fa-headset"></i>
                                <h3>Cần tư vấn?</h3>
                                <p>Nhận tư vấn miễn phí từ chuyên gia của chúng tôi về các vấn đề tóc và da đầu của bạn.</p>
                                <a href="/tu-van" class="btn btn-secondary">Đặt lịch tư vấn</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
    /* Service Slider */
    .service-slider {
        margin-bottom: 30px;
    }
    
    .main-slider {
        margin-bottom: 10px;
    }
    
    .main-slider .slider-item {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .main-slider .slider-item img {
        width: 100%;
        height: 500px;
        object-fit: cover;
    }
    
    .thumbnail-slider .slider-item {
        padding: 5px;
        cursor: pointer;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .thumbnail-slider .slider-item img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    
    .thumbnail-slider .slick-slide.slick-current .slider-item img {
        border: 2px solid #38a89d;
    }
    
    /* Service Title & Price */
    .service-title-price {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .service-title-price h2 {
        font-size: 30px;
        margin-bottom: 10px;
    }
    
    .service-rating {
        color: #ffb900;
        font-size: 16px;
    }
    
    .service-rating span {
        color: #777;
        margin-left: 5px;
    }
    
    .service-price {
        text-align: right;
    }
    
    .service-price .price {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: #38a89d;
    }
    
    .service-price .duration {
        display: block;
        font-size: 14px;
        color: #777;
        margin-top: 5px;
    }
    
    .service-price .duration i {
        margin-right: 5px;
    }
    
    /* Service Description */
    .service-description {
        margin-bottom: 40px;
    }
    
    .service-description h3 {
        font-size: 22px;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .service-description h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #38a89d;
    }
    
    .description-content {
        font-size: 16px;
        line-height: 1.8;
    }
    
    /* Service Process */
    .service-process {
        margin-bottom: 40px;
    }
    
    .service-process h3 {
        font-size: 22px;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .service-process h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #38a89d;
    }
    
    .process-steps {
        margin-top: 30px;
    }
    
    .process-item {
        display: flex;
        margin-bottom: 30px;
    }
    
    .step-number {
        min-width: 50px;
        height: 50px;
        background-color: #38a89d;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 600;
        margin-right: 20px;
    }
    
    .step-content h4 {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .step-content p {
        font-size: 15px;
        margin-bottom: 0;
    }
    
    /* Service Benefits */
    .service-benefits {
        margin-bottom: 40px;
    }
    
    .service-benefits h3 {
        font-size: 22px;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .service-benefits h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #38a89d;
    }
    
    .benefits-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .benefits-list li {
        margin-bottom: 15px;
        font-size: 16px;
        display: flex;
        align-items: flex-start;
    }
    
    .benefits-list li i {
        color: #38a89d;
        margin-right: 10px;
        margin-top: 4px;
    }
    
    /* Customer Reviews */
    .customer-reviews {
        margin-bottom: 40px;
    }
    
    .customer-reviews h3 {
        font-size: 22px;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .customer-reviews h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #38a89d;
    }
    
    .reviews-list {
        margin-bottom: 30px;
    }
    
    .review-item {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .reviewer-info {
        display: flex;
        align-items: center;
    }
    
    .reviewer-img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 15px;
    }
    
    .reviewer-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .reviewer-meta h4 {
        font-size: 18px;
        margin-bottom: 5px;
    }
    
    .review-date {
        font-size: 14px;
        color: #777;
    }
    
    .review-rating {
        color: #ffb900;
        font-size: 14px;
    }
    
    .review-content p {
        font-size: 16px;
        line-height: 1.7;
        margin-bottom: 0;
    }
    
    .no-reviews {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .no-reviews p {
        margin-bottom: 0;
    }
    
    /* Review Form */
    .review-form-wrapper {
        background-color: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
    }
    
    .review-form-wrapper h4 {
        font-size: 20px;
        margin-bottom: 20px;
    }
    
    .rating-select {
        margin-bottom: 20px;
    }
    
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }
    
    .rate:not(:checked) > input {
        position: absolute;
        top: -9999px;
    }
    
    .rate:not(:checked) > label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        color: #ccc;
        margin-bottom: 0;
    }
    
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    
    .rate > input:checked ~ label {
        color: #ffb900;
    }
    
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #ffb900;
    }
    
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #ffb900;
    }
    
    .review-note {
        font-size: 14px;
        color: #777;
        margin-top: 20px;
    }
    
    /* Sidebar */
    .service-sidebar {
        position: sticky;
        top: 100px;
    }
    
    .sidebar-widget {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }
    
    .sidebar-widget h3 {
        font-size: 20px;
        padding: 20px;
        margin-bottom: 0;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .widget-content {
        padding: 20px;
    }
    
    /* Booking Widget */
    .service-info {
        margin-bottom: 20px;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .info-item i {
        min-width: 40px;
        height: 40px;
        background-color: rgba(56, 168, 157, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38a89d;
        font-size: 18px;
        margin-right: 15px;
    }
    
    .info-content h4 {
        font-size: 16px;
        margin-bottom: 5px;
    }
    
    .info-content p {
        font-size: 15px;
        margin-bottom: 0;
    }
    
    .booking-form {
        margin-bottom: 20px;
    }
    
    .contact-info {
        text-align: center;
        margin-top: 20px;
    }
    
    .contact-info p {
        font-size: 14px;
        margin-bottom: 10px;
    }
    
    .contact-phone {
        font-size: 18px;
        font-weight: 600;
    }
    
    .contact-phone i {
        color: #38a89d;
        margin-right: 5px;
    }
    
    .contact-phone a {
        color: #333;
    }
    
    /* Categories Widget */
    .categories-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .categories-list li {
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .categories-list li:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .categories-list li a {
        display: block;
        color: #333;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .categories-list li a:hover {
        color: #38a89d;
        text-decoration: none;
    }
    
    .categories-list li a i {
        margin-right: 10px;
        font-size: 14px;
        color: #38a89d;
    }
    
    .categories-list li.active a {
        color: #38a89d;
        font-weight: 600;
    }
    
    /* Related Services Widget */
    .related-services-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .related-services-list li {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .related-services-list li:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .related-service-item {
        display: flex;
        align-items: center;
    }
    
    .related-service-item .service-img {
        width: 80px;
        height: 80px;
        border-radius: 5px;
        overflow: hidden;
        margin-right: 15px;
    }
    
    .related-service-item .service-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .related-service-item .service-info h4 {
        font-size: 16px;
        margin-bottom: 5px;
    }
    
    .related-service-item .service-info h4 a {
        color: #333;
        transition: all 0.3s ease;
    }
    
    .related-service-item .service-info h4 a:hover {
        color: #38a89d;
        text-decoration: none;
    }
    
    .related-service-item .service-meta .price {
        font-size: 15px;
        font-weight: 600;
        color: #38a89d;
    }
    
    /* Consultation Widget */
    .consultation-widget {
        background-color: #38a89d;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .consultation-widget .widget-content {
        padding: 30px;
    }
    
    .consultation-content {
        text-align: center;
        color: #fff;
    }
    
    .consultation-content i {
        font-size: 48px;
        margin-bottom: 20px;
    }
    
    .consultation-content h3 {
        font-size: 24px;
        color: #fff;
        margin-bottom: 15px;
    }
    
    .consultation-content p {
        font-size: 16px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.8);
    }
    
    .consultation-content .btn-secondary {
        background-color: #fff;
        color: #38a89d;
        border: none;
    }
    
    .consultation-content .btn-secondary:hover {
        background-color: rgba(255, 255, 255, 0.9);
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .main-slider .slider-item img {
            height: 400px;
        }
        
        .service-sidebar {
            margin-top: 50px;
        }
    }
    
    @media (max-width: 767px) {
        .main-slider .slider-item img {
            height: 300px;
        }
        
        .service-title-price {
            text-align: center;
        }
        
        .service-price {
            text-align: center;
            margin-top: 20px;
        }
        
        .review-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .review-rating {
            margin-top: 10px;
        }
    }
</style>

<!-- Link to Slick Slider -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<!-- Initialize sliders -->
<script>
    $(document).ready(function(){
        // Main slider
        $('.main-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.thumbnail-slider'
        });
        
        // Thumbnail slider
        $('.thumbnail-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.main-slider',
            dots: false,
            arrows: true,
            centerMode: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        });
    });
</script>

<?php
// Include footer
include_once dirname(__DIR__) . '/templates/footer.php';
?>
