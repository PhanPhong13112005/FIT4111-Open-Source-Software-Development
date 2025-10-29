<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../index.php');
?>

<!DOCTYPE html>

<html>

<head>
    <title>DNU - Quản lý người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Tổng quan</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_users.php">Quản lý người dùng</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_courses.php">Quản lý khóa học</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-danger" href="../../handle/logout_process.php"><i>Đăng
                                xuất</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <h3 class="mt-3 mb-4">QUẢN LÝ NGƯỜI DÙNG</h3>
        <?php
        // Hiển thị thông báo thành công
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                . htmlspecialchars($_GET['success']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
        }

        // Hiển thị thông báo lỗi
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                . htmlspecialchars($_GET['error']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
        }
        ?>

        <script>
            // Tự động ẩn alert sau 3 giây
            setTimeout(() => {
                let alertNode = document.querySelector('.alert');
                if (alertNode) {
                    let bsAlert = bootstrap.Alert.getOrCreateInstance(alertNode);
                    bsAlert.close();
                }
            }, 3000);
        </script>

        <a href="../admin/create_users.php" class="btn btn-primary mb-3">➕ Thêm người dùng</a>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên đăng nhập</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số Điện thoại</th>
                    <th scope="col">Vai trò</th>
                    <th scope="col" style="width: 150px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once __DIR__ . '/../../handle/user_process.php';
                $users = handleGetAllUsers();

                if (!empty($users)) {
                    foreach ($users as $user) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone'])?></td>
                            <td><?= htmlspecialchars($user['role'])?></td>
                            <td>
                                <a href="../admin/edit_users.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="../handle/user_process.php?action=delete&id=<?= $user['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center text-muted">Chưa có người dùng nào.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    ```

</body>

</html>