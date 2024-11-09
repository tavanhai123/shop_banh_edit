<?php
// Bắt đầu session
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "localhost"; // Địa chỉ máy chủ
$db_username = "root"; // Tên người dùng MySQL
$db_password = ""; // Mật khẩu MySQL
$dbname = "shopbanh"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
$conn->set_charset("utf8"); // Đặt bộ mã ký tự

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lấy thông tin từ database
    $sql = "SELECT * FROM user WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra kết quả
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu
        if ($user['Password'] === $password) { // Thay thế bằng password_verify nếu dùng password_hash
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $user['FullName'];
            $_SESSION['userrole'] = (string)$user['UserRole']; // Lưu UserRole vào session như chuỗi

            // Chuyển hướng dựa vào UserRole
            if ($_SESSION['userrole'] === '1') {
                header("Location: admin.php"); // Admin
            } elseif ($_SESSION['userrole'] === '2') {
                header("Location: index.php"); // User
            } else {
                $error_message = "Lỗi phân quyền: Không xác định UserRole.";
            }
            exit();
        } else {
            $error_message = "Mật khẩu không đúng.";
        }
    } else {
        $error_message = "Đăng nhập thất bại. Vui lòng kiểm tra lại tên đăng nhập.";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Cake</title>
    <link href='./assets/img/logo.png' rel='icon' type='image/x-icon' />
    <link rel="stylesheet" href="./assets/css/main.css">
</head>
<body>
    <div class="form-content login">
        <h3 class="form-title">Đăng nhập tài khoản</h3>
        <p class="form-description">Đăng nhập thành viên để mua hàng và nhận những ưu đãi đặc biệt từ chúng tôi</p>
        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input id="username-login" name="username" type="text" placeholder="Nhập tên đăng nhập" class="form-control" required>
                <span class="form-message usernamelog"></span>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password-login" name="password" type="password" placeholder="Nhập mật khẩu" class="form-control" required>
                <span class="form-message-check-login form-message"></span>
            </div>
            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <button class="form-submit" id="login-button">Đăng nhập</button>
            <div class="back-home">
                <a href="trangchuaffter.html">← Quay lại trang chủ</a>
            </div>
        </form>
        <p class="change-login">Bạn chưa có tài khoản? <a href="dky.php" class="signup-link">Đăng ký ngay</a></p>
    </div>
</body>
</html>
