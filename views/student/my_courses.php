<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/enrollment_functions.php';
require_once __DIR__ . '/../../functions/course_functions.php'; // để getCourseById
checkLogin('/BaiTapLon/index.php');

$user_id = $_SESSION['user_id'];
$enrollments = getEnrollmentsByStudent($user_id);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Khóa học đã đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        h2 {
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .card {
            transition: transform 0.25s, box-shadow 0.25s;
        }


        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 25px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
        }

        .card-title {
            font-weight: 500;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .card-body p {
            margin: 0.2rem 0;
            font-size: 0.95rem;
            color: #555;
        }

        .btn-course {
            font-size: 0.85rem;
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
        }

        .btn-detail {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-detail:hover {
            background-color: #0069d9;
        }

        .btn-pay {
            background-color: #ffc107;
            color: #fff;
            border: none;
        }

        .btn-pay:hover {
            background-color: #e0a800;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-cancel:hover {
            background-color: #c82333;
        }

        .action-group {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: auto;
        }

        .text-center.mt-4 a.btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
        }

        .text-center.mt-4 a.btn:hover {
            background-color: #0069d9;
            color: #fff;
        }

        .course-card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-body p {
            font-size: 0.95rem;
            color: #555;
            margin: 0.2rem 0;
        }

        .btn-sm {
            border-radius: 10px;
            font-weight: 500;
        }

        .btn-outline-primary {
            color: #007bff;
            border-color: #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }


        .btn-warning {
            background: linear-gradient(45deg, #ffc107, #ffca2c);
            color: #212529;
            border: none;
        }


        .btn-warning:hover {
            background: linear-gradient(45deg, #e0a800, #d39e00);
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>

</head>

<body>
    <?php include '../menu.php'; ?>

    <div class="container py-5">
        <h2 class="mb-4 text-center">Danh sách khóa học đã đăng ký</h2>

        <div class="row">
            <?php if (!empty($enrollments)): ?>
                <?php foreach ($enrollments as $enroll):
                    $course = getCourseById($enroll['id']); // lấy chi tiết khóa học
                    if (!$course)
                        continue; // bỏ qua nếu khóa học không tồn tại
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                            <?php if (!empty($course["image"])): ?>
                                <img src="<?= htmlspecialchars($course["image"]) ?>" class="card-img-top"
                                    style="height:200px; object-fit:cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                                    style="height:200px;">
                                    <span class="text-light">Không có ảnh</span>
                                </div>
                            <?php endif; ?>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-2"><?= htmlspecialchars($course["title"]) ?></h5>
                                <p class="mb-1"><strong>Giảng viên:</strong> <?= htmlspecialchars($course["teacher"]) ?></p>
                                <p class="mb-3 text-muted"><strong>Ngày đăng ký:</strong>
                                    <?= htmlspecialchars($enroll["enroll_date"]) ?></p>

                                <div class="mt-auto d-flex gap-2 justify-content-center flex-wrap">
                                    <a href="course_detail.php?id=<?= $course['id'] ?>"
                                        class="btn btn-outline-primary btn-sm px-3">
                                        Chi tiết
                                    </a>

                                    <?php if ($course['price'] > 0): ?>
                                        <a href="enrolled_courses.php?course_id=<?= $course['id'] ?>"
                                            class="btn btn-warning btn-sm px-3"
                                            onclick="return confirm('Bạn sẽ thanh toán <?= number_format($course['price'], 0, ',', '.') ?> VNĐ cho khóa học này. Tiếp tục?');">
                                            Thanh Toán
                                        </a>
                                    <?php endif; ?>

                                    <a href="/BaiTapLon/handle/cancel_process.php?id=<?= $course['id'] ?>"
                                        class="btn btn-danger btn-sm px-3"
                                        onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký khóa học này không?');">
                                        Hủy
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-muted py-5">
                    Bạn chưa đăng ký khóa học nào.
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-4">
            <a href="/BaiTapLon/views/student/menu_student.php" class="btn btn-primary">
                ← Quay lại danh sách khóa học
            </a>
        </div>
    </div>
</body>

</html>