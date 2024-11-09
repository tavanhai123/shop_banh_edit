<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost"; // Thay đổi nếu cần
$username = "root"; // Tên người dùng MySQL
$password = ""; // Mật khẩu MySQL
$dbname = "shopbanh"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Đặt mã hóa ký tự
$conn->set_charset("utf8");

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = $_POST['password']; // Mật khẩu gốc
    $password_confirmation = $_POST['password_confirmation'];
    $created_time = date("Y-m-d H:i:s"); // Thời gian tạo tài khoản

    // Kiểm tra mật khẩu xác nhận
    if ($password !== $password_confirmation) {
        echo "<p style='color:red;'>Mật khẩu không khớp.</p>";
    } else {
        // Kiểm tra tên đăng nhập có tồn tại không
        $check_username = $conn->prepare("SELECT * FROM user WHERE Username = ?");
        $check_username->bind_param("s", $username);
        $check_username->execute();
        $result = $check_username->get_result();

        if ($result->num_rows > 0) {
            // Hiển thị thông báo lỗi trong form
            $error_message = "Tên đăng nhập đã được dùng.";
        } else {
            // Chuẩn bị câu lệnh SQL để chèn dữ liệu bao gồm thời gian tạo và gán userrole = 2
            $sql = "INSERT INTO user (Fullname, Username, Password, userrole, created_time) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Gán giá trị cho userrole
            $userrole = 2;  // Gán vai trò người dùng là 2 (người dùng)

            // Thực hiện bind các giá trị cần thiết cho câu lệnh SQL
            $stmt->bind_param("sssss", htmlspecialchars($fullname), htmlspecialchars($username), $password, $userrole, $created_time);

            // Thực thi câu lệnh SQL
            if ($stmt->execute()) {
                // Chuyển hướng về trang đăng nhập mà không in ra văn bản trước đó
                header("Location: dnhap.php");
                exit();
            } else {
                echo "<p style='color:red;'>Lỗi: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }

        $check_username->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <link href='./assets/img/logo.png' rel='icon' type='image/x-icon' />
    <link rel="stylesheet" href="./assets/css/main.css">
</head>
<body>
<div class="form-content sign-up">
    <h3 class="form-title">Đăng ký tài khoản</h3>
    <p class="form-description">Đăng ký thành viên để mua hàng và nhận những ưu đãi đặc biệt từ chúng tôi.</p>
    <form action="" method="POST" class="signup-form">
        <div class="form-group">
            <label for="fullname" class="form-label">Tên đầy đủ</label>
            <input id="fullname" name="fullname" type="text" placeholder="VD: Văn Hải" class="form-control" required>
            <span class="form-message-name form-message"></span>
        </div>
        <div class="form-group">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input id="username" name="username" type="text" placeholder="Nhập tên đăng nhập" class="form-control" required>
            <span class="form-message-username form-message"></span>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu</label>
            <input id="password" name="password" type="password" placeholder="Nhập mật khẩu" class="form-control" required>
            <span class="form-message-password form-message"></span>
        </div>
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
            <input id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" type="password" class="form-control" required>
            <span class="form-message-password-confi form-message"></span>
        </div>
        <div class="form-group">
            <input class="checkbox" name="checkbox" required="" type="checkbox" id="checkbox-signup">
            <label for="checkbox-signup" class="form-checkbox">Tôi đồng ý với <a href="#" title="chính sách trang web" target="_blank">chính sách trang web</a></label>
            <p class="form-message-checkbox form-message"></p>
        </div>

        <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
        
        <button class="form-submit" id="signup-button" type="submit">Đăng ký</button>
        <div class="back-home">
            <a href="index.php">← Quay lại trang chủ</a>
        </div>
    </form>
    <p class="change-login">Bạn đã có tài khoản? <a href="dnhap.php" class="login-link">Đăng nhập ngay</a></p>
</div>
</body>
</html>
