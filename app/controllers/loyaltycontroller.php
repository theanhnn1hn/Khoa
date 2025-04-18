<?php
/**
 * Loyalty Controller - Điều khiển trang khách hàng thân thiết
 * File: app/controllers/LoyaltyController.php
 */

class LoyaltyController extends Controller {
    private $memberModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->memberModel = $this->model('Member');
    }
    
    /**
     * Trang khách hàng thân thiết
     */
    public function index() {
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Khách hàng thân thiết - Luxury Head Spa',
            'page_description' => 'Chương trình khách hàng thân thiết tại Luxury Head Spa',
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        // Hiển thị view
        $this->view('loyalty/index', $data);
    }
    
    /**
     * Xử lý đăng ký khách hàng thân thiết
     */
    public function register() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/khach-hang-than-thiet');
            exit;
        }
        
        // Lấy dữ liệu từ form
        $data = [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'address' => $this->input('address', ''),
            'membership_level' => 'silver', // Mặc định bắt đầu từ bạc
            'points' => 0, // Mặc định bắt đầu từ 0 điểm
            'registration_date' => date('Y-m-d'),
            'benefits' => 'Ưu đãi giảm 5% cho tất cả dịch vụ, tích lũy điểm đổi quà',
            'expiry_date' => date('Y-m-d', strtotime('+1 year')), // Thẻ có hiệu lực 1 năm
            'status' => 'active'
        ];
        
        // Kiểm tra dữ liệu đầu vào
        $errors = $this->validateMemberData($data);
        
        // Nếu có lỗi, trả về thông báo lỗi
        if (!empty($errors)) {
            $this->setFlashMessage('error', $errors[0]);
            
            // Chuyển hướng về trang đăng ký
            $this->redirect('/khach-hang-than-thiet');
            exit;
        }
        
        // Kiểm tra xem email hoặc số điện thoại đã tồn tại chưa
        if ($this->memberModel->emailExists($data['email'])) {
            $this->setFlashMessage('error', 'Email này đã được đăng ký. Vui lòng sử dụng email khác hoặc liên hệ với chúng tôi.');
            $this->redirect('/khach-hang-than-thiet');
            exit;
        }
        
        if ($this->memberModel->phoneExists($data['phone'])) {
            $this->setFlashMessage('error', 'Số điện thoại này đã được đăng ký. Vui lòng sử dụng số điện thoại khác hoặc liên hệ với chúng tôi.');
            $this->redirect('/khach-hang-than-thiet');
            exit;
        }
        
        // Lưu thông tin thành viên
        $memberId = $this->memberModel->create($data);
        
        if ($memberId) {
            // Gửi email xác nhận đăng ký thành công
            $this->sendConfirmationEmail($data);
            
            // Thiết lập thông báo thành công
            $this->setFlashMessage('success', 'Đăng ký thành công! Chúng tôi đã gửi email xác nhận đến địa chỉ email của bạn.');
            
            // Chuyển hướng đến trang thành công
            $this->redirect('/khach-hang-than-thiet/thanh-cong?id=' . $memberId);
        } else {
            // Thiết lập thông báo lỗi
            $this->setFlashMessage('error', 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại sau.');
            
            // Chuyển hướng về trang đăng ký
            $this->redirect('/khach-hang-than-thiet');
        }
    }
    
    /**
     * Trang đăng ký thành công
     */
    public function success() {
        // Lấy ID thành viên từ URL
        $memberId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($memberId === 0) {
            $this->redirect('/khach-hang-than-thiet');
            exit;
        }
        
        // Lấy thông tin thành viên
        $member = $this->memberModel->getById($memberId);
        
        if (!$member) {
            $this->redirect('/khach-hang-than-thiet');
            exit;
        }
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Đăng ký thành công - Luxury Head Spa',
            'page_description' => 'Đăng ký thành viên thành công tại Luxury Head Spa',
            'member' => $member
        ];
        
        // Hiển thị view
        $this->view('loyalty/success', $data);
    }
    
    /**
     * Trang tra cứu thông tin thành viên
     */
    public function check() {
        // Kiểm tra nếu có submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $email = $this->input('email');
            $phone = $this->input('phone');
            
            if (empty($email) && empty($phone)) {
                $this->setFlashMessage('error', 'Vui lòng nhập email hoặc số điện thoại');
                $this->redirect('/khach-hang-than-thiet/tra-cuu');
                exit;
            }
            
            // Tìm thành viên
            $member = null;
            
            if (!empty($email)) {
                $member = $this->memberModel->getByEmail($email);
            } elseif (!empty($phone)) {
                $member = $this->memberModel->getByPhone($phone);
            }
            
            if ($member) {
                // Truyền dữ liệu đến view
                $data = [
                    'page_title' => 'Thông tin thành viên - Luxury Head Spa',
                    'page_description' => 'Thông tin thành viên khách hàng thân thiết tại Luxury Head Spa',
                    'member' => $member,
                    'csrf_token' => $this->generateCsrfToken()
                ];
                
                // Hiển thị view
                $this->view('loyalty/member_info', $data);
                return;
            } else {
                $this->setFlashMessage('error', 'Không tìm thấy thông tin thành viên. Vui lòng kiểm tra lại thông tin đã nhập.');
            }
        }
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Tra cứu thông tin thành viên - Luxury Head Spa',
            'page_description' => 'Tra cứu thông tin thành viên khách hàng thân thiết tại Luxury Head Spa',
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        // Hiển thị view
        $this->view('loyalty/check', $data);
    }
    
    /**
     * Kiểm tra dữ liệu thành viên
     */
    private function validateMemberData($data) {
        $errors = [];
        
        // Kiểm tra tên
        if (empty($data['name'])) {
            $errors[] = 'Vui lòng nhập họ tên';
        } elseif (strlen($data['name']) < 3) {
            $errors[] = 'Họ tên phải có ít nhất 3 ký tự';
        }
        
        // Kiểm tra email
        if (empty($data['email'])) {
            $errors[] = 'Vui lòng nhập email';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ';
        }
        
        // Kiểm tra số điện thoại
        if (empty($data['phone'])) {
            $errors[] = 'Vui lòng nhập số điện thoại';
        } elseif (!preg_match('/^[0-9]{10,15}$/', $data['phone'])) {
            $errors[] = 'Số điện thoại không hợp lệ';
        }
        
        return $errors;
    }
    
    /**
     * Gửi email xác nhận đăng ký thành công
     */
    private function sendConfirmationEmail($data) {
        // Xây dựng nội dung email
        $subject = 'Xác nhận đăng ký thành viên Luxury Head Spa';
        
        $message = '<html><body>';
        $message .= '<h2 style="color: #38a89d;">Xác nhận đăng ký thành viên Luxury Head Spa</h2>';
        $message .= '<p>Xin chào <strong>' . $data['name'] . '</strong>,</p>';
        $message .= '<p>Cảm ơn bạn đã đăng ký thành viên khách hàng thân thiết tại Luxury Head Spa. Dưới đây là thông tin thành viên của bạn:</p>';
        $message .= '<table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Họ tên:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . $data['name'] . '</td></tr>';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Email:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . $data['email'] . '</td></tr>';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Số điện thoại:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . $data['phone'] . '</td></tr>';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Cấp độ thành viên:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">Silver</td></tr>';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Ngày đăng ký:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . date('d/m/Y', strtotime($data['registration_date'])) . '</td></tr>';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Ngày hết hạn:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . date('d/m/Y', strtotime($data['expiry_date'])) . '</td></tr>';
        $message .= '</table>';
        
        $message .= '<h3 style="color: #38a89d;">Quyền lợi thành viên:</h3>';
        $message .= '<ul>';
        $message .= '<li>Giảm 5% cho tất cả dịch vụ tại Luxury Head Spa</li>';
        $message .= '<li>Tích lũy điểm thưởng với mỗi lần sử dụng dịch vụ</li>';
        $message .= '<li>Quà tặng sinh nhật đặc biệt</li>';
        $message .= '<li>Ưu tiên đặt lịch và thông báo ưu đãi sớm nhất</li>';
        $message .= '</ul>';
        
        $message .= '<p>Bạn có thể tra cứu thông tin thành viên của mình tại <a href="' . $this->config['site']['url'] . '/khach-hang-than-thiet/tra-cuu">đây</a>.</p>';
        
        $message .= '<p>Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua số điện thoại: ' . $this->config['site']['phone'] . ' hoặc email: ' . $this->config['site']['email'] . '</p>';
        
        $message .= '<p>Trân trọng,<br>Luxury Head Spa</p>';
        $message .= '</body></html>';
        
        // Cài đặt email
        $mailConfig = $this->config['mail'];
        
        // Headers
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $mailConfig['from_name'] . " <" . $mailConfig['from_email'] . ">" . "\r\n";
        
        // Gửi email
        mail($data['email'], $subject, $message, $headers);
    }
}
