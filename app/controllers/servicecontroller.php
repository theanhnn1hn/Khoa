<?php
/**
 * Service Controller - Điều khiển trang dịch vụ
 * File: app/controllers/ServiceController.php
 */

class ServiceController extends \App\Core\Controller {
    private $serviceModel;
    private $galleryModel;
    private $testimonialModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->serviceModel = $this->model('Service');
        $this->galleryModel = $this->model('Gallery');
        $this->testimonialModel = $this->model('Testimonial');
    }
    
    /**
     * Trang danh sách dịch vụ
     */
    public function index() {
        // Lấy danh sách danh mục dịch vụ
        $categories = $this->serviceModel->getAllCategories();
        
        // Lấy danh mục từ URL nếu có
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        
        // Lấy số trang
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        if ($page < 1) $page = 1;
        
        $perPage = 8; // Số dịch vụ mỗi trang
        
        // Lấy dịch vụ theo danh mục hoặc tất cả dịch vụ
        if (!empty($category)) {
            $result = $this->serviceModel->paginateByCategory($category, $page, $perPage);
            $totalServices = $this->serviceModel->countByCategory($category);
        } else {
            $result = $this->serviceModel->paginate($page, $perPage, ['status' => 'active']);
            $totalServices = $this->serviceModel->count(['status' => 'active']);
        }
        
        // Tính toán phân trang
        $totalPages = ceil($totalServices / $perPage);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Dịch vụ - Luxury Head Spa',
            'page_description' => 'Danh sách dịch vụ tại Luxury Head Spa - Spa tóc chuyên nghiệp',
            'services' => $result['items'],
            'categories' => $categories,
            'current_category' => $category,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_services' => $totalServices
        ];
        
        // Hiển thị view
        $this->view('services/index', $data);
    }
    
    /**
     * Trang chi tiết dịch vụ
     */
    public function show($params) {
        // Lấy slug từ URL
        $slug = isset($params['slug']) ? $params['slug'] : '';
        
        // Nếu không có slug, chuyển hướng về trang dịch vụ
        if (empty($slug)) {
            $this->redirect('/dich-vu');
            exit;
        }
        
        // Lấy thông tin dịch vụ theo slug
        $service = $this->serviceModel->getBySlug($slug);
        
        // Nếu không tìm thấy dịch vụ, chuyển hướng về trang dịch vụ
        if (!$service) {
            $this->redirect('/dich-vu');
            exit;
        }
        
        // Tăng lượt xem
        $this->serviceModel->incrementViews($service['id']);
        
        // Lấy ảnh gallery của dịch vụ
        $gallery = $this->galleryModel->getByServiceId($service['id']);
        
        // Lấy đánh giá của dịch vụ
        $testimonials = $this->testimonialModel->getByService($service['id'], 5);
        
        // Tính điểm đánh giá trung bình
        $averageRating = $this->testimonialModel->getAverageRatingByService($service['id']);
        
        // Lấy dịch vụ liên quan
        $relatedServices = $this->serviceModel->getRelatedServices($service['id'], $service['category'], 4);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => $service['name'] . ' - Luxury Head Spa',
            'page_description' => !empty($service['short_description']) ? $service['short_description'] : substr(strip_tags($service['description']), 0, 160),
            'service' => $service,
            'gallery' => $gallery,
            'testimonials' => $testimonials,
            'average_rating' => $averageRating,
            'related_services' => $relatedServices,
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        // Hiển thị view
        $this->view('services/show', $data);
    }
    
    /**
     * Trang danh sách dịch vụ theo danh mục
     */
    public function category($params) {
        // Lấy slug danh mục từ URL
        $categorySlug = isset($params['category']) ? $params['category'] : '';
        
        // Nếu không có slug danh mục, chuyển hướng về trang dịch vụ
        if (empty($categorySlug)) {
            $this->redirect('/dich-vu');
            exit;
        }
        
        // Chuyển đổi slug thành tên danh mục
        $category = str_replace('-', '_', $categorySlug);
        
        // Lấy danh sách dịch vụ theo danh mục
        $services = $this->serviceModel->getByCategory($category);
        
        // Lấy tất cả danh mục
        $categories = $this->serviceModel->getAllCategories();
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => ucfirst(str_replace('_', ' ', $category)) . ' - Luxury Head Spa',
            'page_description' => 'Dịch vụ ' . ucfirst(str_replace('_', ' ', $category)) . ' tại Luxury Head Spa - Spa tóc chuyên nghiệp',
            'services' => $services,
            'categories' => $categories,
            'current_category' => $category
        ];
        
        // Hiển thị view
        $this->view('services/category', $data);
    }
    
    /**
     * Thêm đánh giá cho dịch vụ
     */
    public function addTestimonial() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/dich-vu');
            exit;
        }
        
        // Lấy dữ liệu từ form
        $data = [
            'name' => $this->input('name'),
            'content' => $this->input('content'),
            'rating' => $this->input('rating'),
            'service_id' => $this->input('service_id'),
            'status' => 'pending', // Mặc định là chờ phê duyệt
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Xử lý upload ảnh nếu có
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = $this->config['paths']['uploads'] . '/testimonials/';
            $result = $this->uploadFile($_FILES['image'], $uploadDir, ['jpg', 'jpeg', 'png', 'gif']);
            
            if ($result['success']) {
                $data['image'] = $result['file_name'];
            }
        }
        
        // Lấy thông tin dịch vụ
        $service = $this->serviceModel->getById($data['service_id']);
        
        // Thêm đánh giá
        $testimonialId = $this->testimonialModel->addTestimonial($data);
        
        if ($testimonialId) {
            // Thiết lập thông báo flash
            $this->setFlashMessage('success', 'Cảm ơn bạn đã gửi đánh giá! Đánh giá của bạn đang chờ phê duyệt.');
            
            // Chuyển hướng về trang chi tiết dịch vụ
            $this->redirect('/dich-vu/' . $service['slug']);
        } else {
            // Thiết lập thông báo flash
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại sau.');
            
            // Chuyển hướng về trang chi tiết dịch vụ
            $this->redirect('/dich-vu/' . $service['slug']);
        }
    }
    
    /**
     * Đặt lịch nhanh từ trang chi tiết dịch vụ
     */
    public function quickBook() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/dich-vu');
            exit;
        }
        
        // Lấy dữ liệu từ form
        $serviceId = $this->input('service_id');
        
        // Chuyển hướng đến trang đặt lịch với service_id
        $this->redirect('/dat-lich?service_id=' . $serviceId);
        exit;
    }
}
