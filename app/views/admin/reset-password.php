<?php
/**
 * Reset Password View
 * File: app/views/admin/reset-password.php
 */
$content = ob_start();
?>
<div class="login-wrapper">
    <div class="login-box">
        <div class="login-logo">
            <img src="/assets/images/logo.png" alt="Luxury Head Spa" class="img-fluid">
            <h1>Đặt lại mật khẩu</h1>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <?php flash(); ?>
                <p class="login-box-msg">Nhập mật khẩu mới của bạn</p>

                <form action="/admin/reset-password" method="post">
                    <input type="hidden" name="token" value="<?php echo $data['token']; ?>">
                    <input type="hidden" name="email" value="<?php echo $data['email']; ?>">
                    
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control <?php echo !empty($data['password_err']) ? 'is-invalid' : ''; ?>" 
                                placeholder="Mật khẩu mới">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?php echo $data['password_err'] ?? ''; ?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="password" name="confirm_password" class="form-control <?php echo !empty($data['confirm_password_err']) ? 'is-invalid' : ''; ?>" 
                                placeholder="Xác nhận mật khẩu">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?php echo $data['confirm_password_err'] ?? ''; ?></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Đặt lại mật khẩu</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="/admin/login">Quay lại đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include_once 'layout.php';
?>
