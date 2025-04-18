<?php
/**
 * About/Index View - Trang giới thiệu
 * File: app/views/about/index.php
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
                    <h1>Giới thiệu</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image">
                    <img src="/assets/images/about/about-main.jpg" alt="Luxury Head Spa" class="img-fluid">
                    <div class="experience-badge">
                        <span class="number">10+</span>
                        <span class="text">Năm kinh nghiệm</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <div class="section-header">
                        <span class="subtitle">Về chúng tôi</span>
                        <h2>Chào mừng đến với Luxury Head Spa</h2>
                    </div>
                    
                    <p class="lead">Luxury Head Spa tự hào là spa tóc cao cấp với dịch vụ chăm sóc tóc và da đầu chuyên nghiệp tại Việt Nam.</p>
                    
                    <p>Được thành lập bởi những chuyên gia có hơn 10 năm kinh nghiệm trong ngành, Luxury Head Spa ra đời với sứ mệnh mang đến những dịch vụ chăm sóc tóc đẳng cấp, kết hợp giữa phương pháp truyền thống và công nghệ hiện đại từ Hàn Quốc và Nhật Bản.</p>
                    
                    <p>Chúng tôi tự hào mang đến cho khách hàng không gian thư giãn sang trọng, đội ngũ chuyên gia tận tâm và các sản phẩm thảo dược thiên nhiên an toàn, giúp bạn có được mái tóc khỏe đẹp và tinh thần sảng khoái.</p>
                    
                    <div class="about-features">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-award"></i>
                                    <h4>Dịch vụ đẳng cấp</h4>
                                    <p>Dịch vụ chăm sóc tóc cao cấp với quy trình chuẩn Hàn-Nhật</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-leaf"></i>
                                    <h4>Nguyên liệu thiên nhiên</h4>
                                    <p>Sử dụng các sản phẩm từ thiên nhiên, an toàn cho mọi loại da đầu</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-user-md"></i>
                                    <h4>Chuyên gia kinh nghiệm</h4>
                                    <p>Đội ngũ chuyên gia được đào tạo bài bản tại Hàn Quốc và Nhật Bản</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-spa"></i>
                                    <h4>Không gian thư giãn</h4>
                                    <p>Không gian sang trọng, tạo cảm giác thư giãn tuyệt đối</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="/dat-lich" class="btn btn-primary">Đặt lịch ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision Mission Section -->
<section class="vision-mission-section section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" data-aos="fade-up">
                <div class="vision-box">
                    <div class="section-header">
                        <h2>Tầm nhìn</h2>
                    </div>
                    <p>Trở thành thương hiệu spa tóc cao cấp hàng đầu tại Việt Nam, mang đến những dịch vụ chăm sóc tóc và da đầu đẳng cấp chuẩn quốc tế, góp phần nâng cao chất lượng cuộc sống và sự tự tin của khách hàng.</p>
                    <ul class="vision-list">
                        <li><i class="fas fa-check-circle"></i> Phục vụ hơn 10,000 khách hàng mỗi năm</li>
                        <li><i class="fas fa-check-circle"></i> Mở rộng chi nhánh tại các thành phố lớn</li>
                        <li><i class="fas fa-check-circle"></i> Nghiên cứu và phát triển sản phẩm riêng</li>
                        <li><i class="fas fa-check-circle"></i> Đào tạo và phát triển đội ngũ chuyên gia</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="mission-box">
                    <div class="section-header">
                        <h2>Sứ mệnh</h2>
                    </div>
                    <p>Luxury Head Spa cam kết mang đến cho khách hàng những dịch vụ chăm sóc tóc và da đầu chất lượng cao, an toàn và hiệu quả, giúp khách hàng có được mái tóc khỏe đẹp và tự tin tỏa sáng.</p>
                    <ul class="mission-list">
                        <li><i class="fas fa-check-circle"></i> Cung cấp dịch vụ chất lượng cao với giá cả hợp lý</li>
                        <li><i class="fas fa-check-circle"></i> Sử dụng các sản phẩm an toàn và thân thiện với môi trường</li>
                        <li><i class="fas fa-check-circle"></i> Liên tục cập nhật kiến thức và kỹ thuật mới</li>
                        <li><i class="fas fa-check-circle"></i> Tạo môi trường làm việc chuyên nghiệp và thân thiện</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Đội ngũ chuyên gia</span>
            <h2>Gặp gỡ chuyên gia của chúng tôi</h2>
            <p>Đội ngũ chuyên gia giàu kinh nghiệm, được đào tạo bài bản tại Hàn Quốc và Nhật Bản</p>
        </div>
        
        <div class="row">
            <?php if (!empty($staff)): ?>
                <?php $limitedStaff = array_slice($staff, 0, 4); ?>
                <?php foreach ($limitedStaff as $member): ?>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $loop * 100; ?>">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="/assets/images/staff/<?php echo $member['image']; ?>" alt="<?php echo $member['name']; ?>" class="img-fluid">
                            <div class="social-icons">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h3><?php echo $member['name']; ?></h3>
                            <span class="position"><?php echo $member['position']; ?></span>
                            <p><?php echo $member['bio']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>Không có thông tin về đội ngũ chuyên gia.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="/gioi-thieu/team" class="btn btn-secondary">Xem tất cả chuyên gia</a>
        </div>
    </div>
</section>

<!-- History Section -->
<section class="history-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Lịch sử phát triển</span>
            <h2>Chặng đường phát triển</h2>
            <p>Từ những bước đi đầu tiên đến thương hiệu spa tóc cao cấp hàng đầu</p>
        </div>
        
        <div class="timeline" data-aos="fade-up">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3>2015</h3>
                    <p>Thành lập Luxury Head Spa với chi nhánh đầu tiên tại Quận 1, TP.HCM, chuyên về dịch vụ gội đầu dưỡng sinh và massage đầu.</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3>2017</h3>
                    <p>Mở rộng dịch vụ với các liệu trình điều trị rụng tóc và da đầu. Đưa vào ứng dụng công nghệ head spa từ Hàn Quốc.</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3>2019</h3>
                    <p>Phát triển chi nhánh thứ hai tại Quận 3, TP.HCM. Nhận giải thưởng "Spa tóc uy tín hàng đầu" do người tiêu dùng bình chọn.</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3>2021</h3>
                    <p>Ra mắt dịch vụ điều trị tóc và da đầu chuyên sâu với công nghệ ion âm và ánh sáng sinh học từ Nhật Bản.</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3>2023</h3>
                    <p>Mở rộng chi nhánh thứ ba tại Quận 7, TP.HCM. Nâng cấp không gian và trang thiết bị với tiêu chuẩn 5 sao.</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3>2025</h3>
                    <p>Kế hoạch mở rộng chi nhánh tại Hà Nội và Đà Nẵng, phát triển dòng sản phẩm chăm sóc tóc riêng của Luxury Head Spa.</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="/gioi-thieu/history" class="btn btn-secondary">Xem chi tiết</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Đánh giá từ khách hàng</span>
            <h2>Khách hàng nói gì về chúng tôi</h2>
            <p>Những trải nghiệm thực tế từ khách hàng đã sử dụng dịch vụ tại Luxury Head Spa</p>
        </div>
        
        <div class="row">
            <?php if (!empty($testimonials)): ?>
                <?php foreach ($testimonials as $testimonial): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="testimonial-card">
                        <div class="rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $testimonial['rating']): ?>
                                    <i class="fas fa-star"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="testimonial-content">
                            <p>"<?php echo $testimonial['content']; ?>"</p>
                        </div>
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
                <div class="col-12 text-center">
                    <p>Không có đánh giá nào.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="/danh-gia" class="btn btn-secondary">Xem tất cả đánh giá</a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section parallax-bg" style="background-image: url('/assets/images/cta-bg.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="cta-content" data-aos="fade-up">
                    <h2>Sẵn sàng trải nghiệm dịch vụ đẳng cấp?</h2>
                    <p>Đặt lịch ngay hôm nay để trải nghiệm dịch vụ chăm sóc tóc và da đầu đẳng cấp tại Luxury Head Spa.</p>
                    <div class="cta-buttons">
                        <a href="/dat-lich" class="btn btn-primary">Đặt lịch ngay</a>
                        <a href="/lien-he" class="btn btn-outline-light">Liên hệ với chúng tôi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
    /* About Section */
    .about-image {
        position: relative;
        margin-bottom: 30px;
    }
    
    .about-image img {
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .experience-badge {
        position: absolute;
        bottom: -20px;
        right: -20px;
        background-color: #38a89d;
        color: #fff;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .experience-badge .number {
        font-size: 36px;
        font-weight: 700;
        display: block;
        line-height: 1;
    }
    
    .experience-badge .text {
        font-size: 16px;
        display: block;
        margin-top: 5px;
    }
    
    .about-content .lead {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 20px;
        color: #38a89d;
    }
    
    .about-content p {
        font-size: 16px;
        line-height: 1.7;
        margin-bottom: 20px;
    }
    
    .about-features {
        margin: 30px 0;
    }
    
    .feature-item {
        margin-bottom: 25px;
    }
    
    .feature-item i {
        font-size: 24px;
        color: #38a89d;
        margin-bottom: 15px;
    }
    
    .feature-item h4 {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .feature-item p {
        font-size: 15px;
        margin-bottom: 0;
    }
    
    /* Vision Mission Section */
    .vision-box,
    .mission-box {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    
    .vision-box h2,
    .mission-box h2 {
        font-size: 28px;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 15px;
    }
    
    .vision-box h2:after,
    .mission-box h2:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background-color: #38a89d;
    }
    
    .vision-list,
    .mission-list {
        list-style: none;
        padding: 0;
        margin: 20px 0 0;
    }
    
    .vision-list li,
    .mission-list li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .vision-list li i,
    .mission-list li i {
        color: #38a89d;
        margin-right: 10px;
        margin-top: 4px;
    }
    
    /* Team Section */
    .team-member {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .team-member:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .member-img {
        position: relative;
        overflow: hidden;
    }
    
    .member-img img {
        width: 100%;
        height: 350px;
        object-fit: cover;
    }
    
    .social-icons {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
    }
    
    .team-member:hover .social-icons {
        opacity: 1;
        transform: translateX(0);
    }
    
    .social-icons a {
        width: 40px;
        height: 40px;
        background-color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38a89d;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .social-icons a:hover {
        background-color: #38a89d;
        color: #fff;
    }
    
    .member-info {
        padding: 20px;
        text-align: center;
    }
    
    .member-info h3 {
        font-size: 20px;
        margin-bottom: 5px;
    }
    
    .member-info .position {
        display: block;
        font-size: 14px;
        color: #38a89d;
        margin-bottom: 15px;
    }
    
    .member-info p {
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 0;
    }
    
    /* History Section */
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 50px auto;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e9ecef;
        transform: translateX(-50%);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 50px;
    }
    
    .timeline-dot {
        width: 20px;
        height: 20px;
        background-color: #38a89d;
        border-radius: 50%;
        position: absolute;
        left: 50%;
        top: 10px;
        transform: translateX(-50%);
        z-index: 2;
    }
    
    .timeline-content {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        width: calc(50% - 30px);
        position: relative;
    }
    
    .timeline-item:nth-child(odd) .timeline-content {
        float: left;
    }
    
    .timeline-item:nth-child(even) .timeline-content {
        float: right;
    }
    
    .timeline-item:nth-child(odd) .timeline-content:after {
        content: '';
        position: absolute;
        top: 10px;
        right: -10px;
        width: 20px;
        height: 20px;
        background-color: #fff;
        transform: rotate(45deg);
        box-shadow: 5px -5px 10px rgba(0, 0, 0, 0.05);
    }
    
    .timeline-item:nth-child(even) .timeline-content:after {
        content: '';
        position: absolute;
        top: 10px;
        left: -10px;
        width: 20px;
        height: 20px;
        background-color: #fff;
        transform: rotate(45deg);
        box-shadow: -5px 5px 10px rgba(0, 0, 0, 0.05);
    }
    
    .timeline-content h3 {
        font-size: 22px;
        margin-bottom: 10px;
        color: #38a89d;
    }
    
    .timeline-content p {
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 0;
    }
    
    /* Testimonial Cards */
    .testimonial-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .testimonial-card .rating {
        color: #ffb900;
        font-size: 14px;
        margin-bottom: 15px;
    }
    
    .testimonial-content {
        min-height: 120px;
        margin-bottom: 20px;
    }
    
    .testimonial-content p {
        font-size: 15px;
        line-height: 1.7;
        font-style: italic;
        margin-bottom: 0;
    }
    
    .testimonial-author {
        display: flex;
        align-items: center;
        border-top: 1px solid #f1f1f1;
        padding-top: 20px;
    }
    
    .author-img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 15px;
    }
    
    .author-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .author-info h4 {
        font-size: 16px;
        margin-bottom: 5px;
    }
    
    .author-info span {
        font-size: 14px;
        color: #777;
    }
    
    /* CTA Section */
    .cta-section {
        position: relative;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 100px 0;
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
        color: #fff;
    }
    
    .cta-content h2 {
        font-size: 36px;
        margin-bottom: 20px;
        color: #fff;
    }
    
    .cta-content p {
        font-size: 18px;
        margin-bottom: 30px;
        color: rgba(255, 255, 255, 0.8);
    }
    
    .cta-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    .btn-outline-light {
        color: #fff;
        border-color: #fff;
    }
    
    .btn-outline-light:hover {
        background-color: #fff;
        color: #38a89d;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .experience-badge {
            bottom: -10px;
            right: 20px;
        }
        
        .team-member {
            margin-bottom: 30px;
        }
    }
    
    @media (max-width: 767px) {
        .timeline:before {
            left: 20px;
        }
        
        .timeline-dot {
            left: 20px;
        }
        
        .timeline-content {
            width: calc(100% - 60px);
            float: right !important;
        }
        
        .timeline-item:nth-child(odd) .timeline-content:after,
        .timeline-item:nth-child(even) .timeline-content:after {
            left: -10px;
            right: auto;
        }
        
        .cta-content h2 {
            font-size: 28px;
        }
        
        .cta-content p {
            font-size: 16px;
        }
        
        .cta-buttons {
            flex-direction: column;
            gap: 10px;
        }
        
        .about-content .lead {
            font-size: 16px;
        }
    }
</style>

<?php
// Include footer
include_once dirname(__DIR__) . '/templates/footer.php';
?>
