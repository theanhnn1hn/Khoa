<?php
/**
 * Booking View - Trang đặt lịch
 * File: app/views/booking/index.php
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
                    <h1>Đặt lịch</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Đặt lịch</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Section -->
<section class="booking-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="booking-form-wrapper">
                    <div class="section-header mb-4">
                        <h2>Đặt lịch dịch vụ</h2>
                        <p>Điền thông tin để đặt lịch sử dụng dịch vụ tại Luxury Head Spa</p>
                    </div>
                    
                    <form id="booking-form" action="/dat-lich/store" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Nhập họ và tên" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email (để nhận xác nhận)" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                            <small class="form-text text-muted">Chúng tôi sẽ gửi xác nhận đặt lịch qua email của bạn</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="service-select">Chọn dịch vụ <span class="text-danger">*</span></label>
                            <select id="service-select" name="service_id" class="form-control" required>
                                <option value="">-- Chọn dịch vụ --</option>
                                <?php if(!empty($services)): ?>
                                    <?php foreach($services as $service): ?>
                                    <option value="<?php echo $service['id']; ?>" 
                                            data-price="<?php echo $service['price']; ?>" 
                                            data-duration="<?php echo $service['duration']; ?>"
                                            <?php echo (isset($_GET['service_id']) && $_GET['service_id'] == $service['id']) ? 'selected' : ''; ?>>
                                        <?php echo $service['name']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div id="service-info" class="service-info" style="display: none;">
                            <div class="alert alert-info">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>Giá:</strong> <span id="service-price">0</span>
                                    </div>
                                    <div>
                                        <strong>Thời gian:</strong> <span id="service-duration">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking-date">Chọn ngày <span class="text-danger">*</span></label>
                                    <input type="text" id="booking-date" name="date" class="form-control" placeholder="Chọn ngày" value="<?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>" readonly required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="time-slots-container" style="display: none;">
                                    <label>Chọn giờ <span class="text-danger">*</span></label>
                                    <div id="time-slots" class="time-slots">
                                        <div class="alert alert-warning">Vui lòng chọn dịch vụ và ngày trước</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Ghi chú</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Nhập ghi chú hoặc yêu cầu đặc biệt (nếu có)"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="privacy-policy" required>
                                <label class="form-check-label" for="privacy-policy">
                                    Tôi đồng ý với <a href="/chinh-sach-bao-mat" target="_blank">chính sách bảo mật</a> và <a href="/dieu-khoan-su-dung" target="_blank">điều khoản sử dụng</a> của Luxury Head Spa
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Đặt lịch ngay</button>
                        </div>
                        
                        <p class="booking-note text-center">
                            <i class="fas fa-info-circle"></i> Chúng tôi sẽ liên hệ xác nhận lịch hẹn qua số điện thoại của bạn
                        </p>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="booking-sidebar">
                    <div class="sidebar-widget">
                        <h3>Thông tin liên hệ</h3>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>123 Nguyễn Huệ, Quận 1, TP.HCM</p>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <p><a href="tel:+84901234567">0901 234 567</a></p>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <p><a href="mailto:info@luxuryheadspa.vn">info@luxuryheadspa.vn</a></p>
                            </div>
                            <div class="contact-item">
                                <i class="far fa-clock"></i>
                                <p>9:00 - 20:00, Thứ Hai - Chủ Nhật</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sidebar-widget">
                        <h3>Dịch vụ nổi bật</h3>
                        <ul class="featured-services">
                            <?php if(!empty($services)): ?>
                                <?php
                                $featuredServices = array_filter($services, function($service) {
                                    return isset($service['featured']) && $service['featured'] == 1;
                                });
                                $featuredServices = array_slice($featuredServices, 0, 5);
                                ?>
                                
                                <?php foreach($featuredServices as $service): ?>
                                <li>
                                    <div class="service-item">
                                        <div class="service-icon">
                                            <i class="fas fa-spa"></i>
                                        </div>
                                        <div class="service-content">
                                            <h4><?php echo $service['name']; ?></h4>
                                            <div class="service-meta">
                                                <span class="price"><?php echo number_format($service['price'], 0, ',', '.'); ?>đ</span>
                                                <span class="duration"><i class="far fa-clock"></i> <?php echo $service['duration']; ?> phút</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div class="sidebar-widget">
                        <h3>Tại sao chọn chúng tôi?</h3>
                        <ul class="why-choose-list">
                            <li><i class="fas fa-check-circle"></i> Chuyên gia giàu kinh nghiệm</li>
                            <li><i class="fas fa-check-circle"></i> Nguyên liệu thiên nhiên an toàn</li>
                            <li><i class="fas fa-check-circle"></i> Công nghệ tiên tiến từ Hàn Quốc và Nhật Bản</li>
                            <li><i class="fas fa-check-circle"></i> Không gian sang trọng, thư giãn</li>
                            <li><i class="fas fa-check-circle"></i> Trang thiết bị hiện đại</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center">
            <span class="subtitle">Câu hỏi thường gặp</span>
            <h2>Thông tin về đặt lịch</h2>
            <p>Một số câu hỏi thường gặp về quy trình đặt lịch tại Luxury Head Spa</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Làm thế nào để đặt lịch tại Luxury Head Spa?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bạn có thể đặt lịch dễ dàng thông qua website này bằng cách điền đầy đủ thông tin vào form đặt lịch. Ngoài ra, bạn cũng có thể đặt lịch qua số điện thoại 0901 234 567 hoặc liên hệ qua Zalo của chúng tôi.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Tôi cần chuẩn bị gì khi đến sử dụng dịch vụ?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bạn không cần chuẩn bị gì đặc biệt. Chúng tôi cung cấp đầy đủ các trang thiết bị và sản phẩm cần thiết cho dịch vụ. Tuy nhiên, bạn nên đến sớm khoảng 5-10 phút trước giờ hẹn để làm thủ tục và thư giãn trước khi bắt đầu.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Tôi có thể thay đổi hoặc hủy lịch hẹn không?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có, bạn có thể thay đổi hoặc hủy lịch hẹn ít nhất 24 giờ trước giờ hẹn mà không mất phí. Để thay đổi hoặc hủy lịch, vui lòng liên hệ với chúng tôi qua số điện thoại 0901 234 567 hoặc qua email info@luxuryheadspa.vn. Nếu bạn đã cung cấp email khi đặt lịch, bạn cũng có thể hủy lịch thông qua đường dẫn trong email xác nhận.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Các phương thức thanh toán được chấp nhận?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chúng tôi chấp nhận nhiều phương thức thanh toán bao gồm tiền mặt, thẻ ngân hàng (Visa, Mastercard, JCB), chuyển khoản ngân hàng, và các ví điện tử như Momo, ZaloPay, VNPay. Việc thanh toán sẽ được thực hiện sau khi hoàn thành dịch vụ tại spa.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Tôi có cần tư vấn trước khi đặt lịch không?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Không bắt buộc, nhưng chúng tôi khuyến khích bạn sử dụng dịch vụ tư vấn miễn phí của chúng tôi, đặc biệt là đối với các dịch vụ điều trị chuyên sâu như trị rụng tóc, trị gàu, hoặc phục hồi tóc hư tổn. Việc tư vấn sẽ giúp chúng tôi hiểu rõ hơn về tình trạng tóc và da đầu của bạn để đề xuất liệu trình phù hợp nhất. Bạn có thể đặt lịch tư vấn <a href="/tu-van">tại đây</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CSS cho trang đặt lịch -->
<style>
    /* Booking Form */
    .booking-form-wrapper {
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    
    .booking-note {
        font-size: 14px;
        color: #777;
        margin-top: 20px;
    }
    
    .time-slots {
        margin-top: 10px;
    }
    
    .time-slot {
        position: relative;
        background-color: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 5px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
    }
    
    .time-slot:hover {
        border-color: #38a89d;
    }
    
    .time-slot.selected {
        border-color: #38a89d;
        background-color: rgba(56, 168, 157, 0.1);
    }
    
    .time-slot.disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background-color: #f1f1f1;
        border-color: #ddd;
    }
    
    .time-slot input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .time-slot input[type="radio"]:disabled {
        cursor: not-allowed;
    }
    
    .time-slot label {
        display: block;
        padding: 10px;
        cursor: pointer;
        font-weight: 500;
        margin: 0;
    }
    
    .time-slot.disabled label {
        cursor: not-allowed;
    }
    
    .booked-label {
        display: block;
        font-size: 12px;
        color: #dc3545;
        margin-top: -5px;
        padding-bottom: 5px;
    }
    
    /* Service Info */
    .service-info {
        margin-bottom: 20px;
    }
    
    /* Booking Sidebar */
    .booking-sidebar {
        position: sticky;
        top: 100px;
    }
    
    .sidebar-widget {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    
    .sidebar-widget h3 {
        font-size: 20px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f1f1f1;
        position: relative;
    }
    
    .sidebar-widget h3:after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #38a89d;
    }
    
    .featured-services {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .featured-services li {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .featured-services li:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .service-item {
        display: flex;
        align-items: center;
    }
    
    .service-icon {
        min-width: 40px;
        height: 40px;
        background-color: rgba(56, 168, 157, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #38a89d;
        margin-right: 15px;
    }
    
    .service-content h4 {
        font-size: 16px;
        margin-bottom: 5px;
    }
    
    .service-meta {
        display: flex;
        flex-wrap: wrap;
        font-size: 14px;
    }
    
    .service-meta .price {
        font-weight: 600;
        color: #38a89d;
        margin-right: 15px;
    }
    
    .service-meta .duration {
        color: #777;
    }
    
    .service-meta .duration i {
        margin-right: 5px;
    }
    
    .why-choose-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .why-choose-list li {
        margin-bottom: 12px;
        display: flex;
        align-items: flex-start;
    }
    
    .why-choose-list li i {
        color: #38a89d;
        margin-right: 10px;
        margin-top: 4px;
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
    
    /* Datepicker Styling */
    .datepicker table tr td.day:hover,
    .datepicker table tr td.focused {
        background-color: rgba(56, 168, 157, 0.1);
        color: #38a89d;
    }
    
    .datepicker table tr td.active.active,
    .datepicker table tr td.active.highlighted.active,
    .datepicker table tr td.active.highlighted:active,
    .datepicker table tr td.active:active {
        background-color: #38a89d;
        border-color: #38a89d;
    }
    
    .datepicker table tr td.fully-booked {
        position: relative;
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .datepicker table tr td.fully-booked:hover {
        background-color: #f8d7da;
        color: #721c24;
        cursor: not-allowed;
    }
    
    .datepicker table tr td.today {
        background-color: rgba(56, 168, 157, 0.2);
        color: #38a89d;
    }
    
    .datepicker-dropdown {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        border: none;
    }
    
    /* Page Header */
    .page-header {
        background-image: url('/assets/images/page-header-bg.jpg');
        background-size: cover;
        background-position: center;
        position: relative;
        padding: 100px 0;
        margin-bottom: 30px;
    }
    
    .page-header:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }
    
    .page-header-content {
        position: relative;
        text-align: center;
        color: #fff;
    }
    
    .page-header h1 {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #fff;
    }
    
    .breadcrumb {
        display: inline-flex;
        background: transparent;
        padding: 0;
        margin: 0;
    }
    
    .breadcrumb-item {
        font-size: 16px;
    }
    
    .breadcrumb-item a {
        color: #fff;
        opacity: 0.8;
    }
    
    .breadcrumb-item a:hover {
        opacity: 1;
    }
    
    .breadcrumb-item.active {
        color: #fff;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: #fff;
        opacity: 0.8;
    }
    
    @media (max-width: 767px) {
        .booking-form-wrapper {
            padding: 30px 20px;
        }
        
        .page-header {
            padding: 70px 0;
        }
        
        .page-header h1 {
            font-size: 28px;
        }
    }
</style>

<!-- Link datepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>

<?php
// Include footer
include_once dirname(__DIR__) . '/templates/footer.php';
?>
