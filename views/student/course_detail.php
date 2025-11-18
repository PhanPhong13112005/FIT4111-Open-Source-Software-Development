<?php
require_once __DIR__ . '/../../functions/course_functions.php';
require_once __DIR__ . '/../../functions/lesson_functions.php';
require_once __DIR__ . '/../../functions/auth.php';
checkLogin('/BaiTapLon/index.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("❌ Không tìm thấy khóa học.");
}

$course_id = intval($_GET['id']);
$course = getCourseById($course_id);

if (!$course) {
    die("❌ Khóa học không tồn tại.");
}

// Lấy danh sách bài học từ DB
$lessons = getLessonsByCourseId($course_id);
$total_lessons = count($lessons);

// Tính tổng thời lượng
$total_seconds = 0;
foreach ($lessons as $l) {
    list($min, $sec) = explode(':', $l['duration']);
    $total_seconds += $min * 60 + $sec;
}
$hours = floor($total_seconds / 3600);
$minutes = floor(($total_seconds % 3600) / 60);
$total_duration = sprintf("%02d:%02d", $hours, $minutes);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($course['title']) ?> - Chi tiết khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <style>body {
            background-color: #f0f2f5;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        h2 {
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .qr-box {
            text-align: center;
            margin-bottom: 30px;
        }

        .qr-box img {
            width: 220px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .info-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            margin: auto;
            line-height: 1.5;
        }

        .info-box p {
            font-size: 0.95rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        #countdown {
            font-weight: 600;
            color: #d63333;
            font-size: 1.2rem;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
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
    </style>

    </style>
</head>

<body class="bg-light">

    <div class="container mt-5 mb-5">
        <div class="row">
            <!-- Thông tin khóa học -->
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2><?= htmlspecialchars($course['title']) ?></h2>
                        <p class="text-muted"><?= htmlspecialchars($course['description'] ?? 'Chưa có mô tả') ?></p>

                        <h5>Bạn sẽ học được gì?</h5>
                        <ul>
                            <li>Các kiến thức cơ bản, nền móng của ngành IT</li>
                            <li>Các mô hình, kiến trúc cơ bản khi triển khai ứng dụng</li>
                            <li>Các khái niệm, thuật ngữ cốt lõi khi triển khai ứng dụng</li>
                            <li>Hiểu hơn về cách Internet và máy vi tính hoạt động</li>
                        </ul>

                        <h5>Nội dung khóa học</h5>
                        <p>
                            <span class="badge bg-success">Giá:
                                <?= $course["price"] == 0 ? '<span class="text-success fw-bold">Miễn phí</span>' : number_format($course["price"], 0, ',', '.') . ' VNĐ'; ?></span>

                            <span class="badge bg-primary">Trình độ cơ bản</span>
                            Tổng số <?= $total_lessons ?> bài học
                            • Thời lượng <?= $total_duration ?>
                            • Học mọi lúc, mọi nơi
                        </p>

                        <h5 class="mt-4">Danh sách bài học</h5>
                        <ul class="lesson-list list-unstyled">
                            <?php foreach ($lessons as $index => $lesson): ?>
                                <li>
                                    <?= ($index + 1) . '. ' . htmlspecialchars($lesson['title']) ?>
                                    <span class="lesson-duration"><?= $lesson['duration'] ?></span>
                                    <?php if (!empty($lesson['video_url'])): ?>
                                        <a href="/BaiTapLon/views/student/lesson_detail.php?id=<?= $lesson['id'] ?>"
                                            class="btn btn-sm btn-outline-primary ms-2">Xem</a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="mt-4">
                            <a href="/BaiTapLon/handle/enroll_process.php?id=<?= $course['id'] ?>"
                                class="btn btn-success btn-lg"
                                onclick="return confirm('❓ Bạn có chắc chắn muốn đăng ký khóa học này không?');">
                                Đăng ký khóa học
                            </a>

                            <a href="menu_student.php" class="btn btn-secondary btn-lg">Quay lại danh sách</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar thông tin ngắn -->
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h6>Thông tin khóa học</h6>
                    <p><strong>Giảng viên:</strong> <?= htmlspecialchars($course['teacher']) ?></p>
                    <p><strong>Ngày tạo:</strong> <?= htmlspecialchars($course['created_at']) ?></p>
                    <p><strong>Giá:</strong>
                        <?= $course['price'] == 0 ? 'Miễn phí' : number_format($course['price'], 0, ',', '.') . ' VNĐ' ?>
                    </p>
                    <p><strong>Tổng bài:</strong> <?= $total_lessons ?> bài</p>
                    <p><strong>Tổng thời lượng:</strong> <?= $total_duration ?></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>