<?php
/**
 * Gallery Controller - Điều khiển trang thư viện ảnh
 * File: app/controllers/GalleryController.php
 */

class GalleryController extends Controller {
    private $galleryModel;
    private $serviceModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->galleryModel = $this->model('Gallery');
        $this->serviceModel = $this->model('Service');
    }
    
    /**
     * Trang thư viện ảnh
     */
    public function index() {
        // Lấy tham số trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = ($page < 1) ? 1 : $page;
        
        // Lấy loại ảnh (nếu có)
        $type = isset($_GET['type']) ? $_GET['type'] : null;
        
        // Lấy ảnh có phân trang
        $perPage = 12;
        $result = $this->galleryModel->paginateGallery($page, $perPage, $type);
        
        // Lấy danh sách loại ảnh
        $categories = $this->galleryModel->getAllCategories();
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Thư viện ảnh - Luxury Head Spa',
            'page_description' => 'Thư viện ảnh của Luxury Head Spa - Không gian và kết quả điều trị',
            'gallery' => $result['items'],
            'total' => $result['total'],
            'current_page' => $page,
            'total_pages' => $result['total_pages'],
            'type' => $type,
            'categories' => $categories
        ];
        
        // Hiển thị view
        $this->view('gallery/index', $data);
    }
    
    /**
     * Trang thư viện ảnh theo danh mục
     */
    public function category($params) {
        // Lấy danh mục từ URL
        $category = isset($params['category']) ? $params['category'] : '';
        
        if (empty($category)) {
            $this->redirect('/thu-vien-anh');
            exit;
        }
        
        // Lấy tham số trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = ($page < 1) ? 1 : $page;
        
        // Lấy ảnh theo danh mục có phân trang
        $perPage = 12;
        $result = $this->galleryModel->paginateGallery($page, $perPage, null, $category);
        
        // Lấy danh sách danh mục
        $categories = $this->galleryModel->getAllCategories();
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => ucfirst($category) . ' - Thư viện ảnh - Luxury Head Spa',
            'page_description' => 'Thư viện ảnh ' . $category . ' của Luxury Head Spa',
            'gallery' => $result['items'],
            'total' => $result['total'],
            'current_page' => $page,
            'total_pages' => $result['total_pages'],
            'current_category' => $category,
            'categories' => $categories
        ];
        
        // Hiển thị view
        $this->view('gallery/category', $data);
    }
    
    /**
     * Trang chi tiết ảnh
     */
    public function show($params) {
        // Lấy ID ảnh từ URL
        $id = isset($params['id']) ? (int)$params['id'] : 0;
        
        if ($id === 0) {
            $this->redirect('/thu-vien-anh');
            exit;
        }
        
        // Lấy thông tin ảnh
        $image = $this->galleryModel->getById($id);
        
        if (!$image) {
            $this->redirect('/thu-vien-anh');
            exit;
        }
        
        // Lấy ảnh liên quan
        $relatedImages = $this->galleryModel->getByCategory($image['category'], 6);
        
        // Nếu có service_id, lấy thông tin dịch vụ
        $service = null;
        if (!empty($image['service_id'])) {
            $service = $this->serviceModel->getById($image['service_id']);
        }
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => $image['title'] . ' - Thư viện ảnh - Luxury Head Spa',
            'page_description' => 'Chi tiết ảnh ' . $image['title'] . ' tại Luxury Head Spa',
            'image' => $image,
            'related_images' => $relatedImages,
            'service' => $service
        ];
        
        // Hiển thị view
        $this->view('gallery/show', $data);
    }
    
    /**
     * Trang ảnh trước & sau điều trị
     */
    public function beforeAfter() {
        // Lấy tham số trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = ($page < 1) ? 1 : $page;
        
        // Lấy ảnh trước & sau có phân trang
        $perPage = 12;
        $result = $this->galleryModel->paginateGallery($page, $perPage, 'before_after');
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Trước & Sau điều trị - Luxury Head Spa',
            'page_description' => 'Hình ảnh trước và sau khi điều trị tại Luxury Head Spa',
            'gallery' => $result['items'],
            'total' => $result['total'],
            'current_page' => $page,
            'total_pages' => $result['total_pages'],
            'type' => 'before_after'
        ];
        
        // Hiển thị view
        $this->view('gallery/before_after', $data);
    }
    
    /**
     * Trang ảnh không gian spa
     */
    public function spaInterior() {
        // Lấy tham số trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = ($page < 1) ? 1 : $page;
        
        // Lấy ảnh không gian spa có phân trang
        $perPage = 12;
        $result = $this->galleryModel->paginateGallery($page, $perPage, 'spa_interior');
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Không gian Spa - Luxury Head Spa',
            'page_description' => 'Hình ảnh không gian sang trọng tại Luxury Head Spa',
            'gallery' => $result['items'],
            'total' => $result['total'],
            'current_page' => $page,
            'total_pages' => $result['total_pages'],
            'type' => 'spa_interior'
        ];
        
        // Hiển thị view
        $this->view('gallery/spa_interior', $data);
    }
}
