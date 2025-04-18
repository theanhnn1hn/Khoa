<?php
/**
 * Cấu hình kết nối Database
 * File: app/config/database.php
 */

return [
    // Thông tin kết nối Database
    'host'     => 'localhost',      // Thay đổi nếu cần
    'username' => 'root',           // Thay đổi thành username MySQL của bạn
    'password' => '',               // Thay đổi thành password MySQL của bạn
    'dbname'   => 'luxury_head_spa',
    'charset'  => 'utf8mb4',
    'port'     => 3306,
    
    // Cấu hình PDO
    'options' => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]
];
