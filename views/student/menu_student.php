<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin('/BaiTapLon/index.php');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../menu.php'; ?>

    <div class="container py-5">
        <h2 class="mb-4">Danh sách khóa học</h2>

        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">'.htmlspecialchars($_SESSION['success']).'</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">'.htmlspecialchars($_SESSION['error']).'</div>';
            unset($_SESSION['error']);
        }
        ?>

        <div class="row">
            <?php
            require_once __DIR__ . '/../../handle/course_process.php';
            $courses = handleGetAllCourses();

            if (!empty($courses)) {
                foreach ($courses as $course) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if ($course["image"]) { ?>
                                <img src="<?= htmlspecialchars($course["image"]) ?>" class="card-img-top" style="height:200px;object-fit:cover;">
                            <?php } else { ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                                    <span class="text-muted">Không có ảnh</span>
                                </div>
                            <?php } ?>

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($course["title"]) ?></h5>
                                <p><?= number_format($course["price"], 0, ',', '.') ?> VNĐ</p>
                                <p class="text-muted small">Ngày tạo: <?= htmlspecialchars($course["created_at"]) ?></p>

                                <div class="d-flex gap-2">
                                    <a href="/BaiTapLon/handle/enroll_process.php?id=<?= $course["id"] ?>" class="btn btn-success">Đăng ký</a>
                                    <a href="../student/course_detail.php?id=<?= $course["id"] ?>" class="btn btn-outline-primary">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="text-center text-muted py-5">Không có khóa học nào.</div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
