<?php
/**
 * Router Class - Xử lý định tuyến URL
 * File: app/core/Router.php
 */

class Router {
    private $routes = [];
    private $params = [];
    private $notFoundHandler = null;
    
    /**
     * Thêm route mới
     */
    public function add($route, $params = []) {
        // Chuyển đổi route thành regular expression
        $route = preg_replace('/\//', '\\/', $route);
        
        // Chuyển đổi {param} thành (?P<param>[^\/]+)
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[^\/]+)', $route);
        
        // Thêm ^ và $ vào đầu và cuối regex
        $route = '/^' . $route . '$/i';
        
        // Thêm route vào mảng routes
        $this->routes[$route] = $params;
    }
    
    /**
     * Thêm route GET
     */
    public function get($route, $controller, $action) {
        $this->add($route, [
            'controller' => $controller,
            'action' => $action,
            'method' => 'GET'
        ]);
    }
    
    /**
     * Thêm route POST
     */
    public function post($route, $controller, $action) {
        $this->add($route, [
            'controller' => $controller,
            'action' => $action,
            'method' => 'POST'
        ]);
    }
    
    /**
     * Thêm route PUT
     */
    public function put($route, $controller, $action) {
        $this->add($route, [
            'controller' => $controller,
            'action' => $action,
            'method' => 'PUT'
        ]);
    }
    
    /**
     * Thêm route DELETE
     */
    public function delete($route, $controller, $action) {
        $this->add($route, [
            'controller' => $controller,
            'action' => $action,
            'method' => 'DELETE'
        ]);
    }
    
    /**
     * Kiểm tra route có khớp với URL hiện tại không
     */
    public function match($url) {
        // Loại bỏ query string nếu có
        if ($pos = strpos($url, '?')) {
            $url = substr($url, 0, $pos);
        }
        
        // Loại bỏ dấu / ở cuối URL
        $url = rtrim($url, '/');
        
        // Thêm / nếu URL trống
        if ($url === '') {
            $url = '/';
        }
        
        // Kiểm tra từng route
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Lấy các tham số từ URL (nếu có)
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                
                $this->params = $params;
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Dispatch route
     */
    public function dispatch($url) {
        if ($this->match($url)) {
            // Kiểm tra phương thức HTTP
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            
            // Xử lý phương thức PUT và DELETE qua _method trong form
            if ($requestMethod === 'POST' && isset($_POST['_method'])) {
                $requestMethod = strtoupper($_POST['_method']);
            }
            
            // Nếu route yêu cầu phương thức cụ thể, kiểm tra xem có khớp không
            if (isset($this->params['method']) && $this->params['method'] !== $requestMethod) {
                $this->handleMethodNotAllowed();
                return;
            }
            
            $controller = $this->params['controller'];
            $action = $this->params['action'];
            
            // Kiểm tra controller có tồn tại không
            $controllerFile = dirname(__DIR__) . "/controllers/{$controller}.php";
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                
                // Khởi tạo controller
                $controllerInstance = new $controller();
                
                // Kiểm tra action có tồn tại không
                if (method_exists($controllerInstance, $action)) {
                    // Gọi action với tham số từ URL
                    call_user_func_array([$controllerInstance, $action], $this->params);
                } else {
                    throw new Exception("Action {$action} không tồn tại trong controller {$controller}");
                }
            } else {
                throw new Exception("Controller {$controller} không tồn tại");
            }
        } else {
            $this->handleNotFound();
        }
    }
    
    /**
     * Thiết lập handler cho route không tìm thấy
     */
    public function setNotFoundHandler($handler) {
        $this->notFoundHandler = $handler;
    }
    
    /**
     * Xử lý route không tìm thấy
     */
    protected function handleNotFound() {
        if ($this->notFoundHandler) {
            call_user_func($this->notFoundHandler);
        } else {
            // Redirect đến trang 404 mặc định
            header('HTTP/1.1 404 Not Found');
            include dirname(__DIR__) . '/views/errors/404.php';
        }
    }
    
    /**
     * Xử lý phương thức không được phép
     */
    protected function handleMethodNotAllowed() {
        header('HTTP/1.1 405 Method Not Allowed');
        include dirname(__DIR__) . '/views/errors/405.php';
    }
    
    /**
     * Lấy tất cả tham số
     */
    public function getParams() {
        return $this->params;
    }
    
    /**
     * Tạo URL từ tên route và tham số
     */
    public function generateUrl($routeName, $params = []) {
        if (isset($this->routes[$routeName])) {
            $url = $routeName;
            
            // Thay thế các tham số trong URL
            foreach ($params as $key => $value) {
                $url = str_replace('{' . $key . '}', $value, $url);
            }
            
            return $url;
        }
        
        return false;
    }
}
