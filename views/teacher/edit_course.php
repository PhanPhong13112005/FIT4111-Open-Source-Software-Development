<?php
require_once 'header_teacher.php';
require_once '../../handle/course_process_teacher.php';

$id = intval($_GET['id']);
$course = getCourseById($id, $_SESSION['username']);

if (!$course) {
    header("Location: manage_my_courses.php?error=Không tìm thấy khóa học");
    exit;
}

// Lấy danh mục
$conn = getDbConnection();
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h3 class="mb-3">✏️ Chỉnh sửa khóa học</h3>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="../../handle/course_process_teacher.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?= $course['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Tên khóa học</label>
            <input type="text" name="title" class="form-control" required
                   value="<?= htmlspecialchars($course['title']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" rows="4" class="form-control"><?= htmlspecialchars($course['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" min="0" class="form-control"
                   value="<?= $course['price'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $course['category_id'] ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Thumbnail hiện tại</label><br>
            <?php if ($course['image']): ?>
                <img src="../../<?= $course['image'] ?>" width="120" class="border mb-2">
            <?php else: ?>
                <p class="text-muted">Không có ảnh</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh mới (nếu muốn thay)</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>

        <button class="btn btn-success">Cập nhật</button>
        <a href="manage_my_courses.php" class="btn btn-secondary">Quay lại</a>

    </form>
</div>
</body>
</html>
