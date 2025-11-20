<?php
session_start();
require_once __DIR__ . "/../functions/db_connection.php";

$conn = getDbConnection();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: /BaiTapLon/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Nhận dữ liệu từ form
$fullname = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';

// Kiểm tra email có trùng người khác không
$check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$check->bind_param("si", $email, $userId);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    header("Location: /BaiTapLon/views/student/setting.php?error=Email đã tồn tại");
    exit;
}
$check->close();

// Cập nhật thông tin
$stmt = $conn->prepare("UPDATE users SET username=?, email=?, phone=? WHERE id=?");
$stmt->bind_param("sssi", $fullname, $email, $phone, $userId);

if ($stmt->execute()) {
    header("Location: /BaiTapLon/views/student/setting.php?success=1");
} else {
    header("Location: /BaiTapLon/views/student/setting.php?error=Lỗi cập nhật");
}
$stmt->close();
?>
