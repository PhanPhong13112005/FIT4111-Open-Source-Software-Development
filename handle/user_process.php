<?php
// session_start();
require_once __DIR__ . '/../functions/user_functions.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateUser();
        break;
    case 'edit':
        handleEditUser();
        break;
    case 'delete':
        handleDeleteUser();
        break;
    // default:
    //     header("Location: ../views/student.php?error=Hành động không hợp lệ");
    //     exit();
}
/**
 * Lấy tất cả danh sách sinh viên
 */
function handleGetAllUsers() {
    return getAllUsers();
}

function handleGetUserById($id) {
    return getUserById($id);
}

/**
 * Xử lý tạo sinh viên mới
 */
function handleCreateUser() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/admin/manage_users.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_POST['username']) || !isset($_POST['email'])) {
        header("Location: ../views/admin/create_users.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    
    // Validate dữ liệu
    if (empty($username) || empty($gmail)) {
        header("Location: ../views/admin/create_users.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }
    
    // Gọi hàm thêm sinh viên
    $result = addUser($username, $email, $role);
    
    if ($result) {
        header("Location: ../views/admin/manage_users.php?success=Thêm sinh viên thành công");
    } else {
        header("Location: ../views/admin/student/create_users.php?error=Có lỗi xảy ra khi thêm sinh viên");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa sinh viên
 */
function handleEditUser() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/admin/manage_users.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_POST['id']) || !isset($_POST['username']) || !isset($_POST['email'])) {
        header("Location: ../views/admin/manage_users.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    
    // Validate dữ liệu
    if (empty($username) || empty($email)) {
        header("Location: ../views/admin/edit_users.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }
    
    // Gọi function để cập nhật nguời dùng
    $result = updateUser($id, $username, $email, $role);
    
    if ($result) {
        header("Location: ../views/admin/manage_users.php?success=Cập nhật sinh viên thành công");
    } else {
        header("Location: ../views/admin/edit_users.php?id=" . $id . "&error=Cập nhật sinh viên thất bại");
    }
    exit();
}

/**
 * Xử lý xóa sinh viên
 */
function handleDeleteUser() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/admin/manage_users.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/admin/manage_users.php?error=Không tìm thấy ID sinh viên");
        exit();
    }
    
    $id = $_GET['id'];
    
    // Validate ID là số
    if (!is_numeric($id)) {
        header("Location: ../views/admin/manage_users.php?error=ID sinh viên không hợp lệ");
        exit();
    }
    
    // Gọi function để xóa sinh viên
    $result = deleteUser($id);
    
    if ($result) {
        header("Location: ../views/admin/manage_users.php?success=Xóa sinh viên thành công");
    } else {
        header("Location: ../views/admin/manage_users.php?error=Xóa sinh viên thất bại");
    }
    exit();
}
?>
