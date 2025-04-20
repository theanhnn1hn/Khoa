<?php
/**
 * Base Model Class - Lớp Model cơ sở
 * File: app/core/Model.php
 */

namespace App\Core;

abstract class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    
    /**
     * Constructor - Khởi tạo kết nối đến database
     */
    public function __construct() {
        $this->db = \App\Core\Database::getInstance();
    }
    
    /**
     * Lấy tất cả bản ghi
     */
    public function getAll($orderBy = null, $limit = null, $offset = null) {
        $sql = "SELECT * FROM {$this->table}";
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Lấy một bản ghi theo ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        return $this->db->query($sql)->bind(':id', $id)->fetch();
    }
    
    /**
     * Tìm bản ghi theo điều kiện
     */
    public function findBy($field, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value";
        return $this->db->query($sql)->bind(':value', $value)->fetchAll();
    }
    
    /**
     * Tìm một bản ghi theo điều kiện
     */
    public function findOneBy($field, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value LIMIT 1";
        return $this->db->query($sql)->bind(':value', $value)->fetch();
    }
    
    /**
     * Tìm kiếm với nhiều điều kiện
     */
    public function findWhere($conditions = [], $orderBy = null, $limit = null, $offset = null) {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        foreach ($conditions as $field => $value) {
            $param = ':' . $field;
            $sql .= " AND {$field} = {$param}";
            $params[$param] = $value;
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        $query = $this->db->query($sql);
        
        foreach ($params as $param => $value) {
            $query->bind($param, $value);
        }
        
        return $query->fetchAll();
    }
    
    /**
     * Thêm bản ghi mới
     */
    public function create($data) {
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Cập nhật bản ghi
     */
    public function update($id, $data) {
        $condition = "{$this->primaryKey} = :id";
        $params = [':id' => $id];
        
        return $this->db->update($this->table, $data, $condition, $params);
    }
    
    /**
     * Xóa bản ghi
     */
    public function delete($id) {
        $condition = "{$this->primaryKey} = :id";
        $params = [':id' => $id];
        
        return $this->db->delete($this->table, $condition, $params);
    }
    
    /**
     * Đếm số bản ghi
     */
    public function count($conditions = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $params = [];
        
        foreach ($conditions as $field => $value) {
            $param = ':' . $field;
            $sql .= " AND {$field} = {$param}";
            $params[$param] = $value;
        }
        
        $query = $this->db->query($sql);
        
        foreach ($params as $param => $value) {
            $query->bind($param, $value);
        }
        
        $result = $query->fetch();
        return $result['total'];
    }
    
    /**
     * Phân trang
     */
    public function paginate($page = 1, $perPage = 10, $conditions = [], $orderBy = null) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        foreach ($conditions as $field => $value) {
            $param = ':' . $field;
            $sql .= " AND {$field} = {$param}";
            $params[$param] = $value;
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        $sql .= " LIMIT {$perPage} OFFSET {$offset}";
        
        $query = $this->db->query($sql);
        
        foreach ($params as $param => $value) {
            $query->bind($param, $value);
        }
        
        $items = $query->fetchAll();
        $total = $this->count($conditions);
        
        $totalPages = ceil($total / $perPage);
        
        return [
            'items'       => $items,
            'total'       => $total,
            'per_page'    => $perPage,
            'current_page'=> $page,
            'total_pages' => $totalPages,
            'has_more'    => ($page < $totalPages)
        ];
    }
    
    /**
     * Tìm kiếm
     */
    public function search($keyword, $fields, $orderBy = null, $limit = null, $offset = null) {
        $sql = "SELECT * FROM {$this->table} WHERE ";
        
        $conditions = [];
        foreach ($fields as $field) {
            $conditions[] = "{$field} LIKE :keyword";
        }
        
        $sql .= '(' . implode(' OR ', $conditions) . ')';
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->query($sql)
            ->bind(':keyword', '%' . $keyword . '%')
            ->fetchAll();
    }
    
    /**
     * Kiểm tra tồn tại
     */
    public function exists($field, $value) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE {$field} = :value LIMIT 1";
        $result = $this->db->query($sql)
            ->bind(':value', $value)
            ->fetch();
        
        return ($result['count'] > 0);
    }
}
