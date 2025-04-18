<?php
/**
 * Admin Controller - Base controller for admin section
 * File: app/controllers/AdminController.php
 */

class AdminController extends Controller {
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
        $data = [
            'page_title' => 'Bảng điều khiển',
            'active_menu' => 'dashboard'
        ];
        
        $this->view('admin/dashboard', $data);
    }
}
