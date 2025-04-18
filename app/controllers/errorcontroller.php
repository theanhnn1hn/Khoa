<?php
/**
 * Error Controller - Điều khiển trang lỗi
 * File: app/controllers/ErrorController.php
 */

class ErrorController extends Controller {
    
    /**
     * Constructor - Khởi tạo controller
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Trang lỗi 404 - Không tìm thấy
     */
    public function notFound() {
        // Thiết lập HTTP status code
        http_response_code(404);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => '404 - Không tìm thấy trang | Luxury Head Spa',
            'page_description' => 'Trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.',
            'error_code' => '404',
            'error_title' => 'Không tìm thấy trang',
            'error_message' => 'Rất tiếc, trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.',
        ];
        
        // Hiển thị view
        $this->view('errors/error', $data);
    }
    
    /**
     * Trang lỗi 403 - Truy cập bị từ chối
     */
    public function forbidden() {
        // Thiết lập HTTP status code
        http_response_code(403);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => '403 - Truy cập bị từ chối | Luxury Head Spa',
            'page_description' => 'Bạn không có quyền truy cập vào trang này.',
            'error_code' => '403',
            'error_title' => 'Truy cập bị từ chối',
            'error_message' => 'Rất tiếc, bạn không có quyền truy cập vào trang này.',
        ];
        
        // Hiển thị view
        $this->view('errors/error', $data);
    }
    
    /**
     * Trang lỗi 500 - Lỗi máy chủ
     */
    public function serverError() {
        // Thiết lập HTTP status code
        http_response_code(500);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => '500 - Lỗi máy chủ | Luxury Head Spa',
            'page_description' => 'Đã xảy ra lỗi máy chủ. Vui lòng thử lại sau.',
            'error_code' => '500',
            'error_title' => 'Lỗi máy chủ',
            'error_message' => 'Đã xảy ra lỗi trong quá trình xử lý yêu cầu của bạn. Vui lòng thử lại sau hoặc liên hệ với chúng tôi nếu lỗi vẫn tiếp tục xảy ra.',
        ];
        
        // Hiển thị view
        $this->view('errors/error', $data);
    }
    
    /**
     * Trang lỗi 401 - Chưa được xác thực
     */
    public function unauthorized() {
        // Thiết lập HTTP status code
        http_response_code(401);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => '401 - Chưa được xác thực | Luxury Head Spa',
            'page_description' => 'Bạn cần đăng nhập để truy cập trang này.',
            'error_code' => '401',
            'error_title' => 'Chưa được xác thực',
            'error_message' => 'Bạn cần đăng nhập để truy cập trang này. Vui lòng đăng nhập và thử lại.',
        ];
        
        // Hiển thị view
        $this->view('errors/error', $data);
    }
    
    /**
     * Trang lỗi 400 - Yêu cầu không hợp lệ
     */
    public function badRequest() {
        // Thiết lập HTTP status code
        http_response_code(400);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => '400 - Yêu cầu không hợp lệ | Luxury Head Spa',
            'page_description' => 'Yêu cầu của bạn không hợp lệ.',
            'error_code' => '400',
            'error_title' => 'Yêu cầu không hợp lệ',
            'error_message' => 'Yêu cầu của bạn không hợp lệ. Vui lòng kiểm tra lại thông tin và thử lại.',
        ];
        
        // Hiển thị view
        $this->view('errors/error', $data);
    }
    
    /**
     * Trang lỗi 405 - Phương thức không được phép
     */
    public function methodNotAllowed() {
        // Thiết lập HTTP status code
        http_response_code(405);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => '405 - Phương thức không được phép | Luxury Head Spa',
            'page_description' => 'Phương thức HTTP bạn đang sử dụng không được phép.',
            'error_code' => '405',
            'error_title' => 'Phương thức không được phép',
            'error_message' => 'Phương thức HTTP bạn đang sử dụng không được phép cho tài nguyên này.',
        ];
        
        // Hiển thị view
        $this->view('errors/error', $data);
    }
    
    /**
     * Trang bảo trì
     */
    public function maintenance() {
        // Thiết lập HTTP status code
        http_response_code(503);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Bảo trì hệ thống | Luxury Head Spa',
            'page_description' => 'Trang web đang trong quá trình bảo trì. Vui lòng quay lại sau.',
            'error_code' => '503',
            'error_title' => 'Đang bảo trì',
            'error_message' => 'Trang web hiện đang trong quá trình bảo trì. Vui lòng quay lại sau. Chúng tôi xin lỗi vì sự bất tiện này.',
        ];
        
        // Hiển thị view
        $this->view('errors/maintenance', $data);
    }
}
