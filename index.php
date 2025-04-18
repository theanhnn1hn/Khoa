<?php
/**
 * File index.php chính - Entry point của ứng dụng
 * File: public/index.php
 */

// Định nghĩa hằng số cho đường dẫn thư mục
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', __DIR__);
define('ASSETS_PATH', ROOT_PATH . '/assets');

// Bắt đầu session
session_start();

// Thiết lập error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Tự động load các lớp
spl_autoload_register(function ($class) {
    // Danh sách các thư mục chứa các lớp
    $directories = [
        APP_PATH . '/core/',
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
        APP_PATH . '/helpers/'
    ];
    
    // Duyệt qua từng thư mục để tìm file class
    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Tạo instance của Router
$router = new Router();

// Định nghĩa các routes

// Trang chủ
$router->get('/', 'HomeController', 'index');

// Trang dịch vụ
$router->get('/dich-vu', 'ServiceController', 'index');
$router->get('/dich-vu/{slug}', 'ServiceController', 'show');

// Trang đặt lịch
$router->get('/dat-lich', 'BookingController', 'index');
$router->post('/dat-lich', 'BookingController', 'store');
$router->get('/dat-lich/thanh-cong', 'BookingController', 'success');

// Trang tư vấn
$router->get('/tu-van', 'ConsultationController', 'index');
$router->post('/tu-van', 'ConsultationController', 'store');
$router->get('/tu-van/thanh-cong', 'ConsultationController', 'success');

// Trang giới thiệu
$router->get('/gioi-thieu', 'AboutController', 'index');

// Trang thư viện ảnh
$router->get('/thu-vien-anh', 'GalleryController', 'index');
$router->get('/thu-vien-anh/{category}', 'GalleryController', 'category');

// Trang blog
$router->get('/blog', 'BlogController', 'index');
$router->get('/blog/{slug}', 'BlogController', 'show');
$router->get('/blog/danh-muc/{category}', 'BlogController', 'category');

// Trang đánh giá
$router->get('/danh-gia', 'TestimonialController', 'index');
$router->post('/danh-gia', 'TestimonialController', 'store');

// Trang khách hàng thân thiết
$router->get('/khach-hang-than-thiet', 'LoyaltyController', 'index');
$router->post('/khach-hang-than-thiet', 'LoyaltyController', 'register');

// Trang liên hệ
$router->get('/lien-he', 'ContactController', 'index');
$router->post('/lien-he', 'ContactController', 'send');

// Trang tìm kiếm
$router->get('/tim-kiem', 'SearchController', 'index');

// Trang lỗi
$router->get('/error/404', 'ErrorController', 'notFound');
$router->get('/error/403', 'ErrorController', 'forbidden');
$router->get('/error/500', 'ErrorController', 'serverError');

// Thiết lập xử lý khi không tìm thấy route
$router->setNotFoundHandler(function() {
    header('Location: /error/404');
});

// Lấy URL hiện tại
$url = $_SERVER['REQUEST_URI'];

try {
    // Dispatch route tương ứng
    $router->dispatch($url);
} catch (Exception $e) {
    // Ghi log lỗi
    error_log($e->getMessage());
    
    // Chuyển hướng đến trang lỗi
    header('Location: /error/500');
}
