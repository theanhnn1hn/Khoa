<?php
/**
 * Gallery Model - Quản lý dữ liệu thư viện ảnh
 * File: app/models/Gallery.php
 */

class Gallery extends Model {
    protected $table = 'gallery';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Lấy ảnh theo ID dịch vụ
     */
    public function getByServiceId($serviceId, $limit = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE service_id = :service_id ORDER BY id DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':service_id', $serviceId)
            ->fetchAll();
    }
    
    /**
     * Lấy ảnh theo loại
     */
    public function getByType($type, $limit = 0) {
        $sql = "SELECT g.*, s.name as service_name 
                FROM {$this->table} g 
                LEFT JOIN services s ON g.service_id = s.id 
                WHERE g.type = :type 
                ORDER BY g.id DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':type', $type)
            ->fetchAll();
    }
    
    /**
     * Lấy ảnh theo danh mục
     */
    public function getByCategory($category, $limit = 0) {
        $sql = "SELECT g.*, s.name as service_name 
                FROM {$this->table} g 
                LEFT JOIN services s ON g.service_id = s.id 
                WHERE g.category = :category 
                ORDER BY g.id DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':category', $category)
            ->fetchAll();
    }
    
    /**
     * Lấy ảnh nổi bật
     */
    public function getFeaturedImages($limit = 0) {
        $sql = "SELECT g.*, s.name as service_name 
                FROM {$this->table} g 
                LEFT JOIN services s ON g.service_id = s.id 
                WHERE g.featured = 1 
                ORDER BY g.id DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy ảnh trước và sau
     */
    public function getBeforeAfterImages($limit = 0) {
        return $this->getByType('before_after', $limit);
    }
    
    /**
     * Lấy ảnh không gian spa
     */
    public function getSpaInteriorImages($limit = 0) {
        return $this->getByType('spa_interior', $limit);
    }
    
    /**
     * Lấy ảnh dịch vụ
     */
    public function getServiceImages($limit = 0) {
        return $this->getByType('service', $limit);
    }
    
    /**
     * Tạo thư viện ảnh mới
     */
    public function addGalleryImage($data) {
        return $this->create($data);
    }
    
    /**
     * Cập nhật thông tin ảnh
     */
    public function updateGalleryImage($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Xóa ảnh
     */
    public function deleteGalleryImage($id) {
        // Lấy thông tin ảnh
        $image = $this->getById($id);
        
        if ($image) {
            // Đường dẫn đến file ảnh
            $imagePath = ROOT_PATH . '/assets/uploads/gallery/' . $image['image'];
            
            // Xóa file ảnh nếu tồn tại
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            // Xóa record trong database
            return $this->delete($id);
        }
        
        return false;
    }
    
    /**
     * Lấy tất cả danh mục
     */
    public function getAllCategories() {
        $sql = "SELECT DISTINCT category FROM {$this->table}";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy tất cả thư viện ảnh có phân trang
     */
    public function paginateGallery($page = 1, $perPage = 12, $type = null, $category = null) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT g.*, s.name as service_name 
                FROM {$this->table} g 
                LEFT JOIN services s ON g.service_id = s.id 
                WHERE 1=1";
                
        $params = [];
        
        if ($type) {
            $sql .= " AND g.type = :type";
            $params[':type'] = $type;
        }
        
        if ($category) {
            $sql .= " AND g.category = :category";
            $params[':category'] = $category;
        }
        
        $sql .= " ORDER BY g.id DESC LIMIT {$perPage} OFFSET {$offset}";
        
        $query = $this->db->query($sql);
        
        foreach ($params as $param => $value) {
            $query->bind($param, $value);
        }
        
        $items = $query->fetchAll();
        
        // Đếm tổng số bản ghi
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        
        if ($type) {
            $countSql .= " AND type = :type";
        }
        
        if ($category) {
            $countSql .= " AND category = :category";
        }
        
        $countQuery = $this->db->query($countSql);
        
        foreach ($params as $param => $value) {
            $countQuery->bind($param, $value);
        }
        
        $result = $countQuery->fetch();
        $total = $result['total'];
        
        $totalPages = ceil($total / $perPage);
        
        return [
            'items' => $items,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => $totalPages
        ];
    }
    
    /**
     * Tìm kiếm trong thư viện ảnh
     */
    public function searchGallery($keyword, $limit = 0) {
        $sql = "SELECT g.*, s.name as service_name 
                FROM {$this->table} g 
                LEFT JOIN services s ON g.service_id = s.id 
                WHERE g.title LIKE :keyword OR s.name LIKE :keyword 
                ORDER BY g.id DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':keyword', '%' . $keyword . '%')
            ->fetchAll();
    }
}
