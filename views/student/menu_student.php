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
//thấy thông tin người dúng nếu đã login
$currentUser = null;
if (isset($_SESSION['user_id'])) {
    $currentUser = [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'role' => $_SESSION['role']
    ];
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang chủ sinh viên | FIT-DNU</title>
    <link rel="stylesheet" href="/BaiTapLon/css/student.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button data-mdb-collapse-init class="navbar-toggler" type="button"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar brand -->
                <a class="navbar-brand mt-2 mt-lg-0" href="/BaiTapLon/views/student/menu_student.php">
                    <img src="/BaiTapLon/images/logo.png" height="40" alt="Logo" title="Trang chủ"> Trang Chủ
                </a>
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="class.php"></a>
                    </li>
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->

            <!-- Right elements -->
            <div class="d-flex align-items-center">
                <!-- Icon -->
                <!-- Dropdown Avatar -->
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center hidden-arrow text-decoration-none" href="#"
                        id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/BaiTapLon/images/aiotlab_logo.png" class="rounded-circle" height="35" alt="Avatar"
                            loading="lazy" />
                        <span
                            class="ms-2 text-dark fw-semibold"><?= htmlspecialchars($currentUser['username'] ?? 'Sinh viên') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdownMenuAvatar">
                        <li><a class="dropdown-item" href="/BaiTapLon/views/student/setting.php">🛠 Cài đặt</a> </li>
                        <li><a class="dropdown-item" href="/BaiTapLon/views/student/my_courses.php">📘 Khóa học đã đăng
                                ký</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="/BaiTapLon/handle/logout_process.php">🚪 Đăng
                                xuất</a></li>
                    </ul>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

            </div>
            <!-- Right elements -->
        </div>
        <!-- Container wrapper -->
    </nav>

    <!-- Font Awesome nếu cần icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <div class="container py-4">

        <!-- Thanh tìm kiếm -->
        <form method="GET" class="search-form" role="search" action="#all_courses">
            <input type="search" name="keyword" placeholder="Tìm kiếm khóa học..."
                value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            <button type="submit">Tìm kiếm</button>
        </form>

        <!-- Banner giới thiệu -->
        <div class="banner">
            <div class="banner-text">
                <h1>Học Lập Trình Để Đi Làm</h1>
                <p>Nơi khơi dậy đam mê và giúp bạn bắt đầu hành trình trở thành lập trình viên chuyên nghiệp.</p>
                <a href="/BaiTapLon/views/student/menu_student.php#popular_courses" class=" btn btn-primary mt-3">Khóa
                    học phổ biến</a>

            </div>
        </div>
        <!-- Danh sách khóa học -->
        <h2 class="section-title text-center mb-4" id="all_courses">Tất cả khóa học <span class="badge-new">Mới</span>
        </h2>
        <div class="row">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
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
                                <h5 class="card-title"><?= htmlspecialchars($course["title"]) ?></h5>
                                <p><strong>Giảng viên:</strong> <?= htmlspecialchars($course["teacher"]) ?></p>
                                <p><strong>Giá:</strong>
                                    <?= $course["price"] == 0 ? '<span class="text-success fw-bold">Miễn phí</span>' : number_format($course["price"], 0, ',', '.') . ' VNĐ'; ?>
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="course_detail.php?id=<?= $course["id"] ?>" class="btn btn-outline-primary">Chi
                                        tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-muted py-5">
                    Không tìm thấy khóa học nào.
                </div>
            <?php endif; ?>
        </div>
        <!-- Phần giới thiệu khóa học nổi bật -->
        <div class="mt-5">
            <h2 class="section-title text-center" id="popular_courses">Khóa học phổ biến</h2>
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
                                <img src="<?= htmlspecialchars($c["image"] ?? '../../images/default.jpg') ?>"
                                    class="card-img-top" style="height:200px;object-fit:cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($c["title"]) ?></h5>
                                    <span class="enroll-count">
                                        <?php echo htmlspecialchars($c['total_enrollments']); ?> số lượt đăng ký
                                    </span><br>
                                    <a href="course_detail.php?id=<?= $c["id"] ?>" class="btn btn-outline-primary btn-sm">Xem
                                        chi tiết</a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; else: ?>
                    <p class="text-center text-muted">Chưa có khóa học nổi bật nào.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</body>
<!-- Nút footer -->
<footer>
    <button id="backToTop" class="back-to-top">
        ⬆
    </button>
</footer>

<style>
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
        border: none;
        padding: 12px 16px;
        border-radius: 50px;
        cursor: pointer;
        font-size: 20px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .back-to-top:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }
</style>

<script>
    document.getElementById('backToTop').addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>

</html>