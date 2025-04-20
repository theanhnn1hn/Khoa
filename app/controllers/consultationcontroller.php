<?php
/**
 * Consultation Controller - Điều khiển trang tư vấn
 * File: app/controllers/ConsultationController.php
 */

class ConsultationController extends \App\Core\Controller {
    private $consultationModel;
    private $serviceModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->consultationModel = $this->model('Consultation');
        $this->serviceModel = $this->model('Service');
    }
    
    /**
     * Trang tư vấn
     */
    public function index() {
        // Lấy danh sách dịch vụ
        $services = $this->serviceModel->getActiveServices();
        
        // Tạo token CSRF
        $csrfToken = $this->generateCsrfToken();
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Tư vấn - Luxury Head Spa',
            'page_description' => 'Đặt lịch tư vấn cá nhân hóa tại Luxury Head Spa',
            'services' => $services,
            'csrf_token' => $csrfToken
        ];
        
        // Hiển thị view
        $this->view('consultation/index', $data);
    }
    
    /**
     * Xử lý gửi form tư vấn
     */
    public function store() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/tu-van');
            exit;
        }
        
        // Lấy dữ liệu từ form
        $data = [
            'name' => $this->input('name'),
            'phone' => $this->input('phone'),
            'email' => $this->input('email', ''),
            'hair_condition' => $this->input('hair_condition', ''),
            'wishes' => $this->input('wishes', ''),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Kiểm tra dữ liệu đầu vào
        $errors = $this->validateConsultationData($data);
        
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
                
                // Chuyển hướng về trang tư vấn
                $this->redirect('/tu-van');
                exit;
            }
        }
        
        // Lưu thông tin tư vấn
        $consultationId = $this->consultationModel->createConsultation($data);
        
        if ($consultationId) {
            // Gửi email xác nhận
            $this->sendConsultationConfirmationEmail($data, $consultationId);
            
            if ($this->isAjaxRequest()) {
                // Trả về JSON nếu là request AJAX
                $response = [
                    'success' => true,
                    'message' => 'Gửi yêu cầu tư vấn thành công! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.',
                    'redirect' => '/tu-van/thanh-cong'
                ];
                
                echo json_encode($response);
                exit;
            } else {
                // Thiết lập thông báo flash
                $this->setFlashMessage('success', 'Gửi yêu cầu tư vấn thành công! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.');
                
                // Chuyển hướng đến trang thành công
                $this->redirect('/tu-van/thanh-cong');
                exit;
            }
        } else {
            if ($this->isAjaxRequest()) {
                // Trả về JSON nếu là request AJAX
                $response = [
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi gửi yêu cầu tư vấn. Vui lòng thử lại sau.'
                ];
                
                echo json_encode($response);
                exit;
            } else {
                // Thiết lập thông báo flash
                $this->setFlashMessage('error', 'Có lỗi xảy ra khi gửi yêu cầu tư vấn. Vui lòng thử lại sau.');
                
                // Chuyển hướng về trang tư vấn
                $this->redirect('/tu-van');
                exit;
            }
        }
    }
    
    /**
     * Trang tư vấn thành công
     */
    public function success() {
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Tư vấn thành công - Luxury Head Spa',
            'page_description' => 'Gửi yêu cầu tư vấn thành công'
        ];
        
        // Hiển thị view
        $this->view('consultation/success', $data);
    }
    
    /**
     * Gợi ý dịch vụ dựa trên tình trạng tóc
     */
    public function suggestServices() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $response = [
                'success' => false,
                'message' => 'Phương thức không được hỗ trợ'
            ];
            
            echo json_encode($response);
            exit;
        }
        
        // Lấy dữ liệu từ request
        $hairConditions = $this->input('hair_conditions', []);
        
        // Kiểm tra dữ liệu đầu vào
        if (empty($hairConditions)) {
            $response = [
                'success' => false,
                'message' => 'Vui lòng chọn ít nhất một tình trạng tóc'
            ];
            
            echo json_encode($response);
            exit;
        }
        
        // Lấy gợi ý dịch vụ dựa trên tình trạng tóc
        $suggestedServices = $this->getSuggestedServices($hairConditions);
        
        // Trả về kết quả
        $response = [
            'success' => true,
            'services' => $suggestedServices
        ];
        
        echo json_encode($response);
        exit;
    }
    
    /**
     * Kiểm tra dữ liệu tư vấn
     */
    private function validateConsultationData($data) {
        $errors = [];
        
        // Kiểm tra tên
        if (empty($data['name'])) {
            $errors[] = 'Vui lòng nhập họ tên';
        } elseif (strlen($data['name']) < 3) {
            $errors[] = 'Họ tên phải có ít nhất 3 ký tự';
        }
        
        // Kiểm tra số điện thoại
        if (empty($data['phone'])) {
            $errors[] = 'Vui lòng nhập số điện thoại';
        } elseif (!preg_match('/^[0-9]{10,15}$/', $data['phone'])) {
            $errors[] = 'Số điện thoại không hợp lệ';
        }
        
        // Kiểm tra email
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ';
        }
        
        return $errors;
    }
    
    /**
     * Gửi email xác nhận tư vấn
     */
    private function sendConsultationConfirmationEmail($data, $consultationId) {
        // Xây dựng nội dung email
        $subject = 'Xác nhận yêu cầu tư vấn tại Luxury Head Spa';
        
        $message = '<html><body>';
        $message .= '<h2 style="color: #38a89d;">Xác nhận yêu cầu tư vấn tại Luxury Head Spa</h2>';
        $message .= '<p>Xin chào <strong>' . $data['name'] . '</strong>,</p>';
        $message .= '<p>Cảm ơn bạn đã gửi yêu cầu tư vấn tại Luxury Head Spa. Chúng tôi đã nhận được thông tin của bạn và sẽ liên hệ lại trong thời gian sớm nhất.</p>';
        $message .= '<p><strong>Thông tin yêu cầu tư vấn:</strong></p>';
        $message .= '<ul>';
        $message .= '<li><strong>Mã yêu cầu:</strong> TV' . str_pad($consultationId, 5, '0', STR_PAD_LEFT) . '</li>';
        $message .= '<li><strong>Họ tên:</strong> ' . $data['name'] . '</li>';
        $message .= '<li><strong>Số điện thoại:</strong> ' . $data['phone'] . '</li>';
        
        if (!empty($data['email'])) {
            $message .= '<li><strong>Email:</strong> ' . $data['email'] . '</li>';
        }
        
        if (!empty($data['hair_condition'])) {
            $message .= '<li><strong>Tình trạng tóc hiện tại:</strong> ' . $data['hair_condition'] . '</li>';
        }
        
        if (!empty($data['wishes'])) {
            $message .= '<li><strong>Mong muốn của bạn:</strong> ' . $data['wishes'] . '</li>';
        }
        
        $message .= '</ul>';
        
        $message .= '<p>Chuyên gia của chúng tôi sẽ nghiên cứu thông tin bạn cung cấp và liên hệ lại để tư vấn cụ thể hơn.</p>';
        
        $message .= '<p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua số điện thoại: ' . $this->config['site']['phone'] . '</p>';
        
        $message .= '<p>Trân trọng,<br>Luxury Head Spa</p>';
        $message .= '</body></html>';
        
        // Cài đặt email
        $mailConfig = $this->config['mail'];
        
        // Headers
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $mailConfig['from_name'] . " <" . $mailConfig['from_email'] . ">" . "\r\n";
        
        // Gửi email nếu có địa chỉ email
        if (!empty($data['email'])) {
            mail($data['email'], $subject, $message, $headers);
        }
    }
    
    /**
     * Lấy gợi ý dịch vụ dựa trên tình trạng tóc
     */
    private function getSuggestedServices($hairConditions) {
        $serviceCategories = [];
        
        // Ánh xạ tình trạng tóc với danh mục dịch vụ
        $conditionToCategory = [
            'rung_toc' => ['treatment', 'head_spa'],
            'gau' => ['treatment'],
            'kho_xo' => ['treatment'],
            'toc_gay' => ['treatment'],
            'toc_bac' => ['color'],
            'da_dau_nhon' => ['head_spa', 'treatment'],
            'da_dau_kho' => ['head_spa', 'treatment'],
            'stress' => ['massage', 'head_spa']
        ];
        
        // Lấy danh mục dịch vụ dựa trên tình trạng tóc
        foreach ($hairConditions as $condition) {
            if (isset($conditionToCategory[$condition])) {
                foreach ($conditionToCategory[$condition] as $category) {
                    if (!in_array($category, $serviceCategories)) {
                        $serviceCategories[] = $category;
                    }
                }
            }
        }
        
        // Nếu không tìm thấy danh mục phù hợp, gợi ý mặc định là head_spa
        if (empty($serviceCategories)) {
            $serviceCategories[] = 'head_spa';
        }
        
        // Lấy dịch vụ theo danh mục
        $suggestedServices = [];
        
        foreach ($serviceCategories as $category) {
            $services = $this->serviceModel->getByCategory($category, 3);
            $suggestedServices = array_merge($suggestedServices, $services);
        }
        
        // Loại bỏ các dịch vụ trùng lặp
        $uniqueServices = [];
        foreach ($suggestedServices as $service) {
            $uniqueServices[$service['id']] = $service;
        }
        
        // Giới hạn số lượng dịch vụ gợi ý
        $result = array_slice(array_values($uniqueServices), 0, 4);
        
        return $result;
    }
    
    /**
     * Kiểm tra xem có phải là request AJAX không
     */
    private function isAjaxRequest() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}
