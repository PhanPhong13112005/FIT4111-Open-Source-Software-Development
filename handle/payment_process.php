<?php
require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/payment_functions.php';
require_once __DIR__ . '/../functions/course_functions.php';
require_once __DIR__ . '/../functions/enrollment_functions.php'; // file bạn vừa gửi

checkLogin('/BaiTapLon/index.php');

$user_id = $_SESSION['user_id'];
$course_id = intval($_GET['id']);
$course = getCourseById($course_id);

if (!$course) die("Khóa học không tồn tại");

// Nếu đã đăng ký rồi
if (checkEnrollmentExists($user_id, $course_id)) {
    $_SESSION['error'] = "Bạn đã đăng ký khóa học này trước đó!";
    header("Location: /BaiTapLon/views/student/enrolled_courses.php");
    exit;
}

// Nếu miễn phí
if ($course['price'] == 0) {
    addEnrollment($user_id, $course_id);
    $_SESSION['success'] = "Bạn đã đăng ký khóa học miễn phí!";
    header("Location: /BaiTapLon/views/student/enrolled_courses.php");
    exit;
}

// Tạo payment record
$payment_id = createPayment($user_id, $course_id, $course['price']);

// Giả lập thanh toán thành công
addEnrollment($user_id, $course_id);
$_SESSION['success'] = "Thanh toán thành công và đăng ký khóa học!";
header("Location: /BaiTapLon/views/student/enrolled_courses.php");
exit;
