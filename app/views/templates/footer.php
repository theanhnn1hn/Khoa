<?php
/**
 * Footer Template
 * File: app/views/templates/footer.php
 */
?>

    </main>
    <!-- Main Content Ends Here -->
    
    <!-- Footer -->
    <footer class="footer">
        <!-- Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <!-- About Us Column -->
                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <div class="footer-widget">
                            <img src="/assets/images/logo/logo-white.png" alt="Luxury Head Spa" class="footer-logo">
                            <p class="footer-about">Luxury Head Spa là spa tóc cao cấp với các dịch vụ chăm sóc tóc và da đầu chuyên nghiệp, sử dụng thảo dược thiên nhiên và công nghệ Hàn-Nhật tiên tiến.</p>
                            <div class="social-icons">
                                <a href="https://facebook.com/luxuryheadspa" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://instagram.com/luxuryheadspa" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="https://youtube.com/luxuryheadspa" target="_blank"><i class="fab fa-youtube"></i></a>
                                <a href="https://zalo.me/luxuryheadspa" target="_blank"><i class="fas fa-comment-dots"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Links Column -->
                    <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                        <div class="footer-widget">
                            <h4 class="footer-widget-title">Liên kết nhanh</h4>
                            <ul class="footer-links">
                                <li><a href="/">Trang chủ</a></li>
                                <li><a href="/gioi-thieu">Giới thiệu</a></li>
                                <li><a href="/dich-vu">Dịch vụ</a></li>
                                <li><a href="/dat-lich">Đặt lịch</a></li>
                                <li><a href="/blog">Blog</a></li>
                                <li><a href="/lien-he">Liên hệ</a></li>
                                <li><a href="/chinh-sach-bao-mat">Chính sách bảo mật</a></li>
                                <li><a href="/dieu-khoan-su-dung">Điều khoản sử dụng</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Services Column -->
                    <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                        <div class="footer-widget">
                            <h4 class="footer-widget-title">Dịch vụ</h4>
                            <ul class="footer-links">
                                <li><a href="/dich-vu/goi-dau-duong-sinh">Gội đầu dưỡng sinh</a></li>
                                <li><a href="/dich-vu/goi-head-spa-han-quoc">Gội Head Spa Hàn Quốc</a></li>
                                <li><a href="/dich-vu/tri-rung-toc-chuyen-sau">Trị rụng tóc</a></li>
                                <li><a href="/dich-vu/tri-gau-va-nam-da-dau">Trị gàu & nấm</a></li>
                                <li><a href="/dich-vu/nhuom-toc-nhat-ban">Nhuộm tóc Nhật Bản</a></li>
                                <li><a href="/dich-vu/dap-mat-na-thao-duoc">Đắp mặt nạ thảo dược</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Contact Info Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-widget">
                            <h4 class="footer-widget-title">Thông tin liên hệ</h4>
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
                            
                            <!-- Newsletter Form -->
                            <div class="newsletter">
                                <h5>Đăng ký nhận khuyến mãi</h5>
                                <form action="/newsletter/subscribe" method="POST" class="newsletter-form">
                                    <input type="hidden" name="csrf_token" value="<?php echo isset($csrf_token) ? $csrf_token : ''; ?>">
                                    <div class="input-group">
                                        <input type="email" name="email" placeholder="Email của bạn" required>
                                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="copyright">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p>&copy; <?php echo date('Y'); ?> Luxury Head Spa. Tất cả quyền được bảo lưu.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-methods text-md-end">
                            <img src="/assets/images/payment-methods.png" alt="Phương thức thanh toán" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Zalo Chat Widget -->
    <div class="zalo-chat-widget" data-oaid="123456789" data-welcome-message="Xin chào! Luxury Head Spa có thể giúp gì cho bạn?" data-autopopup="0" data-width="350" data-height="420"></div>
    
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    
    <!-- Slick Slider JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    
    <!-- AOS Animation JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <!-- Zalo SDK -->
    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    
    <!-- Custom JS -->
    <script src="/assets/js/main.js"></script>
    
    <?php if (strpos($_SERVER['REQUEST_URI'], '/dat-lich') !== false): ?>
    <!-- Booking JS (Load only on booking page) -->
    <script src="/assets/js/booking.js"></script>
    <?php endif; ?>
    
    <?php if (strpos($_SERVER['REQUEST_URI'], '/lien-he') !== false): ?>
    <!-- Google Maps (Load only on contact page) -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
    <?php endif; ?>
    
    <script>
        // Initialize AOS Animation
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>
