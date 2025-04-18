<?php
/**
 * Consultation/Index View - Trang tư vấn
 * File: app/views/consultation/index.php
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
                    <h1>Tư vấn cá nhân hóa</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tư vấn</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Consultation Section -->
<section class="consultation-section section-padding">
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
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="consultation-content" data-aos="fade-right">
                    <div class="section-header">
                        <span class="subtitle">Tư vấn cá nhân hóa</span>
                        <h2>Giải pháp tối ưu cho mái tóc của bạn</h2>
                    </div>
                    
                    <p class="lead">Tại Luxury Head Spa, chúng tôi hiểu rằng mỗi mái tóc đều có những đặc điểm và vấn đề riêng biệt. Vì vậy, chúng tôi cung cấp dịch vụ tư vấn cá nhân hóa để đem đến giải pháp phù hợp nhất cho bạn.</p>
                    
                    <div class="consultation-steps">
                        <div class="step-item">
                            <div class="step-number">01</div>
                            <div class="step-content">
                                <h3>Đăng ký tư vấn</h3>
                                <p>Điền thông tin và mô tả tình trạng tóc hiện tại của bạn qua form tư vấn.</p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">02</div>
                            <div class="step-content">
                                <h3>Nhận cuộc gọi từ chuyên gia</h3>
                                <p>Chuyên gia của chúng tôi sẽ liên hệ lại để tìm hiểu chi tiết hơn về tình trạng tóc.</p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">03</div>
                            <div class="step-content">
                                <h3>Nhận tư vấn cá nhân hóa</h3>
                                <p>Chúng tôi sẽ đề xuất giải pháp tối ưu dựa trên tình trạng và nhu cầu thực tế của bạn.</p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">04</div>
                            <div class="step-content">
                                <h3>Trải nghiệm dịch vụ</h3>
                                <p>Đặt lịch và trải nghiệm dịch vụ tại Luxury Head Spa với liệu trình phù hợp.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="expert-info">
                        <div class="expert-img">
                            <img src="/assets/images/expert.jpg" alt="Chuyên gia tư vấn" class="img-fluid">
                        </div>
                        <div class="expert-content">
                            <h3>Chuyên gia tư vấn</h3>
                            <p>Đội ngũ chuyên gia của chúng tôi với hơn 10 năm kinh nghiệm, được đào tạo bài bản tại Hàn Quốc và Nhật Bản, sẽ giúp bạn tìm ra giải pháp tối ưu cho mái tóc.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="consultation-form-wrapper">
                    <div class="form-header">
                        <h3>Đăng ký tư vấn</h3>
                        <p>Điền thông tin của bạn để nhận tư vấn từ chuyên gia</p>
                    </div>
                    
                    <form id="consultation-form" action="/tu-van/store" method="POST" class="consultation-form">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <div class="form-group">
                            <label for="name">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nhập họ và tên" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email (để nhận kết quả tư vấn)">
                        </div>
                        
                        <div class="form-group">
                            <label>Tình trạng tóc hiện tại của bạn</label>
                            <div class="hair-conditions">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input hair-condition-checkbox" type="checkbox" id="condition-rung-toc" name="hair_conditions[]" value="rung_toc">
                                            <label class="form-check-label" for="condition-rung-toc">Rụng tóc, hói đầu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input hair-condition-checkbox" type="checkbox" id="condition-gau" name="hair_conditions[]" value="gau">
                                            <label class="form-check-label" for="condition-gau">Gàu, nấm da đầu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input hair-condition-checkbox" type="checkbox" id="condition-kho-xo" name="hair_conditions[]" value="kho_xo">
                                            <label class="form-check-label" for="condition-kho-xo">Tóc khô, xơ, chẻ ngọn</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input hair-condition-checkbox" type="checkbox" id="condition-toc-gay" name="hair_conditions[]" value="toc_gay">
                                            <label class="form-check-label" for="condition-toc-gay">Tóc gãy, hư tổn nặng</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input hair-condition-checkbox" type="checkbox" id="condition-toc-bac" name="hair_conditions[]" value="toc_bac">
                                            <label class="form-check-label" for="condition-toc-bac">Tóc bạc, muốn nhuộm</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input hair-condition-checkbox" type="checkbox" id="condition-da-dau-nhon" name="hair_conditions[]" value="da_dau_nhon">
                                            <label class="form-check-label" for="condition-da-dau-nhon">Da đầu nhờn, tiết nhiều dầu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input hair-condition-checkbox" type="checkbox" id="condition-da-dau-kho" name="hair_conditions[]" value="da_dau_kho">
                                            <label class="form-check-label" for="condition-da-dau-kho">Da đầu khô, ngứa</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input hair-condition-checkbox" type="checkbox" id="condition-stress" name="hair_conditions[]" value="stress">
                                            <label class="form-check-label" for="condition-stress">Stress, đau đầu, mất ngủ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="suggested-services" class="suggested-services" style="display: none;">
                            <h4>Dịch vụ phù hợp với bạn</h4>
                            <div class="service-cards" id="service-cards-container">
                                <!-- Dịch vụ gợi ý sẽ được thêm vào đây bằng JavaScript -->
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="wishes">Mong muốn của bạn</label>
                            <textarea id="wishes" name="wishes" class="form-control" rows="3" placeholder="Chia sẻ mong muốn và kết quả bạn mong đợi..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Gửi yêu cầu tư vấn</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Our Consultation Section -->
<section class="why-choose-consultation section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Vì sao chọn dịch vụ tư vấn của chúng tôi</span>
            <h2>Trải nghiệm tư vấn chuyên nghiệp</h2>
            <p>Tại Luxury Head Spa, chúng tôi tự hào mang đến dịch vụ tư vấn chuyên nghiệp và hiệu quả</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Chuyên gia giàu kinh nghiệm</h3>
                        <p>Đội ngũ chuyên gia của chúng tôi được đào tạo bài bản tại Hàn Quốc và Nhật Bản với hơn 10 năm kinh nghiệm trong lĩnh vực chăm sóc tóc.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-diagnoses"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Phân tích chuyên sâu</h3>
                        <p>Chúng tôi sử dụng thiết bị phân tích da đầu chuyên sâu để đánh giá chính xác tình trạng tóc và da đầu của bạn.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Giải pháp cá nhân hóa</h3>
                        <p>Mỗi khách hàng sẽ nhận được giải pháp riêng biệt, được thiết kế phù hợp với tình trạng tóc và nhu cầu cá nhân.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Sản phẩm thiên nhiên</h3>
                        <p>Chúng tôi tư vấn và sử dụng các sản phẩm có thành phần từ thiên nhiên, an toàn cho mọi loại da đầu, kể cả da nhạy cảm.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Theo dõi tiến triển</h3>
                        <p>Chúng tôi theo dõi và đánh giá tiến triển của bạn trong suốt quá trình điều trị để đảm bảo kết quả tốt nhất.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Hỗ trợ liên tục</h3>
                        <p>Bạn sẽ được hỗ trợ và tư vấn liên tục, ngay cả sau khi kết thúc liệu trình điều trị tại Luxury Head Spa.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Đánh giá từ khách hàng</span>
            <h2>Khách hàng nói gì về dịch vụ tư vấn của chúng tôi</h2>
        </div>
        
        <div class="testimonial-carousel" data-aos="fade-up">
            <div class="testimonial-item">
                <div class="testimonial-content">
                    <div class="rating">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                    </div>
                    <p class="quote">"Tôi đã từng gặp vấn đề về rụng tóc nhiều năm và đã thử nhiều cách khác nhau nhưng không hiệu quả. Sau khi được tư vấn tại Luxury Head Spa, tôi đã tìm ra giải pháp phù hợp và đang thấy sự cải thiện rõ rệt. Chuyên gia tại đây rất tận tâm và chuyên nghiệp!"</p>
                    <div class="testimonial-author">
                        <div class="author-img">
                            <img src="/assets/images/testimonials/testimonial-1.jpg" alt="Nguyễn Thị Hà">
                        </div>
                        <div class="author-info">
                            <h4>Nguyễn Thị Hà</h4>
                            <span>Khách hàng từ Quận 1, TP.HCM</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-item">
                <div class="testimonial-content">
                    <div class="rating">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                    </div>
                    <p class="quote">"Tôi đã được tư vấn cụ thể về tình trạng tóc gãy rụng của mình. Chuyên gia đã tư vấn rất tận tình và chuyên nghiệp, giúp tôi hiểu rõ nguyên nhân và cách khắc phục. Sau 3 tháng thực hiện liệu trình, tóc tôi đã chắc khỏe và mượt mà hơn rất nhiều."</p>
                    <div class="testimonial-author">
                        <div class="author-img">
                            <img src="/assets/images/testimonials/testimonial-2.jpg" alt="Trần Thanh Bình">
                        </div>
                        <div class="author-info">
                            <h4>Trần Thanh Bình</h4>
                            <span>Khách hàng từ Quận 3, TP.HCM</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-item">
                <div class="testimonial-content">
                    <div class="rating">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                    </div>
                    <p class="quote">"Dịch vụ tư vấn tại Luxury Head Spa thực sự xuất sắc. Tôi đã được phân tích chi tiết về tình trạng da đầu và nguyên nhân khiến tôi bị gàu nhiều. Sau khi thực hiện đúng theo liệu trình được tư vấn, tình trạng gàu của tôi đã được cải thiện đáng kể."</p>
                    <div class="testimonial-author">
                        <div class="author-img">
                            <img src="/assets/images/testimonials/testimonial-3.jpg" alt="Lê Văn Minh">
                        </div>
                        <div class="author-info">
                            <h4>Lê Văn Minh</h4>
                            <span>Khách hàng từ Quận 7, TP.HCM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="subtitle">Câu hỏi thường gặp</span>
            <h2>Giải đáp thắc mắc</h2>
            <p>Một số câu hỏi thường gặp về dịch vụ tư vấn tại Luxury Head Spa</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="accordion" id="faqAccordion" data-aos="fade-up">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Dịch vụ tư vấn có mất phí không?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Dịch vụ tư vấn tại Luxury Head Spa hoàn toàn miễn phí. Bạn có thể đặt lịch tư vấn trực tuyến hoặc trực tiếp tại spa mà không mất bất kỳ chi phí nào.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Quy trình tư vấn diễn ra như thế nào?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Quy trình tư vấn bao gồm các bước: (1) Đặt lịch tư vấn qua website hoặc điện thoại, (2) Chuyên gia của chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ, (3) Trao đổi về tình trạng tóc và da đầu của bạn, (4) Nhận tư vấn cụ thể về liệu trình điều trị phù hợp, và (5) Đặt lịch sử dụng dịch vụ nếu bạn quan tâm.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Làm thế nào để chuẩn bị cho buổi tư vấn?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Để buổi tư vấn hiệu quả, bạn nên chuẩn bị: (1) Thông tin về tình trạng tóc và da đầu hiện tại, (2) Các vấn đề bạn đang gặp phải, (3) Lịch sử sử dụng các sản phẩm chăm sóc tóc, (4) Các liệu trình điều trị tóc trước đây (nếu có), và (5) Mong muốn của bạn về mái tóc trong tương lai.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Tư vấn có áp dụng cho mọi vấn đề về tóc không?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có, dịch vụ tư vấn của chúng tôi áp dụng cho hầu hết các vấn đề về tóc và da đầu, bao gồm: rụng tóc, hói đầu, tóc mỏng, tóc gãy rụng, tóc hư tổn, tóc khô xơ, da đầu khô/nhờn, gàu, nấm da đầu, và nhiều vấn đề khác. Nếu vấn đề của bạn cần sự hỗ trợ từ bác sĩ da liễu, chúng tôi sẽ tư vấn và giới thiệu bạn đến các chuyên gia y tế phù hợp.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Tôi có bắt buộc phải sử dụng dịch vụ sau khi được tư vấn không?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Không, bạn hoàn toàn có quyền quyết định sử dụng dịch vụ hay không sau khi được tư vấn. Chúng tôi cung cấp dịch vụ tư vấn miễn phí với mục đích giúp bạn hiểu rõ hơn về tình trạng tóc và các giải pháp phù hợp. Bạn có thể cân nhắc và quyết định sử dụng dịch vụ khi bạn cảm thấy sẵn sàng.
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
    /* Consultation Section */
    .consultation-content .lead {
        font-size: 18px;
        margin-bottom: 30px;
    }
    
    .consultation-steps {
        margin-bottom: 40px;
    }
    
    .step-item {
        display: flex;
        margin-bottom: 30px;
    }
    
    .step-number {
        font-size: 24px;
        font-weight: 700;
        color: #38a89d;
        min-width: 70px;
        height: 70px;
        background-color: rgba(56, 168, 157, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
    }
    
    .step-content h3 {
        font-size: 20px;
        margin-bottom: 10px;
    }
    
    .step-content p {
        font-size: 16px;
        margin-bottom: 0;
    }
    
    .expert-info {
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
    }
    
    .expert-img {
        min-width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 20px;
    }
    
    .expert-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .expert-content h3 {
        font-size: 20px;
        margin-bottom: 10px;
    }
    
    .expert-content p {
        font-size: 15px;
        margin-bottom: 0;
    }
    
    /* Consultation Form */
    .consultation-form-wrapper {
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
    
    .hair-conditions {
        margin-bottom: 20px;
    }
    
    .form-check {
        margin-bottom: 10px;
    }
    
    .form-check-input:checked {
        background-color: #38a89d;
        border-color: #38a89d;
    }
    
    /* Suggested Services */
    .suggested-services {
        margin: 20px 0;
        padding: 20px;
        background-color: rgba(56, 168, 157, 0.05);
        border-radius: 10px;
        border: 1px dashed #38a89d;
    }
    
    .suggested-services h4 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #38a89d;
    }
    
    .service-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .service-card {
        background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .service-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .service-card h5 {
        font-size: 16px;
        margin-bottom: 5px;
    }
    
    .service-card p {
        font-size: 14px;
        color: #777;
        margin-bottom: 0;
    }
    
    .service-card .price {
        font-weight: 600;
        color: #38a89d;
    }
    
    /* Why Choose Our Consultation Section */
    .feature-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .feature-icon {
        font-size: 40px;
        color: #38a89d;
        margin-bottom: 20px;
    }
    
    .feature-content h3 {
        font-size: 20px;
        margin-bottom: 15px;
    }
    
    .feature-content p {
        font-size: 15px;
        margin-bottom: 0;
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
        .consultation-form-wrapper {
            margin-top: 50px;
        }
        
        .service-cards {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 767px) {
        .consultation-form-wrapper {
            padding: 30px 20px;
        }
        
        .expert-info {
            flex-direction: column;
            text-align: center;
        }
        
        .expert-img {
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .step-item {
            flex-direction: column;
            text-align: center;
        }
        
        .step-number {
            margin: 0 auto 15px;
        }
    }
</style>

<!-- Service Suggestion Script -->
<script>
    $(document).ready(function() {
        // Lắng nghe sự kiện khi chọn tình trạng tóc
        $('.hair-condition-checkbox').on('change', function() {
            // Lấy danh sách các tình trạng tóc đã chọn
            var selectedConditions = [];
            $('.hair-condition-checkbox:checked').each(function() {
                selectedConditions.push($(this).val());
            });
            
            // Nếu có ít nhất một tình trạng được chọn, gọi AJAX để lấy gợi ý dịch vụ
            if (selectedConditions.length > 0) {
                $.ajax({
                    url: '/tu-van/suggest-services',
                    type: 'POST',
                    data: {
                        hair_conditions: selectedConditions,
                        csrf_token: $('input[name="csrf_token"]').val()
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        
                        if (result.success && result.services.length > 0) {
                            // Hiển thị phần gợi ý dịch vụ
                            $('#suggested-services').show();
                            
                            // Xóa nội dung cũ
                            $('#service-cards-container').empty();
                            
                            // Thêm các dịch vụ gợi ý
                            $.each(result.services, function(index, service) {
                                var serviceCard = '<div class="service-card">' +
                                    '<h5>' + service.name + '</h5>' +
                                    '<p>' + service.short_description + '</p>' +
                                    '<p class="price">' + formatCurrency(service.price) + '</p>' +
                                    '</div>';
                                
                                $('#service-cards-container').append(serviceCard);
                            });
                            
                            // Cập nhật trường hair_condition
                            var hairConditionText = selectedConditions.map(function(value) {
                                return $('label[for="condition-' + value.replace('_', '-') + '"]').text();
                            }).join(', ');
                            
                            $('#wishes').val('Tôi đang gặp vấn đề: ' + hairConditionText + '. ');
                        } else {
                            // Ẩn phần gợi ý dịch vụ nếu không có kết quả
                            $('#suggested-services').hide();
                        }
                    },
                    error: function() {
                        // Ẩn phần gợi ý dịch vụ nếu có lỗi
                        $('#suggested-services').hide();
                    }
                });
            } else {
                // Ẩn phần gợi ý dịch vụ nếu không có tình trạng nào được chọn
                $('#suggested-services').hide();
            }
        });
        
        // Định dạng tiền tệ
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }
        
        // Xử lý gửi form
        $('#consultation-form').submit(function(e) {
            e.preventDefault();
            
            // Tạo biến chứa các tình trạng tóc đã chọn
            var hairConditions = [];
            $('.hair-condition-checkbox:checked').each(function() {
                hairConditions.push($(this).next('label').text());
            });
            
            // Gán giá trị vào trường hair_condition nếu chưa có nội dung
            if ($('#wishes').val().trim() === '') {
                $('#wishes').val('Tôi đang gặp vấn đề: ' + hairConditions.join(', ') + '.');
            }
            
            // Gửi form bằng AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function() {
                    $('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);
                },
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
                            // Chuyển hướng đến trang thành công
                            window.location.href = result.redirect;
                        });
                    } else {
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: result.message,
                            confirmButtonColor: '#38a89d'
                        });
                        
                        // Khôi phục nút submit
                        $('button[type="submit"]').html('Gửi yêu cầu tư vấn').prop('disabled', false);
                    }
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
                    $('button[type="submit"]').html('Gửi yêu cầu tư vấn').prop('disabled', false);
                }
            });
        });
    });
</script>

<?php
// Include footer
include_once dirname(__DIR__) . '/templates/footer.php';
?>
