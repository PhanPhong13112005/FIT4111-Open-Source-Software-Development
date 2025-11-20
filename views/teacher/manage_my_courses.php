<?php
require_once 'header_teacher.php';
require_once '../../handle/course_process_teacher.php';
$courses = getCoursesByTeacher($_SESSION['username']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Khóa học của tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h3 class="mb-3">KHÓA HỌC CỦA TÔI</h3>
    <a href="create_course.php" class="btn btn-primary mb-3">➕ Thêm khóa học</a>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($courses)): ?>
            <tr><td colspan="6" class="text-center text-muted">Bạn chưa có khóa học nào.</td></tr>
        <?php else: ?>
            <?php foreach ($courses as $c): ?>
                <tr>
                    <td><?= $c['id']; ?></td>
                    <td><?= htmlspecialchars($c['title']); ?></td>
                    <td><?= number_format($c['price']); ?></td>
                    <td>
                        <?php if ($c["image"]): ?>
                            <img src="../../<?= $c["image"] ?>" width="80">
                        <?php else: ?>
                            <span class="text-muted">Không có ảnh</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $c['created_at'] ?></td>
                    <td>
                        <a href="edit_course.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="../../handle/course_process_teacher.php?action=delete&id=<?= $c['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xóa?')" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
