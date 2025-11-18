<?php
// menu.php
// File navbar chung, tự xử lý login/guest

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy thông tin người dùng nếu đã login
$currentUser = null;
if (isset($_SESSION['user_id'])) {
    $currentUser = [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'role' => $_SESSION['role']
    ];
}
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand mt-2 mt-lg-0" href="/BaiTapLon/index.php">
            <img src="/BaiTapLon/images/logo.png" height="40" alt="Logo" title="Trang chủ">
        </a>

        <!-- Toggle button cho responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu bên trái -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/BaiTapLon/index.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/BaiTapLon/views/student/class.php"></a>
                </li>
            </ul>

            <!-- Menu bên phải -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if ($currentUser): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/BaiTapLon/images/aiotlab_logo.png" class="rounded-circle" height="35" alt="Avatar">
                            <span class="ms-2"><?= htmlspecialchars($currentUser['username']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <?php if ($currentUser['role'] === 'student'): ?>
                                <li><a class="dropdown-item" href="/BaiTapLon/views/student/my_courses.php">📘 Khóa học đã đăng ký</a></li>
                            <?php elseif ($currentUser['role'] === 'teacher'): ?>
                                <li><a class="dropdown-item" href="/BaiTapLon/views/teacher/my_courses.php">📘 Khóa học của tôi</a></li>
                            <?php elseif ($currentUser['role'] === 'admin'): ?>
                                <li><a class="dropdown-item" href="/BaiTapLon/views/admin/dashboard.php">🛠 Dashboard</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/BaiTapLon/handle/logout_process.php">🚪 Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/BaiTapLon/views/system/login.php">Đăng nhập</a></li>
                    <li class="nav-item"><a class="nav-link" href="/BaiTapLon/views/system/register.php">Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS và Font Awesome -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
