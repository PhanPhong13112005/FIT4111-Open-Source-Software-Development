<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách courses từ database
 * @return array Danh sách courses
 */
function getAllCourses() {
    $conn = getDbConnection();
    
    $sql = "SELECT id, title, description, teacher, price, image, created_at 
            FROM courses ORDER BY id";
    $result = mysqli_query($conn, $sql);
    
    $courses = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }
    }
    
    mysqli_close($conn);
    return $courses;
}

/**
 * Thêm course mới
 * @param string $title
 * @param string $description
 * @param string $teacher
 * @param float $price
 * @param string $image
 * @return bool
 */
function addCourse($title, $description, $teacher, $price, $image) {
    $conn = getDbConnection();
    
    $sql = "INSERT INTO courses (title, description, teacher, price, image, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssds", $title, $description, $teacher, $price, $image);
        $success = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }
    
    mysqli_close($conn);
    return false;
}

/**
 * Lấy thông tin một course theo ID
 * @param int $id
 * @return array|null
 */
function getCourseById($id) {
    $conn = getDbConnection();
    
    $sql = "SELECT id, title, description, teacher, price, image, created_at 
            FROM courses 
            WHERE id = ? 
            LIMIT 1";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        mysqli_close($conn);
        return null;
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $course = null;
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $course = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $course;
}

/**
 * Cập nhật thông tin course
 * @param int $id
 * @param string $title
 * @param string $description
 * @param string $teacher
 * @param float $price
 * @param string $image
 * @return bool
 */
function updateCourse($id, $title, $description, $teacher, $price, $image) {
    $conn = getDbConnection();
    
    $sql = "UPDATE courses 
            SET title = ?, description = ?, teacher = ?, price = ?, image = ?
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssdsi", $title, $description, $teacher, $price, $image, $id);
        $success = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }
    
    mysqli_close($conn);
    return false;
}

/**
 * Xóa course theo ID
 * @param int $id
 * @return bool
 */
function deleteCourse($id) {
    $conn = getDbConnection();
    
    $sql = "DELETE FROM courses WHERE id = ?";
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
function getPopularCourses($limit = 5) {
    require_once 'db_connection.php';

    $conn = getDbConnection();

    $sql = "SELECT c.id, c.title, c.description, c.teacher, c.price, c.image, 
                   COUNT(e.id) AS total_enrollments
            FROM courses c
            LEFT JOIN enrollments e ON c.id = e.course_id
            GROUP BY c.id
            ORDER BY total_enrollments DESC
            LIMIT ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $courses;
}


?>
