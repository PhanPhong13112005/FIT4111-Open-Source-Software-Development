<?php
session_start();
require_once '../functions/db_connection.php';
require_once '../functions/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDbConnection();
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);
    $role = 'student';

    if ($username === '' || $email === '' || $password === '' || $confirm === '') {
        $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
        header('Location: ../views/register.php');
        exit();
    }

    if ($password !== $confirm) {
        $_SESSION['error'] = 'Mật khẩu nhập lại không khớp!';
        header('Location: ../views/register.php');
        exit();
    }

    // Kiểm tra username đã tồn tại
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = 'Tên đăng nhập đã tồn tại!';
        $stmt->close();
        header('Location: ../views/register.php');
        exit();
    }
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $phone, $password, $role);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Đăng ký thành công! Mời bạn đăng nhập.';
        $stmt->close();
        mysqli_close($conn);
        header('Location: ../index.php'); // Về trang login
        exit();
    } else {
        $_SESSION['error'] = 'Đăng ký thất bại, vui lòng thử lại.';
        header('Location: ../views/register.php');
        exit();
    }
}
?>
