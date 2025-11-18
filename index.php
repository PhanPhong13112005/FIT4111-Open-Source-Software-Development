<?php
require_once __DIR__ . '/handle/course_process.php';

// Lấy danh sách khóa học
$courses = handleGetAllCourses();
$populars = getPopularCourses(12);

// Tìm kiếm
if (!empty($_GET['keyword'])) {
    $keyword = strtolower(trim($_GET['keyword']));
    $courses = array_values(array_filter($courses, function ($course) use ($keyword) {
        return strpos(strtolower($course['title'] ?? ''), $keyword) !== false ||
            strpos(strtolower($course['teacher'] ?? ''), $keyword) !== false;
    }));
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang chủ sinh viên | FIT-DNU</title>
    <link rel="stylesheet" href="/BaiTapLon/css/student.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include __DIR__ . '/views/menu.php'; ?>

    <div class="container py-4">

        <!-- Thanh tìm kiếm -->
        <form method="GET" class="search-form" role="search">
            <input type="search" name="keyword" placeholder="Tìm kiếm khóa học..."
                value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            <button type="submit">Tìm kiếm</button>
        </form>


        <!-- Banner giới thiệu -->
        <div class="banner">
            <div class="banner-text">
                <h1>Học Lập Trình Để Đi Làm</h1>
                <p>Nơi khơi dậy đam mê và giúp bạn bắt đầu hành trình trở thành lập trình viên chuyên nghiệp.</p>
                <a href="/BaiTapLon/views/system/login.php" class="btn btn-primary mt-3">
                    Bắt đầu học ngay
                </a>
            </div>
        </div>

        <!-- Khóa học phổ biến -->
        <div class="mt-5">
            <h2 class="section-title text-center">Khóa học phổ biến</h2>
            <p class="text-center text-muted mb-4">Các khóa học được nhiều sinh viên đăng ký nhất</p>
            <div class="row">
                <?php
                $popular = array_slice($populars, 0, 3);
                if (!empty($popular)):
                    foreach ($popular as $c): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <img src="<?= htmlspecialchars($c["image"] ?? '/BaiTapLon/images/default.jpg') ?>"
                                    class="card-img-top" style="height:200px;object-fit:cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($c["title"] ?? '') ?></h5>
                                    <span class="enroll-count"><?= htmlspecialchars($c['total_enrollments'] ?? 0) ?> số lượt
                                        đăng ký</span>
                                        
                                    <div class="d-flex gap-2 mt-2">
                                        <a class="btn btn-outline-primary" href="/BaiTapLon/views/system/login.php">
                                            <i class="fa fa-sign-in-alt"></i> Đăng nhập để học
                                        </a>
                                        <a class="btn btn-outline-primary" href="/BaiTapLon/views/system/register.php">
                                            <i class="fa fa-user-plus"></i> Đăng ký tài khoản
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                else: ?>
                    <p class="text-center text-muted">Chưa có khóa học nổi bật nào.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tất cả khóa học -->
        <h2 class="section-title text-center mb-4">Tất cả khóa học <span class="badge-new">Mới</span></h2>
        <div class="row">
            <?php if (!empty($courses)):
                foreach ($courses as $course): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($course["image"])): ?>
                                <img src="<?= htmlspecialchars($course["image"]) ?>" class="card-img-top"
                                    style="height:200px;object-fit:cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                    style="height:200px;">
                                    <span class="text-muted">Không có ảnh</span>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($course["title"] ?? '') ?></h5>
                                <p><strong>Giảng viên:</strong> <?= htmlspecialchars($course["teacher"] ?? '') ?></p>
                                <p><strong>Giá:</strong>
                                    <?= ($course["price"] ?? 0) == 0 ? '<span class="text-success fw-bold">Miễn phí</span>'
                                        : number_format($course["price"], 0, ',', '.') . ' VNĐ'; ?>
                                </p>
                                <div class="d-flex gap-2">
                                    <a class="btn btn-outline-primary" href="/BaiTapLon/views/system/login.php">
                                        <i class="fa fa-sign-in-alt"></i> Đăng nhập để học
                                    </a>
                                    <a class="btn btn-outline-primary" href="/BaiTapLon/views/system/register.php">
                                        <i class="fa fa-user-plus"></i> Đăng ký tài khoản
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            else: ?>
                <div class="text-center text-muted py-5">Không tìm thấy khóa học nào.</div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>