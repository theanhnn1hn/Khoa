<?php
/**
 * Search Controller - Điều khiển trang tìm kiếm
 * File: app/controllers/SearchController.php
 */

class SearchController extends Controller {
    private $serviceModel;
    private $blogModel;
    private $galleryModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->serviceModel = $this->model('Service');
        $this->blogModel = $this->model('BlogPost');
        $this->galleryModel = $this->model('Gallery');
    }
    
    /**
     * Trang kết quả tìm kiếm
     */
    public function index() {
        // Lấy từ khóa tìm kiếm
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        if (empty($keyword)) {
            $this->redirect('/');
            exit;
        }
        
        // Lấy loại tìm kiếm (mặc định là tất cả)
        $type = isset($_GET['type']) ? $_GET['type'] : 'all';
        
        // Lấy tham số trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = ($page < 1) ? 1 : $page;
        $perPage = 12; // Số kết quả mỗi trang
        
        // Khởi tạo biến lưu kết quả
        $services = [];
        $blogPosts = [];
        $gallery = [];
        $totalResults = 0;
        $totalPages = 0;
        
        // Tìm kiếm theo từng loại
        switch ($type) {
            case 'services':
                // Tìm kiếm trong dịch vụ
                $services = $this->serviceModel->search($keyword, $perPage, ($page - 1) * $perPage);
                $totalResults = $this->serviceModel->countSearchResults($keyword);
                $totalPages = ceil($totalResults / $perPage);
                break;
                
            case 'blog':
                // Tìm kiếm trong bài viết
                $result = $this->blogModel->search($keyword, $page, $perPage);
                $blogPosts = $result['items'];
                $totalResults = $result['total'];
                $totalPages = $result['total_pages'];
                break;
                
            case 'gallery':
                // Tìm kiếm trong thư viện ảnh
                $gallery = $this->galleryModel->searchGallery($keyword, $perPage, ($page - 1) * $perPage);
                $totalResults = count($gallery); // Giả lập đếm kết quả
                $totalPages = ceil($totalResults / $perPage);
                break;
                
            default:
                // Tìm kiếm tất cả
                $services = $this->serviceModel->search($keyword, 4);
                $blogResult = $this->blogModel->search($keyword, 1, 4);
                $blogPosts = $blogResult['items'];
                $gallery = $this->galleryModel->searchGallery($keyword, 4);
                
                // Tính tổng số kết quả
                $totalServices = $this->serviceModel->countSearchResults($keyword);
                $totalBlogPosts = $blogResult['total'];
                $totalGallery = count($this->galleryModel->searchGallery($keyword)); // Giả lập đếm tất cả kết quả
                
                $totalResults = $totalServices + $totalBlogPosts + $totalGallery;
                $totalPages = 1; // Không phân trang khi tìm kiếm tất cả
                break;
        }
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Kết quả tìm kiếm: ' . $keyword . ' - Luxury Head Spa',
            'page_description' => 'Kết quả tìm kiếm cho từ khóa: ' . $keyword,
            'keyword' => $keyword,
            'type' => $type,
            'services' => $services,
            'blog_posts' => $blogPosts,
            'gallery' => $gallery,
            'total_results' => $totalResults,
            'current_page' => $page,
            'total_pages' => $totalPages
        ];
        
        // Hiển thị view
        $this->view('search/index', $data);
    }
}
