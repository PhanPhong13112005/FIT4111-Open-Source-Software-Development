<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/enrollments.php';
checkLogin('/BaiTapLon/index.php');

$user_id = $_SESSION['user_id'];
$courses = getEnrollmentsByStudent($user_id);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khóa học đã đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../menu.php'; ?>

    <div class="container py-5">
        <h2 class="mb-4 text-center">Danh sách khóa học đã đăng ký</h2>

        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($course["image"])): ?>
                                <img src="<?= htmlspecialchars($course["image"]) ?>" class="card-img-top" style="height:200px;object-fit:cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                                    <span class="text-muted">Không có ảnh</span>
                                </div>
                            <?php endif; ?>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($course["title"]) ?></h5>
                                <p><strong>Giảng viên:</strong> <?= htmlspecialchars($course["teacher"]) ?></p>
                                <p><strong>Ngày đăng ký:</strong> <?= htmlspecialchars($course["enroll_date"]) ?></p>

                                <div class="mt-auto d-flex justify-content-between">
                                    <a href="course_detail.php?id=<?= $course['id'] ?>" class="btn btn-outline-primary btn-sm">Chi tiết</a>
                                    <a href="/BaiTapLon/handle/cancel_enrollment.php?id=<?= $course['id'] ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký khóa học này không?');">
                                       Hủy
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-muted py-5">
                    Bạn chưa đăng ký khóa học nào.
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
            <a href="/BaiTapLon/views/student/menu_student.php" class="btn btn-primary">
                ← Quay lại danh sách khóa học
            </a>
        </div>
    </div>
</body>
</html>
