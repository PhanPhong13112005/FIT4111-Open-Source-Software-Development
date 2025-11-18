<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/course_functions.php';
checkLogin('/BaiTapLon/index.php');

if (!isset($_GET['course_id'])) {
    die("Khóa học không tồn tại");
}

$course_id = intval($_GET['course_id']);
$course = getCourseById($course_id);
if (!$course) die("Khóa học không tồn tại");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .qr-box { text-align:center; margin-bottom:20px; }
        .info-box { background:#f8f9fa; padding:15px; border-radius:5px; }
    </style>
</head>
<body>
<?php include '../menu.php'; ?>

<div class="container py-5">
    <h2 class="mb-4 text-center">Thanh toán khóa học: <?= htmlspecialchars($course['title']) ?></h2>

    <p>Đơn hàng tự động hủy sau: <span id="countdown">00:14:00</span></p>

    <div class="qr-box">
        <img src="/BaiTapLon/images/maqr.jpg" alt="QR Code" style="width:200px;">
        <p>Quét mã QR để thanh toán</p>
    </div>

    <div class="info-box">
        <p><strong>Ngân hàng:</strong> MBBank</p>
        <p><strong>Số tài khoản:</strong> 0865063397</p>
        <p><strong>Tên tài khoản:</strong> Phan Lưu Phong</p>
        <p><strong>Số tiền:</strong> <?= number_format($course['price'],0,',','.') ?>đ</p>
        <p><strong>Nội dung:</strong> KH<?= $course['id'] ?></p>
        <p>Lưu ý: Nếu đơn hàng của bạn không tự động kích hoạt sau khi chuyển khoản 5 phút, vui lòng liên hệ để được hỗ trợ.</p>
    </div>

    <div class="text-center mt-4">
        <a href="/BaiTapLon/views/student/my_courses.php" class="btn btn-primary">← Quay lại danh sách khóa học</a>
        <button class="btn btn-success ms-2">Tôi đã thanh toán</button>
    </div>
</div>

<script>
    // Đồng hồ đếm ngược 14 phút
    let time = 15 * 60;
    const countdownEl = document.getElementById('countdown');
    setInterval(() => {
        let minutes = Math.floor(time / 60).toString().padStart(2,'0');
        let seconds = (time % 60).toString().padStart(2,'0');
        countdownEl.textContent = `00:${minutes}:${seconds}`;
        if(time > 0) time--;
    }, 1000);
</script>

</body>
</html>
