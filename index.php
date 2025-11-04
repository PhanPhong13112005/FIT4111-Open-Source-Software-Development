<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/login.css" rel="stylesheet">
    <title>FITDNU-OpenSource</title>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="text-center mb-3">
                <img src="./images/login.jpg" alt="Logo" class="logo">
                <h5 class="text-success fw-bold mt-2">OCE - Online Course Education</h5>
                <h2 class="text-muted mb-3">Đăng nhập hệ thống</h2>
            </div>
            <form action="./handle/login_process.php" method="POST">
                <div class="form-group mb-3">
                    <label class="form-label">Email hoặc Số điện thoại:</label>
                    <input type="text" name="username" class="form-control form-control-lg" required>
                </div>
                <div class="form-group mb-4">
                    <label class="form-label">Mật khẩu:</label>
                    <input type="password" name="password" class="form-control form-control-lg" required>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger py-2">
                        <?= $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success py-2">
                        <?= $_SESSION['success'];
                        unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <button type="submit" name="login" class="btn btn-primary w-100 btn-lg">Đăng nhập</button>

                <div class="text-center mt-3">
                    <small>Chưa có tài khoản? <a href="views/register.php"
                            class="text-decoration-none fw-bold text-primary">Đăng ký ngay</a></small>
                </div>
            </form>
        </div>
    </div>
</body>

</html>