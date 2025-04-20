<?php
/**
 * Blog Controller - Điều khiển trang blog
 * File: app/controllers/BlogController.php
 */

class BlogController extends \App\Core\Controller {
    private $blogModel;
    private $categoryModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->blogModel = $this->model('BlogPost');
        $this->categoryModel = $this->model('BlogCategory');
    }
    
    /**
     * Trang danh sách bài viết
     */
    public function index() {
        // Lấy tham số trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = ($page < 1) ? 1 : $page;
        $perPage = 6; // Số bài viết mỗi trang
        
        // Lấy danh sách bài viết có phân trang
        $result = $this->blogModel->paginate($page, $perPage, ['status' => 'published']);
        
        // Lấy danh sách danh mục
        $categories = $this->categoryModel->getAll('name ASC');
        
        // Lấy bài viết nổi bật
        $featuredPosts = $this->blogModel->getFeaturedPosts(3);
        
        // Lấy bài viết phổ biến nhất
        $popularPosts = $this->blogModel->getPopularPosts(4);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Blog - Luxury Head Spa',
            'page_description' => 'Blog kiến thức chăm sóc tóc và da đầu từ chuyên gia Luxury Head Spa',
            'posts' => $result['items'],
            'total' => $result['total'],
            'current_page' => $page,
            'total_pages' => $result['total_pages'],
            'categories' => $categories,
            'featured_posts' => $featuredPosts,
            'popular_posts' => $popularPosts
        ];
        
        // Hiển thị view
        $this->view('blog/index', $data);
    }
    
    /**
     * Trang chi tiết bài viết
     */
    public function show($params) {
        // Lấy slug từ URL
        $slug = isset($params['slug']) ? $params['slug'] : '';
        
        if (empty($slug)) {
            $this->redirect('/blog');
            exit;
        }
        
        // Lấy thông tin bài viết
        $post = $this->blogModel->getBySlug($slug);
        
        if (!$post) {
            $this->redirect('/error/404');
            exit;
        }
        
        // Tăng số lượt xem
        $this->blogModel->incrementViews($post['id']);
        
        // Lấy thông tin tác giả
        $author = $this->model('User')->getById($post['author_id']);
        
        // Lấy danh mục của bài viết
        $postCategories = $this->categoryModel->getCategoriesByPostId($post['id']);
        
        // Lấy bài viết liên quan
        $relatedPosts = $this->blogModel->getRelatedPosts($post['id'], 3);
        
        // Lấy bài viết trước và sau
        $prevPost = $this->blogModel->getPreviousPost($post['id']);
        $nextPost = $this->blogModel->getNextPost($post['id']);
        
        // Lấy danh sách danh mục
        $categories = $this->categoryModel->getAll('name ASC');
        
        // Lấy bài viết phổ biến nhất
        $popularPosts = $this->blogModel->getPopularPosts(4);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => $post['title'] . ' - Luxury Head Spa',
            'page_description' => $post['excerpt'] ? $post['excerpt'] : substr(strip_tags($post['content']), 0, 160),
            'post' => $post,
            'author' => $author,
            'post_categories' => $postCategories,
            'related_posts' => $relatedPosts,
            'prev_post' => $prevPost,
            'next_post' => $nextPost,
            'categories' => $categories,
            'popular_posts' => $popularPosts,
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        // Hiển thị view
        $this->view('blog/show', $data);
    }
    
    /**
     * Trang danh sách bài viết theo danh mục
     */
    public function category($params) {
        // Lấy slug danh mục từ URL
        $slug = isset($params['category']) ? $params['category'] : '';
        
        if (empty($slug)) {
            $this->redirect('/blog');
            exit;
        }
        
        // Lấy thông tin danh mục
        $category = $this->categoryModel->getBySlug($slug);
        
        if (!$category) {
            $this->redirect('/error/404');
            exit;
        }
        
        // Lấy tham số trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = ($page < 1) ? 1 : $page;
        $perPage = 6; // Số bài viết mỗi trang
        
        // Lấy danh sách bài viết theo danh mục
        $result = $this->blogModel->paginateByCategory($category['id'], $page, $perPage);
        
        // Lấy danh sách danh mục
        $categories = $this->categoryModel->getAll('name ASC');
        
        // Lấy bài viết phổ biến nhất
        $popularPosts = $this->blogModel->getPopularPosts(4);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => $category['name'] . ' - Blog - Luxury Head Spa',
            'page_description' => 'Danh sách bài viết trong danh mục ' . $category['name'],
            'category' => $category,
            'posts' => $result['items'],
            'total' => $result['total'],
            'current_page' => $page,
            'total_pages' => $result['total_pages'],
            'categories' => $categories,
            'popular_posts' => $popularPosts
        ];
        
        // Hiển thị view
        $this->view('blog/category', $data);
    }
    
    /**
     * Xử lý tìm kiếm bài viết
     */
    public function search() {
        // Lấy từ khóa tìm kiếm
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        if (empty($keyword)) {
            $this->redirect('/blog');
            exit;
        }
        
        // Lấy tham số trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = ($page < 1) ? 1 : $page;
        $perPage = 6; // Số bài viết mỗi trang
        
        // Tìm kiếm bài viết
        $result = $this->blogModel->search($keyword, $page, $perPage);
        
        // Lấy danh sách danh mục
        $categories = $this->categoryModel->getAll('name ASC');
        
        // Lấy bài viết phổ biến nhất
        $popularPosts = $this->blogModel->getPopularPosts(4);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Kết quả tìm kiếm: ' . $keyword . ' - Blog - Luxury Head Spa',
            'page_description' => 'Kết quả tìm kiếm cho: ' . $keyword,
            'keyword' => $keyword,
            'posts' => $result['items'],
            'total' => $result['total'],
            'current_page' => $page,
            'total_pages' => $result['total_pages'],
            'categories' => $categories,
            'popular_posts' => $popularPosts
        ];
        
        // Hiển thị view
        $this->view('blog/search', $data);
    }
    
    /**
     * Thêm bình luận vào bài viết
     */
    public function addComment() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/blog');
            exit;
        }
        
        // Lấy dữ liệu từ form
        $postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $content = isset($_POST['content']) ? trim($_POST['content']) : '';
        
        // Lấy thông tin bài viết
        $post = $this->blogModel->getById($postId);
        
        if (!$post) {
            $this->redirect('/blog');
            exit;
        }
        
        // Kiểm tra dữ liệu đầu vào
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Vui lòng nhập họ tên';
        }
        
        if (empty($email)) {
            $errors[] = 'Vui lòng nhập email';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ';
        }
        
        if (empty($content)) {
            $errors[] = 'Vui lòng nhập nội dung bình luận';
        }
        
        // Nếu có lỗi, chuyển hướng về trang chi tiết bài viết với thông báo lỗi
        if (!empty($errors)) {
            $this->setFlashMessage('error', $errors[0]);
            $this->redirect('/blog/' . $post['slug']);
            exit;
        }
        
        // Thêm bình luận
        $commentData = [
            'post_id' => $postId,
            'name' => $name,
            'email' => $email,
            'content' => $content,
            'status' => 'pending', // Bình luận cần được phê duyệt
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $commentModel = $this->model('Comment');
        $commentId = $commentModel->create($commentData);
        
        if ($commentId) {
            $this->setFlashMessage('success', 'Bình luận của bạn đã được gửi thành công và đang chờ phê duyệt.');
        } else {
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi gửi bình luận. Vui lòng thử lại sau.');
        }
        
        // Chuyển hướng về trang chi tiết bài viết
        $this->redirect('/blog/' . $post['slug']);
    }
    
    /**
     * Lấy danh sách tất cả các bài viết (dạng JSON) cho AJAX
     */
    public function getAllPosts() {
        // Lấy tất cả bài viết
        $posts = $this->blogModel->getAll('created_at DESC', 100);
        
        // Trả về dạng JSON
        header('Content-Type: application/json');
        echo json_encode($posts);
        exit;
    }
}
