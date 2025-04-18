<?php
/**
 * BlogPost Model - Quản lý dữ liệu bài viết blog
 * File: app/models/BlogPost.php
 */

class BlogPost extends Model {
    protected $table = 'blog_posts';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Lấy bài viết theo slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug AND status = 'published' LIMIT 1";
        return $this->db->query($sql)->bind(':slug', $slug)->fetch();
    }
    
    /**
     * Lấy bài viết nổi bật
     */
    public function getFeaturedPosts($limit = 3) {
        $sql = "SELECT bp.*, u.full_name as author_name 
                FROM {$this->table} bp
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE bp.status = 'published' 
                ORDER BY bp.created_at DESC 
                LIMIT {$limit}";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy bài viết phổ biến nhất (dựa trên lượt xem)
     */
    public function getPopularPosts($limit = 4) {
        $sql = "SELECT bp.*, u.full_name as author_name 
                FROM {$this->table} bp
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE bp.status = 'published' 
                ORDER BY bp.views DESC 
                LIMIT {$limit}";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy danh sách bài viết theo danh mục
     */
    public function getPostsByCategory($categoryId, $limit = 0) {
        $sql = "SELECT bp.*, u.full_name as author_name 
                FROM {$this->table} bp
                LEFT JOIN users u ON bp.author_id = u.id
                LEFT JOIN blog_post_categories bpc ON bp.id = bpc.post_id
                WHERE bp.status = 'published' AND bpc.category_id = :category_id
                ORDER BY bp.created_at DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)->bind(':category_id', $categoryId)->fetchAll();
    }
    
    /**
     * Phân trang bài viết theo danh mục
     */
    public function paginateByCategory($categoryId, $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT bp.*, u.full_name as author_name 
                FROM {$this->table} bp
                LEFT JOIN users u ON bp.author_id = u.id
                LEFT JOIN blog_post_categories bpc ON bp.id = bpc.post_id
                WHERE bp.status = 'published' AND bpc.category_id = :category_id
                ORDER BY bp.created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";
                
        $posts = $this->db->query($sql)->bind(':category_id', $categoryId)->fetchAll();
        
        // Đếm tổng số bài viết theo danh mục
        $countSql = "SELECT COUNT(*) as total 
                    FROM {$this->table} bp
                    LEFT JOIN blog_post_categories bpc ON bp.id = bpc.post_id
                    WHERE bp.status = 'published' AND bpc.category_id = :category_id";
                    
        $result = $this->db->query($countSql)->bind(':category_id', $categoryId)->fetch();
        $total = $result['total'];
        
        $totalPages = ceil($total / $perPage);
        
        return [
            'items' => $posts,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => $totalPages
        ];
    }
    
    /**
     * Tìm kiếm bài viết
     */
    public function search($keyword, $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT bp.*, u.full_name as author_name 
                FROM {$this->table} bp
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE bp.status = 'published' 
                AND (bp.title LIKE :keyword OR bp.content LIKE :keyword OR bp.excerpt LIKE :keyword)
                ORDER BY bp.created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";
                
        $posts = $this->db->query($sql)
            ->bind(':keyword', '%' . $keyword . '%')
            ->fetchAll();
        
        // Đếm tổng số bài viết tìm thấy
        $countSql = "SELECT COUNT(*) as total 
                    FROM {$this->table}
                    WHERE status = 'published' 
                    AND (title LIKE :keyword OR content LIKE :keyword OR excerpt LIKE :keyword)";
                    
        $result = $this->db->query($countSql)
            ->bind(':keyword', '%' . $keyword . '%')
            ->fetch();
        $total = $result['total'];
        
        $totalPages = ceil($total / $perPage);
        
        return [
            'items' => $posts,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => $totalPages
        ];
    }
    
    /**
     * Lấy bài viết liên quan
     */
    public function getRelatedPosts($postId, $limit = 3) {
        // Lấy danh mục của bài viết hiện tại
        $sql = "SELECT category_id FROM blog_post_categories WHERE post_id = :post_id";
        $categories = $this->db->query($sql)->bind(':post_id', $postId)->fetchAll();
        
        if (empty($categories)) {
            // Nếu không có danh mục, lấy bài viết ngẫu nhiên
            $sql = "SELECT bp.*, u.full_name as author_name 
                    FROM {$this->table} bp
                    LEFT JOIN users u ON bp.author_id = u.id
                    WHERE bp.status = 'published' AND bp.id != :post_id
                    ORDER BY RAND()
                    LIMIT {$limit}";
                    
            return $this->db->query($sql)->bind(':post_id', $postId)->fetchAll();
        }
        
        // Lấy ID của các danh mục
        $categoryIds = array_column($categories, 'category_id');
        $categoryIdStr = implode(',', $categoryIds);
        
        // Lấy bài viết cùng danh mục
        $sql = "SELECT DISTINCT bp.*, u.full_name as author_name 
                FROM {$this->table} bp
                LEFT JOIN users u ON bp.author_id = u.id
                LEFT JOIN blog_post_categories bpc ON bp.id = bpc.post_id
                WHERE bp.status = 'published' AND bp.id != :post_id
                AND bpc.category_id IN ({$categoryIdStr})
                ORDER BY bp.created_at DESC
                LIMIT {$limit}";
                
        return $this->db->query($sql)->bind(':post_id', $postId)->fetchAll();
    }
    
    /**
     * Lấy bài viết trước đó
     */
    public function getPreviousPost($postId) {
        $sql = "SELECT id, title, slug FROM {$this->table}
                WHERE status = 'published' AND id < :post_id
                ORDER BY id DESC
                LIMIT 1";
                
        return $this->db->query($sql)->bind(':post_id', $postId)->fetch();
    }
    
    /**
     * Lấy bài viết tiếp theo
     */
    public function getNextPost($postId) {
        $sql = "SELECT id, title, slug FROM {$this->table}
                WHERE status = 'published' AND id > :post_id
                ORDER BY id ASC
                LIMIT 1";
                
        return $this->db->query($sql)->bind(':post_id', $postId)->fetch();
    }
    
    /**
     * Tăng lượt xem bài viết
     */
    public function incrementViews($postId) {
        $sql = "UPDATE {$this->table} SET views = views + 1 WHERE id = :post_id";
        return $this->db->query($sql)->bind(':post_id', $postId)->execute();
    }
    
    /**
     * Thêm bài viết mới
     */
    public function addPost($data) {
        // Thêm bài viết
        $postId = $this->create($data);
        
        if (!$postId) {
            return false;
        }
        
        // Nếu có danh mục, thêm vào bảng liên kết
        if (isset($data['categories']) && is_array($data['categories'])) {
            foreach ($data['categories'] as $categoryId) {
                $this->addPostCategory($postId, $categoryId);
            }
        }
        
        return $postId;
    }
    
    /**
     * Cập nhật bài viết
     */
    public function updatePost($postId, $data) {
        // Cập nhật bài viết
        $updated = $this->update($postId, $data);
        
        if (!$updated) {
            return false;
        }
        
        // Nếu có danh mục, cập nhật bảng liên kết
        if (isset($data['categories']) && is_array($data['categories'])) {
            // Xóa tất cả danh mục hiện tại
            $this->removeAllPostCategories($postId);
            
            // Thêm danh mục mới
            foreach ($data['categories'] as $categoryId) {
                $this->addPostCategory($postId, $categoryId);
            }
        }
        
        return true;
    }
    
    /**
     * Thêm liên kết bài viết với danh mục
     */
    public function addPostCategory($postId, $categoryId) {
        $sql = "INSERT INTO blog_post_categories (post_id, category_id) VALUES (:post_id, :category_id)";
        return $this->db->query($sql)
            ->bind(':post_id', $postId)
            ->bind(':category_id', $categoryId)
            ->execute();
    }
    
    /**
     * Xóa tất cả liên kết danh mục của bài viết
     */
    public function removeAllPostCategories($postId) {
        $sql = "DELETE FROM blog_post_categories WHERE post_id = :post_id";
        return $this->db->query($sql)->bind(':post_id', $postId)->execute();
    }
    
    /**
     * Đếm số bài viết theo trạng thái
     */
    public function countByStatus($status) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = :status";
        $result = $this->db->query($sql)->bind(':status', $status)->fetch();
        return $result['total'];
    }
    
    /**
     * Lấy bài viết mới nhất
     */
    public function getLatestPosts($limit = 5) {
        $sql = "SELECT bp.*, u.full_name as author_name 
                FROM {$this->table} bp
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE bp.status = 'published' 
                ORDER BY bp.created_at DESC 
                LIMIT {$limit}";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Tìm kiếm bài viết (admin)
     */
    public function searchAdmin($keyword, $status = null) {
        $sql = "SELECT bp.*, u.full_name as author_name 
                FROM {$this->table} bp
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE (bp.title LIKE :keyword OR bp.content LIKE :keyword OR bp.excerpt LIKE :keyword)";
                
        if ($status !== null) {
            $sql .= " AND bp.status = :status";
        }
        
        $sql .= " ORDER BY bp.created_at DESC";
        
        $query = $this->db->query($sql)->bind(':keyword', '%' . $keyword . '%');
        
        if ($status !== null) {
            $query->bind(':status', $status);
        }
        
        return $query->fetchAll();
    }
}
