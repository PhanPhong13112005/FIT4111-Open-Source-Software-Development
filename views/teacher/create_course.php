<?php
require_once 'header_teacher.php';
require_once '../../handle/course_process_teacher.php';

// Lấy danh mục
$conn = getDbConnection();
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3 class="mb-3">➕ Thêm khóa học mới</h3>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="../../handle/course_process_teacher.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">

        <div class="mb-3">
            <label class="form-label">Tên khóa học</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" rows="4" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" min="0" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh thumbnail</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>

        <button class="btn btn-primary">Thêm khóa học</button>
        <a href="manage_my_courses.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

</body>
</html>
