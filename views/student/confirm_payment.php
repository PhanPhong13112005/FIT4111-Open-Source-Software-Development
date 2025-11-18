<?php
require_once '/../../functions/auth.php';
require_once '/../../functions/enrollment_functions.php';
checkLogin('/BaiTapLon/index.php');

$user_id = $_SESSION['user_id'];
$course_id = intval($_POST['course_id'] ?? 0);

if ($course_id > 0) {
    // Cập nhật trạng thái thanh toán trong bảng enrollments
    $conn = getDbConnection();
    $stmt = $conn->prepare("UPDATE enrollments SET status = 1 WHERE user_id = ? AND course_id = ?");
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $_SESSION['success'] = "Bạn đã xác nhận thanh toán thành công!";
}

header("Location: my_courses.php");
exit;
