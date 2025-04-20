<?php
/**
 * About Controller - Điều khiển trang giới thiệu
 * File: app/controllers/AboutController.php
 */

class AboutController extends \App\Core\Controller {
    private $staffModel;
    private $testimonialModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->staffModel = $this->model('Staff');
        $this->testimonialModel = $this->model('Testimonial');
    }
    
    /**
     * Trang giới thiệu
     */
    public function index() {
        // Lấy danh sách nhân viên
        $staff = $this->staffModel->getAllActiveStaff();
        
        // Lấy top đánh giá
        $testimonials = $this->testimonialModel->getTopRatings(3);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Giới thiệu - Luxury Head Spa',
            'page_description' => 'Giới thiệu về Luxury Head Spa - Spa tóc cao cấp tại Việt Nam',
            'staff' => $staff,
            'testimonials' => $testimonials
        ];
        
        // Hiển thị view
        $this->view('about/index', $data);
    }
    
    /**
     * Trang đội ngũ chuyên gia
     */
    public function team() {
        // Lấy danh sách nhân viên
        $staff = $this->staffModel->getAllActiveStaff();
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Đội ngũ chuyên gia - Luxury Head Spa',
            'page_description' => 'Đội ngũ chuyên gia tại Luxury Head Spa - Spa tóc cao cấp tại Việt Nam',
            'staff' => $staff
        ];
        
        // Hiển thị view
        $this->view('about/team', $data);
    }
    
    /**
     * Trang lịch sử phát triển
     */
    public function history() {
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Lịch sử phát triển - Luxury Head Spa',
            'page_description' => 'Lịch sử phát triển của Luxury Head Spa - Spa tóc cao cấp tại Việt Nam'
        ];
        
        // Hiển thị view
        $this->view('about/history', $data);
    }
    
    /**
     * Trang giá trị cốt lõi
     */
    public function values() {
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Giá trị cốt lõi - Luxury Head Spa',
            'page_description' => 'Giá trị cốt lõi của Luxury Head Spa - Spa tóc cao cấp tại Việt Nam'
        ];
        
        // Hiển thị view
        $this->view('about/values', $data);
    }
    
    /**
     * Trang chính sách bảo mật
     */
    public function privacy() {
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Chính sách bảo mật - Luxury Head Spa',
            'page_description' => 'Chính sách bảo mật tại Luxury Head Spa - Spa tóc cao cấp tại Việt Nam'
        ];
        
        // Hiển thị view
        $this->view('about/privacy', $data);
    }
    
    /**
     * Trang điều khoản sử dụng
     */
    public function terms() {
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Điều khoản sử dụng - Luxury Head Spa',
            'page_description' => 'Điều khoản sử dụng tại Luxury Head Spa - Spa tóc cao cấp tại Việt Nam'
        ];
        
        // Hiển thị view
        $this->view('about/terms', $data);
    }
}
