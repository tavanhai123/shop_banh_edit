<?php
session_start();
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
</head>
<body>
    <header>
        <div class="header-middle">
            <div class="container">
                <div class="header-middle-left">
                    <div class="header-logo">
                        <a href="index.php">
                            <img src="./assets/img/logo.png" alt="" class="header-logo-img">
                        </a>
                    </div>
                </div>
                <div class="header-middle-center">
                    <form action="" class="form-search">
                        <span class="search-btn"><i class="fa-light fa-magnifying-glass"></i></span>
                        <input type="text" class="form-search-input" placeholder="Tìm kiếm món ăn..." autocomplete="on" required value="<?=isset($_GET['name']) ? $_GET['name'] : ""?>" name="name" />
                        <button type="button" class="filter-btn" onclick="document.querySelector('.advanced-search').classList.toggle('open');"><i class="fa-light fa-filter-list" ></i><span>Lọc</span></button>
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
                                    <span class="text-tk">Tài khoản <i class="fa-sharp fa-solid fa-caret-down"></i></span>
                                <?php endif; ?>
                            </div>
                            <ul class="header-middle-right-menu">
                                <?php if (isset($_SESSION['username'])): ?>
                                    <li><a href="account.php"><i class="fa-light fa-user-pen"></i> Thay đổi thông tin</a></li>
                                    <li><a href="dxuat.php"><i class="fa-light fa-right-from-bracket"></i> Thoát</a></li>
                                <?php else: ?>
                                    <li><a href="dnhap.php"><i class="fa-light fa-right-to-bracket"></i> Đăng nhập</a></li>
                                    <li><a href="dky.php"><i class="fa-light fa-right-to-bracket"></i> Đăng ký</a></li>
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
    <?php
    include './connect_db.php'; // Đảm bảo đã kết nối với cơ sở dữ liệu

    // Truy vấn để lấy tất cả các danh mục từ bảng category
    $categoryQuery = "SELECT CateID, CateName FROM category";
    $categoryResult = mysqli_query($con, $categoryQuery);
    ?>
    <nav class="header-bottom">
        <div class="container">
            <ul class="menu-list">
                <li class="menu-list-item"><a href="index.php" class="menu-link">Trang chủ</a></li>
                <?php
                // Kiểm tra và lặp qua các kết quả để tạo danh sách động
                if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                    while ($row = mysqli_fetch_assoc($categoryResult)) {
                        $cateID = htmlspecialchars($row['CateID']);
                        $cateName = htmlspecialchars($row['CateName']);
                        echo "<li class='menu-list-item'><a href='?category=$cateID' class='menu-link'>$cateName</a></li>";
                    }
                }
                ?>
            </ul>
        </div>
    </nav>
    
    <?php
    include './connect_db.php'; // Đảm bảo đã kết nối với cơ sở dữ liệu

    // Truy vấn để lấy tất cả các danh mục từ bảng category
    $categoryQuery = "SELECT CateID, CateName FROM category";
    $categoryResult = mysqli_query($con, $categoryQuery);
    ?>
    <form action="" method="GET" class="advanced-search" onsubmit="return keepAdvancedSearchOpen(event);">
        <input type="hidden" name="name" value="<?= isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '' ?>">
        <div class="container">
            <div class="advanced-search-category">
                <span>Phân loại</span>
                <select name="category" id="advanced-search-category-select">
                    <option value="all">Tất cả</option>
                    <?php
                    // Lặp qua kết quả truy vấn để tạo các tùy chọn
                    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                        while ($row = mysqli_fetch_assoc($categoryResult)) {
                            $selected = isset($_GET['category']) && $_GET['category'] == $row['CateID'] ? "selected" : "";
                            echo "<option value='" . htmlspecialchars($row['CateID']) . "' $selected>" . htmlspecialchars($row['CateName']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="advanced-search-price">
                <span>Giá từ</span>
                <input type="number" name="min_price" placeholder="tối thiểu" id="min-price" value="<?= isset($_GET['min_price']) ? $_GET['min_price'] : "" ?>">
                <span>đến</span>
                <input type="number" name="max_price" placeholder="tối đa" id="max-price" value="<?= isset($_GET['max_price']) ? $_GET['max_price'] : "" ?>">
                <button type="submit" id="advanced-search-price-btn"><i class="fa-light fa-magnifying-glass-dollar"></i></button>
            </div>
            <div class="advanced-search-control">
                <button type="submit" name="sort_order" value="asc" id="sort-ascending"><i class="fa-regular fa-arrow-up-short-wide"></i></button>
                <button type="submit" name="sort_order" value="desc" id="sort-descending"><i class="fa-regular fa-arrow-down-wide-short"></i></button>
                <button type="reset" id="reset-search" onclick="window.location.href='index.php';"><i class="fa-light fa-arrow-rotate-right"></i></button>
                <button type="button" onclick="document.querySelector('.advanced-search').classList.remove('open');"><i class="fa-light fa-xmark"></i></button>
            </div>
        </div>
    </form>

    <main class="main-wrapper">
        <div class="container" id="trangchu">
            <div class="home-slider">
                <img src="./assets/img/banner-1.jpg" alt="">
               
            </div>
            <div class="home-service" id="home-service">
                <div class="home-service-item">
                    <div class="home-service-item-icon">
                        <i class="fa-light fa-person-carry-box"></i>
                    </div>
                    <div class="home-service-item-content">
                        <h4 class="home-service-item-content-h">GIAO HÀNG NHANH</h4>
                        <p class="home-service-item-content-desc">Cho tất cả đơn hàng</p>
                    </div>
                </div>
                <div class="home-service-item">
                    <div class="home-service-item-icon">
                        <i class="fa-light fa-shield-heart"></i>
                    </div>
                    <div class="home-service-item-content">
                        <h4 class="home-service-item-content-h">SẢN PHẨM AN TOÀN</h4>
                        <p class="home-service-item-content-desc">Cam kết chất lượng</p>
                    </div>
                </div>
                <div class="home-service-item">
                    <div class="home-service-item-icon">
                        <i class="fa-light fa-headset"></i>
                    </div>
                    <div class="home-service-item-content">
                        <h4 class="home-service-item-content-h">HỖ TRỢ 24/7</h4>
                        <p class="home-service-item-content-desc">Tất cả ngày trong tuần</p>
                    </div>
                </div>
                <div class="home-service-item">
                    <div class="home-service-item-icon">
                        <i class="fa-light fa-circle-dollar"></i>
                    </div>
                    <div class="home-service-item-content">
                        <h4 class="home-service-item-content-h">HOÀN LẠI TIỀN</h4>
                        <p class="home-service-item-content-desc">Nếu không hài lòng</p>
                    </div>
                </div>
            </div>
            <div class="home-title-block" id="home-title">
                <h2 class="home-title">Khám phá tiệm bánh của chúng tôi</h2>
            </div>
            
            <?php
            // Tìm và lọc
            $search = isset($_GET['name']) ? $_GET['name'] : "";
            $category = isset($_GET['category']) && $_GET['category'] !== "all" ? $_GET['category'] : null;
            $min_price = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? $_GET['min_price'] : null;
            $max_price = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? $_GET['max_price'] : null;
            $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : null;

            $whereClauses = [];
            if ($search) {
                $whereClauses[] = "`ProductName` LIKE '%" . $search . "%'";
            }
            if ($category) {
                $whereClauses[] = "`CateID` = '" . $category . "'";
            }
            if ($min_price !== null) {
                $whereClauses[] = "`Price` >= " . $min_price;
            }
            if ($max_price !== null) {
                $whereClauses[] = "`Price` <= " . $max_price;
            }

            $whereSQL = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

            $orderSQL = "";
            if ($sort_order === "asc") {
                $orderSQL = "ORDER BY `Price` ASC";
            } elseif ($sort_order === "desc") {
                $orderSQL = "ORDER BY `Price` DESC";
            }

            include './connect_db.php';
            $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 4;
            $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($current_page - 1) * $item_per_page;

            $query = "SELECT * FROM `product` $whereSQL $orderSQL LIMIT $item_per_page OFFSET $offset";
            $product = mysqli_query($con, $query);

            $totalQuery = "SELECT * FROM `product` $whereSQL";
            $totalRecords = mysqli_query($con, $totalQuery);
            $totalRecords = $totalRecords->num_rows;
            $totalPages = ceil($totalRecords / $item_per_page);
            ?>

            
            <div class="home-products" id="home-products">
                <?php if ($product->num_rows > 0): ?>
                    <?php while ($row = mysqli_fetch_array($product)) { ?>
                    <!-- Sản phẩm 1 -->
                    <div class="col-product">
                        <article class="card-product">
                            <div class="card-header">
                                <a href="detail.php?ProductID=<?= $row['ProductID'] ?>" class="card-image-link">
                                    <img class="card-image" src="./<?= $row['ProductImage'] ?>" alt="<?= $row['ProductName'] ?>">
                                </a>
                            </div>
                            <div class="food-info">
                                <div class="card-content">
                                    <div class="card-title">
                                        <a href="detail.php?ProductID=<?= $row['ProductID'] ?>" class="card-title-link"><?= $row['ProductName'] ?></a>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="product-price">
                                        <span class="current-price"><?= number_format($row['Price'], 0, ",", ".") ?> VND</span>
                                    </div>
                                    <div class="product-buy" data-product-id="<?= $row['ProductID'] ?>">
                                        <button class="card-button order-item">
                                            <i class="fa-regular fa-cart-shopping-fast"></i>Đặt món</button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php } ?>
                <?php else: ?>
                <div class="no-result">
                    <div class="no-result-h">Tìm kiếm không có kết quả</div>
                    <div class="no-result-p">Xin lỗi, chúng tôi không thể tìm được kết quả hợp với tìm kiếm của bạn</div>
                    <div class="no-result-i"><i class="fa-light fa-face-sad-cry"></i></div>
                </div>
                <?php endif; ?>
                <?php
                    include 'pagination.php';
                ?>
            <div/>    
        </div>
    </main>
    
        
        <footer class="footer">
            <div class="container">
                <div class="footer-top">
                    <div class="footer-top-content">
                        <div class="footer-top-img">
                            <img src="./assets/img/Thiết kế chưa có tên (2).png" alt="">
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
    
<script src="./js/main.js"></script> 
   
</body>
</html>   
     
            
            
     
       
    
    
            
                
                
                    
            