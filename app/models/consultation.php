<?php
/**
 * Consultation Model - Quản lý dữ liệu tư vấn
 * File: app/models/Consultation.php
 */

class Consultation extends Model {
    protected $table = 'consultations';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Tạo yêu cầu tư vấn mới
     */
    public function createConsultation($data) {
        return $this->create($data);
    }
    
    /**
     * Lấy thông tin tư vấn theo ID
     */
    public function getConsultationById($id) {
        return $this->getById($id);
    }
    
    /**
     * Lấy danh sách tư vấn theo trạng thái
     */
    public function getConsultationsByStatus($status, $limit = 0, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE status = :status ORDER BY created_at DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset > 0) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->query($sql)
            ->bind(':status', $status)
            ->fetchAll();
    }
    
    /**
     * Đếm số lượng tư vấn theo trạng thái
     */
    public function countConsultationsByStatus($status) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = :status";
        $result = $this->db->query($sql)
            ->bind(':status', $status)
            ->fetch();
            
        return $result['total'];
    }
    
    /**
     * Cập nhật trạng thái tư vấn
     */
    public function updateStatus($id, $status) {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($id, $data);
    }
    
    /**
     * Cập nhật gợi ý dịch vụ
     */
    public function updateRecommendation($id, $recommendation) {
        $data = [
            'recommendation' => $recommendation,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($id, $data);
    }
    
    /**
     * Lấy danh sách tư vấn theo số điện thoại
     */
    public function getConsultationsByPhone($phone, $limit = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE phone = :phone ORDER BY created_at DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':phone', $phone)
            ->fetchAll();
    }
    
    /**
     * Lấy danh sách tư vấn với phân trang
     */
    public function paginateConsultations($page = 1, $perPage = 10, $status = null) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        if ($status) {
            $sql .= " AND status = :status";
            $params[':status'] = $status;
        }
        
        $sql .= " ORDER BY created_at DESC LIMIT {$perPage} OFFSET {$offset}";
        
        $query = $this->db->query($sql);
        
        foreach ($params as $param => $value) {
            $query->bind($param, $value);
        }
        
        $items = $query->fetchAll();
        
        // Đếm tổng số bản ghi
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        
        if ($status) {
            $countSql .= " AND status = :status";
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
     * Tìm kiếm trong danh sách tư vấn
     */
    public function searchConsultations($keyword, $limit = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE name LIKE :keyword 
                OR phone LIKE :keyword 
                OR email LIKE :keyword 
                OR hair_condition LIKE :keyword 
                ORDER BY created_at DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':keyword', '%' . $keyword . '%')
            ->fetchAll();
    }
    
    /**
     * Lấy số lượng tư vấn trong 7 ngày gần đây
     */
    public function getRecentConsultationsCount() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} 
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                
        $result = $this->db->query($sql)->fetch();
        return $result['total'];
    }
    
    /**
     * Lấy tư vấn mới nhất
     */
    public function getLatestConsultations($limit = 5) {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT {$limit}";
        return $this->db->query($sql)->fetchAll();
    }
}
