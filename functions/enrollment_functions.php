<?php
require_once __DIR__ . '/db_connection.php';

/** Kiểm tra sinh viên đã đăng ký khóa học chưa */
function checkEnrollmentExists($user_id, $course_id) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    $conn->close();
    return $exists;
}

/** Thêm đăng ký mới */
function addEnrollment($user_id, $course_id) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("INSERT INTO enrollments (user_id, course_id, enroll_date, status) VALUES (?, ?, NOW(), 1)");
    $stmt->bind_param("ii", $user_id, $course_id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

/** Lấy danh sách khóa học sinh viên đã đăng ký */
function getEnrollmentsByStudent($user_id) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("
        SELECT c.*, e.enroll_date, e.status
        FROM enrollments e
        JOIN courses c ON e.course_id = c.id
        WHERE e.user_id = ?
        ORDER BY e.enroll_date DESC
    ");
    $stmt->bind_param("i", $user_id);
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

/** Hủy đăng ký khóa học */
function cancelEnrollment($user_id, $course_id) {
    $conn = getDbConnection();
    $stmt = $conn->prepare("DELETE FROM enrollments WHERE user_id = ? AND course_id = ?");
    $stmt->bind_param("ii", $user_id, $course_id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}
?>
