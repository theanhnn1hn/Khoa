<?php
/**
 * Forgot Password View
 * File: app/views/admin/forgot-password.php
 */
$content = ob_start();
?>
<div class="login-wrapper">
    <div class="login-box">
        <div class="login-logo">
            <img src="/assets/images/logo.png" alt="Luxury Head Spa" class="img-fluid">
            <h1>Quên mật khẩu</h1>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <?php flash(); ?>
                <p class="login-box-msg">Nhập email để nhận liên kết đặt lại mật khẩu</p>

                <form action="/admin/forgot-password" method="post">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control <?php echo !empty($data['email_err']) ? 'is-invalid' : ''; ?>" 
                                placeholder="Email" value="<?php echo $data['email'] ?? ''; ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?php echo $data['email_err'] ?? ''; ?></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Gửi liên kết đặt lại</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="/admin/login">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include_once 'layout.php';
?>
