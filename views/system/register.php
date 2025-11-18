<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="/BaiTapLon/css/register.css">
</head>

<body>
    <div class="form-container">
        <h2>Đăng ký tài khoản</h2>

        <?php
        if (isset($_GET['success'])) {
            echo "<p style='color: green; font-weight: bold;'>Đăng ký thành công! <a href='login.php'>Đăng nhập ngay</a></p>";
        } elseif (isset($_GET['error'])) {
            $err = $_GET['error'];
            if ($err == 'empty')
                echo "<p style='color:red;'>Vui lòng điền đầy đủ thông tin.</p>";
            elseif ($err == 'nomatch')
                echo "<p style='color:red;'>Mật khẩu nhập lại không khớp.</p>";
            elseif ($err == 'exists')
                echo "<p style='color:red;'>Email đã tồn tại trong hệ thống.</p>";
            else
                echo "<p style='color:red;'>Đã xảy ra lỗi, vui lòng thử lại.</p>";
        }
        ?>

        <form action="/baitaplon/handle/register_process.php" method="POST">
            <label>Tên người dùng:</label>
            <input type="text" name="username" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Số điện thoại:</label>
            <input type="tel" name="phone" pattern="[0-9]{10}" required>

            <label>Mật khẩu:</label>
            <input type="password" name="password" required>

            <label>Nhập lại mật khẩu:</label>
            <input type="password" name="confirm" required>

            <button type="submit">Đăng ký</button>
        </form>

        <p>Đã có tài khoản? <a href="/baitaplon/views/system/login.php">Đăng nhập</a></p>
    </div>
</body>

</html>