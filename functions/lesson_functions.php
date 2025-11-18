<?php
require_once __DIR__ . '/db_connection.php';

function getLessonsByCourseId($course_id) {
    $conn = getDbConnection(); // gọi hàm để lấy kết nối

    // Chuẩn bị câu lệnh
    $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY id ASC";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Lỗi prepare: " . mysqli_error($conn));
    }

    // Gán tham số
    mysqli_stmt_bind_param($stmt, "i", $course_id);

    // Thực thi
    mysqli_stmt_execute($stmt);

    // Lấy kết quả
    $result = mysqli_stmt_get_result($stmt);
    $lessons = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Giải phóng
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $lessons;
}
?>
