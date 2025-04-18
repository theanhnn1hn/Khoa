<?php
/**
 * ContactMessage Model - Quản lý dữ liệu tin nhắn liên hệ
 * File: app/models/ContactMessage.php
 */

class ContactMessage extends Model {
    protected $table = 'contact_messages';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Tạo tin nhắn liên hệ mới
     */
    public function createMessage($data) {
        return $this->create($data);
    }
    
    /**
     * Lấy thông tin tin nhắn theo ID
     */
    public function getMessageById($id) {
        return $this->getById($id);
    }
    
    /**
     * Lấy danh sách tin nhắn theo trạng thái
     */
    public function getMessagesByStatus($status, $limit = 0, $offset = 0) {
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
     * Đếm số lượng tin nhắn theo trạng thái
     */
    public function countMessagesByStatus($status) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = :status";
        $result = $this->db->query($sql)
            ->bind(':status', $status)
            ->fetch();
            
        return $result['total'];
    }
    
    /**
     * Cập nhật trạng thái tin nhắn
     */
    public function updateStatus($id, $status) {
        $data = ['status' => $status];
        return $this->update($id, $data);
    }
    
    /**
     * Lấy danh sách tin nhắn với phân trang
     */
    public function paginateMessages($page = 1, $perPage = 10, $status = null) {
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
     * Tìm kiếm trong danh sách tin nhắn
     */
    public function searchMessages($keyword, $limit = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE name LIKE :keyword 
                OR email LIKE :keyword 
                OR subject LIKE :keyword 
                OR message LIKE :keyword 
                ORDER BY created_at DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':keyword', '%' . $keyword . '%')
            ->fetchAll();
    }
    
    /**
     * Lấy số lượng tin nhắn chưa đọc
     */
    public function countUnreadMessages() {
        return $this->countMessagesByStatus('unread');
    }
    
    /**
     * Lấy các tin nhắn mới nhất
     */
    public function getLatestMessages($limit = 5) {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT {$limit}";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy tin nhắn theo email
     */
    public function getMessagesByEmail($email, $limit = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email ORDER BY created_at DESC";
        
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':email', $email)
            ->fetchAll();
    }
    
    /**
     * Xóa tin nhắn
     */
    public function deleteMessage($id) {
        return $this->delete($id);
    }
}
