<?php
/**
 * Booking Controller - Điều khiển trang đặt lịch
 * File: app/controllers/BookingController.php
 */

class BookingController extends Controller {
    private $serviceModel;
    private $bookingModel;
    private $settingModel;
    
    /**
     * Constructor - Khởi tạo controller với các model
     */
    public function __construct() {
        parent::__construct();
        $this->serviceModel = $this->model('Service');
        $this->bookingModel = $this->model('Booking');
        $this->settingModel = $this->model('Setting');
    }
    
    /**
     * Trang đặt lịch
     */
    public function index() {
        // Lấy danh sách dịch vụ đang hoạt động
        $services = $this->serviceModel->getActiveServices();
        
        // Lấy cài đặt booking
        $settings = $this->settingModel->getSettingsByGroup('booking');
        
        // Chuyển đổi mảng settings thành dạng key-value
        $bookingSettings = [];
        foreach ($settings as $setting) {
            $bookingSettings[$setting['setting_name']] = $setting['setting_value'];
        }
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Đặt lịch - Luxury Head Spa',
            'page_description' => 'Đặt lịch dịch vụ tại Luxury Head Spa - Spa tóc chuyên nghiệp',
            'services' => $services,
            'settings' => $bookingSettings,
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        // Hiển thị view
        $this->view('booking/index', $data);
    }
    
    /**
     * Xử lý đặt lịch
     */
    public function store() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/dat-lich');
            exit;
        }
        
        // Lấy dữ liệu từ form
        $data = [
            'name' => $this->input('name'),
            'phone' => $this->input('phone'),
            'email' => $this->input('email', ''),
            'service_id' => $this->input('service_id'),
            'date' => $this->input('date'),
            'time' => $this->input('time_slot'),
            'notes' => $this->input('notes', ''),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Kiểm tra dữ liệu đầu vào
        $errors = $this->validateBookingData($data);
        
        // Nếu có lỗi, trả về thông báo lỗi
        if (!empty($errors)) {
            $response = [
                'success' => false,
                'message' => $errors[0]
            ];
            
            echo json_encode($response);
            exit;
        }
        
        // Kiểm tra xem khung giờ đã được đặt chưa
        if ($this->bookingModel->isTimeSlotBooked($data['date'], $data['time'])) {
            $response = [
                'success' => false,
                'message' => 'Khung giờ này đã được đặt. Vui lòng chọn khung giờ khác.'
            ];
            
            echo json_encode($response);
            exit;
        }
        
        // Lưu thông tin đặt lịch
        $bookingId = $this->bookingModel->createBooking($data);
        
        if ($bookingId) {
            // Gửi email xác nhận
            $this->sendBookingConfirmationEmail($data, $bookingId);
            
            // Trả về thông báo thành công
            $response = [
                'success' => true,
                'message' => 'Đặt lịch thành công! Chúng tôi sẽ liên hệ xác nhận qua số điện thoại của bạn.',
                'redirect' => '/dat-lich/thanh-cong?id=' . $bookingId
            ];
        } else {
            // Trả về thông báo lỗi
            $response = [
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đặt lịch. Vui lòng thử lại sau.'
            ];
        }
        
        echo json_encode($response);
        exit;
    }
    
    /**
     * Trang đặt lịch thành công
     */
    public function success() {
        // Lấy ID đặt lịch từ URL
        $bookingId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        // Nếu không có ID, chuyển hướng về trang đặt lịch
        if ($bookingId === 0) {
            $this->redirect('/dat-lich');
            exit;
        }
        
        // Lấy thông tin đặt lịch
        $booking = $this->bookingModel->getBookingById($bookingId);
        
        // Nếu không tìm thấy thông tin đặt lịch, chuyển hướng về trang đặt lịch
        if (!$booking) {
            $this->redirect('/dat-lich');
            exit;
        }
        
        // Lấy thông tin dịch vụ
        $service = $this->serviceModel->getById($booking['service_id']);
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Đặt lịch thành công - Luxury Head Spa',
            'page_description' => 'Đặt lịch thành công tại Luxury Head Spa',
            'booking' => $booking,
            'service' => $service
        ];
        
        // Hiển thị view
        $this->view('booking/success', $data);
    }
    
    /**
     * Lấy các khung giờ trống
     */
    public function getTimeSlots() {
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
        $date = $this->input('date');
        $serviceId = $this->input('service_id');
        
        // Kiểm tra dữ liệu đầu vào
        if (empty($date) || empty($serviceId)) {
            $response = [
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ];
            
            echo json_encode($response);
            exit;
        }
        
        // Lấy thông tin dịch vụ
        $service = $this->serviceModel->getById($serviceId);
        
        if (!$service) {
            $response = [
                'success' => false,
                'message' => 'Dịch vụ không tồn tại'
            ];
            
            echo json_encode($response);
            exit;
        }
        
        // Lấy cài đặt booking
        $settings = $this->settingModel->getSettingsByGroup('booking');
        
        // Chuyển đổi mảng settings thành dạng key-value
        $bookingSettings = [];
        foreach ($settings as $setting) {
            $bookingSettings[$setting['setting_name']] = $setting['setting_value'];
        }
        
        // Lấy các khung giờ trống
        $timeSlots = $this->bookingModel->getAvailableTimeSlots($date, $service['duration'], $bookingSettings);
        
        // Trả về danh sách khung giờ trống
        $response = [
            'success' => true,
            'time_slots' => $timeSlots
        ];
        
        echo json_encode($response);
        exit;
    }
    
    /**
     * Lấy danh sách ngày đã đầy lịch
     */
    public function getFullyBookedDates() {
        // Kiểm tra nếu không phải là request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $response = [
                'success' => false,
                'message' => 'Phương thức không được hỗ trợ'
            ];
            
            echo json_encode($response);
            exit;
        }
        
        // Lấy ngày hiện tại
        $today = date('Y-m-d');
        
        // Lấy cài đặt booking
        $settings = $this->settingModel->getSettingsByGroup('booking');
        
        // Chuyển đổi mảng settings thành dạng key-value
        $bookingSettings = [];
        foreach ($settings as $setting) {
            $bookingSettings[$setting['setting_name']] = $setting['setting_value'];
        }
        
        // Tính ngày tối đa có thể đặt lịch
        $maxDate = date('Y-m-d', strtotime($today . ' + ' . $bookingSettings['advance_days'] . ' days'));
        
        // Lấy danh sách ngày đã đầy lịch
        $fullyBookedDates = $this->bookingModel->getFullyBookedDates($today, $maxDate);
        
        // Trả về danh sách ngày đã đầy lịch
        $response = [
            'success' => true,
            'fully_booked_dates' => $fullyBookedDates
        ];
        
        echo json_encode($response);
        exit;
    }
    
    /**
     * Đặt lịch nhanh từ trang chủ
     */
    public function quickBooking() {
        // Chuyển hướng đến trang đặt lịch với các tham số
        $name = urlencode($this->input('name'));
        $phone = urlencode($this->input('phone'));
        $email = urlencode($this->input('email', ''));
        $serviceId = intval($this->input('service_id', 0));
        $date = urlencode($this->input('date', ''));
        $time = urlencode($this->input('time', ''));
        
        $this->redirect("/dat-lich?name={$name}&phone={$phone}&email={$email}&service_id={$serviceId}&date={$date}&time={$time}");
        exit;
    }
    
    /**
     * Xác nhận lịch đặt
     */
    public function confirm() {
        // Lấy ID và mã xác nhận từ URL
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $token = isset($_GET['token']) ? $_GET['token'] : '';
        
        // Nếu không có ID hoặc token, chuyển hướng về trang chủ
        if ($id === 0 || empty($token)) {
            $this->redirect('/');
            exit;
        }
        
        // Kiểm tra thông tin đặt lịch
        $booking = $this->bookingModel->getBookingById($id);
        
        // Nếu không tìm thấy thông tin đặt lịch, chuyển hướng về trang chủ
        if (!$booking) {
            $this->redirect('/');
            exit;
        }
        
        // Tạo token từ thông tin đặt lịch
        $expectedToken = md5($booking['id'] . $booking['email'] . $booking['created_at']);
        
        // Nếu token không khớp, chuyển hướng về trang chủ
        if ($token !== $expectedToken) {
            $this->redirect('/');
            exit;
        }
        
        // Nếu đặt lịch đã được xác nhận, chuyển hướng đến trang thành công
        if ($booking['status'] === 'confirmed') {
            $this->redirect('/dat-lich/thanh-cong?id=' . $id);
            exit;
        }
        
        // Cập nhật trạng thái đặt lịch
        $updated = $this->bookingModel->updateStatus($id, 'confirmed');
        
        if ($updated) {
            // Truyền dữ liệu đến view
            $data = [
                'page_title' => 'Xác nhận đặt lịch - Luxury Head Spa',
                'page_description' => 'Xác nhận đặt lịch thành công tại Luxury Head Spa',
                'booking' => $booking
            ];
            
            // Hiển thị view
            $this->view('booking/confirm', $data);
        } else {
            // Chuyển hướng về trang chủ nếu cập nhật thất bại
            $this->redirect('/');
            exit;
        }
    }
    
    /**
     * Hủy lịch đặt
     */
    public function cancel() {
        // Lấy ID và mã xác nhận từ URL
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $token = isset($_GET['token']) ? $_GET['token'] : '';
        
        // Nếu không có ID hoặc token, chuyển hướng về trang chủ
        if ($id === 0 || empty($token)) {
            $this->redirect('/');
            exit;
        }
        
        // Kiểm tra thông tin đặt lịch
        $booking = $this->bookingModel->getBookingById($id);
        
        // Nếu không tìm thấy thông tin đặt lịch, chuyển hướng về trang chủ
        if (!$booking) {
            $this->redirect('/');
            exit;
        }
        
        // Tạo token từ thông tin đặt lịch
        $expectedToken = md5($booking['id'] . $booking['email'] . $booking['created_at']);
        
        // Nếu token không khớp, chuyển hướng về trang chủ
        if ($token !== $expectedToken) {
            $this->redirect('/');
            exit;
        }
        
        // Nếu đặt lịch đã bị hủy, chuyển hướng đến trang thành công
        if ($booking['status'] === 'cancelled') {
            $this->redirect('/dat-lich/huy-thanh-cong?id=' . $id);
            exit;
        }
        
        // Cập nhật trạng thái đặt lịch
        $updated = $this->bookingModel->updateStatus($id, 'cancelled');
        
        if ($updated) {
            // Chuyển hướng đến trang hủy thành công
            $this->redirect('/dat-lich/huy-thanh-cong?id=' . $id);
            exit;
        } else {
            // Chuyển hướng về trang chủ nếu cập nhật thất bại
            $this->redirect('/');
            exit;
        }
    }
    
    /**
     * Trang hủy lịch thành công
     */
    public function cancelSuccess() {
        // Lấy ID đặt lịch từ URL
        $bookingId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        // Nếu không có ID, chuyển hướng về trang chủ
        if ($bookingId === 0) {
            $this->redirect('/');
            exit;
        }
        
        // Lấy thông tin đặt lịch
        $booking = $this->bookingModel->getBookingById($bookingId);
        
        // Nếu không tìm thấy thông tin đặt lịch, chuyển hướng về trang chủ
        if (!$booking) {
            $this->redirect('/');
            exit;
        }
        
        // Truyền dữ liệu đến view
        $data = [
            'page_title' => 'Hủy lịch thành công - Luxury Head Spa',
            'page_description' => 'Hủy lịch thành công tại Luxury Head Spa',
            'booking' => $booking
        ];
        
        // Hiển thị view
        $this->view('booking/cancel_success', $data);
    }
    
    /**
     * Kiểm tra dữ liệu đặt lịch
     */
    private function validateBookingData($data) {
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
        
        // Kiểm tra dịch vụ
        if (empty($data['service_id'])) {
            $errors[] = 'Vui lòng chọn dịch vụ';
        } else {
            $service = $this->serviceModel->getById($data['service_id']);
            if (!$service) {
                $errors[] = 'Dịch vụ không tồn tại';
            }
        }
        
        // Kiểm tra ngày
        if (empty($data['date'])) {
            $errors[] = 'Vui lòng chọn ngày';
        } elseif (strtotime($data['date']) < strtotime(date('Y-m-d'))) {
            $errors[] = 'Ngày không hợp lệ';
        }
        
        // Kiểm tra giờ
        if (empty($data['time'])) {
            $errors[] = 'Vui lòng chọn khung giờ';
        }
        
        return $errors;
    }
    
    /**
     * Gửi email xác nhận đặt lịch
     */
    private function sendBookingConfirmationEmail($data, $bookingId) {
        // Lấy thông tin dịch vụ
        $service = $this->serviceModel->getById($data['service_id']);
        
        // Tạo token xác nhận
        $token = md5($bookingId . $data['email'] . $data['created_at']);
        
        // Xây dựng URL xác nhận và hủy
        $confirmUrl = $this->config['site']['url'] . '/dat-lich/xac-nhan?id=' . $bookingId . '&token=' . $token;
        $cancelUrl = $this->config['site']['url'] . '/dat-lich/huy?id=' . $bookingId . '&token=' . $token;
        
        // Nội dung email
        $subject = 'Xác nhận đặt lịch tại Luxury Head Spa';
        
        $message = '<html><body>';
        $message .= '<h2 style="color: #38a89d;">Xác nhận đặt lịch tại Luxury Head Spa</h2>';
        $message .= '<p>Xin chào <strong>' . $data['name'] . '</strong>,</p>';
        $message .= '<p>Cảm ơn bạn đã đặt lịch tại Luxury Head Spa. Dưới đây là thông tin chi tiết về lịch hẹn của bạn:</p>';
        $message .= '<table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Dịch vụ:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . $service['name'] . '</td></tr>';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Ngày:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . date('d/m/Y', strtotime($data['date'])) . '</td></tr>';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Giờ:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . $data['time'] . '</td></tr>';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Giá:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . number_format($service['price'], 0, ',', '.') . ' đ</td></tr>';
        $message .= '<tr><th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Thời gian thực hiện:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">' . $service['duration'] . ' phút</td></tr>';
        $message .= '</table>';
        
        $message .= '<p>Vui lòng nhấp vào nút bên dưới để xác nhận lịch hẹn:</p>';
        $message .= '<p><a href="' . $confirmUrl . '" style="display: inline-block; padding: 10px 20px; background-color: #38a89d; color: #ffffff; text-decoration: none; border-radius: 5px;">Xác nhận lịch hẹn</a></p>';
        
        $message .= '<p>Nếu bạn muốn hủy lịch hẹn, vui lòng nhấp vào liên kết sau: <a href="' . $cancelUrl . '">Hủy lịch hẹn</a></p>';
        
        $message .= '<p><strong>Lưu ý:</strong></p>';
        $message .= '<ul>';
        $message .= '<li>Vui lòng đến sớm 5-10 phút trước giờ hẹn.</li>';
        $message .= '<li>Nếu bạn cần thay đổi lịch hẹn, vui lòng liên hệ với chúng tôi qua số điện thoại: ' . $this->config['site']['phone'] . '</li>';
        $message .= '</ul>';
        
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
