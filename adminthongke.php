<?php
session_start();
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "shopbanh"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Kiểm tra nếu chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['username']) || $_SESSION['userrole'] != 1) {
    header("Location: dnhap.php"); 
    exit();
}

// Kiểm tra và lấy thông tin người dùng từ session
$fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; 
$username = $_SESSION['username'];
$userrole = $_SESSION['userrole'];

// Nếu chưa lấy fullname từ session, truy vấn để lấy nó từ CSDL
if (empty($fullname)) {
    // Truy vấn dữ liệu của admin từ CSDL
    $stmt = $conn->prepare("SELECT FullName FROM user WHERE Username = ? AND userrole = 1");

    if ($stmt === false) {
        die('Lỗi câu lệnh SQL: ' . $conn->error); 
    }

    // Liên kết tham số và thực thi câu lệnh
    $stmt->bind_param("s", $username); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $fullname = $user['FullName'];  
        $_SESSION['fullname'] = $fullname;  // Lưu fullname vào session để sử dụng sau
    } else {
        $fullname = "Admin"; 
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='./assets/img/logo.png' rel='icon' type='image/x-icon' />
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="./assets/css/toast-message.css">
    <link href="./assets/font/font-awesome-pro-v6-6.2.0/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="./assets/css/admin-responsive.css">
    <title>Quản lý cửa hàng</title>
</head>
<body>
    <header class="header">
        <button class="menu-icon-btn">
            <div class="menu-icon">
                <i class="fa-regular fa-bars"></i>
            </div>
        </button>
    </header>
    <div class="container">
        <div class="div-left">
            <aside class="sidebar open">
                <div class="top-sidebar">
                    <a href="#" class="channel-logo"><img src="./assets/img/logo.png" alt="Channel Logo"></a>
                
                </div>
                <div class="middle-sidebar">
                    <ul class="sidebar-list">
                        <li class="sidebar-list-item tab-content">
                            <a href="admin.php" class="sidebar-link">
                                <div class="sidebar-icon"><i class="fa-light fa-house"></i></div>
                                <div class="hidden-sidebar">Trang tổng quan</div>
                            </a>
                        </li>
                        <li class="sidebar-list-item tab-content">
                            <a href="adminsp.php" class="sidebar-link">
                                <div class="sidebar-icon"><i class="fa-light fa-pot-food"></i></div>
                                <div class="hidden-sidebar">Sản phẩm</div>
                            </a>
                        </li>
                        <li class="sidebar-list-item tab-content">
                            <a href="adminkhachhang.php" class="sidebar-link">
                                <div class="sidebar-icon"><i class="fa-light fa-users"></i></div>
                                <div class="hidden-sidebar">Khách hàng</div>
                            </a>
                        </li>
                        <li class="sidebar-list-item tab-content">
                            <a href="admindonhang.php" class="sidebar-link">
                                <div class="sidebar-icon"><i class="fa-light fa-basket-shopping"></i></div>
                                <div class="hidden-sidebar">Đơn hàng</div>
                            </a>
                        </li>
                        <li class="sidebar-list-item tab-content active">
                            <a href="adminthongke.php" class="sidebar-link">
                                <div class="sidebar-icon"><i class="fa-light fa-chart-simple"></i></div>
                                <div class="hidden-sidebar">Thống kê</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="bottom-sidebar">
                    <ul class="sidebar-list">
                        <li class="sidebar-list-item user-logout">
                            <a href="account.php" class="sidebar-link">
                                <div class="sidebar-icon"><i class="fa-light fa-circle-user"></i></div>
                                <div class="hidden-sidebar" id="name-acc"><?php echo htmlspecialchars($fullname); ?></div>
                            </a>
                        </li>
                        <li class="sidebar-list-item user-logout">
                            <a href="dxuat.php" class="sidebar-link" id="logout-acc">
                                <div class="sidebar-icon"><i class="fa-light fa-arrow-right-from-bracket"></i></div>
                                <div class="hidden-sidebar">Đăng xuất</div>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
            </div>
        <div class="section">
            <div class="admin-control">
                <div class="admin-control-left">
                    <select name="the-loai-tk" id="the-loai-tk">
                        <option>Tất cả</option>
                        <option>Món chay</option>
                        <option>Món mặn</option>
                        <option>Món lẩu</option>
                        <option>Món ăn vặt</option>
                        <option>Món tráng miệng</option>
                        <option>Nước uống</option>
                        <option>Món khác</option>
                    </select>
                </div>
                <div class="admin-control-center">
                    <form action="" class="form-search">
                        <span class="search-btn"><i class="fa-light fa-magnifying-glass"></i></span>
                        <input id="form-search-tk" type="text" class="form-search-input" placeholder="Tìm kiếm tên món...">
                    </form>
                </div>
                <div class="admin-control-right">
                    <form action="" class="fillter-date">
                        <div>
                            <label for="time-start">Từ</label>
                            <input type="date" class="form-control-date" id="time-start-tk">
                        </div>
                        <div>
                            <label for="time-end">Đến</label>
                            <input type="date" class="form-control-date" id="time-end-tk">
                        </div>
                    </form> 
                    <button class="btn-reset-order"><i class="fa-regular fa-arrow-up-short-wide"></i></i></button>
                    <button class="btn-reset-order"><i class="fa-regular fa-arrow-down-wide-short"></i></button>
                    <button class="btn-reset-order"><i class="fa-light fa-arrow-rotate-right"></i></button>                    
                </div>
            </div>
            <div class="order-statistical" id="order-statistical">
                <div class="order-statistical-item">
                    <div class="order-statistical-item-content">
                        <p class="order-statistical-item-content-desc">Sản phẩm được bán ra</p>
                        <h4 class="order-statistical-item-content-h" id="quantity-product">0</h4>
                    </div>
                    <div class="order-statistical-item-icon">
                        <i class="fa-light fa-salad"></i>
                    </div>
                </div>
                <div class="order-statistical-item">
                    <div class="order-statistical-item-content">
                        <p class="order-statistical-item-content-desc">Số lượng bán ra</p>
                        <h4 class="order-statistical-item-content-h" id="quantity-order">0</h4>
                    </div>
                    <div class="order-statistical-item-icon">
                        <i class="fa-light fa-file-lines"></i>
                    </div>
                </div>
                <div class="order-statistical-item">
                    <div class="order-statistical-item-content">
                        <p class="order-statistical-item-content-desc">Doanh thu</p>
                        <h4 class="order-statistical-item-content-h" id="quantity-sale">0VND</h4>
                    </div>
                    <div class="order-statistical-item-icon">
                        <i class="fa-light fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="table">
                <table width="100%">
                    <thead>
                        <tr>
                            <td>STT</td>
                            <td>Tên món</td>
                            <td>Số lượng bán</td>
                            <td>Doanh thu</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="showTk">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>