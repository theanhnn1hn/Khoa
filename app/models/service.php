<?php
/**
 * Service Model - Quản lý dữ liệu dịch vụ
 * File: app/models/Service.php
 */

class Service extends Model {
    protected $table = 'services';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Lấy các dịch vụ được đánh dấu là nổi bật
     */
    public function getFeaturedServices($limit = 4) {
        $sql = "SELECT * FROM {$this->table} WHERE featured = 1 AND status = 'active' ORDER BY id DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy dịch vụ theo slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug AND status = 'active' LIMIT 1";
        return $this->db->query($sql)->bind(':slug', $slug)->fetch();
    }
    
    /**
     * Lấy dịch vụ theo danh mục
     */
    public function getByCategory($category, $limit = 0, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE category = :category AND status = 'active' ORDER BY id DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset > 0) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->query($sql)->bind(':category', $category)->fetchAll();
    }
    
    /**
     * Đếm số dịch vụ theo danh mục
     */
    public function countByCategory($category) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE category = :category AND status = 'active'";
        $result = $this->db->query($sql)->bind(':category', $category)->fetch();
        return $result['total'];
    }
    
    /**
     * Lấy tất cả danh mục dịch vụ
     */
    public function getAllCategories() {
        $sql = "SELECT DISTINCT category FROM {$this->table} WHERE status = 'active'";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Tìm kiếm dịch vụ
     */
    public function search($keyword, $limit = 0, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (name LIKE :keyword OR description LIKE :keyword OR short_description LIKE :keyword) 
                AND status = 'active' 
                ORDER BY id DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset > 0) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->query($sql)
            ->bind(':keyword', '%' . $keyword . '%')
            ->fetchAll();
    }
    
    /**
     * Đếm số kết quả tìm kiếm
     */
    public function countSearchResults($keyword) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} 
                WHERE (name LIKE :keyword OR description LIKE :keyword OR short_description LIKE :keyword) 
                AND status = 'active'";
                
        $result = $this->db->query($sql)
            ->bind(':keyword', '%' . $keyword . '%')
            ->fetch();
            
        return $result['total'];
    }
    
    /**
     * Lấy dịch vụ liên quan
     */
    public function getRelatedServices($serviceId, $category, $limit = 4) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE id != :id AND category = :category AND status = 'active' 
                ORDER BY RAND() 
                LIMIT {$limit}";
                
        return $this->db->query($sql)
            ->bind(':id', $serviceId)
            ->bind(':category', $category)
            ->fetchAll();
    }
    
    /**
     * Lấy các dịch vụ phổ biến nhất
     */
    public function getPopularServices($limit = 5) {
        // Giả sử có trường views để theo dõi lượt xem
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY views DESC LIMIT {$limit}";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Tăng lượt xem cho dịch vụ
     */
    public function incrementViews($id) {
        $sql = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
        return $this->db->query($sql)->bind(':id', $id)->execute();
    }
}
