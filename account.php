<?php
$servername = "localhost"; // Địa chỉ máy chủ
$username = "root"; // Tên người dùng cơ sở dữ liệu
$password = ""; // Mật khẩu của cơ sở dữ liệu
$dbname = "shopbanh"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: index.php'); // Chuyển hướng nếu chưa đăng nhập
    exit;
}

// Lấy tên người dùng từ session
$username = $_SESSION['username'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT fullname, email, phone FROM user WHERE username='$username'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullname = $row['fullname'];
    $email = $row['email'];
    $phone = $row['phone'];
} else {
    $fullname = $email = $phone = ''; // Gán giá trị rỗng nếu không có dữ liệu
}

$message = ""; // Khởi tạo thông báo trống

// Xử lý form khi được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Kiểm tra xem các trường không để trống
    if (!empty($fullname) && !empty($email) && !empty($phone)) {
        // Câu truy vấn để cập nhật thông tin người dùng
        $sql = "UPDATE user SET fullname='$fullname', email='$email', phone='$phone' WHERE username='$username'";

        if ($conn->query($sql) === TRUE) {
            $message = "Cập nhật thông tin thành công!";
        } else {
            $message = "Lỗi: " . $conn->error;
        }
    } else {
        $message = "Vui lòng điền đầy đủ thông tin.";
    }
}

// Đóng kết nối
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
    <link rel="stylesheet" href="./assets/css/home-responsive.css">
    <link rel="stylesheet" href="./assets/css/toast-message.css">
    <link rel="stylesheet" href="./assets/font/font-awesome-pro-v6-6.2.0/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<header>
    <div class="header-middle">
        <div class="container">
            <div class="header-middle-left">
                <div class="header-logo">
                    <a href="">
                        <img src="./assets/img/logo.png" alt="" class="header-logo-img">
                    </a>
                </div>
            </div>
            <div class="header-middle-center">
                <form action="" class="form-search">
                    <span class="search-btn"><i class="fa-light fa-magnifying-glass"></i></span>
                    <input type="text" class="form-search-input" placeholder="Tìm kiếm món ăn...">
                    <button class="filter-btn"><i class="fa-light fa-filter-list"></i><span>Lọc</span></button>
                </form>
            </div>
            <div class="header-middle-right">
                <ul class="header-middle-right-list">
                    <li class="header-middle-right-item dropdown open">
                            <i class="fa-light fa-user"></i>
                            <div class="auth-container">
                                <?php if (isset($_SESSION['username'])): ?>
                                    <a href="account.php" class="text-tk"><?php echo htmlspecialchars($_SESSION['username']); ?> <i class="fa-sharp fa-solid fa-caret-down"></i></a>
                                <?php else: ?>
                                    <span class="text-dndk">Đăng nhập / Đăng ký</span>
                                <?php endif; ?>
                            </div>
                            <ul class="header-middle-right-menu">
                                <?php if (isset($_SESSION['username'])): ?>
                                    <li><a href="account.php"><i class="fa-light fa-user-pen"></i> Thay đổi thông tin</a></li>
                                    <li><a href="dxuat.php"><i class="fa-light fa-right-from-bracket"></i> Thoát</a></li>
                                <?php else: ?>
                                    <li><a href="dnhap.php"><i class="fa-light fa-right-to-bracket"></i> Đăng nhập</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>

            
                    <li class="header-middle-right-item open" onclick="window.location.href='giohang.html';">
                        <div class="cart-icon-menu">
                            <a href="#" class="gio-hang">
                                <i class="fa-light fa-basket-shopping"></i>
                                <span class="count-product-cart">0</span>
                            </a>
                        </div>
                        <span>Giỏ hàng</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<div class="modal-cart">
    <div class="cart-container">
        <h2 class="gio-hang-trong" style="display: none;">Giỏ hàng trống</h2>  <ul class="cart-list"></ul>
        <div class="cart-total-container">
            <p class="cart-total-title">Tổng cộng:</p>
            <p class="cart-total-amount">0 ₫</p>  </div>
        <button class="thanh-toan disabled">Thanh toán</button> </div>
</div>
<nav class="header-bottom">
    <div class="container">
        <ul class="menu-list">
            <li class="menu-list-item"><a href="" class="menu-link">Trang chủ</a></li>
            <li class="menu-list-item" ><a href="#" class="menu-link">Cupcake</a></li>
            <li class="menu-list-item"><a href="#" class="menu-link">Bentocake</a></li>
            <li class="menu-list-item"><a href="#" class="menu-link">Chessecake</a></li>
            <li class="menu-list-item" ><a href="#" class="menu-link">Layercake</a></li>
            <li class="menu-list-item" ><a href="#" class="menu-link">Mochicake</a></li>
            <li class="menu-list-item" ><a href="#" class="menu-link">Tiramisu</a></li>
            <li class="menu-list-item" ><a href="#" class="menu-link">Specialcake</a></li>
        </ul>
    </div>
</nav>
<div class="advanced-search">
    <div class="container">
        <div class="advanced-search-category">
            <span>Phân loại </span>
            <select name="" id="advanced-search-category-select" >
                <option>Tất cả</option>
                <option>Cupcake</option>
                <option>Bentocake</option>
                <option>Chessecake</option>
                <option>Layercake</option>
                <option>Mochicake</option>
                <option>Tiramisu</option>
            </select>
        </div>
        <div class="advanced-search-price">
            <span>Giá từ</span>
            <input type="number" placeholder="tối thiểu" id="min-price" >
            <span>đến</span>
            <input type="number" placeholder="tối đa" id="max-price" >
            <button id="advanced-search-price-btn"><i class="fa-light fa-magnifying-glass-dollar"></i></button>
        </div>
        <div class="advanced-search-control">
            <button id="sort-ascending" ><i class="fa-regular fa-arrow-up-short-wide"></i></button>
            <button id="sort-descending"><i class="fa-regular fa-arrow-down-wide-short"></i></button>
            <button id="reset-search" ></button><i class="fa-light fa-arrow-rotate-right"></i></button>
            <button><i class="fa-light fa-xmark"></i></button>
        </div>
    </div>
</div>
<main class="main-wrapper">
    <div class="container" id="trangchu">   
        <div class="home-products" id="home-products">
        </div>
        <div class="page-nav">
            <ul class="page-nav-list">
            </ul>
        </div>
    </div>
    <div class="container" id="account-user">
        <div class="main-account">
            <div class="main-account-header">
                <h3>Thông tin tài khoản của bạn</h3>
                <p>Quản lý thông tin để bảo mật tài khoản</p>
            </div>
            <div class="main-account-body">
                <div class="main-account-body-col">
                    <form action="account.php" method="POST" class="info-user">
                        <div class="form-group">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input class="form-control" type="text" name="fullname" id="fullname" placeholder="Nhập họ và tên của bạn" value="<?php echo htmlspecialchars($fullname); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input class="form-control" type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" disabled="true" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input class="form-control" type="text" name="phone" id="phone" placeholder="Nhập số điện thoại" value="<?php echo htmlspecialchars($phone); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Nhập email của bạn" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <button type="submit" id="save-info-user"><i class="fa-regular fa-floppy-disk"></i> Lưu thay đổi</button>
                        <?php if ($message): ?>
                            <div class="notification"><?php echo $message; ?></div>
                        <?php endif; ?>
                    </form>
                </div>


                    <div class="main-account-body-col">
                    <form action="change_pass.php" method="POST" class="change-password">
                        <div class="form-group">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input class="form-control" type="password" name="current_password" id="current_password" placeholder="Nhập mật khẩu hiện tại" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input class="form-control" type="password" name="new_password" id="new_password" placeholder="Nhập mật khẩu mới" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                            <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
                        </div>
                        <button type="submit" id="save-password"><i class="fa-regular fa-key"></i> Đổi mật khẩu</button>
                    </form>
                    </div>
                    
                    <?php
    if (isset($_SESSION['message'])) {
        echo "<script type='text/javascript'>alert('" . $_SESSION['message'] . "');</script>";
        // Xóa thông báo sau khi hiển thị
        unset($_SESSION['message']);
    }
    ?>
                </div>
            </div>
        </div>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-top-content">
                <div class="footer-top-img">
                    <img src="./assets/img/logo.png" alt="">
                </div>
                <div class="footer-top-subbox">
                    <div class="footer-top-subs">
                        <h2 class="footer-top-subs-title">Đăng ký nhận tin</h2>
                        <p class="footer-top-subs-text">Nhận thông tin mới nhất từ chúng tôi</p>
                    </div>
                    <form class="form-ground">
                        <input type="email" class="form-ground-input" placeholder="Nhập email của bạn">
                        <button class="form-ground-btn">
                            <span>ĐĂNG KÝ</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="widget-area">
        <div class="container">
            <div class="widget-row">
                <div class="widget-row-col-1">
                    <h3 class="widget-title">Về chúng tôi</h3>
                    <div class="widget-row-col-content">
                        <p>Sweet Cake là thương hiệu được thành lập vào năm 2024 với tiêu chí đặt chất lượng sản phẩm lên hàng đầu.</p>
                    </div>
                    <div class="widget-social">
                        <div class="widget-social-item">
                            <a href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                        <div class="widget-social-item">
                            <a href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                        <div class="widget-social-item">
                            <a href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                        <div class="widget-social-item">
                            <a href="">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="widget-row-col">
                    <h3 class="widget-title">Liên kết</h3>
                    <ul class="widget-contact">
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Về chúng tôi</span>
                            </a>
                        </li>
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Thực đơn</span>
                            </a>
                        </li>
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Điều khoản</span>
                            </a>
                        </li>
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Liên hệ</span>
                            </a>
                        </li>
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Tin tức</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="widget-row-col">
                    <h3 class="widget-title">Thực đơn</h3>
                    <ul class="widget-contact">
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Cupcake</span>
                            </a>
                        </li>
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Bentocake</span>
                            </a>
                        </li>
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Chessecake</span>
                            </a>
                        </li>
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Layercake</span>
                            </a>
                        </li>
                        <li class="widget-contact-item">
                            <a href="">
                                <i class="fa-regular fa-arrow-right"></i>
                                <span>Specialcake</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="widget-row-col-1">
                    <h3 class="widget-title">Liên hệ</h3>
                    <div class="contact">
                        <div class="contact-item">
                            <div class="contact-item-icon">
                                <i class="fa-regular fa-location-dot"></i>
                            </div>
                            <div class="contact-content">
                                <span>79 Hồ Tùng Mậu</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-item-icon">
                                <i class="fa-regular fa-phone"></i>
                            </div>
                            <div class="contact-content contact-item-phone">
                                <span>0123 456 789</span>
                                <br>
                                <span>0987 654 321</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-item-icon">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <div class="contact-content conatct-item-email">
                                <span>abc@cake.com</span><br />
                                <span>infoabc@cake.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright-wrap">
    <div class="container">
        <div class="copyright-content">
            <p>Sweet Cake. All Rights Reserved.</p>
        </div>
    </div>
</div>
<div class="back-to-top">
    <a href="#"><i class="fa-regular fa-arrow-up"></i></a>
</div> 
</div>
</body>