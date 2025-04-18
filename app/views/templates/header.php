<?php
/**
 * Header Template
 * File: app/views/templates/header.php
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo isset($page_title) ? $page_title : 'Luxury Head Spa - Spa tóc cao cấp tại Việt Nam'; ?></title>
    
    <!-- Meta Tags -->
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Luxury Head Spa - Spa tóc chuyên nghiệp với các dịch vụ chăm sóc tóc và da đầu cao cấp, sử dụng thảo dược thiên nhiên và công nghệ Hàn-Nhật tiên tiến'; ?>">
    <meta name="keywords" content="spa tóc, head spa, gội đầu dưỡng sinh, trị rụng tóc, trị gàu, nhuộm tóc, chăm sóc tóc">
    <meta name="author" content="Luxury Head Spa">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="/assets/images/logo/favicon.ico" type="image/x-icon">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title : 'Luxury Head Spa - Spa tóc cao cấp tại Việt Nam'; ?>">
    <meta property="og:description" content="<?php echo isset($page_description) ? $page_description : 'Luxury Head Spa - Spa tóc chuyên nghiệp với các dịch vụ chăm sóc tóc và da đầu cao cấp, sử dụng thảo dược thiên nhiên và công nghệ Hàn-Nhật tiên tiến'; ?>">
    <meta property="og:image" content="/assets/images/logo/og-image.jpg">
    <meta property="og:url" content="<?php echo isset($page_url) ? $page_url : 'https://luxuryheadspa.vn'; ?>">
    <meta property="og:type" content="website">
    
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($page_title) ? $page_title : 'Luxury Head Spa - Spa tóc cao cấp tại Việt Nam'; ?>">
    <meta name="twitter:description" content="<?php echo isset($page_description) ? $page_description : 'Luxury Head Spa - Spa tóc chuyên nghiệp với các dịch vụ chăm sóc tóc và da đầu cao cấp, sử dụng thảo dược thiên nhiên và công nghệ Hàn-Nhật tiên tiến'; ?>">
    <meta name="twitter:image" content="/assets/images/logo/og-image.jpg">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    
    <!-- AOS Animation CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/assets/css/styles.css" rel="stylesheet">
    <link href="/assets/css/responsive.css" rel="stylesheet">
    
    <!-- Schema.org markup for Google -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BeautySalon",
        "name": "Luxury Head Spa",
        "image": "/assets/images/logo/logo.png",
        "url": "https://luxuryheadspa.vn",
        "telephone": "+84901234567",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "123 Nguyễn Huệ",
            "addressLocality": "Quận 1",
            "addressRegion": "TP.HCM",
            "postalCode": "70000",
            "addressCountry": "VN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 10.780115,
            "longitude": 106.701429
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
                "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
            ],
            "opens": "09:00",
            "closes": "20:00"
        },
        "priceRange": "$$",
        "servesCuisine": "Hair Care Services"
    }
    </script>
    
    <!-- Google Analytics -->
    <!-- Đặt mã Google Analytics ở đây -->
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader">
            <img src="/assets/images/logo/logo-icon.png" alt="Luxury Head Spa">
            <span>Đang tải...</span>
        </div>
    </div>
    
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>
    
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="top-bar-left">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <i class="fas fa-envelope"></i> 
                                <a href="mailto:info@luxuryheadspa.vn">info@luxuryheadspa.vn</a>
                            </li>
                            <li class="list-inline-item">
                                <i class="fas fa-phone-alt"></i> 
                                <a href="tel:+84901234567">0901 234 567</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="top-bar-right">
                        <div class="social-links">
                            <a href="https://facebook.com/luxuryheadspa" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://instagram.com/luxuryheadspa" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="https://youtube.com/luxuryheadspa" target="_blank"><i class="fab fa-youtube"></i></a>
                            <a href="https://zalo.me/luxuryheadspa" target="_blank"><i class="fas fa-comment-dots"></i></a>
                        </div>
                        <div class="working-hours">
                            <i class="far fa-clock"></i> 9:00 - 20:00, Thứ Hai - Chủ Nhật
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <!-- Logo -->
                <a class="navbar-brand" href="/">
                    <img src="/assets/images/logo/logo.png" alt="Luxury Head Spa" class="img-fluid">
                </a>
                
                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/') === 0 && strlen($_SERVER['REQUEST_URI']) == 1) ? 'active' : ''; ?>">
                            <a class="nav-link" href="/">Trang chủ</a>
                        </li>
                        <li class="nav-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/gioi-thieu') !== false) ? 'active' : ''; ?>">
                            <a class="nav-link" href="/gioi-thieu">Giới thiệu</a>
                        </li>
                        <li class="nav-item dropdown <?php echo (strpos($_SERVER['REQUEST_URI'], '/dich-vu') !== false) ? 'active' : ''; ?>">
                            <a class="nav-link dropdown-toggle" href="/dich-vu" id="navbarDropdownServices" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dịch vụ
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownServices">
                                <li><a class="dropdown-item" href="/dich-vu/goi-dau-duong-sinh">Gội đầu dưỡng sinh</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/goi-head-spa-han-quoc">Gội Head Spa Hàn Quốc</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/tri-rung-toc-chuyen-sau">Trị rụng tóc chuyên sâu</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/nhuom-toc-nhat-ban">Nhuộm tóc Nhật Bản</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/tri-gau-va-nam-da-dau">Trị gàu và nấm da đầu</a></li>
                                <li><a class="dropdown-item" href="/dich-vu">Xem tất cả dịch vụ</a></li>
                            </ul>
                        </li>
                        <li class="nav-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/dat-lich') !== false) ? 'active' : ''; ?>">
                            <a class="nav-link" href="/dat-lich">Đặt lịch</a>
                        </li>
                        <li class="nav-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/tu-van') !== false) ? 'active' : ''; ?>">
                            <a class="nav-link" href="/tu-van">Tư vấn</a>
                        </li>
                        <li class="nav-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/thu-vien-anh') !== false) ? 'active' : ''; ?>">
                            <a class="nav-link" href="/thu-vien-anh">Thư viện ảnh</a>
                        </li>
                        <li class="nav-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/blog') !== false) ? 'active' : ''; ?>">
                            <a class="nav-link" href="/blog">Blog</a>
                        </li>
                        <li class="nav-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/lien-he') !== false) ? 'active' : ''; ?>">
                            <a class="nav-link" href="/lien-he">Liên hệ</a>
                        </li>
                    </ul>
                    
                    <!-- Search Button -->
                    <div class="search-btn">
                        <button type="button" class="search-toggle">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                    <!-- Booking Button -->
                    <div class="booking-btn">
                        <a href="/dat-lich" class="btn btn-primary">Đặt lịch</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    
    <!-- Search Form -->
    <div class="search-form-wrapper">
        <div class="container">
            <form action="/tim-kiem" method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="Tìm kiếm..." required>
                <button type="submit"><i class="fas fa-search"></i></button>
                <span class="search-close"><i class="fas fa-times"></i></span>
            </form>
        </div>
    </div>
    
    <!-- Mobile Contact Buttons -->
    <div class="mobile-contact-btns d-lg-none">
        <a href="tel:+84901234567" class="call-btn">
            <i class="fas fa-phone-alt"></i>
        </a>
        <a href="https://zalo.me/luxuryheadspa" class="zalo-btn" target="_blank">
            <i class="fas fa-comment-dots"></i>
        </a>
    </div>
    
    <!-- Main Content Starts Here -->
    <main>
