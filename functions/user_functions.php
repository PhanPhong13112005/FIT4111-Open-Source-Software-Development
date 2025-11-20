
<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách students từ database
 * @return array Danh sách students
 */
function getAllUsers($role = '', $keyword = '') {
    $conn = getDbConnection();

    $sql = "SELECT id, username, email, role, phone FROM users";
    $conditions = [];
    $params = [];

    // Lọc theo vai trò
    if ($role !== '') {
        $conditions[] = "role = ?";
        $params[] = $role;
    }

    // Tìm kiếm theo username hoặc email
    if ($keyword !== '') {
        $conditions[] = "(username LIKE ? OR email LIKE ?)";
        $params[] = "%$keyword%";
        $params[] = "%$keyword%";
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY id DESC";

    $stmt = mysqli_prepare($conn, $sql);

    if (!empty($params)) {
        // Xây dựng kiểu dữ liệu cho bind_param
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $users;
}

/**
 * Thêm student mới
 * @param string $username tên
 * @param string $email thư
 * @param string $phone
 * @param string $password
 * @param string $role vai trò
 * @return bool True nếu thành công, False nếu thất bại
 */
function addUser($username, $email, $role, $password, $phone) {
    $conn = getDbConnection();

    // Mã hóa mật khẩu an toàn
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Câu lệnh SQL thêm người dùng
    $sql = "INSERT INTO users (username, email, password, phone, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedPassword, $phone, $role);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}


/**
 * Lấy thông tin một student theo ID
 * @param int $id ID của student
 * @return array|null Thông tin student hoặc null nếu không tìm thấy
 */
function getUserById($id) {
    $conn = getDbConnection();
    
    $sql = "SELECT id, username, email, role FROM users WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $user;
        }
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
    return null;
}

/**
 * Cập nhật thông tin student
 * @param int $id ID của người dùng
 * @param string $username tên người dùng mới
 * @param string $email email mới
 * @param string $role vai trò
 * @param string $phone số điện thoại
 * @return bool True nếu thành công, False nếu thất bại
 */
function updateUser($id, $username, $email, $role, $phone) {
    $conn = getDbConnection();
    
    $sql = "UPDATE users SET username = ?, email = ?, role = ?, phone = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $role, $phone, $id);
        $success = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }
    
    mysqli_close($conn);
    return false;
}


/**
 * Xóa user theo ID
 * @param int $id ID của user cần xóa
 * @return bool True nếu thành công, False nếu thất bại
 */
function deleteUser($id) {
    $conn = getDbConnection();
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }
    
    mysqli_close($conn);
    return false;
}
?>
