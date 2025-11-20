<?php
session_start();
require_once __DIR__ . "/../../functions/db_connection.php";

// Tạo kết nối
$conn = getDbConnection();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: /BaiTapLon/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Lấy thông tin người dùng
$stmt = $conn->prepare("SELECT username, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($fullname, $email, $phone);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cài đặt tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm p-4">
            <h3 class="mb-4 text-center fw-bold">Cài đặt tài khoản</h3>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Cập nhật thành công!</div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <form method="POST" action="/BaiTapLon/handle/student_update_process.php">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>">
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2">Cập nhật</button>
                <a href="/BaiTapLon/views/student/menu_student.php" class="btn btn-secondary w-100">Quay lại trang chủ</a>
            </form>

        </div>

</body>

</html>