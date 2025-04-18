<?php
/**
 * Class Database - Lớp xử lý kết nối và truy vấn database
 * File: app/core/Database.php
 */

class Database {
    private $connection;
    private static $instance = null;
    private $statement;
    private $config;

    /**
     * Constructor - Khởi tạo kết nối PDO đến database
     */
    private function __construct() {
        $this->config = require dirname(__DIR__) . '/config/database.php';
        
        $dsn = "mysql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['dbname']};charset={$this->config['charset']}";
        
        try {
            $this->connection = new PDO($dsn, $this->config['username'], $this->config['password'], $this->config['options']);
        } catch (PDOException $e) {
            throw new Exception('Không thể kết nối đến database: ' . $e->getMessage());
        }
    }

    /**
     * Singleton pattern - Trả về instance của Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Chuẩn bị câu query với prepared statement
     */
    public function query($sql) {
        $this->statement = $this->connection->prepare($sql);
        return $this;
    }

    /**
     * Bind các tham số vào prepared statement
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->statement->bindValue($param, $value, $type);
        return $this;
    }

    /**
     * Bind nhiều tham số cùng lúc
     */
    public function bindParams($params) {
        foreach ($params as $param => $value) {
            $this->bind($param, $value);
        }
        return $this;
    }

    /**
     * Thực thi câu query
     */
    public function execute() {
        return $this->statement->execute();
    }

    /**
     * Lấy tất cả kết quả
     */
    public function fetchAll() {
        $this->execute();
        return $this->statement->fetchAll();
    }

    /**
     * Lấy một kết quả
     */
    public function fetch() {
        $this->execute();
        return $this->statement->fetch();
    }

    /**
     * Đếm số dòng bị ảnh hưởng
     */
    public function rowCount() {
        return $this->statement->rowCount();
    }

    /**
     * Lấy ID cuối cùng được insert
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    /**
     * Bắt đầu transaction
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit() {
        return $this->connection->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollBack() {
        return $this->connection->rollBack();
    }

    /**
     * Debug thông tin câu query
     */
    public function debugDumpParams() {
        return $this->statement->debugDumpParams();
    }
    
    /**
     * Thực hiện câu INSERT
     */
    public function insert($table, $data) {
        $keys = array_keys($data);
        $values = array_values($data);
        
        $fields = '`' . implode('`, `', $keys) . '`';
        $placeholders = ':' . implode(', :', $keys);
        
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        
        $this->query($sql);
        
        foreach ($keys as $key) {
            $this->bind(':' . $key, $data[$key]);
        }
        
        if ($this->execute()) {
            return $this->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Thực hiện câu UPDATE
     */
    public function update($table, $data, $condition, $params = []) {
        $setStr = [];
        
        foreach ($data as $key => $value) {
            $setStr[] = "`{$key}` = :{$key}";
        }
        
        $setStr = implode(', ', $setStr);
        
        $sql = "UPDATE {$table} SET {$setStr} WHERE {$condition}";
        
        $this->query($sql);
        
        // Bind giá trị cho các field cần update
        foreach ($data as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        
        // Bind giá trị cho điều kiện WHERE
        foreach ($params as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        
        return $this->execute();
    }
    
    /**
     * Thực hiện câu DELETE
     */
    public function delete($table, $condition, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$condition}";
        
        $this->query($sql);
        
        foreach ($params as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        
        return $this->execute();
    }
    
    /**
     * Tạo một record nếu không tồn tại, update nếu có
     */
    public function insertOrUpdate($table, $data, $unique_fields) {
        // Tạo câu UPDATE cho phần ON DUPLICATE KEY UPDATE
        $update_str = '';
        foreach ($data as $key => $val) {
            // Bỏ qua các trường không cần update
            if (!in_array($key, $unique_fields)) {
                $update_str .= "`$key`=VALUES(`$key`), ";
            }
        }
        $update_str = rtrim($update_str, ', ');
        
        // Tạo câu INSERT
        $fields = '`' . implode('`, `', array_keys($data)) . '`';
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders}) ON DUPLICATE KEY UPDATE {$update_str}";
        
        $this->query($sql);
        
        foreach ($data as $key => $value) {
            $this->bind(':' . $key, $value);
        }
        
        return $this->execute();
    }
}
