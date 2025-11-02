<?php
// Sử dụng __DIR__ để tính toán đường dẫn chính xác từ vị trí file hiện tại
require_once __DIR__ . '/../functions/auth.php';
checkLogin(__DIR__ . '/../index.php');
$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    // Lấy tên tệp hiện tại (ví dụ: "index.php", "ve-chung-toi.php")
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <!-- Navbar -->
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
                    <img src="../images/fitdnu_logo.png" height="40" alt="FIT-DNU Logo" loading="lazy" />
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
                <a class="text-reset me-3" href="#">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                <!-- Dropdown Avatar -->
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center hidden-arrow text-decoration-none" href="#"
                        id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../images/aiotlab_logo.png" class="rounded-circle" height="35" alt="Avatar"
                            loading="lazy" />
                        <span
                            class="ms-2 text-dark fw-semibold"><?= htmlspecialchars($currentUser['username'] ?? 'Sinh viên') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdownMenuAvatar">
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
    <!-- Navbar -->
</body>

</html>