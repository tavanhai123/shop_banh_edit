<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: dnhap.php"); // Chuyển hướng nếu chưa đăng nhập
    exit();
}

// Lấy userrole từ session
$userrole = $_SESSION['userrole'];

// Ghi log giá trị userrole
error_log("User Role on Role Page: " . $userrole); // Ghi log giá trị userrole

// Chuyển hướng dựa trên userrole
if ($userrole == 1) {
    header("Location: admin.php"); // Admin
    exit(); // Đảm bảo dừng thực thi sau khi chuyển hướng
} elseif ($userrole == 2) {
    header("Location: index.php"); // User
    exit(); // Đảm bảo dừng thực thi sau khi chuyển hướng
}

?>

