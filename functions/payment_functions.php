<?php
require_once __DIR__ . '/db_connection.php'; // file bạn vừa gửi

function createPayment($user_id, $course_id, $amount) {
    $conn = getDbConnection(); // Lấy kết nối từ hàm

    $stmt = $conn->prepare("INSERT INTO payments (user_id, course_id, amount, status) VALUES (?, ?, ?, 'pending')");
    if (!$stmt) {
        die("Lỗi prepare statement: " . $conn->error);
    }

    $stmt->bind_param("iid", $user_id, $course_id, $amount);
    $stmt->execute();

    $insert_id = $conn->insert_id;
    $conn->close(); // đóng kết nối sau khi xong
    return $insert_id;
}
