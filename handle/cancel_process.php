<?php
session_start();
require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/enrollment_functions.php';
checkLogin('/BaiTapLon/index.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Khóa học không hợp lệ!";
    header("Location: /BaiTapLon/views/student/my_courses.php");
    exit();
}

$course_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

if (cancelEnrollment($user_id, $course_id)) {
    $_SESSION['success'] = "Hủy đăng ký thành công!";
} else {
    $_SESSION['error'] = "Không thể hủy đăng ký!";
}

header("Location: /BaiTapLon/views/student/my_courses.php");
exit();
?>
