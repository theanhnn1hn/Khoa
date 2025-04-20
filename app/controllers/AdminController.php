<?php
/**
 * Admin Controller - Base controller for admin section
 * File: app/controllers/AdminController.php
 */

class AdminController extends \App\Core\Controller {
    protected $userModel;
    protected $layout = 'admin/layout';

    public function __construct() {
        parent::__construct();
        
        // Check admin authentication
        $this->checkAdminAuth();
        
        // Load models
        $this->userModel = $this->model('User');
    }

    /**
     * Check if user is authenticated and has admin role
     */
    protected function checkAdminAuth() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            flash('login_required', 'Vui lòng đăng nhập với quyền quản trị', 'danger');
            redirect('admin/login');
        }
    }

    /**
     * Admin dashboard
     */
    public function dashboard() {
        // Load necessary models
        $bookingModel = $this->model('Booking');
        $serviceModel = $this->model('Service');
        $blogModel = $this->model('BlogPost');
        $testimonialModel = $this->model('Testimonial');
        
        $data = [
            'page_title' => 'Bảng điều khiển',
            'active_menu' => 'dashboard',
            'todayBookings' => $bookingModel->getTodayBookingsCount(),
            'totalServices' => $serviceModel->getTotalServicesCount(),
            'totalPosts' => $blogModel->getTotalPostsCount(),
            'pendingTestimonials' => $testimonialModel->getPendingTestimonialsCount(),
            'recentBookings' => $bookingModel->getRecentBookings(5),
            'recentTestimonials' => $testimonialModel->getRecentTestimonials(5)
        ];
        
        $this->view('admin/dashboard', $data);
    }

    /**
     * Admin login form
     */
    public function login() {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin') {
            redirect('admin');
        }

        $data = [
            'page_title' => 'Đăng nhập quản trị'
        ];
        
        $this->view('admin/login', $data);
    }

    /**
     * Authenticate admin user
     */
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => ''
            ];

            // Validate username
            if (empty($data['username'])) {
                $data['username_err'] = 'Vui lòng nhập tên đăng nhập';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            }

            // Check for errors
            if (empty($data['username_err']) && empty($data['password_err'])) {
                // Attempt to login
                $loggedInUser = $this->userModel->login($data['username'], $data['password'], 'admin');
                
                if ($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                    redirect('admin');
                } else {
                    $data['password_err'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
                    $this->view('admin/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('admin/login', $data);
            }
        } else {
            redirect('admin/login');
        }
    }

    /**
     * Logout admin user
     */
    public function logout() {
        $this->destroyUserSession();
        redirect('admin/login');
    }

    /**
     * Create user session after login
     */
    private function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->full_name;
        $_SESSION['user_role'] = $user->role;
        $_SESSION['user_email'] = $user->email;
    }

    /**
     * Destroy user session
     */
    private function destroyUserSession() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_email']);
        session_destroy();
    }

    /**
     * Forgot password form
     */
    public function forgotPassword() {
        $data = [
            'page_title' => 'Quên mật khẩu'
        ];
        $this->view('admin/forgot-password', $data);
    }

    /**
     * Send password reset link
     */
    public function sendResetLink() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'email' => trim($_POST['email']),
                'email_err' => ''
            ];

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Vui lòng nhập email';
            } elseif (!$this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email không tồn tại trong hệ thống';
            }

            if (empty($data['email_err'])) {
                // Generate token and send email
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                if ($this->userModel->createPasswordReset($data['email'], $token, $expires)) {
                    // Send email with reset link (implementation depends on your email service)
                    $resetLink = URLROOT . '/admin/reset-password/' . $token;
                    
                    // In a real app, you would send an email here
                    // mail($data['email'], 'Reset Password', 'Click here to reset: ' . $resetLink);
                    
                    flash('reset_sent', 'Liên kết đặt lại mật khẩu đã được gửi đến email của bạn', 'success');
                    redirect('admin/login');
                } else {
                    flash('reset_error', 'Có lỗi xảy ra, vui lòng thử lại', 'danger');
                    $this->view('admin/forgot-password', $data);
                }
            } else {
                $this->view('admin/forgot-password', $data);
            }
        } else {
            redirect('admin/forgot-password');
        }
    }

    /**
     * Reset password form
     */
    public function resetPassword($token) {
        // Verify token
        $user = $this->userModel->findUserByResetToken($token);
        
        if (!$user || strtotime($user->reset_expires) < time()) {
            flash('reset_error', 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn', 'danger');
            redirect('admin/forgot-password');
        }

        $data = [
            'page_title' => 'Đặt lại mật khẩu',
            'token' => $token,
            'email' => $user->email
        ];
        
        $this->view('admin/reset-password', $data);
    }

    /**
     * Update password
     */
    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'token' => trim($_POST['token']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu mới';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Vui lòng xác nhận mật khẩu';
            } elseif ($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_err'] = 'Mật khẩu không khớp';
            }

            if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash password
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                
                if ($this->userModel->updatePassword($data['email'], $hashedPassword)) {
                    // Delete reset token
                    $this->userModel->deleteResetToken($data['email']);
                    
                    flash('reset_success', 'Mật khẩu đã được cập nhật. Vui lòng đăng nhập', 'success');
                    redirect('admin/login');
                } else {
                    flash('reset_error', 'Có lỗi xảy ra, vui lòng thử lại', 'danger');
                    redirect('admin/reset-password/' . $data['token']);
                }
            } else {
                $this->view('admin/reset-password', $data);
            }
        } else {
            redirect('admin/login');
        }
    }
}
