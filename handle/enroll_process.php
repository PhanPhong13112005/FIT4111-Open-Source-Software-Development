<?php
session_start();
require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/enrollment_functions.php';
checkLogin('/BaiTapLon/index.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Khóa học không hợp lệ!";
    header("Location: /BaiTapLon/views/student/menu_student.php");
    exit();
}

$course_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

if (checkEnrollmentExists($user_id, $course_id)) {
    $_SESSION['error'] = "Bạn đã đăng ký khóa học này rồi!";
} else {
    if (addEnrollment($user_id, $course_id)) {
        $_SESSION['success'] = "Đăng ký khóa học thành công!";
    } else {
        $_SESSION['error'] = "Đăng ký thất bại!";
    }
}

header("Location: /BaiTapLon/views/student/my_courses.php");
exit();
?>
