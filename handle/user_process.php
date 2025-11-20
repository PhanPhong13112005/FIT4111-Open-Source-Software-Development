<?php
require_once __DIR__ . '/../functions/user_functions.php';

// Xác định action
$action = $_GET['action'] ?? $_POST['action'] ?? '';

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
}

/**
 * Lấy tất cả người dùng
 */
function handleGetAllUsers() {
    $roleFilter = $_GET['role'] ?? '';
    $keyword = trim($_GET['keyword'] ?? '');
    return getAllUsers($roleFilter, $keyword);
}

function handleGetUserById($id) {
    return getUserById($id);
}

/**
 * Xử lý tạo người dùng mới
 */
function handleCreateUser() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/admin/manage_users.php?error=Phương thức không hợp lệ");
        exit();
    }

    // Kiểm tra dữ liệu
    if (
        !isset($_POST['username']) || 
        !isset($_POST['email']) || 
        !isset($_POST['password']) || 
        !isset($_POST['phone']) || 
        !isset($_POST['role'])
    ) {
        header("Location: ../views/admin/users/add_user.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $role = trim($_POST['role']);

    // Validate cơ bản
    if (empty($username) || empty($email) || empty($password) || empty($phone)) {
        header("Location: ../views/admin/users/add_user.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm người dùng
    $result = addUser($username, $email, $role, $password, $phone);

    if ($result) {
        header("Location: ../views/admin/manage_users.php?success=Thêm người dùng thành công");
    } else {
        header("Location: ../views/admin/users/add_user.php?error=Có lỗi xảy ra khi thêm người dùng");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa người dùng
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
    $phone = trim($_POST['phone']);  // 👈 Thêm dòng này
    
    // Validate dữ liệu
    if (empty($username) || empty($email)) {
        header("Location: ../views/admin/edit_users.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }
    
    // Gọi function để cập nhật người dùng
    $result = updateUser($id, $username, $email, $role, $phone); 
    
    if ($result) {
        header("Location: ../views/admin/manage_users.php?success=Cập nhật người dùng thành công");
    } else {
        header("Location: ../views/admin/edit_users.php?id=" . $id . "&error=Cập nhật người dùng thất bại");
    }
    exit();
}


/**
 * Xử lý xóa người dùng
 */
function handleDeleteUser() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/admin/manage_users.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: ../views/admin/manage_users.php?error=ID người dùng không hợp lệ");
        exit();
    }

    $id = $_GET['id'];
    $result = deleteUser($id);

    if ($result) {
        header("Location: ../views/admin/manage_users.php?success=Xóa người dùng thành công");
    } else {
        header("Location: ../views/admin/manage_users.php?error=Xóa người dùng thất bại");
    }
    exit();
}
?>
