<?php
/**
 * File index.php chính - Entry point của ứng dụng
 * File: public/index.php
 */

// Định nghĩa hằng số cho đường dẫn thư mục
define('ROOT_PATH', __DIR__);
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
    // Chuyển đổi namespace thành đường dẫn file
    $prefix = 'App\\';
    
    // Kiểm tra xem class có bắt đầu bằng prefix không
    if (strpos($class, $prefix) !== 0) {
        return;
    }
    
    // Lấy đường dẫn tương đối (bỏ prefix App\)
    $relative_class = substr($class, strlen($prefix));
    
    // Chuyển đổi namespace thành đường dẫn file - KHÔNG chuyển thành lowercase
    $file = APP_PATH . '/' . str_replace('\\', '/', $relative_class) . '.php';
    
    // Nếu file tồn tại, load nó
    if (file_exists($file)) {
        require_once $file;
        return;
    }
    
    // Nếu không tìm thấy file
    throw new Exception("Không thể tìm thấy class {$class} tại đường dẫn {$file}");
});

// Sử dụng namespace
use App\Core\Router;

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

// Admin Routes
$router->get('/admin', 'AdminController', 'dashboard');
$router->get('/admin/login', 'AdminController', 'login');
$router->post('/admin/login', 'AdminController', 'authenticate');
$router->get('/admin/logout', 'AdminController', 'logout');
$router->get('/admin/forgot-password', 'AdminController', 'forgotPassword');
$router->post('/admin/forgot-password', 'AdminController', 'sendResetLink');
$router->get('/admin/reset-password/{token}', 'AdminController', 'resetPassword');
$router->post('/admin/reset-password', 'AdminController', 'updatePassword');

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
