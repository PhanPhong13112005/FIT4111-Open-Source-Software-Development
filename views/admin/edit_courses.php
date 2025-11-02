<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php');
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>DNU - OpenSource | Chỉnh sửa khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-3">
        <h3 class="mt-3 mb-4 text-center">CHỈNH SỬA KHÓA HỌC</h3>

        <?php
        // Kiểm tra có ID không
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: ../course.php?error=Không tìm thấy khóa học");
            exit;
        }

        $id = intval($_GET['id']);

        // Lấy thông tin khóa học
        require_once __DIR__ . '/../../functions/course_functions.php';
        $course = getCourseById($id);

        if (!$course) {
            header("Location: ../course.php?error=Không tìm thấy khóa học");
            exit;
        }

        // Hiển thị thông báo lỗi
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                . htmlspecialchars($_GET['error']) .
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        }

        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                . htmlspecialchars($_GET['success']) .
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        }
        ?>

        <script>
            // Sau 3 giây tự động ẩn thông báo
            setTimeout(() => {
                let alertNode = document.querySelector('.alert');
                if (alertNode) {
                    let bsAlert = bootstrap.Alert.getOrCreateInstance(alertNode);
                    bsAlert.close();
                }
            }, 3000);
        </script>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="../../handle/course_process.php" method="POST">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($course['id']) ?>">

                            <div class="mb-3">
                                <label for="title" class="form-label">Tên khóa học</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="<?= htmlspecialchars($course['title']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <input type="text" class="form-control" id="description" name="description"
                                    value="<?= htmlspecialchars($course['description']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="teacher" class="form-label">Giảng viên</label>
                                <input type="text" class="form-control" id="teacher" name="teacher"
                                    value="<?= htmlspecialchars($course['teacher']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Giá (VNĐ)</label>
                                <input type="number" class="form-control" id="price" name="price" min="0"
                                    value="<?= htmlspecialchars($course['price']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Hình ảnh (URL hoặc tên file)</label>
                                <input type="text" class="form-control" id="image" name="image"
                                    value="<?= htmlspecialchars($course['image']) ?>">
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="../admin/manage_course.php" class="btn btn-secondary me-md-2">Hủy</a>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>