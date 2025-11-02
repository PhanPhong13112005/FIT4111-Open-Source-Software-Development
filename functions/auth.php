<?php
/**
 * Kiểm tra đăng nhập
 */
function checkLogin($redirectPath = '../index.php') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        $_SESSION['error'] = 'Bạn cần đăng nhập để truy cập trang này!';
        header('Location: ' . $redirectPath);
        exit();
    }
}

/**
 * Đăng xuất
 */
function logout($redirectPath = '../index.php') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();
    session_destroy();

    session_start();
    $_SESSION['success'] = 'Đăng xuất thành công!';
    header('Location: ' . $redirectPath);
    exit();
}

/**
 * Lấy user hiện tại
 */
function getCurrentUser() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_id'])) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role'] ?? null
        ];
    }
    return null;
}

/**
 * Kiểm tra đăng nhập
 */
function isLoggedIn() { 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['user_id']);
}

/**
 * Xác thực user đăng nhập
 */

function authenticateUser($conn, $username, $password) {
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // trả về thông tin user
    } else {
        return null;
    }
}
?>

