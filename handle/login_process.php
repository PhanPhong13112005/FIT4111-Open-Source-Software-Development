<?php
session_start();
require_once '../functions/db_connection.php';
require_once '../functions/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $conn = getDbConnection();

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        $_SESSION['error'] = 'Vui lòng nhập đầy đủ username và password!';
        header('Location: ../index.php');
        exit();
    }

    // Gọi hàm xác thực
    $user = authenticateUser($conn, $username, $password);

    if ($user) {
        // Lưu session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['success'] = 'Đăng nhập thành công!';

        mysqli_close($conn);

        //Phân quyền chuyển trang
        if ($user['role'] === 'admin') {
            header('Location: ../views/admin/dashboard.php');
        } elseif ($user['role'] === 'teacher') {
            header("Location: ../views/teacher/menu_teacher.php");
        }
        else {
            header('Location: ../views/student/menu_student.php');
        }
        exit();
    } else {
        $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng!';
        mysqli_close($conn);
        header('Location: ../index.php');
        exit();
    }
}
?>
