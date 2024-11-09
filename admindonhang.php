<?php
session_start();
$servername = "localhost"; 
$db_username = "root"; 
$db_password = ""; 
$dbname = "shopbanh"; 

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
$conn->set_charset("utf8"); 

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

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
        $_SESSION['fullname'] = $fullname;
    } else {
        $fullname = "Admin";
    }

    $stmt->close();
}

// Truy vấn để lấy dữ liệu đơn hàng

$sql = "SELECT o.OrderID, u.FullName AS CustomerName, o.OrderDate, o.Total, o.Status 
        FROM `order` o 
        JOIN `user` u ON o.UserID = u.UserID";

$result = $conn->query($sql);

// Kiểm tra xem truy vấn có thành công hay không
if ($result === false) {
    die("Lỗi truy vấn: " . $conn->error);
}

// Khởi tạo một mảng để chứa dữ liệu đơn hàng
$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row; // Thêm từng đơn hàng vào mảng
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
        <aside class="sidebar open">
            <div class="top-sidebar">
                <a href="#" class="channel-logo"><img src="./assets/img/logo.png" alt="Channel Logo"></a>
            </div>

            <div class="middle-sidebar">
                <ul class="sidebar-list">
                    <li class="sidebar-list-item tab-content ">
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
                    <li class="sidebar-list-item tab-content ">
                        <a href="adminkhachhang.php" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa-light fa-users"></i></div>
                            <div class="hidden-sidebar">Khách hàng</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item tab-content active">
                        <a href="admindonhang.php" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa-light fa-basket-shopping"></i></div>
                            <div class="hidden-sidebar">Đơn hàng</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item tab-content">
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
                            <div class="hidden-sidebar"><?php echo isset($_SESSION['fullname']) ? htmlspecialchars($_SESSION['fullname']) : 'Tài khoản'; ?></div>
                        </a>
                    </li>
                    <li class="sidebar-list-item user-logout">
                        <a href="dxuat.php" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa-light fa-arrow-right-from-bracket"></i></div>
                            <div class="hidden-sidebar">Đăng xuất</div>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <main class="content">
            <!-- Order  -->
            <div class="section">
            <div class="admin-control">
                    <div class="admin-control-left">
                        <select name="tinh-trang" id="tinh-trang" onchange="findOrder()">
                            <option value="2">Tất cả</option>
                            <option value="1">Đã xử lý</option>
                            <option value="0">Chưa xử lý</option>
                        </select>
                    </div>
                    <div class="admin-control-center">
                        <form action="" class="form-search">
                            <span class="search-btn"><i class="fa-light fa-magnifying-glass"></i></span>
                            <input id="form-search-order" type="text" class="form-search-input" placeholder="Tìm kiếm mã đơn, khách hàng..." oninput="findOrder()">
                        </form>
                    </div>
                    <div class="admin-control-right">
                        <form action="" class="fillter-date">
                            <div>
                                <label for="time-start">Từ</label>
                                <input type="date" class="form-control-date" id="time-start" onchange="findOrder()">
                            </div>
                            <div>
                                <label for="time-end">Đến</label>
                                <input type="date" class="form-control-date" id="time-end" onchange="findOrder()">
                            </div>
                        </form>      
                        <button class="btn-reset-order" onclick="cancelSearchOrder()"><i class="fa-light fa-arrow-rotate-right"></i></button>               
                    </div>
                </div>
                <div class="table">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>Mã đơn</td>
                                <td>Khách hàng</td>
                                <td>Ngày đặt</td>
                                <td>Tổng tiền</td>
                                <td>Trạng thái</td>
                                <td>Thao tác</td>
                            </tr>
                        </thead>
                        <tbody id="showOrder">
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                                    <td><?php echo htmlspecialchars($order['CustomerName']); ?></td>
                                    <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                                    <td><?php echo htmlspecialchars($order['Total']); ?></td>
                                    <td><?php echo htmlspecialchars($order['Status']); ?></td>
                                    <td>
                                    <button class="btn-view" onclick="viewOrder(<?php echo htmlspecialchars($order['OrderID']); ?>)">Xem chi tiết</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        function editOrder(orderID) {
            // Chuyển hướng đến trang chỉnh sửa đơn hàng
            window.location.href = `editOrder.php?orderID=${orderID}`;
        }

        function deleteOrder(orderID) {
            if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
                // Gửi yêu cầu xóa đơn hàng
                fetch(`deleteOrder.php?orderID=${orderID}`, { method: 'DELETE' })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message); // Hiển thị thông báo
                        location.reload(); // Tải lại trang
                    })
                    .catch(error => console.error('Lỗi:', error));
            }
        }
    </script>
</body>
</html>
