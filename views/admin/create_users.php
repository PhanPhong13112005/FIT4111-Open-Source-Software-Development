<?php require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php'); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>DNU - Thêm người dùng mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="mt-3 mb-4 text-center">THÊM NGƯỜI DÙNG MỚI</h3>
                <?php if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . htmlspecialchars($_GET['error']) . ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button> </div>';
                }
                if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . htmlspecialchars($_GET['success']) . ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button> </div>';
                } ?>
                <script> setTimeout(() => { const alertNode = document.querySelector('.alert'); if (alertNode) { const bsAlert = bootstrap.Alert.getOrCreateInstance(alertNode); bsAlert.close(); } }, 3000); </script>
                <form action="../../handle/user_process.php" method="POST">
                    <input type="hidden" name="action" value="create">

                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{10}"
                            maxlength="10" required>
                        <div class="form-text">Nhập 10 chữ số (VD: 0987654321)</div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="student">Học viên</option>
                            <option value="teacher">Giảng viên</option>
                            <option value="admin">Quản trị viên</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary"
                            onclick="return confirm('Xác nhận thêm người dùng mới?')">Thêm người dùng</button>
                        <a href="/BaiTapLon/views/admin/manage_users.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>