<?php
/**
 * BlogCategory Model - Quản lý dữ liệu danh mục blog
 * File: app/models/BlogCategory.php
 */

class BlogCategory extends Model {
    protected $table = 'blog_categories';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Lấy danh mục theo slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug LIMIT 1";
        return $this->db->query($sql)->bind(':slug', $slug)->fetch();
    }
    
    /**
     * Lấy danh sách danh mục của một bài viết
     */
    public function getCategoriesByPostId($postId) {
        $sql = "SELECT c.* 
                FROM {$this->table} c
                JOIN blog_post_categories pc ON c.id = pc.category_id
                WHERE pc.post_id = :post_id";
                
        return $this->db->query($sql)->bind(':post_id', $postId)->fetchAll();
    }
    
    /**
     * Đếm số bài viết trong mỗi danh mục
     */
    public function countPostsByCategory() {
        $sql = "SELECT c.id, c.name, c.slug, COUNT(pc.post_id) as post_count
                FROM {$this->table} c
                LEFT JOIN blog_post_categories pc ON c.id = pc.category_id
                LEFT JOIN blog_posts p ON pc.post_id = p.id AND p.status = 'published'
                GROUP BY c.id, c.name, c.slug
                ORDER BY c.name ASC";
                
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy danh mục phổ biến nhất (có nhiều bài viết nhất)
     */
    public function getPopularCategories($limit = 5) {
        $sql = "SELECT c.id, c.name, c.slug, COUNT(pc.post_id) as post_count
                FROM {$this->table} c
                LEFT JOIN blog_post_categories pc ON c.id = pc.category_id
                LEFT JOIN blog_posts p ON pc.post_id = p.id AND p.status = 'published'
                GROUP BY c.id, c.name, c.slug
                ORDER BY post_count DESC, c.name ASC
                LIMIT {$limit}";
                
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Kiểm tra xem danh mục có tồn tại không
     */
    public function categoryExists($name, $excludeId = 0) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE name = :name";
        
        if ($excludeId > 0) {
            $sql .= " AND id != :exclude_id";
        }
        
        $query = $this->db->query($sql)->bind(':name', $name);
        
        if ($excludeId > 0) {
            $query->bind(':exclude_id', $excludeId);
        }
        
        $result = $query->fetch();
        
        return ($result['count'] > 0);
    }
    
    /**
     * Tạo slug từ tên danh mục
     */
    public function createSlug($name) {
        // Loại bỏ các ký tự đặc biệt và chuyển sang chữ thường
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $this->removeVietnameseAccents($name)), '-'));
        
        // Kiểm tra nếu slug đã tồn tại
        $originalSlug = $slug;
        $count = 0;
        
        while ($this->slugExists($slug)) {
            $count++;
            $slug = $originalSlug . '-' . $count;
        }
        
        return $slug;
    }
    
    /**
     * Kiểm tra xem slug đã tồn tại chưa
     */
    public function slugExists($slug, $excludeId = 0) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE slug = :slug";
        
        if ($excludeId > 0) {
            $sql .= " AND id != :exclude_id";
        }
        
        $query = $this->db->query($sql)->bind(':slug', $slug);
        
        if ($excludeId > 0) {
            $query->bind(':exclude_id', $excludeId);
        }
        
        $result = $query->fetch();
        
        return ($result['count'] > 0);
    }
    
    /**
     * Loại bỏ dấu tiếng Việt
     */
    private function removeVietnameseAccents($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }
    
    /**
     * Thêm danh mục mới
     */
    public function addCategory($data) {
        // Nếu không có slug, tạo slug từ tên
        if (!isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = $this->createSlug($data['name']);
        }
        
        return $this->create($data);
    }
    
    /**
     * Cập nhật danh mục
     */
    public function updateCategory($id, $data) {
        // Nếu không có slug, tạo slug từ tên
        if (!isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = $this->createSlug($data['name']);
        }
        
        return $this->update($id, $data);
    }
    
    /**
     * Xóa danh mục
     * Lưu ý: Cần xóa các liên kết với bài viết trước khi xóa danh mục
     */
    public function deleteCategory($id) {
        // Xóa tất cả liên kết với bài viết
        $sql = "DELETE FROM blog_post_categories WHERE category_id = :category_id";
        $this->db->query($sql)->bind(':category_id', $id)->execute();
        
        // Xóa danh mục
        return $this->delete($id);
    }
}
