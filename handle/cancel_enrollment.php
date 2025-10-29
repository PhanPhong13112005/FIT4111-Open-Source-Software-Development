<?php
session_start();
require_once __DIR__ . '/../functions/db_connection.php';
require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/enrollments.php';

checkLogin('/BaiTapLon/index.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Khóa học không hợp lệ!";
    header("Location: /BaiTapLon/views/student/my_courses.php");
    exit();
}

$course_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

if (cancelEnrollment($user_id, $course_id)) {
    $_SESSION['success'] = "Bạn đã hủy đăng ký khóa học thành công.";
} else {
    $_SESSION['error'] = "Không thể hủy đăng ký (khóa học có thể không tồn tại).";
}

header("Location: /BaiTapLon/views/student/my_courses.php");
exit();
?>
