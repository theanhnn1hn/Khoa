<?php
/**
 * Contact Controller - Điều khiển trang liên hệ
 * File: app/controllers/ContactController.php
 */

class ContactController extends \App\Core\Controller {
    private $contactModel;
    private $settingModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->contactModel = $this->model('ContactMessage');
        $this->settingModel = $this->model('Setting');
    }
    
    /**
     * Trang liên hệ
     */
    public function index() {
        // Lấy thông tin cài đặt liên hệ
        $contactSettings = $this->settingModel->getSettingsByGroup('contact');
        
        // Tạo token CSRF
        $csrfToken = $this->generateCsrfToken();
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Liên hệ - Luxury Head Spa',
            'page_description' => 'Liên hệ với Luxury Head Spa - Spa tóc cao cấp tại Việt Nam',
            'contact_settings' => $contactSettings,
            'csrf_token' => $csrfToken
        ];
        
        // Hiển thị view
        $this->view('contact/index', $data);
    }
    
    /**
     * Xử lý gửi form liên hệ
     */
    public function send() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/lien-he');
            exit;
        }
        
        // Lấy dữ liệu từ form
        $data = [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone', ''),
            'subject' => $this->input('subject', ''),
            'message' => $this->input('message'),
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Kiểm tra dữ liệu đầu vào
        $errors = $this->validateContactData($data);
        
        // Nếu có lỗi, trả về thông báo lỗi
        if (!empty($errors)) {
            if ($this->isAjaxRequest()) {
                // Trả về JSON nếu là request AJAX
                $response = [
                    'success' => false,
                    'message' => $errors[0]
                ];
                
                echo json_encode($response);
                exit;
            } else {
                // Thiết lập thông báo flash
                $this->setFlashMessage('error', $errors[0]);
                
                // Chuyển hướng về trang liên hệ
                $this->redirect('/lien-he');
                exit;
            }
        }
        
        // Lưu thông tin liên hệ
        $contactId = $this->contactModel->createMessage($data);
        
        if ($contactId) {
            // Gửi email thông báo
            $this->sendContactNotificationEmail($data);
            
            if ($this->isAjaxRequest()) {
                // Trả về JSON nếu là request AJAX
                $response = [
                    'success' => true,
                    'message' => 'Cảm ơn bạn đã liên hệ với chúng tôi! Chúng tôi sẽ phản hồi lại trong thời gian sớm nhất.'
                ];
                
                echo json_encode($response);
                exit;
            } else {
                // Thiết lập thông báo flash
                $this->setFlashMessage('success', 'Cảm ơn bạn đã liên hệ với chúng tôi! Chúng tôi sẽ phản hồi lại trong thời gian sớm nhất.');
                
                // Chuyển hướng về trang liên hệ
                $this->redirect('/lien-he');
                exit;
            }
        } else {
            if ($this->isAjaxRequest()) {
                // Trả về JSON nếu là request AJAX
                $response = [
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.'
                ];
                
                echo json_encode($response);
                exit;
            } else {
                // Thiết lập thông báo flash
                $this->setFlashMessage('error', 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.');
                
                // Chuyển hướng về trang liên hệ
                $this->redirect('/lien-he');
                exit;
            }
        }
    }
    
    /**
     * Kiểm tra dữ liệu liên hệ
     */
    private function validateContactData($data) {
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
        
        // Kiểm tra số điện thoại nếu có
        if (!empty($data['phone']) && !preg_match('/^[0-9]{10,15}$/', $data['phone'])) {
            $errors[] = 'Số điện thoại không hợp lệ';
        }
        
        // Kiểm tra nội dung tin nhắn
        if (empty($data['message'])) {
            $errors[] = 'Vui lòng nhập nội dung tin nhắn';
        } elseif (strlen($data['message']) < 10) {
            $errors[] = 'Nội dung tin nhắn phải có ít nhất 10 ký tự';
        }
        
        return $errors;
    }
    
    /**
     * Gửi email thông báo liên hệ
     */
    private function sendContactNotificationEmail($data) {
        // Xây dựng nội dung email
        $subject = 'Thông báo: Tin nhắn liên hệ mới từ website';
        
        $message = '<html><body>';
        $message .= '<h2 style="color: #38a89d;">Thông báo: Tin nhắn liên hệ mới từ website</h2>';
        $message .= '<p>Bạn vừa nhận được một tin nhắn liên hệ mới từ website Luxury Head Spa:</p>';
        $message .= '<p><strong>Họ tên:</strong> ' . $data['name'] . '</p>';
        $message .= '<p><strong>Email:</strong> ' . $data['email'] . '</p>';
        
        if (!empty($data['phone'])) {
            $message .= '<p><strong>Số điện thoại:</strong> ' . $data['phone'] . '</p>';
        }
        
        if (!empty($data['subject'])) {
            $message .= '<p><strong>Tiêu đề:</strong> ' . $data['subject'] . '</p>';
        }
        
        $message .= '<p><strong>Nội dung tin nhắn:</strong></p>';
        $message .= '<p>' . nl2br($data['message']) . '</p>';
        $message .= '<p><strong>Thời gian gửi:</strong> ' . date('d/m/Y H:i:s') . '</p>';
        
        $message .= '<p>Vui lòng đăng nhập vào hệ thống quản trị để xem và phản hồi tin nhắn này.</p>';
        $message .= '</body></html>';
        
        // Cài đặt email
        $mailConfig = $this->config['mail'];
        
        // Headers
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $mailConfig['from_name'] . " <" . $mailConfig['from_email'] . ">" . "\r\n";
        
        // Gửi email đến admin
        mail($this->config['site']['email'], $subject, $message, $headers);
        
        // Gửi email xác nhận đến người gửi
        $this->sendContactConfirmationEmail($data);
    }
    
    /**
     * Gửi email xác nhận liên hệ đến người gửi
     */
    private function sendContactConfirmationEmail($data) {
        // Xây dựng nội dung email
        $subject = 'Xác nhận tin nhắn liên hệ - Luxury Head Spa';
        
        $message = '<html><body>';
        $message .= '<h2 style="color: #38a89d;">Xác nhận tin nhắn liên hệ - Luxury Head Spa</h2>';
        $message .= '<p>Xin chào <strong>' . $data['name'] . '</strong>,</p>';
        $message .= '<p>Cảm ơn bạn đã liên hệ với Luxury Head Spa. Chúng tôi đã nhận được tin nhắn của bạn và sẽ phản hồi lại trong thời gian sớm nhất.</p>';
        $message .= '<p><strong>Thông tin tin nhắn:</strong></p>';
        
        if (!empty($data['subject'])) {
            $message .= '<p><strong>Tiêu đề:</strong> ' . $data['subject'] . '</p>';
        }
        
        $message .= '<p><strong>Nội dung tin nhắn:</strong></p>';
        $message .= '<p>' . nl2br($data['message']) . '</p>';
        
        $message .= '<p>Nếu bạn có bất kỳ câu hỏi nào khác, vui lòng liên hệ với chúng tôi qua số điện thoại: ' . $this->config['site']['phone'] . '</p>';
        
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
    
    /**
     * Kiểm tra xem có phải là request AJAX không
     */
    private function isAjaxRequest() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}
