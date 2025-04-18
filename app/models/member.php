<?php
/**
 * Member Model - Quản lý dữ liệu khách hàng thân thiết
 * File: app/models/Member.php
 */

class Member extends Model {
    protected $table = 'members';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Lấy thành viên theo email
     */
    public function getByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        return $this->db->query($sql)->bind(':email', $email)->fetch();
    }
    
    /**
     * Lấy thành viên theo số điện thoại
     */
    public function getByPhone($phone) {
        $sql = "SELECT * FROM {$this->table} WHERE phone = :phone LIMIT 1";
        return $this->db->query($sql)->bind(':phone', $phone)->fetch();
    }
    
    /**
     * Kiểm tra email đã tồn tại chưa
     */
    public function emailExists($email) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = :email";
        $result = $this->db->query($sql)->bind(':email', $email)->fetch();
        return $result['count'] > 0;
    }
    
    /**
     * Kiểm tra số điện thoại đã tồn tại chưa
     */
    public function phoneExists($phone) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE phone = :phone";
        $result = $this->db->query($sql)->bind(':phone', $phone)->fetch();
        return $result['count'] > 0;
    }
    
    /**
     * Lấy danh sách thành viên theo cấp bậc
     */
    public function getByLevel($level, $limit = 0, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE membership_level = :level AND status = 'active' ORDER BY registration_date DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset > 0) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->query($sql)->bind(':level', $level)->fetchAll();
    }
    
    /**
     * Lấy danh sách thành viên sắp hết hạn
     */
    public function getExpiringMembers($days = 30) {
        $expiryDate = date('Y-m-d', strtotime("+{$days} days"));
        
        $sql = "SELECT * FROM {$this->table} WHERE expiry_date <= :expiry_date AND status = 'active' ORDER BY expiry_date ASC";
        return $this->db->query($sql)->bind(':expiry_date', $expiryDate)->fetchAll();
    }
    
    /**
     * Cập nhật điểm thành viên
     */
    public function updatePoints($id, $points) {
        $sql = "UPDATE {$this->table} SET points = points + :points WHERE id = :id";
        return $this->db->query($sql)
            ->bind(':id', $id)
            ->bind(':points', $points)
            ->execute();
    }
    
    /**
     * Nâng cấp/hạ cấp cấp bậc thành viên
     */
    public function updateLevel($id, $level) {
        $data = [
            'membership_level' => $level,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($id, $data);
    }
    
    /**
     * Gia hạn thành viên
     */
    public function renewMembership($id, $months = 12) {
        // Lấy thông tin thành viên
        $member = $this->getById($id);
        
        if (!$member) {
            return false;
        }
        
        // Tính ngày hết hạn mới
        $currentExpiry = new DateTime($member['expiry_date']);
        $newExpiry = clone $currentExpiry;
        $newExpiry->modify("+{$months} months");
        
        // Cập nhật ngày hết hạn
        $data = [
            'expiry_date' => $newExpiry->format('Y-m-d'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($id, $data);
    }
    
    /**
     * Tìm kiếm thành viên
     */
    public function searchMembers($keyword, $limit = 0, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword) 
                ORDER BY registration_date DESC";
        
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
     * Đếm số thành viên theo cấp bậc
     */
    public function countByLevel($level) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE membership_level = :level AND status = 'active'";
        $result = $this->db->query($sql)->bind(':level', $level)->fetch();
        return $result['count'];
    }
    
    /**
     * Đếm tổng số thành viên đang hoạt động
     */
    public function countActiveMembers() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'active'";
        $result = $this->db->query($sql)->fetch();
        return $result['count'];
    }
    
    /**
     * Vô hiệu hóa thành viên
     */
    public function deactivateMember($id) {
        $data = [
            'status' => 'inactive',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($id, $data);
    }
    
    /**
     * Kích hoạt lại thành viên
     */
    public function activateMember($id) {
        $data = [
            'status' => 'active',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($id, $data);
    }
}
