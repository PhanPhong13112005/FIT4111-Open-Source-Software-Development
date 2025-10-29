<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../index.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>DNU - OpenSource</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin.css">
</head>

<body>
  <header class="admin-header">
    <h2>Trang quản trị hệ thống</h2>
    <nav>
      <a href="dashboard.php">Tổng quan</a>
      <a href="manage_courses.php">Quản lý khóa học</a>
      <a href="manage_users.php">Quản lý người dùng</a>
      <a href="../../handle/logout_process.php" class="logout">Đăng xuất</a>
    </nav>
  </header>
    <div class="container mt-3">

        <h3 class="mt-3">Quản lý khóa học</h3>

        <?php
        // Thông báo thành công
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                ' . htmlspecialchars($_GET['success']) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        }

        // Thông báo lỗi
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . htmlspecialchars($_GET['error']) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        }
        ?>

        <script>
        // Ẩn alert sau 3 giây
        setTimeout(() => {
            let alertNode = document.querySelector('.alert');
            if (alertNode) {
                let bsAlert = bootstrap.Alert.getOrCreateInstance(alertNode);
                bsAlert.close();
            }
        }, 3000);
        </script>

        <a href="../admin/create_courses.php" class="btn btn-primary mb-3">➕ Thêm khóa học</a>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Giảng viên</th>
                    <th>Giá (VNĐ)</th>
                    <th>Ảnh</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require '../../handle/course_process.php';
                $courses = handleGetAllCourses();

                if (!empty($courses)) {
                    foreach ($courses as $course) { ?>
                        <tr>
                            <td><?= $course["id"] ?></td>
                            <td><?= htmlspecialchars($course["title"]) ?></td>
                            <td><?= htmlspecialchars($course["description"]) ?></td>
                            <td><?= htmlspecialchars($course["teacher"]) ?></td>
                            <td><?= number_format($course["price"], 0, ',', '.') ?></td>
                            <td>
                                <?php if (!empty($course["image"])) { ?>
                                    <img src="<?= htmlspecialchars($course["image"]) ?>" alt="Course Image" width="80">
                                <?php } else { ?>
                                    <span class="text-muted">Không có ảnh</span>
                                <?php } ?>
                            </td>
                            <td><?= htmlspecialchars($course["created_at"]) ?></td>
                            <td>
                                <a href="../admin/edit_courses.php?id=<?= $course["id"] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="/baitaplon/handle/course_process.php?action=delete&id=<?= $course["id"] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">Không có khóa học nào.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
