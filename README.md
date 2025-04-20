# Luxury Head Spa - Hướng dẫn cài đặt

## Yêu cầu hệ thống
- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)
- Composer

## Các bước cài đặt

1. **Clone project**
```bash
git clone [repository_url]
cd luxury-head-spa
```

2. **Cài đặt dependencies**
```bash
composer install
```

3. **Cấu hình database**
- Tạo database mới
- Import file `database-structure.sql`
- Cập nhật thông tin kết nối trong `app/config/database.php`

4. **Cấu hình website**
Chỉnh sửa file `app/config/config.php`:
```php
define('URLROOT', 'http://yourdomain.com');
define('SITENAME', 'Luxury Head Spa');
```

5. **Phân quyền thư mục**
```bash
chmod -R 755 public/
chmod -R 755 app/
```

6. **Tài khoản admin mặc định**
- Email: admin@luxuryheadspa.vn
- Password: admin123

## Kiểm tra trước khi chạy

1. **Kiểm tra database**
- Đảm bảo tất cả tables đã được tạo
- Kiểm tra kết nối trong `app/core/Database.php`

2. **Kiểm tra routes**
- Truy cập trang chủ: `/`
- Truy cập admin: `/admin`

3. **Kiểm tra tính năng chính**
- Đăng nhập admin
- Quản lý dịch vụ
- Đặt lịch hẹn

## Triển khai production

1. **Bảo mật**
- Đổi mật khẩu admin
- Cấu hình HTTPS
- Giới hạn quyền truy cập thư mục

2. **Tối ưu**
- Bật caching
- Enable OPcache
- Tối ưu database

## Xử lý lỗi thường gặp

1. **Lỗi kết nối database**
- Kiểm tra thông tin trong `app/config/database.php`
- Đảm bảo MySQL đang chạy

2. **Lỗi 404**
- Kiểm tra cấu hình rewrite URL
- Đảm bảo `.htaccess` hoạt động

3. **Lỗi permission**
- Kiểm tra quyền thư mục
- Chạy lại lệnh `chmod`
