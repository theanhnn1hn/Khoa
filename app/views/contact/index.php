<?php
/**
 * Contact/Index View - Trang liên hệ
 * File: app/views/contact/index.php
 */

// Include header
include_once dirname(__DIR__) . '/templates/header.php';

// Chuyển đổi cài đặt liên hệ thành dạng key-value
$contactInfo = [];
if (!empty($contact_settings)) {
    foreach ($contact_settings as $setting) {
        $contactInfo[$setting['setting_name']] = $setting['setting_value'];
    }
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content">
                    <h1>Liên hệ</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section section-padding">
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
            <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-right">
                <div class="contact-info">
                    <div class="section-header">
                        <span class="subtitle">Thông tin liên hệ</span>
                        <h2>Liên hệ với chúng tôi</h2>
                    </div>
                    
                    <p class="lead">Hãy liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào hoặc cần hỗ trợ. Chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>
                    
                    <div class="info-box">
                        <div class="info-item">
                            <div class="icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="content">
                                <h4>Địa chỉ</h4>
                                <p><?php echo isset($contactInfo['site_address']) ? $contactInfo['site_address'] : '123 Nguyễn Huệ, Quận 1, TP.HCM'; ?></p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="content">
                                <h4>Điện thoại</h4>
                                <p><a href="tel:<?php echo isset($contactInfo['site_phone']) ? $contactInfo['site_phone'] : '0901234567'; ?>"><?php echo isset($contactInfo['site_phone']) ? $contactInfo['site_phone'] : '0901 234 567'; ?></a></p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="content">
                                <h4>Email</h4>
                                <p><a href="mailto:<?php echo isset($contactInfo['site_email']) ? $contactInfo['site_email'] : 'info@luxuryheadspa.vn'; ?>"><?php echo isset($contactInfo['site_email']) ? $contactInfo['site_email'] : 'info@luxuryheadspa.vn'; ?></a></p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="icon">
                                <i class="far fa-clock"></i>
                            </div>
                            <div class="content">
                                <h4>Giờ làm việc</h4>
                                <p><?php echo isset($contactInfo['working_hours']) ? $contactInfo['working_hours'] : '9:00 - 20:00, Thứ Hai - Chủ Nhật'; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <h4>Kết nối với chúng tôi</h4>
                        <div class="social-icons">
                            <a href="<?php echo isset($contactInfo['facebook_url']) ? $contactInfo['facebook_url'] : 'https://facebook.com/luxuryheadspa'; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="<?php echo isset($contactInfo['instagram_url']) ? $contactInfo['instagram_url'] : 'https://instagram.com/luxuryheadspa'; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="<?php echo isset($contactInfo['youtube_url']) ? $contactInfo['youtube_url'] : 'https://youtube.com/luxuryheadspa'; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                            <a href="https://zalo.me/<?php echo isset($contactInfo['site_phone']) ? $contactInfo['site_phone'] : '0901234567'; ?>" target="_blank"><i class="fas fa-comment-dots"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-form-wrapper">
                    <div class="form-header">
                        <h3>Gửi tin nhắn cho chúng tôi</h3>
                        <p>Điền thông tin của bạn và chúng tôi sẽ liên hệ lại trong thời gian sớm nhất</p>
                    </div>
                    
                    <form id="contact-form" action="/lien-he/send" method="POST" class="contact-form">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Nhập họ và tên" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject">Tiêu đề</label>
                                    <input type="text" id="subject" name="subject" class="form-control" placeholder="Nhập tiêu đề">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Nội dung tin nhắn <span class="text-danger">*</span></label>
                            <textarea id="message" name="message" class="form-control" rows="5" placeholder="Nhập nội dung tin nhắn" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container-fluid p-0">
        <div class="map-container">
            <!-- Google Maps Embed -->
            <?php if (isset($contactInfo['google_maps'])): ?>
                <?php echo $contactInfo['google_maps']; ?>
            <?php else: ?>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3829531983073!2d106.70142965098639!3d10.780115492268337!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4670702e31%3A0xa5777fb3a5bb9468!2zMTIzIE5ndXnhu4VuIEh14buHLCBC4bq_biBOZ2jDqSwgUXXhuq1uIDEsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1650000000000!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Branch Locations Section -->
<section class="branch-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Chi nhánh</span>
            <h2>Các chi nhánh của chúng tôi</h2>
            <p>Luxury Head Spa hiện có mặt tại các địa điểm sau</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="branch-card">
                    <div class="branch-header">
                        <h3>Chi nhánh Quận 1</h3>
                        <span class="badge main-branch">Chi nhánh chính</span>
                    </div>
                    <div class="branch-body">
                        <div class="branch-info">
                            <div class="info-row">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>123 Nguyễn Huệ, Phường Bến Nghé, Quận 1, TP.HCM</p>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-phone-alt"></i>
                                <p><a href="tel:0901234567">0901 234 567</a></p>
                            </div>
                            <div class="info-row">
                                <i class="far fa-clock"></i>
                                <p>9:00 - 20:00, Thứ Hai - Chủ Nhật</p>
                            </div>
                        </div>
                        <div class="branch-action">
                            <a href="https://goo.gl/maps/123" target="_blank" class="btn btn-outline-primary btn-sm">Xem bản đồ</a>
                            <a href="/dat-lich?branch=1" class="btn btn-primary btn-sm">Đặt lịch</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="branch-card">
                    <div class="branch-header">
                        <h3>Chi nhánh Quận 3</h3>
                    </div>
                    <div class="branch-body">
                        <div class="branch-info">
                            <div class="info-row">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>456 Võ Văn Tần, Phường 5, Quận 3, TP.HCM</p>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-phone-alt"></i>
                                <p><a href="tel:0901234568">0901 234 568</a></p>
                            </div>
                            <div class="info-row">
                                <i class="far fa-clock"></i>
                                <p>9:00 - 20:00, Thứ Hai - Chủ Nhật</p>
                            </div>
                        </div>
                        <div class="branch-action">
                            <a href="https://goo.gl/maps/456" target="_blank" class="btn btn-outline-primary btn-sm">Xem bản đồ</a>
                            <a href="/dat-lich?branch=2" class="btn btn-primary btn-sm">Đặt lịch</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="branch-card">
                    <div class="branch-header">
                        <h3>Chi nhánh Quận 7</h3>
                    </div>
                    <div class="branch-body">
                        <div class="branch-info">
                            <div class="info-row">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>789 Nguyễn Thị Thập, Phường Tân Phú, Quận 7, TP.HCM</p>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-phone-alt"></i>
                                <p><a href="tel:0901234569">0901 234 569</a></p>
                            </div>
                            <div class="info-row">
                                <i class="far fa-clock"></i>
                                <p>9:00 - 20:00, Thứ Hai - Chủ Nhật</p>
                            </div>
                        </div>
                        <div class="branch-action">
                            <a href="https://goo.gl/maps/789" target="_blank" class="btn btn-outline-primary btn-sm">Xem bản đồ</a>
                            <a href="/dat-lich?branch=3" class="btn btn-primary btn-sm">Đặt lịch</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Câu hỏi thường gặp</span>
            <h2>Thông tin liên hệ</h2>
            <p>Một số câu hỏi thường gặp về liên hệ và đặt lịch tại Luxury Head Spa</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="accordion" id="faqAccordion" data-aos="fade-up">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Làm thế nào để đặt lịch tại Luxury Head Spa?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bạn có thể đặt lịch dễ dàng thông qua website bằng cách truy cập vào trang <a href="/dat-lich">Đặt lịch</a> và điền đầy đủ thông tin. Ngoài ra, bạn cũng có thể đặt lịch qua số điện thoại <?php echo isset($contactInfo['site_phone']) ? $contactInfo['site_phone'] : '0901 234 567'; ?> hoặc liên hệ qua Zalo của chúng tôi.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Tôi có thể thay đổi hoặc hủy lịch hẹn không?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có, bạn có thể thay đổi hoặc hủy lịch hẹn ít nhất 24 giờ trước giờ hẹn mà không mất phí. Để thay đổi hoặc hủy lịch, vui lòng liên hệ với chúng tôi qua số điện thoại <?php echo isset($contactInfo['site_phone']) ? $contactInfo['site_phone'] : '0901 234 567'; ?> hoặc qua email <?php echo isset($contactInfo['site_email']) ? $contactInfo['site_email'] : 'info@luxuryheadspa.vn'; ?>. Nếu bạn đã cung cấp email khi đặt lịch, bạn cũng có thể hủy lịch thông qua đường dẫn trong email xác nhận.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Các phương thức thanh toán được chấp nhận?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chúng tôi chấp nhận nhiều phương thức thanh toán bao gồm tiền mặt, thẻ ngân hàng (Visa, Mastercard, JCB), chuyển khoản ngân hàng, và các ví điện tử như Momo, ZaloPay, VNPay. Việc thanh toán sẽ được thực hiện sau khi hoàn thành dịch vụ tại spa.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Tôi cần đến sớm bao nhiêu phút trước giờ hẹn?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chúng tôi khuyến khích khách hàng đến sớm khoảng 10-15 phút trước giờ hẹn để làm thủ tục và thư giãn trước khi bắt đầu dịch vụ. Điều này giúp bạn có thời gian để thư giãn và tận hưởng trọn vẹn trải nghiệm tại Luxury Head Spa.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Tôi có cần đặt cọc khi đặt lịch không?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Hiện tại chúng tôi không yêu cầu đặt cọc khi đặt lịch. Tuy nhiên, chúng tôi đánh giá cao nếu bạn thông báo cho chúng tôi sớm nhất có thể trong trường hợp cần hủy hoặc thay đổi lịch hẹn để chúng tôi có thể sắp xếp cho khách hàng khác.
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
    /* Contact Info */
    .contact-info .lead {
        font-size: 18px;
        margin-bottom: 30px;
    }
    
    .info-box {
        margin-bottom: 30px;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
    }
    
    .info-item .icon {
        min-width: 50px;
        height: 50px;
        background-color: rgba(56, 168, 157, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38a89d;
        font-size: 20px;
        margin-right: 15px;
    }
    
    .info-item .content h4 {
        font-size: 18px;
        margin-bottom: 5px;
    }
    
    .info-item .content p {
        font-size: 16px;
        margin-bottom: 0;
    }
    
    .info-item .content a {
        color: #333;
        transition: all 0.3s ease;
    }
    
    .info-item .content a:hover {
        color: #38a89d;
    }
    
    .social-links {
        margin-top: 30px;
    }
    
    .social-links h4 {
        font-size: 18px;
        margin-bottom: 15px;
    }
    
    .social-icons {
        display: flex;
        gap: 15px;
    }
    
    .social-icons a {
        width: 40px;
        height: 40px;
        background-color: rgba(56, 168, 157, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38a89d;
        font-size: 18px;
        transition: all 0.3s ease;
    }
    
    .social-icons a:hover {
        background-color: #38a89d;
        color: #fff;
    }
    
    /* Contact Form */
    .contact-form-wrapper {
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .form-header h3 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .form-header p {
        font-size: 16px;
        color: #777;
    }
    
    /* Map Section */
    .map-section {
        height: 450px;
    }
    
    .map-container {
        height: 100%;
    }
    
    .map-container iframe {
        height: 100%;
        width: 100%;
        border: none;
    }
    
    /* Branch Section */
    .branch-card {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .branch-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .branch-header {
        background-color: #38a89d;
        color: #fff;
        padding: 20px;
        position: relative;
    }
    
    .branch-header h3 {
        font-size: 20px;
        margin-bottom: 0;
        color: #fff;
    }
    
    .branch-header .badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: #d4af37;
        color: #fff;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 20px;
    }
    
    .branch-body {
        padding: 20px;
    }
    
    .branch-info {
        margin-bottom: 20px;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 15px;
    }
    
    .info-row:last-child {
        margin-bottom: 0;
    }
    
    .info-row i {
        min-width: 30px;
        color: #38a89d;
        margin-top: 5px;
    }
    
    .info-row p {
        margin-bottom: 0;
        font-size: 15px;
    }
    
    .info-row a {
        color: #333;
    }
    
    .info-row a:hover {
        color: #38a89d;
    }
    
    .branch-action {
        display: flex;
        gap: 10px;
    }
    
    /* FAQ Section */
    .accordion-item {
        margin-bottom: 15px;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .accordion-button {
        padding: 20px;
        font-weight: 600;
        background-color: #fff;
        box-shadow: none;
    }
    
    .accordion-button:not(.collapsed) {
        color: #38a89d;
        background-color: rgba(56, 168, 157, 0.05);
        box-shadow: none;
    }
    
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(56, 168, 157, 0.1);
    }
    
    .accordion-button::after {
        background-size: 16px;
        width: 16px;
        height: 16px;
    }
    
    .accordion-body {
        padding: 20px;
        background-color: #fff;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .contact-form-wrapper {
            margin-top: 50px;
        }
    }
    
    @media (max-width: 767px) {
        .contact-form-wrapper {
            padding: 30px 20px;
        }
        
        .info-item {
            flex-direction: column;
            text-align: center;
        }
        
        .info-item .icon {
            margin: 0 auto 15px;
        }
        
        .social-icons {
            justify-content: center;
        }
    }
</style>

<!-- Contact Form Validation -->
<script>
    $(document).ready(function() {
        // Form Validation
        $('#contact-form').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    digits: true,
                    minlength: 10,
                    maxlength: 15
                },
                message: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                name: {
                    required: "Vui lòng nhập họ tên",
                    minlength: "Họ tên phải có ít nhất 3 ký tự"
                },
                email: {
                    required: "Vui lòng nhập email",
                    email: "Email không hợp lệ"
                },
                phone: {
                    digits: "Số điện thoại chỉ được chứa các chữ số",
                    minlength: "Số điện thoại không hợp lệ",
                    maxlength: "Số điện thoại không hợp lệ"
                },
                message: {
                    required: "Vui lòng nhập nội dung tin nhắn",
                    minlength: "Nội dung tin nhắn phải có ít nhất 10 ký tự"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            submitHandler: function(form) {
                // Hiển thị loading
                var submitBtn = $(form).find('button[type="submit"]');
                var originalText = submitBtn.text();
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);
                
                // Gửi form bằng AJAX
                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function(response) {
                        var result = JSON.parse(response);
                        
                        if (result.success) {
                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: result.message,
                                confirmButtonColor: '#38a89d'
                            }).then(function() {
                                // Reset form
                                form.reset();
                                $('.form-control').removeClass('is-valid');
                            });
                        } else {
                            // Hiển thị thông báo lỗi
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: result.message,
                                confirmButtonColor: '#38a89d'
                            });
                        }
                        
                        // Khôi phục nút submit
                        submitBtn.html(originalText).prop('disabled', false);
                    },
                    error: function() {
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi. Vui lòng thử lại sau.',
                            confirmButtonColor: '#38a89d'
                        });
                        
                        // Khôi phục nút submit
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
                
                return false;
            }
        });
    });
</script>

<?php
// Include footer
include_once dirname(__DIR__) . '/templates/footer.php';
?>
