<?php
/**
 * Setting Model - Quản lý dữ liệu cài đặt hệ thống
 * File: app/models/Setting.php
 */

class Setting extends Model {
    protected $table = 'settings';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Lấy giá trị cài đặt theo tên
     */
    public function getByName($name) {
        $sql = "SELECT * FROM {$this->table} WHERE setting_name = :name LIMIT 1";
        $result = $this->db->query($sql)
            ->bind(':name', $name)
            ->fetch();
            
        return $result ? $result['setting_value'] : null;
    }
    
    /**
     * Lấy tất cả cài đặt theo nhóm
     */
    public function getSettingsByGroup($group) {
        $sql = "SELECT * FROM {$this->table} WHERE setting_group = :group";
        return $this->db->query($sql)
            ->bind(':group', $group)
            ->fetchAll();
    }
    
    /**
     * Lấy tất cả cài đặt dưới dạng key-value
     */
    public function getAllSettings() {
        $sql = "SELECT setting_name, setting_value FROM {$this->table}";
        $results = $this->db->query($sql)->fetchAll();
        
        $settings = [];
        foreach ($results as $result) {
            $settings[$result['setting_name']] = $result['setting_value'];
        }
        
        return $settings;
    }
    
    /**
     * Cập nhật giá trị cài đặt
     */
    public function updateSetting($name, $value) {
        // Kiểm tra cài đặt đã tồn tại chưa
        $sql = "SELECT id FROM {$this->table} WHERE setting_name = :name LIMIT 1";
        $result = $this->db->query($sql)
            ->bind(':name', $name)
            ->fetch();
            
        if ($result) {
            // Cập nhật cài đặt hiện có
            $data = [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            return $this->update($result['id'], $data);
        } else {
            // Thêm cài đặt mới
            $data = [
                'setting_name' => $name,
                'setting_value' => $value,
                'setting_group' => 'general'
            ];
            
            return $this->create($data);
        }
    }
    
    /**
     * Thêm cài đặt mới
     */
    public function addSetting($name, $value, $group = 'general') {
        $data = [
            'setting_name' => $name,
            'setting_value' => $value,
            'setting_group' => $group
        ];
        
        return $this->create($data);
    }
    
    /**
     * Cập nhật nhiều cài đặt cùng lúc
     */
    public function updateSettings($settings) {
        $success = true;
        
        foreach ($settings as $name => $value) {
            $result = $this->updateSetting($name, $value);
            if (!$result) {
                $success = false;
            }
        }
        
        return $success;
    }
    
    /**
     * Xóa cài đặt
     */
    public function deleteSetting($name) {
        $sql = "DELETE FROM {$this->table} WHERE setting_name = :name";
        return $this->db->query($sql)
            ->bind(':name', $name)
            ->execute();
    }
    
    /**
     * Lấy tất cả nhóm cài đặt
     */
    public function getAllGroups() {
        $sql = "SELECT DISTINCT setting_group FROM {$this->table}";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Chuyển đổi cài đặt từ dạng mảng thành dạng key-value
     */
    public function convertSettingsToKeyValue($settings) {
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_name']] = $setting['setting_value'];
        }
        return $result;
    }
}
