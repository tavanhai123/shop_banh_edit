<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopbanh";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Kiểm tra nếu chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['username']) || $_SESSION['userrole'] != 1) {
    header("Location: dnhap.php"); // Điều hướng về trang đăng nhập nếu chưa đăng nhập hoặc không phải admin
    exit();
}

// Kiểm tra và lấy thông tin người dùng từ session
$fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; 
$username = $_SESSION['username']; 
$userrole = $_SESSION['userrole'];  

// Nếu chưa lấy fullname từ session, truy vấn để lấy nó từ CSDL
if (empty($fullname)) {
    $stmt = $conn->prepare("SELECT FullName FROM user WHERE Username = ? AND userrole = 1");

    if ($stmt === false) {
        die('Lỗi câu lệnh SQL: ' . $conn->error);
    }

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

// Khởi tạo biến tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Truy vấn dữ liệu người dùng với điều kiện tìm kiếm
$sql = "SELECT userid, fullname, phone, email, created_time FROM user WHERE userrole = 2";
if (!empty($search)) {
    $search = $conn->real_escape_string($search); // Bảo vệ khỏi SQL injection
    $sql .= " AND fullname LIKE '%$search%'";
}

$result = $conn->query($sql);

// Xử lý xóa người dùng
if (isset($_GET['delete_user'])) {
    $userid = intval($_GET['delete_user']);
    $delete_sql = "DELETE FROM user WHERE userid = $userid";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Xóa người dùng thành công";
    } else {
        echo "Lỗi xóa người dùng: " . $conn->error;
    }
}

?>


<!DOCTYPE html>
<html lang="vi">
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
                    <li class="sidebar-list-item tab-content active">
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
        <main class="content">
        
            <!-- Account  -->
            <div class="section">
                <div class="admin-control">
                    <div class="admin-control-center">
                        <form action="" method="get" class="form-search">
                            <span class="search-btn"><i class="fa-light fa-magnifying-glass"></i></span>
                            <input id="form-search-user" name="search" type="text" class="form-search-input" placeholder="Tìm kiếm khách hàng..." value="<?php echo htmlspecialchars($search); ?>">
                        </form>
                    </div>
                    <div class="admin-control-right">
                        <form action="" class="fillter-date">
                            <div>
                                <label for="time-start">Từ</label>
                                <input type="date" class="form-control-date" id="time-start-user" onchange="showUser()">
                            </div>
                            <div>
                                <label for="time-end">Đến</label>
                                <input type="date" class="form-control-date" id="time-end-user" onchange="showUser()">
                            </div>
                        </form>      
                        <button class="btn-reset-order" onclick="cancelSearchUser()"><i class="fa-light fa-arrow-rotate-right"></i></button>     
                    </div>
                </div>
                <div class="table">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Họ và tên</td>
                                <td>Số điện thoại</td>
                                <td>Email</td>
                                <td>Ngày tham gia</td>
                                <td>Thao tác</td>
                            </tr>
                        </thead>
                        <tbody id="show-user">
    <?php
        if ($result->num_rows > 0) {
            $stt = 1; // Biến đếm để hiển thị số thứ tự
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['userid']) . "</td>
                        <td>" . htmlspecialchars($row['fullname']) . "</td>
                        <td>" . htmlspecialchars($row['phone']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['created_time']) . "</td>
                        <td>
                            <button class='btn-edit' onclick='editUser(" . $row['userid'] . ")'>Sửa</button>
                            <a href='?delete_user=" . $row['userid'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa người dùng này?\");'>
                                <button class='btn-delete'>Xóa</button>
                            </a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
        }
        $conn->close();
    ?>
</tbody>

                    </table>
                </div>
                <!-- </div> -->
            </div>
        </main>
    </div>
</body>
</html>