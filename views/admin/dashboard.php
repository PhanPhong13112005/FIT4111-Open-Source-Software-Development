<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin();

require_once __DIR__ . '/../../functions/db_connection.php';
$conn = getDbConnection();

// Tổng số lượt đăng ký
$enrollCount = $conn->query("SELECT COUNT(*) AS total FROM enrollments")->fetch_assoc()['total'] ?? 0;

// Tổng doanh thu
$revenueRow = $conn->query("
    SELECT SUM(c.price) AS total
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
")->fetch_assoc();
$revenue = $revenueRow['total'] ?? 0;

// Hoạt động gần đây
$activities = $conn->query("
    SELECT u.username, c.title AS course_name, e.enroll_date
    FROM enrollments e
    JOIN users u ON e.user_id = u.id
    JOIN courses c ON e.course_id = c.id
    ORDER BY e.id DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f1f3f6;
        }

        .navbar {
            background: #fff !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card .icon {
            font-size: 2.5rem;
        }

        .gradient-blue {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
        }

        .gradient-green {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
            color: #fff;
        }

        .activity-list li {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }

        .activity-list li:last-child {
            border-bottom: none;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #888;
        }

        h5 {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="dashboard.php">Admin Panel</a>
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

    <div class="container my-4">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card gradient-blue p-3 text-center">
                    <div class="icon mb-2"><i class="bi bi-person-plus-fill"></i></div>
                    <h6>Tổng lượt đăng ký</h6>
                    <h3><?= $enrollCount ?></h3>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card gradient-green p-3 text-center">
                    <div class="icon mb-2"><i class="bi bi-currency-dollar"></i></div>
                    <h6>Tổng doanh thu</h6>
                    <h3><?= number_format($revenue) ?> VNĐ</h3>
                </div>
            </div>
        </div>

        <div class="card mt-4 p-3">
            <h5>Hoạt động gần đây</h5>
            <ul class="activity-list list-unstyled mt-3">
                <?php while ($row = $activities->fetch_assoc()): ?>
                    <li>
                        <span>Người dùng: <strong><?= htmlspecialchars($row['username']) ?></strong> đã đăng ký
                            <em><?= htmlspecialchars($row['course_name']) ?></em></span>
                        <span class="activity-time"><?= date('d/m/Y H:i', strtotime($row['enroll_date'])) ?></span>
                    </li>
                <?php endwhile; ?>
                <?php if ($activities->num_rows == 0): ?>
                    <li>Chưa có hoạt động nào</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>