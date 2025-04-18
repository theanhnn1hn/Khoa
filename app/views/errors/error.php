<?php
/**
 * Error View - Trang lỗi chung
 * File: app/views/errors/error.php
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
                    <h1><?php echo $error_code; ?> - <?php echo $error_title; ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lỗi <?php echo $error_code; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Error Section -->
<section class="error-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="error-content text-center">
                    <div class="error-img">
                        <img src="/assets/images/error/<?php echo strtolower($error_code); ?>.svg" alt="Error <?php echo $error_code; ?>" class="img-fluid">
                    </div>
                    <h2 class="error-code"><?php echo $error_code; ?></h2>
                    <h3 class="error-title"><?php echo $error_title; ?></h3>
                    <p class="error-message"><?php echo $error_message; ?></p>
                    <div class="error-actions">
                        <a href="/" class="btn btn-primary">Về trang chủ</a>
                        <a href="/lien-he" class="btn btn-outline-primary">Liên hệ hỗ trợ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Suggestion Section -->
<section class="suggestion-section section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="suggestion-content text-center">
                    <h3>Bạn có thể quan tâm</h3>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="suggestion-item">
                                <i class="fas fa-spa"></i>
                                <h4>Dịch vụ của chúng tôi</h4>
                                <p>Khám phá các dịch vụ chăm sóc tóc và da đầu cao cấp</p>
                                <a href="/dich-vu" class="btn-link">Xem dịch vụ</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="suggestion-item">
                                <i class="fas fa-calendar-alt"></i>
                                <h4>Đặt lịch</h4>
                                <p>Đặt lịch trực tuyến nhanh chóng và dễ dàng</p>
                                <a href="/dat-lich" class="btn-link">Đặt lịch ngay</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="suggestion-item">
                                <i class="fas fa-headset"></i>
                                <h4>Tư vấn miễn phí</h4>
                                <p>Nhận tư vấn miễn phí từ chuyên gia của chúng tôi</p>
                                <a href="/tu-van" class="btn-link">Đăng ký tư vấn</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Error Section Styles */
    .error-section {
        padding: 80px 0;
    }
    
    .error-content {
        background-color: #fff;
        border-radius: 10px;
        padding: 50px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    
    .error-img {
        max-width: 350px;
        margin: 0 auto 30px;
    }
    
    .error-code {
        font-size: 72px;
        font-weight: 700;
        color: #38a89d;
        margin-bottom: 20px;
    }
    
    .error-title {
        font-size: 28px;
        margin-bottom: 20px;
    }
    
    .error-message {
        font-size: 18px;
        color: #777;
        margin-bottom: 30px;
    }
    
    .error-actions {
        margin-top: 30px;
    }
    
    .error-actions .btn {
        margin: 0 10px;
    }
    
    /* Suggestion Section Styles */
    .suggestion-section {
        background-color: #f8f9fa;
    }
    
    .suggestion-content h3 {
        font-size: 24px;
        margin-bottom: 20px;
    }
    
    .suggestion-item {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .suggestion-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .suggestion-item i {
        font-size: 40px;
        color: #38a89d;
        margin-bottom: 20px;
    }
    
    .suggestion-item h4 {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .suggestion-item p {
        font-size: 14px;
        color: #777;
        margin-bottom: 15px;
    }
    
    .suggestion-item .btn-link {
        color: #38a89d;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .suggestion-item .btn-link:hover {
        color: #2c8c82;
    }
    
    @media (max-width: 767px) {
        .error-content {
            padding: 30px 20px;
        }
        
        .error-code {
            font-size: 60px;
        }
        
        .error-title {
            font-size: 24px;
        }
        
        .error-message {
            font-size: 16px;
        }
        
        .suggestion-item {
            margin-bottom: 20px;
        }
    }
</style>

<?php
// Include footer
include_once dirname(__DIR__) . '/templates/footer.php';
?>
