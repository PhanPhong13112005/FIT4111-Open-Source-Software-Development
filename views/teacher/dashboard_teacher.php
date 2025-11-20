<?php
require_once 'header_teacher.php';
require_once '../../handle/course_process_teacher.php';
$courses = getCoursesByTeacher($_SESSION['username']);
$totalEnrollments = getTotalEnrollmentsByTeacher($_SESSION['username']);
$latestCourse = getLatestCourseTitle($_SESSION['username']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h3 class="mb-4 text-center fw-bold">TỔNG QUAN GIẢNG VIÊN</h3>

        <div class="row g-4 justify-content-center">

            <div class="col-12 col-md-4">
                <div class="card shadow-sm p-4 text-center h-100">
                    <h5 class="fw-semibold mb-2">Tổng khóa học</h5>
                    <p class="fs-2 text-primary fw-bold">
                        <?= count(getCoursesByTeacher($_SESSION['username'])); ?>
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card shadow-sm p-4 text-center h-100">
                    <h5 class="fw-semibold mb-2">Học viên đăng ký</h5>
                    <p class="fs-2 text-success fw-bold">
                        <?= getTotalEnrollmentsByTeacher($_SESSION['username']); ?>
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card shadow-sm p-4 text-center h-100">
                    <h5 class="fw-semibold mb-2">Khóa học mới nhất</h5>
                    <p class="fs-5 fw-semibold">
                        <?= getLatestCourseTitle($_SESSION['username']); ?>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>