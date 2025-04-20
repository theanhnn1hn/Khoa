<?php
/**
 * Router Class - Xử lý định tuyến URL
 * File: app/core/Router.php
 */

namespace App\Core;

class Router {
    private $routes = [
        'GET' => [],
        'POST' => []
    ];
    private $notFoundHandler;
    
    /**
     * Đăng ký route GET
     */
    public function get($uri, $controller, $action) {
        $this->routes['GET'][$uri] = ['controller' => $controller, 'action' => $action];
        return $this;
    }
    
    /**
     * Đăng ký route POST
     */
    public function post($uri, $controller, $action) {
        $this->routes['POST'][$uri] = ['controller' => $controller, 'action' => $action];
        return $this;
    }
    
    /**
     * Thiết lập xử lý khi không tìm thấy route
     */
    public function setNotFoundHandler($handler) {
        $this->notFoundHandler = $handler;
    }
    
    /**
     * Dispatch route tương ứng với URL
     */
    public function dispatch($url) {
        // Xử lý query string
        $url = parse_url($url, PHP_URL_PATH);
        
        // Lấy phương thức HTTP
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Kiểm tra route có tồn tại không
        if (isset($this->routes[$method][$url])) {
            // Lấy thông tin controller và action
            $controller = $this->routes[$method][$url]['controller'];
            $action = $this->routes[$method][$url]['action'];
            
            // Thêm namespace
            $controller = "App\\Controllers\\{$controller}";
            
            // Kiểm tra controller có tồn tại không
            if (class_exists($controller)) {
                // Tạo instance của controller
                $controllerInstance = new $controller();
                
                // Kiểm tra action có tồn tại không
                if (method_exists($controllerInstance, $action)) {
                    // Gọi action
                    $controllerInstance->$action();
                    return;
                }
            }
        } else {
            // Kiểm tra route có chứa tham số không
            foreach ($this->routes[$method] as $route => $params) {
                // Chuyển đổi route pattern thành regex
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route);
                $pattern = "#^{$pattern}$#";
                
                // Kiểm tra URL có khớp với pattern không
                if (preg_match($pattern, $url, $matches)) {
                    // Lấy thông tin controller và action
                    $controller = $params['controller'];
                    $action = $params['action'];
                    
                    // Thêm namespace
                    $controller = "App\\Controllers\\{$controller}";
                    
                    // Kiểm tra controller có tồn tại không
                    if (class_exists($controller)) {
                        // Tạo instance của controller
                        $controllerInstance = new $controller();
                        
                        // Kiểm tra action có tồn tại không
                        if (method_exists($controllerInstance, $action)) {
                            // Loại bỏ các phần tử không phải tham số
                            foreach ($matches as $key => $value) {
                                if (is_int($key)) {
                                    unset($matches[$key]);
                                }
                            }
                            
                            // Gọi action với tham số
                            call_user_func_array([$controllerInstance, $action], $matches);
                            return;
                        }
                    }
                }
            }
        }
        
        // Nếu không tìm thấy route, gọi handler
        if ($this->notFoundHandler) {
            call_user_func($this->notFoundHandler);
        }
    }
}
