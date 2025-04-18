<?php
/**
 * Banner Model - Quản lý dữ liệu banner và slider
 * File: app/models/Banner.php
 */

class Banner extends Model {
    protected $table = 'banners';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Lấy banner theo trang
     */
    public function getBannersByPage($page) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE page = :page AND status = 'active' 
                ORDER BY position ASC";
                
        return $this->db->query($sql)
            ->bind(':page', $page)
            ->fetchAll();
    }
    
    /**
     * Lấy tất cả banner
     */
    public function getAllBanners() {
        $sql = "SELECT * FROM {$this->table} ORDER BY page, position ASC";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy danh sách trang
     */
    public function getAllPages() {
        $sql = "SELECT DISTINCT page FROM {$this->table}";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Cập nhật vị trí banner
     */
    public function updatePosition($id, $position) {
        $data = ['position' => $position];
        return $this->update($id, $data);
    }
    
    /**
     * Cập nhật trạng thái banner
     */
    public function updateStatus($id, $status) {
        $data = ['status' => $status];
        return $this->update($id, $data);
    }
    
    /**
     * Lấy banner theo ID
     */
    public function getBannerById($id) {
        return $this->getById($id);
    }
    
    /**
     * Thêm banner mới
     */
    public function addBanner($data) {
        return $this->create($data);
    }
    
    /**
     * Cập nhật banner
     */
    public function updateBanner($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Xóa banner
     */
    public function deleteBanner($id) {
        return $this->delete($id);
    }
}
