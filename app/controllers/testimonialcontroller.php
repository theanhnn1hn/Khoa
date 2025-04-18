<?php
/**
 * Testimonial Controller - Điều khiển trang đánh giá
 * File: app/controllers/TestimonialController.php
 */

class TestimonialController extends Controller {
    private $testimonialModel;
    private $serviceModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->testimonialModel = $this->model('Testimonial');
        $this->serviceModel = $this->model('Service');
    }
    
    /**
     * Trang danh sách đánh giá
     */
    public function index() {
        // Lấy tham số trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = ($page < 1) ? 1 : $page;
        $perPage = 9; // Số đánh giá mỗi trang
        
        // Lấy dịch vụ nếu filter theo dịch vụ
        $serviceId = isset($_GET['service_id']) ? (int)$_GET['service_id'] : 0;
        
        // Lấy danh sách đánh giá đã được phê duyệt
        if ($serviceId > 0) {
            // Lấy đánh giá theo dịch vụ
            $service = $this->serviceModel->getById($serviceId);
            if (!$service) {
                $this->redirect('/danh-gia');
                exit;
            }
            
            $testimonials = [];
            $totalTestimonials = 0;
            $totalPages = 0;
            
            // Giả lập phân trang cho đánh giá theo dịch vụ
            $allTestimonials = $this->testimonialModel->getByService($serviceId);
            $totalTestimonials = count($allTestimonials);
            $totalPages = ceil($totalTestimonials / $perPage);
            
            // Lấy các đánh giá cho trang hiện tại
            $start = ($page - 1) * $perPage;
            $testimonials = array_slice($allTestimonials, $start, $perPage);
            
            $pageTitle = 'Đánh giá dịch vụ ' . $service['name'] . ' - Luxury Head Spa';
            $currentService = $service;
        } else {
            // Lấy tất cả đánh giá đã được phê duyệt
            $testimonials = $this->testimonialModel->getApprovedTestimonials(($page - 1) * $perPage, $perPage);
            $totalTestimonials = $this->testimonialModel->countByStatus('approved');
            $totalPages = ceil($totalTestimonials / $perPage);
            
            $pageTitle = 'Đánh giá từ khách hàng - Luxury Head Spa';
            $currentService = null;
        }
        
        // Lấy danh sách dịch vụ cho dropdown filter
        $services = $this->serviceModel->getActiveServices();
        
        // Lấy top đánh giá (rating cao nhất)
        $topRatings = $this->testimonialModel->getTopRatings(3);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => $pageTitle,
            'page_description' => 'Đánh giá từ khách hàng đã sử dụng dịch vụ tại Luxury Head Spa',
            'testimonials' => $testimonials,
            'services' => $services,
            'top_ratings' => $topRatings,
            'current_service' => $currentService,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_testimonials' => $totalTestimonials,
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        // Hiển thị view
        $this->view('testimonials/index', $data);
    }
    
    /**
     * Xử lý thêm đánh giá mới
     */
    public function store() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/danh-gia');
            exit;
        }
        
        // Lấy dữ liệu từ form
        $data = [
            'name' => $this->input('name'),
            'content' => $this->input('content'),
            'rating' => $this->input('rating'),
            'service_id' => $this->input('service_id', 0),
            'status' => 'pending', // Mặc định là chờ phê duyệt
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Kiểm tra dữ liệu đầu vào
        $errors = $this->validateTestimonialData($data);
        
        // Nếu có lỗi, trả về thông báo lỗi
        if (!empty($errors)) {
            $this->setFlashMessage('error', $errors[0]);
            
            // Chuyển hướng về trang danh sách đánh giá
            $this->redirect('/danh-gia');
            exit;
        }
        
        // Xử lý upload ảnh nếu có
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = $this->config['paths']['uploads'] . '/testimonials/';
            $result = $this->uploadFile($_FILES['image'], $uploadDir, ['jpg', 'jpeg', 'png', 'gif']);
            
            if ($result['success']) {
                $data['image'] = $result['file_name'];
            }
        }
        
        // Lưu đánh giá vào database
        $testimonialId = $this->testimonialModel->addTestimonial($data);
        
        if ($testimonialId) {
            $this->setFlashMessage('success', 'Cảm ơn bạn đã gửi đánh giá! Đánh giá của bạn đang chờ phê duyệt.');
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại sau.');
        }
        
        // Chuyển hướng về trang danh sách đánh giá
        $this->redirect('/danh-gia');
    }
    
    /**
     * Kiểm tra dữ liệu đánh giá
     */
    private function validateTestimonialData($data) {
        $errors = [];
        
        // Kiểm tra tên
        if (empty($data['name'])) {
            $errors[] = 'Vui lòng nhập họ tên';
        } elseif (strlen($data['name']) < 3) {
            $errors[] = 'Họ tên phải có ít nhất 3 ký tự';
        }
        
        // Kiểm tra nội dung
        if (empty($data['content'])) {
            $errors[] = 'Vui lòng nhập nội dung đánh giá';
        } elseif (strlen($data['content']) < 10) {
            $errors[] = 'Nội dung đánh giá phải có ít nhất 10 ký tự';
        }
        
        // Kiểm tra rating
        if (empty($data['rating']) || !is_numeric($data['rating']) || $data['rating'] < 1 || $data['rating'] > 5) {
            $errors[] = 'Vui lòng chọn đánh giá từ 1-5 sao';
        }
        
        // Kiểm tra dịch vụ nếu có
        if (!empty($data['service_id'])) {
            $service = $this->serviceModel->getById($data['service_id']);
            if (!$service) {
                $errors[] = 'Dịch vụ không tồn tại';
            }
        }
        
        return $errors;
    }
    
    /**
     * Trang cảm ơn sau khi gửi đánh giá thành công
     */
    public function thankyou() {
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Cảm ơn bạn đã gửi đánh giá - Luxury Head Spa',
            'page_description' => 'Cảm ơn bạn đã gửi đánh giá về dịch vụ tại Luxury Head Spa'
        ];
        
        // Hiển thị view
        $this->view('testimonials/thankyou', $data);
    }
}
