<?php
/**
 * Base Controller Class - Lớp Controller cơ sở
 * File: app/core/Controller.php
 */

namespace App\Core;

class Controller {
    /**
     * Constructor - Khởi tạo controller
     */
    public function __construct() {
        // Khởi tạo các thành phần cần thiết
    }
    
    /**
     * Render view - Hiển thị view
     * 
     * @param string $view Đường dẫn đến view
     * @param array $data Dữ liệu truyền vào view
     * @return void
     */
    protected function view($view, $data = []) {
        // Trích xuất dữ liệu để sử dụng trong view
        extract($data);
        
        // Tạo CSRF token nếu chưa có
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        // Truyền CSRF token vào view
        $csrf_token = $_SESSION['csrf_token'];
        
        // Đường dẫn đến file view
        $viewPath = dirname(__DIR__) . '/views/' . $view . '.php';
        
        // Kiểm tra file view có tồn tại không
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            // Nếu không tìm thấy view, hiển thị lỗi
            throw new \Exception("View {$view} không tồn tại");
        }
    }
    
    /**
     * Redirect - Chuyển hướng đến URL khác
     * 
     * @param string $url URL đích
     * @return void
     */
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Set flash message - Thiết lập thông báo flash
     * 
     * @param string $type Loại thông báo (success, error, warning, info)
     * @param string $message Nội dung thông báo
     * @return void
     */
    protected function setFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    /**
     * Check if request is POST - Kiểm tra có phải request POST không
     * 
     * @return bool
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Validate CSRF token - Xác thực CSRF token
     * 
     * @param string $token Token từ form
     * @return bool
     */
    protected function validateCsrfToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
