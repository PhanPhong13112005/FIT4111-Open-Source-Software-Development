<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../../functions/auth.php';
checkLogin('../../index.php');

if ($_SESSION['role'] !== 'teacher') {
    header("Location: ../../index.php");
    exit;
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_teacher.php">Teacher Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#teacherNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="teacherNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="dashboard_teacher.php">Tổng quan</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_my_courses.php">Khóa học của tôi</a></li>
                <li class="nav-item"><a class="nav-link" href="create_course.php">Thêm khóa học</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="../../handle/logout_process.php" class="nav-link text-danger">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
