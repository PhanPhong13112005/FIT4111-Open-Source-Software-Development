<?php
require_once __DIR__ . '/../../functions/course_functions.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("❌ Không tìm thấy khóa học.");
}

$course_id = intval($_GET['id']);
$course = getCourseById($course_id);

if (!$course) {
    die("❌ Khóa học không tồn tại.");
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết khóa học - <?= htmlspecialchars($course['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><?= htmlspecialchars($course['title']) ?></h3>
            </div>
            <div class="card-body">
                <p><strong>Giảng viên:</strong> <?= htmlspecialchars($course['teacher']) ?></p>
                <p><strong>Giá:</strong> <?= number_format($course['price'], 0, ',', '.') ?> VNĐ</p>
                <p><strong>Ngày tạo:</strong> <?= htmlspecialchars($course['created_at']) ?></p>
                <hr>
                <h5>Mô tả khóa học:</h5>
                <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>
            </div>
            <div class="card-footer text-end">   
                <a href="/BaiTapLon/handle/enroll_process.php?id=<?= $course['id'] ?>" class="btn btn-success">
                    Đăng ký khóa học
                </a>
                <a href="menu_student.php" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </div>
    </div>

</body>
</html>
