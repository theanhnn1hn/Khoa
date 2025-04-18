<?php
/**
 * Staff Model - Quản lý dữ liệu nhân viên
 * File: app/models/Staff.php
 */

class Staff extends Model {
    protected $table = 'staff';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Lấy nhân viên nổi bật
     */
    public function getFeaturedStaff($limit = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE featured = 1 AND status = 'active' 
                ORDER BY id ASC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy tất cả nhân viên đang hoạt động
     */
    public function getAllActiveStaff() {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY name ASC";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy nhân viên theo ID
     */
    public function getStaffById($id) {
        return $this->getById($id);
    }
    
    /**
     * Lấy nhân viên theo chuyên môn
     */
    public function getStaffByExpertise($expertise, $limit = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE expertise LIKE :expertise AND status = 'active' 
                ORDER BY name ASC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':expertise', '%' . $expertise . '%')
            ->fetchAll();
    }
    
    /**
     * Thêm nhân viên mới
     */
    public function addStaff($data) {
        return $this->create($data);
    }
    
    /**
     * Cập nhật nhân viên
     */
    public function updateStaff($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Cập nhật trạng thái nhân viên
     */
    public function updateStatus($id, $status) {
        $data = ['status' => $status];
        return $this->update($id, $data);
    }
    
    /**
     * Cập nhật trạng thái nổi bật
     */
    public function updateFeatured($id, $featured) {
        $data = ['featured' => $featured];
        return $this->update($id, $data);
    }
    
    /**
     * Xóa nhân viên
     */
    public function deleteStaff($id) {
        return $this->delete($id);
    }
    
    /**
     * Đếm tổng số nhân viên theo trạng thái
     */
    public function countByStatus($status) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = :status";
        $result = $this->db->query($sql)
            ->bind(':status', $status)
            ->fetch();
        return $result['total'];
    }
    
    /**
     * Lấy các vị trí công việc hiện có
     */
    public function getAllPositions() {
        $sql = "SELECT DISTINCT position FROM {$this->table} ORDER BY position ASC";
        return $this->db->query($sql)->fetchAll();
    }
}
