<?php
/**
 * Cấu hình chung của ứng dụng
 * File: app/config/config.php
 */

return [
    // Thông tin cơ bản của website
    'site' => [
        'name'        => 'Luxury Head Spa',
        'description' => 'Spa tóc cao cấp với dịch vụ chăm sóc tóc và da đầu chuyên nghiệp',
        'url'         => 'http://localhost/luxury-head-spa', // Thay đổi thành domain thực tế khi triển khai
        'email'       => 'info@luxuryheadspa.vn',
        'phone'       => '0901234567',
        'address'     => '123 Nguyễn Huệ, Quận 1, TP.HCM',
    ],
    
    // Đường dẫn thư mục
    'paths' => [
        'root'        => dirname(dirname(__DIR__)),
        'app'         => dirname(__DIR__),
        'controllers' => dirname(__DIR__) . '/controllers',
        'models'      => dirname(__DIR__) . '/models',
        'views'       => dirname(__DIR__) . '/views',
        'helpers'     => dirname(__DIR__) . '/helpers',
        'uploads'     => dirname(dirname(__DIR__)) . '/assets/uploads',
        'assets'      => dirname(dirname(__DIR__)) . '/assets',
    ],
    
    // Cấu hình upload file
    'upload' => [
        'max_size'    => 5 * 1024 * 1024, // 5MB
        'allowed_ext' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
        'image_sizes' => [
            'thumb'   => ['width' => 150, 'height' => 150],
            'medium'  => ['width' => 400, 'height' => 400],
            'large'   => ['width' => 800, 'height' => 800],
        ],
    ],
    
    // Cấu hình email
    'mail' => [
        'host'       => 'smtp.gmail.com',
        'port'       => 587,
        'username'   => 'your_email@gmail.com', // Thay đổi thành email của bạn
        'password'   => 'your_password',        // Thay đổi thành mật khẩu email
        'encryption' => 'tls',
        'from_email' => 'info@luxuryheadspa.vn',
        'from_name'  => 'Luxury Head Spa',
    ],
    
    // Cấu hình bảo mật
    'security' => [
        'csrf_token_name'   => 'csrf_token',
        'csrf_token_length' => 32,
        'session_name'      => 'luxury_head_spa_session',
        'password_algo'     => PASSWORD_BCRYPT,
        'password_options'  => ['cost' => 12],
    ],
    
    // Cấu hình phân trang
    'pagination' => [
        'per_page' => 10,
    ],
    
    // Cấu hình booking
    'booking' => [
        'start_time'     => '09:00',
        'end_time'       => '20:00',
        'interval'       => 30, // phút
        'advance_days'   => 30, // số ngày có thể đặt trước
        'min_hours'      => 1,  // số giờ tối thiểu trước khi đặt
    ],
    
    // Cấu hình debug
    'debug' => true, // Đặt thành false khi triển khai
];
