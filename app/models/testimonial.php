<?php
/**
 * Testimonial Model - Quản lý dữ liệu đánh giá khách hàng
 * File: app/models/Testimonial.php
 */

class Testimonial extends Model {
    protected $table = 'testimonials';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Lấy đánh giá đã được phê duyệt
     */
    public function getApprovedTestimonials($limit = 0) {
        $sql = "SELECT t.*, s.name as service_name 
                FROM {$this->table} t 
                LEFT JOIN services s ON t.service_id = s.id 
                WHERE t.status = 'approved' 
                ORDER BY t.created_at DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy đánh giá theo dịch vụ
     */
    public function getByService($serviceId, $limit = 0) {
        $sql = "SELECT t.*, s.name as service_name 
                FROM {$this->table} t 
                LEFT JOIN services s ON t.service_id = s.id 
                WHERE t.service_id = :service_id AND t.status = 'approved' 
                ORDER BY t.created_at DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':service_id', $serviceId)
            ->fetchAll();
    }
    
    /**
     * Đếm số đánh giá theo dịch vụ
     */
    public function countByService($serviceId) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE service_id = :service_id AND status = 'approved'";
        $result = $this->db->query($sql)
            ->bind(':service_id', $serviceId)
            ->fetch();
        return $result['total'];
    }
    
    /**
     * Tính điểm đánh giá trung bình cho một dịch vụ
     */
    public function getAverageRatingByService($serviceId) {
        $sql = "SELECT AVG(rating) as average FROM {$this->table} WHERE service_id = :service_id AND status = 'approved'";
        $result = $this->db->query($sql)
            ->bind(':service_id', $serviceId)
            ->fetch();
        
        return $result['average'] ? round($result['average'], 1) : 0;
    }
    
    /**
     * Lấy top đánh giá (rating cao nhất)
     */
    public function getTopRatings($limit = 5) {
        $sql = "SELECT t.*, s.name as service_name 
                FROM {$this->table} t 
                LEFT JOIN services s ON t.service_id = s.id 
                WHERE t.status = 'approved' 
                ORDER BY t.rating DESC, t.created_at DESC 
                LIMIT {$limit}";
                
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Thêm đánh giá mới
     */
    public function addTestimonial($data) {
        // Đặt trạng thái mặc định là pending
        $data['status'] = 'pending';
        
        return $this->create($data);
    }
    
    /**
     * Lấy tất cả đánh giá đang chờ phê duyệt
     */
    public function getPendingTestimonials() {
        $sql = "SELECT t.*, s.name as service_name 
                FROM {$this->table} t 
                LEFT JOIN services s ON t.service_id = s.id 
                WHERE t.status = 'pending' 
                ORDER BY t.created_at ASC";
                
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Phê duyệt đánh giá
     */
    public function approveTestimonial($id) {
        $data = ['status' => 'approved'];
        return $this->update($id, $data);
    }
    
    /**
     * Từ chối đánh giá
     */
    public function rejectTestimonial($id) {
        $data = ['status' => 'rejected'];
        return $this->update($id, $data);
    }
    
    /**
     * Đếm tổng số đánh giá theo trạng thái
     */
    public function countByStatus($status) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = :status";
        $result = $this->db->query($sql)
            ->bind(':status', $status)
            ->fetch();
        return $result['total'];
    }
}
