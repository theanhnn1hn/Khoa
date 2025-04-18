-- Tạo database
CREATE DATABASE IF NOT EXISTS luxury_head_spa;
USE luxury_head_spa;

-- Bảng người dùng (admin và nhân viên)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng dịch vụ
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    short_description VARCHAR(255),
    price DECIMAL(10, 2) NOT NULL,
    duration INT NOT NULL COMMENT 'Thời gian thực hiện (phút)',
    image VARCHAR(255),
    category VARCHAR(50) NOT NULL,
    featured TINYINT(1) DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng đặt lịch
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    service_id INT,
    date DATE NOT NULL,
    time TIME NOT NULL,
    notes TEXT,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL
);

-- Bảng tư vấn
CREATE TABLE consultations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    hair_condition TEXT,
    wishes TEXT,
    recommendation TEXT,
    status ENUM('pending', 'processed', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng đánh giá khách hàng
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    image VARCHAR(255),
    service_id INT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL
);

-- Bảng khách hàng thân thiết
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    membership_level ENUM('silver', 'gold', 'platinum') DEFAULT 'silver',
    points INT DEFAULT 0,
    registration_date DATE NOT NULL,
    benefits TEXT,
    expiry_date DATE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng bài viết blog
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    image VARCHAR(255),
    excerpt VARCHAR(255),
    author_id INT,
    views INT DEFAULT 0,
    status ENUM('published', 'draft') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Bảng danh mục blog
CREATE TABLE blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng liên kết bài viết và danh mục
CREATE TABLE blog_post_categories (
    post_id INT,
    category_id INT,
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE CASCADE
);

-- Bảng thư viện ảnh
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    image VARCHAR(255) NOT NULL,
    category VARCHAR(50),
    type ENUM('before_after', 'spa_interior', 'service') DEFAULT 'service',
    service_id INT,
    featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL
);

-- Bảng nhân viên
CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    bio TEXT,
    image VARCHAR(255),
    expertise TEXT,
    featured TINYINT(1) DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng cài đặt hệ thống
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_name VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_group VARCHAR(50) DEFAULT 'general',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng banner và slider
CREATE TABLE banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    image VARCHAR(255) NOT NULL,
    button_text VARCHAR(50),
    button_link VARCHAR(255),
    position INT DEFAULT 0,
    page VARCHAR(50) DEFAULT 'home',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng thông tin liên hệ
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Chèn dữ liệu mẫu - Admin mặc định
INSERT INTO users (username, password, full_name, email, phone, role, status) 
VALUES ('admin', '$2y$10$uVZpxHsFOnL.Fm/6O9QW3OyjPXnw0qfDjLd7yHZ0ReFrjBVsn0ZZS', 'Admin User', 'admin@luxuryheadspa.vn', '0901234567', 'admin', 'active');
-- Mật khẩu: admin123 (đã hash với bcrypt)

-- Chèn dữ liệu mẫu - Các dịch vụ
INSERT INTO services (name, slug, description, short_description, price, duration, image, category, featured) VALUES
('Gội đầu dưỡng sinh', 'goi-dau-duong-sinh', 'Dịch vụ gội đầu dưỡng sinh sử dụng các thảo dược tự nhiên giúp lưu thông khí huyết, giảm stress và căng thẳng. Kết hợp massage bấm huyệt giúp máu lưu thông tốt hơn, làm dịu tinh thần.', 'Gội đầu thư giãn với thảo dược tự nhiên, massage bấm huyệt giúp lưu thông khí huyết', 250000, 45, 'service-1.jpg', 'head-spa', 1),
('Gội Head Spa Hàn Quốc', 'goi-head-spa-han-quoc', 'Trải nghiệm quy trình gội đầu đẳng cấp từ Hàn Quốc với 9 bước chuyên nghiệp. Làm sạch sâu, cung cấp dưỡng chất cho da đầu và tóc, giúp tóc chắc khỏe và bóng mượt.', 'Quy trình 9 bước chuyên nghiệp, sử dụng công nghệ và sản phẩm cao cấp từ Hàn Quốc', 350000, 60, 'service-2.jpg', 'head-spa', 1),
('Trị rụng tóc chuyên sâu', 'tri-rung-toc-chuyen-sau', 'Điều trị rụng tóc bằng công nghệ tiên tiến, kết hợp máy ánh sáng sinh học và serum kích thích mọc tóc. Phương pháp không xâm lấn, hiệu quả sau 3-5 liệu trình.', 'Điều trị chuyên sâu dành cho tóc rụng nhiều, sử dụng công nghệ ánh sáng sinh học', 500000, 75, 'service-3.jpg', 'treatment', 1),
('Nhuộm tóc Nhật Bản', 'nhuom-toc-nhat-ban', 'Sử dụng thuốc nhuộm Nhật Bản cao cấp, chuẩn màu, bền đẹp và an toàn cho da đầu. Không gây kích ứng, bảo vệ cấu trúc tóc.', 'Thuốc nhuộm cao cấp từ Nhật, không gây hại cho tóc, màu chuẩn và lâu phai', 450000, 90, 'service-4.jpg', 'color', 1),
('Trị gàu và nấm da đầu', 'tri-gau-va-nam-da-dau', 'Điều trị triệt để gàu và nấm da đầu bằng liệu pháp thảo dược kết hợp công nghệ ion âm. Giảm ngứa, giảm viêm và ngăn ngừa tái phát.', 'Loại bỏ gàu và nấm da đầu, giảm ngứa và viêm, phòng ngừa tái phát', 380000, 60, 'service-5.jpg', 'treatment', 0),
('Phục hồi tóc hư tổn', 'phuc-hoi-toc-hu-ton', 'Phục hồi toàn diện cho tóc hư tổn nặng bằng protein, keratin và các dưỡng chất đặc biệt. Tóc được tái cấu trúc từ gốc đến ngọn.', 'Phục hồi chuyên sâu cho tóc khô, xơ, chẻ ngọn, hư tổn do hóa chất', 420000, 75, 'service-6.jpg', 'treatment', 0),
('Massage đầu vai gáy', 'massage-dau-vai-gay', 'Liệu pháp massage kết hợp nhiều kỹ thuật châu Á, giúp giảm đau vai gáy, giảm căng thẳng và cải thiện giấc ngủ.', 'Giảm đau đầu, vai gáy, căng thẳng và mệt mỏi, cải thiện tuần hoàn máu', 280000, 40, 'service-7.jpg', 'massage', 0),
('Đắp mặt nạ thảo dược', 'dap-mat-na-thao-duoc', 'Mặt nạ thảo dược tự nhiên từ các loại thảo mộc quý hiếm, giúp dưỡng tóc, thúc đẩy mọc tóc và cân bằng da đầu.', 'Dưỡng tóc sâu với thảo dược tự nhiên, cung cấp dưỡng chất thiết yếu', 300000, 45, 'service-8.jpg', 'treatment', 0);

-- Chèn dữ liệu mẫu - Nhân viên
INSERT INTO staff (name, position, bio, image, expertise, featured) VALUES
('Nguyễn Thị Minh', 'Chuyên gia tư vấn tóc', 'Với hơn 10 năm kinh nghiệm trong ngành, chị Minh đã được đào tạo tại Hàn Quốc và Nhật Bản về kỹ thuật chăm sóc tóc và da đầu.', 'staff-1.jpg', 'Tư vấn chăm sóc tóc, Điều trị rụng tóc', 1),
('Trần Văn Nam', 'Kỹ thuật viên Head Spa', 'Anh Nam là kỹ thuật viên hàng đầu với chứng chỉ Head Spa chuẩn Hàn Quốc, chuyên về các liệu pháp massage thư giãn và làm sạch da đầu chuyên sâu.', 'staff-2.jpg', 'Head Spa, Massage trị liệu', 1),
('Lê Thị Hương', 'Chuyên gia trị liệu tóc', 'Chị Hương chuyên về các phương pháp điều trị tóc rụng, tóc hư tổn và các vấn đề về da đầu với hơn 8 năm kinh nghiệm.', 'staff-3.jpg', 'Trị liệu tóc rụng, Phục hồi tóc hư tổn', 0);

-- Chèn dữ liệu mẫu - Cài đặt
INSERT INTO settings (setting_name, setting_value, setting_group) VALUES
('site_name', 'Luxury Head Spa', 'general'),
('site_description', 'Spa tóc cao cấp với dịch vụ chăm sóc tóc và da đầu chuyên nghiệp', 'general'),
('site_email', 'info@luxuryheadspa.vn', 'contact'),
('site_phone', '0901234567', 'contact'),
('site_address', '123 Nguyễn Huệ, Quận 1, TP.HCM', 'contact'),
('working_hours', '9:00 - 20:00, Thứ Hai - Chủ Nhật', 'general'),
('facebook_url', 'https://facebook.com/luxuryheadspa', 'social'),
('instagram_url', 'https://instagram.com/luxuryheadspa', 'social'),
('youtube_url', 'https://youtube.com/luxuryheadspa', 'social'),
('google_maps', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3829531983073!2d106.70142965098639!3d10.780115492268337!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4670702e31%3A0xa5777fb3a5bb9468!2zMTIzIE5ndXnhu4VuIEh14buHLCBC4bq_biBOZ2jDqSwgUXXhuq1uIDEsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1650000000000!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>', 'contact');

-- Chèn dữ liệu mẫu - Banners
INSERT INTO banners (title, description, image, button_text, button_link, position, status) VALUES
('Trải nghiệm Head Spa chuẩn Hàn Quốc', 'Chăm sóc toàn diện cho tóc và da đầu của bạn với công nghệ hiện đại', 'banner-1.jpg', 'Đặt lịch ngay', 'booking.php', 1, 'active'),
('Ưu đãi đặc biệt tháng này', 'Giảm 20% cho tất cả dịch vụ Head Spa khi đặt lịch online', 'banner-2.jpg', 'Xem ưu đãi', 'services.php', 2, 'active'),
('Giải pháp trị rụng tóc toàn diện', 'Phương pháp khoa học, hiệu quả sau 3-5 liệu trình', 'banner-3.jpg', 'Tìm hiểu thêm', 'services.php?id=3', 3, 'active');
