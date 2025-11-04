<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin('/BaiTapLon/index.php');

require_once __DIR__ . '/../../handle/course_process.php';

// Lấy danh sách khóa học
$courses = handleGetAllCourses();
$populars = getPopularCourses(12);

// Tìm kiếm
if (!empty($_GET['keyword'])) {
    $keyword = strtolower(trim($_GET['keyword']));
    $courses = array_filter($courses, function ($course) use ($keyword) {
        return strpos(strtolower($course['title']), $keyword) !== false ||
               strpos(strtolower($course['teacher']), $keyword) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ sinh viên | FIT-DNU</title>
    <link rel="stylesheet" href="../../css/student.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <?php include '../menu.php'; ?>

    <div class="container py-4">

        <!-- Thanh tìm kiếm -->
        <form method="GET" class="d-flex mb-4" role="search">
            <input class="form-control me-2" type="search" name="keyword"
                   placeholder="Tìm kiếm khóa học..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </form>

        <!-- Banner giới thiệu -->
        <div class="banner">
            <div class="banner-text">
                <h1>Học Lập Trình Để Đi Làm</h1>
                <p>Nơi khơi dậy đam mê và giúp bạn bắt đầu hành trình trở thành lập trình viên chuyên nghiệp.</p>
            </div>
            <div class="banner-image">
                <img src="../../images/banner.jpg" alt="Banner học lập trình">
            </div>
        </div>

        <!-- Phần giới thiệu khóa học nổi bật -->
        <div class="mt-5">
            <h2 class="section-title text-center">Khóa học phổ biến</h2>
            <p class="text-center text-muted mb-4">Các khóa học được nhiều sinh viên đăng ký nhất</p>
            <div class="row">
                <?php
                // Giả lập khóa học phổ biến (hoặc dùng hàm getPopularCourses)
                $popular = array_slice($populars, 0, 3);
                if (!empty($popular)):
                    foreach ($popular as $c):
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <img src="<?= htmlspecialchars($c["image"] ?? '../../images/default.jpg') ?>" class="card-img-top" style="height:200px;object-fit:cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($c["title"]) ?></h5>
                                <p><?= htmlspecialchars($c["description"] ?? '') ?></p>
                                <span class="enroll-count">
                                    <?php echo htmlspecialchars($c['total_enrollments']); ?> số lượt đăng ký
                                </span><br>
                                <a href="course_detail.php?id=<?= $c["id"] ?>" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                            </div>
                            
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <p class="text-center text-muted">Chưa có khóa học nổi bật nào.</p>
                <?php endif; ?>
            </div>
        </div>
<!-- Danh sách khóa học -->
        <h2 class="section-title text-center mb-4">Tất cả khóa học <span class="badge-new">Mới</span></h2>
        <div class="row">
            <?php if (!empty($courses)) : ?>
                <?php foreach ($courses as $course) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($course["image"])) : ?>
                                <img src="<?= htmlspecialchars($course["image"]) ?>" class="card-img-top" style="height:200px;object-fit:cover;">
                            <?php else : ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                                    <span class="text-muted">Không có ảnh</span>
                                </div>
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($course["title"]) ?></h5>
                                <p><strong>Giảng viên:</strong> <?= htmlspecialchars($course["teacher"]) ?></p>
                                <p><strong>Giá:</strong>
                                    <?= $course["price"] == 0 ? '<span class="text-success fw-bold">Miễn phí</span>' : number_format($course["price"], 0, ',', '.') . ' VNĐ'; ?>
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="/BaiTapLon/handle/enroll_process.php?id=<?= $course["id"] ?>" class="btn btn-success">Đăng ký</a>
                                    <a href="course_detail.php?id=<?= $course["id"] ?>" class="btn btn-outline-primary">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="text-center text-muted py-5">
                    Không tìm thấy khóa học nào.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
