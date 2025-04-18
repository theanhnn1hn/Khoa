<?php
/**
 * Home Controller - Điều khiển trang chủ
 * File: app/controllers/HomeController.php
 */

class HomeController extends Controller {
    private $serviceModel;
    private $testimonialModel;
    private $bannerModel;
    private $staffModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->serviceModel = $this->model('Service');
        $this->testimonialModel = $this->model('Testimonial');
        $this->bannerModel = $this->model('Banner');
        $this->staffModel = $this->model('Staff');
    }
    
    /**
     * Trang chủ
     */
    public function index() {
        // Lấy dịch vụ nổi bật
        $featuredServices = $this->serviceModel->getFeaturedServices(4);
        
        // Lấy đánh giá đã được phê duyệt
        $testimonials = $this->testimonialModel->getApprovedTestimonials(6);
        
        // Lấy banner cho trang chủ
        $banners = $this->bannerModel->getBannersByPage('home');
        
        // Lấy nhân viên nổi bật
        $featuredStaff = $this->staffModel->getFeaturedStaff(3);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Trang chủ - Luxury Head Spa',
            'featured_services' => $featuredServices,
            'testimonials' => $testimonials,
            'banners' => $banners,
            'featured_staff' => $featuredStaff,
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        // Hiển thị view
        $this->view('home/index', $data);
    }
}
