<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php');
?>

<!DOCTYPE html>

<html>

<head>
    <title>DNU - Thêm khóa học mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="mt-3 mb-4 text-center">THÊM KHÓA HỌC MỚI</h3>

            <?php
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                    . htmlspecialchars($_GET['error']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
            }
            ?>

            <script>
            setTimeout(() => {
                let alertNode = document.querySelector('.alert');
                if (alertNode) {
                    let bsAlert = bootstrap.Alert.getOrCreateInstance(alertNode);
                    bsAlert.close();
                }
            }, 3000);
            </script>

            <form action="../../handle/course_process.php" method="POST">
                <input type="hidden" name="action" value="create">

                <div class="mb-3">
                    <label for="title" class="form-label">Tên khóa học</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="teacher" class="form-label">Giảng viên</label>
                    <input type="text" class="form-control" id="teacher" name="teacher" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Học phí (VNĐ)</label>
                    <input type="number" class="form-control" id="price" name="price" min="0" step="1000" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh (URL)</label>
                    <input type="text" class="form-control" id="image" name="image" placeholder="https://example.com/image.jpg">
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <button type="submit" class="btn btn-primary">Thêm khóa học</button>
                    <a href="../admin/manage_courses.php" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
```

</body>

</html>
