<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang quản trị</title>
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
  <hr>
</body>
</html>
