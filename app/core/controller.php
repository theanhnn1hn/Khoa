<?php
/**
 * Base Controller Class - Lớp Controller cơ sở
 * File: app/core/Controller.php
 */

abstract class Controller {
    protected $config;
    
    /**
     * Constructor - Khởi tạo Controller với config
     */
    public function __construct() {
        $this->config = require dirname(__DIR__) . '/config/config.php';
        
        // Kiểm tra CSRF token nếu là request POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
        }
    }
    
    /**
     * Load model
     */
    protected function model($model) {
        // Kiểm tra xem file model có tồn tại không
        $modelFile = dirname(__DIR__) . "/models/{$model}.php";
        
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        } else {
            throw new Exception("Model {$model} không tồn tại");
        }
    }
    
    /**
     * Load view
     */
    protected function view($view, $data = []) {
        // Kiểm tra xem file view có tồn tại không
        $viewFile = dirname(__DIR__) . "/views/{$view}.php";
        
        if (file_exists($viewFile)) {
            // Extract data để sử dụng trong view
            extract($data);
            
            // Bắt đầu output buffering
            ob_start();
            
            // Include file view
            include_once $viewFile;
            
            // Lấy nội dung buffer và xóa buffer
            $content = ob_get_clean();
            
            // Trả về nội dung view
            echo $content;
        } else {
            throw new Exception("View {$view} không tồn tại");
        }
    }
    
    /**
     * Chuyển hướng đến URL
     */
    protected function redirect($url, $statusCode = 303) {
        header('Location: ' . $url, true, $statusCode);
        exit;
    }
    
    /**
     * Lấy input từ $_POST hoặc $_GET
     */
    protected function input($key = null, $default = null, $method = null) {
        // Xác định method (POST hoặc GET)
        if ($method === null) {
            $method = $_SERVER['REQUEST_METHOD'];
        }
        
        // Lấy dữ liệu từ method tương ứng
        $data = ($method === 'POST') ? $_POST : $_GET;
        
        // Nếu $key là null, trả về toàn bộ dữ liệu
        if ($key === null) {
            return $data;
        }
        
        // Trả về giá trị của $key hoặc $default nếu $key không tồn tại
        return isset($data[$key]) ? $this->sanitizeInput($data[$key]) : $default;
    }
    
    /**
     * Xử lý dữ liệu đầu vào
     */
    protected function sanitizeInput($input) {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = $this->sanitizeInput($value);
            }
        } else {
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        }
        
        return $input;
    }
    
    /**
     * Trả về JSON response
     */
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Kiểm tra CSRF token
     */
    protected function validateCsrfToken() {
        $tokenName = $this->config['security']['csrf_token_name'];
        
        if (!isset($_POST[$tokenName]) || !isset($_SESSION[$tokenName])) {
            $this->redirect('/error/403');
        }
        
        if ($_POST[$tokenName] !== $_SESSION[$tokenName]) {
            $this->redirect('/error/403');
        }
        
        // Xóa token sau khi đã sử dụng
        unset($_SESSION[$tokenName]);
    }
    
    /**
     * Tạo CSRF token
     */
    protected function generateCsrfToken() {
        $tokenName = $this->config['security']['csrf_token_name'];
        $tokenLength = $this->config['security']['csrf_token_length'];
        
        $token = bin2hex(random_bytes($tokenLength / 2));
        $_SESSION[$tokenName] = $token;
        
        return $token;
    }
    
    /**
     * Kiểm tra đăng nhập
     */
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Yêu cầu đăng nhập
     */
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }
    
    /**
     * Kiểm tra quyền admin
     */
    protected function requireAdmin() {
        $this->requireLogin();
        
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/error/403');
        }
    }
    
    /**
     * Upload file
     */
    protected function uploadFile($file, $directory, $allowedTypes = [], $maxSize = null) {
        // Kiểm tra lỗi upload
        if ($file['error'] !== 0) {
            return [
                'success' => false,
                'message' => 'Lỗi khi upload file: ' . $this->getUploadErrorMessage($file['error'])
            ];
        }
        
        // Lấy thông tin về file
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Kiểm tra loại file
        if (!empty($allowedTypes) && !in_array($fileExt, $allowedTypes)) {
            return [
                'success' => false,
                'message' => 'Loại file không được phép. Chỉ cho phép: ' . implode(', ', $allowedTypes)
            ];
        }
        
        // Kiểm tra kích thước file
        if ($maxSize !== null && $fileSize > $maxSize) {
            return [
                'success' => false,
                'message' => 'Kích thước file quá lớn. Tối đa: ' . round($maxSize / 1024 / 1024, 2) . 'MB'
            ];
        }
        
        // Tạo tên file mới để tránh trùng lặp
        $newFileName = uniqid() . '.' . $fileExt;
        $destination = $directory . '/' . $newFileName;
        
        // Tạo thư mục nếu không tồn tại
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Di chuyển file upload đến thư mục đích
        if (move_uploaded_file($fileTmpName, $destination)) {
            return [
                'success' => true,
                'file_name' => $newFileName,
                'file_path' => $destination,
                'file_url' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $destination)
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Không thể lưu file upload'
            ];
        }
    }
    
    /**
     * Lấy thông báo lỗi upload
     */
    private function getUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'Kích thước file vượt quá giới hạn trong php.ini';
            case UPLOAD_ERR_FORM_SIZE:
                return 'Kích thước file vượt quá giới hạn trong form HTML';
            case UPLOAD_ERR_PARTIAL:
                return 'File chỉ được tải lên một phần';
            case UPLOAD_ERR_NO_FILE:
                return 'Không có file nào được tải lên';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Thiếu thư mục tạm';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Không thể ghi file vào ổ đĩa';
            case UPLOAD_ERR_EXTENSION:
                return 'Upload bị dừng bởi extension';
            default:
                return 'Lỗi không xác định';
        }
    }
    
    /**
     * Tạo thông báo flash
     */
    protected function setFlashMessage($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type, // success, error, warning, info
            'message' => $message
        ];
    }
    
    /**
     * Lấy thông báo flash
     */
    protected function getFlashMessage() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        
        return null;
    }
}
