<?php
/**
 * Admin Login View
 * File: app/views/admin/login.php
 */
$content = ob_start();
?>
<div class="login-wrapper">
    <div class="login-box">
        <div class="login-logo">
            <img src="/assets/images/logo.png" alt="Luxury Head Spa" class="img-fluid">
            <h1>Admin Panel</h1>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <?php flash(); ?>
                <p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc</p>

                <form action="/admin/login" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control <?php echo !empty($data['username_err']) ? 'is-invalid' : ''; ?>" 
                            placeholder="Tên đăng nhập" value="<?php echo $data['username'] ?? ''; ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?php echo $data['username_err'] ?? ''; ?></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control <?php echo !empty($data['password_err']) ? 'is-invalid' : ''; ?>" 
                            placeholder="Mật khẩu">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?php echo $data['password_err'] ?? ''; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Ghi nhớ đăng nhập</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1 mt-3">
                    <a href="/admin/forgot-password">Quên mật khẩu?</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include_once 'layout.php';
?>
