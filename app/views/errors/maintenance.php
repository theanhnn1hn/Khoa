<?php
/**
 * Maintenance View - Trang bảo trì
 * File: app/views/errors/maintenance.php
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Bảo trì hệ thống - Luxury Head Spa'; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Trang web đang trong quá trình bảo trì. Vui lòng quay lại sau.'; ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #38a89d;
            --primary-hover: #2c8c82;
            --dark-color: #333333;
            --light-color: #f8f9fa;
            --white-color: #ffffff;
            --gray-color: #6c757d;
            
            --heading-font: 'Montserrat', sans-serif;
            --body-font: 'Poppins', sans-serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--body-font);
            font-size: 16px;
            line-height: 1.7;
            color: var(--dark-color);
            background-color: var(--light-color);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .maintenance-container {
            max-width: 800px;
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
        }
        
        .maintenance-header {
            background-color: var(--primary-color);
            padding: 40px 20px;
            color: var(--white-color);
        }
        
        .maintenance-header h1 {
            font-family: var(--heading-font);
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .maintenance-header p {
            font-size: 18px;
            opacity: 0.9;
        }
        
        .maintenance-content {
            padding: 40px;
        }
        
        .maintenance-icon {
            font-size: 80px;
            color: var(--primary-color);
            margin-bottom: 30px;
        }
        
        .maintenance-title {
            font-family: var(--heading-font);
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .maintenance-message {
            font-size: 16px;
            color: var(--gray-color);
            margin-bottom: 30px;
        }
        
        .maintenance-timer {
            margin: 30px 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .timer-item {
            width: 80px;
            height: 80px;
            background-color: var(--light-color);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .timer-count {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .timer-label {
            font-size: 12px;
            color: var(--gray-color);
        }
        
        .social-icons {
            margin-top: 30px;
        }
        
        .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: rgba(56, 168, 157, 0.1);
            border-radius: 50%;
            line-height: 40px;
            text-align: center;
            color: var(--primary-color);
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background-color: var(--primary-color);
            color: var(--white-color);
        }
        
        .contact-info {
            margin-top: 20px;
            font-size: 14px;
            color: var(--gray-color);
        }
        
        .contact-info a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .contact-info a:hover {
            text-decoration: underline;
        }
        
        .maintenance-footer {
            padding: 20px;
            background-color: var(--light-color);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 14px;
            color: var(--gray-color);
        }
        
        @media (max-width: 767px) {
            .maintenance-header {
                padding: 30px 20px;
            }
            
            .maintenance-header h1 {
                font-size: 24px;
            }
            
            .maintenance-header p {
                font-size: 16px;
            }
            
            .maintenance-content {
                padding: 30px 20px;
            }
            
            .maintenance-icon {
                font-size: 60px;
            }
            
            .maintenance-title {
                font-size: 22px;
            }
            
            .maintenance-timer {
                gap: 10px;
            }
            
            .timer-item {
                width: 60px;
                height: 60px;
            }
            
            .timer-count {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-header">
            <h1>Luxury Head Spa</h1>
            <p>Spa tóc chuyên nghiệp tại Việt Nam</p>
        </div>
        
        <div class="maintenance-content">
            <div class="maintenance-icon">
                <i class="fas fa-tools"></i>
            </div>
            
            <h2 class="maintenance-title"><?php echo $error_title; ?></h2>
            <p class="maintenance-message"><?php echo $error_message; ?></p>
            
            <div class="maintenance-timer">
                <div class="timer-item">
                    <span class="timer-count" id="hours">00</span>
                    <span class="timer-label">Giờ</span>
                </div>
                <div class="timer-item">
                    <span class="timer-count" id="minutes">00</span>
                    <span class="timer-label">Phút</span>
                </div>
                <div class="timer-item">
                    <span class="timer-count" id="seconds">00</span>
                    <span class="timer-label">Giây</span>
                </div>
            </div>
            
            <div class="social-icons">
                <a href="https://facebook.com/luxuryheadspa" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://instagram.com/luxuryheadspa" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://zalo.me/luxuryheadspa" target="_blank"><i class="fas fa-comment-dots"></i></a>
            </div>
            
            <div class="contact-info">
                <p>Nếu cần hỗ trợ gấp, vui lòng liên hệ: <a href="tel:+84901234567">0901 234 567</a> hoặc <a href="mailto:info@luxuryheadspa.vn">info@luxuryheadspa.vn</a></p>
            </div>
        </div>
        
        <div class="maintenance-footer">
            <p>&copy; <?php echo date('Y'); ?> Luxury Head Spa. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
    
    <script>
        // Set the date we're counting down to (2 hours from now)
        var countDownDate = new Date();
        countDownDate.setHours(countDownDate.getHours() + 2);
        
        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get today's date and time
            var now = new Date().getTime();
            
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            
            // Time calculations for hours, minutes and seconds
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Display the result
            document.getElementById("hours").innerHTML = (hours < 10 ? "0" : "") + hours;
            document.getElementById("minutes").innerHTML = (minutes < 10 ? "0" : "") + minutes;
            document.getElementById("seconds").innerHTML = (seconds < 10 ? "0" : "") + seconds;
            
            // If the count down is finished, reload the page
            if (distance < 0) {
                clearInterval(x);
                location.reload();
            }
        }, 1000);
    </script>
</body>
</html>
