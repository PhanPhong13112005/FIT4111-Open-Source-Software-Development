<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/user_functions.php';

// Kiểm tra đăng nhập
checkLogin(__DIR__ . '/../../index.php');

// Lấy ID người dùng cần sửa
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../manage_users.php?error=Không tìm thấy ID người dùng");
    exit();
}

$id = intval($_GET['id']);
$user = getUserById($id);

if (!$user) {
    header("Location: ../manage_users.php?error=Không tìm thấy người dùng");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>DNU - Chỉnh sửa người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="mt-3 mb-4 text-center">CHỈNH SỬA NGƯỜI DÙNG</h3>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_GET['error']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_GET['success']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        setTimeout(() => {
                            const alertNode = document.querySelector('.alert');
                            if (alertNode) {
                                const bsAlert = bootstrap.Alert.getOrCreateInstance(alertNode);
                                bsAlert.close();
                            }
                        }, 3000);
                    });
                </script>

                <form action="../../handle/user_process.php" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username"
                               value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                               value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                               pattern="[0-9]{10}" maxlength="10" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Học viên</option>
                            <option value="teacher" <?= $user['role'] === 'teacher' ? 'selected' : '' ?>>Giảng viên</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Quản trị viên</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-success"
                                onclick="return confirm('Xác nhận cập nhật thông tin người dùng này?')">
                            Lưu thay đổi
                        </button>
                        <a href="/BaiTapLon/views/admin/manage_users.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
