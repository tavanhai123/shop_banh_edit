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
                        <li class="header-middle-right-item dnone open">
                            <div class="cart-icon-menu">
                                <i class="fa-light fa-magnifying-glass"></i>
                            </div>
                        </li>
                        <li class="header-middle-right-item close" >
                            <div class="cart-icon-menu">
                                <i class="fa-light fa-circle-xmark"></i>
                            </div>
                        </li>
                        <li class="header-middle-right-item dropdown open">
                            <i class="fa-light fa-user"></i>
                            <div class="auth-container">
                                <span class="text-dndk">Đăng nhập / Đăng ký</span>
                                <span class="text-tk">Tài khoản <i class="fa-sharp fa-solid fa-caret-down"></i></span>
                            </div>
                            <ul class="header-middle-right-menu">
                                <li><a id="login" href="#"><i class="fa-light fa-right-to-bracket"></i> Đăng nhập</a></li>
                                <li><a id="signup" href="#"><i class="fa-light fa-user-plus"></i> Đăng ký</a></li>
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
                <li class="menu-list-item"><a href="#" class="menu-link">Cupcake</a></li>
                <li class="menu-list-item"><a href="#" class="menu-link">Bentocake</a></li>
                <li class="menu-list-item" ><a href="#" class="menu-link">Chessecake</a></li>
                <li class="menu-list-item" ><a href="#" class="menu-link">Layercake</a></li>
                <li class="menu-list-item" ><a href="#" class="menu-link">Mochicake</a></li>
                <li class="menu-list-item" ><a href="#" class="menu-link">Tiramisu</a></li>
                <li class="menu-list-item"><a href="#" class="menu-link">Specialcake</a></li>
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
                <button id="reset-search" ><i class="fa-light fa-arrow-rotate-right"></i></button>
                <button ><i class="fa-light fa-xmark"></i></button>
            </div>
        </div>
    </div>
    <div class="main-wrapper">
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
            <div class="home-products" id="home-products">
            <?php  { ?>
                <!-- Sản phẩm 1 -->
                <div class="col-product">
                    <article class="card-product">
                        <div class="card-header">
                            <a href="#" class="card-image-link">
                                <img class="card-image" src="./assets/img/products/1. Cupcake/1.jpg" alt="Cupcake">
                            </a>
                        </div>
                        <div class="food-info">
                            <div class="card-content">
                                <div class="card-title">
                                    <a href="#" class="card-title-link">Cupcake</a>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="product-price">
                                    <span class="current-price">200,000 VND</span>
                                </div>
                                <div class="product-buy">
                                    <button class="card-button order-item">Đặt món</button>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-product">
                    <article class="card-product">
                        <div class="card-header">
                            <a href="#" class="card-image-link">
                                <img class="card-image" src="./assets/img/products/1. Cupcake/2.jpg" alt="Cupcake">
                            </a>
                        </div>
                        <div class="food-info">
                            <div class="card-content">
                                <div class="card-title">
                                    <a href="#" class="card-title-link">Cupcake</a>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="product-price">
                                    <span class="current-price">180,000 VND</span>
                                </div>
                                <div class="product-buy">
                                    <button class="card-button order-item">Đặt món</button>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-product">
                    <article class="card-product">
                        <div class="card-header">
                            <a href="#" class="card-image-link">
                                <img class="card-image" src="./assets/img/products/2. Bentocake/3.jpg" alt="Bentocake">
                            </a>
                        </div>
                        <div class="food-info">
                            <div class="card-content">
                                <div class="card-title">
                                    <a href="#" class="card-title-link">Bentocake</a>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="product-price">
                                    <span class="current-price">180,000 VND</span>
                                </div>
                                <div class="product-buy">
                                    <button class="card-button order-item">Đặt món</button>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-product">
                    <article class="card-product">
                        <div class="card-header">
                            <a href="#" class="card-image-link">
                                <img class="card-image" src="./assets/img/products/2. Bentocake/6.jpg" alt="Bentocake">
                            </a>
                        </div>
                        <div class="food-info">
                            <div class="card-content">
                                <div class="card-title">
                                    <a href="#" class="card-title-link">Bentocake</a>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="product-price">
                                    <span class="current-price">699,000 VND</span>
                                </div>
                                <div class="product-buy">
                                    <button class="card-button order-item">Đặt món</button>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                
            <?php } ?>
            </div>
            
            <div class="page-nav">
                    <ul class="page-nav-list">
                        <li class="page-nav-item ">
                            <a href="trangchu.html">1</a>
                        </li>
                        <li class="page-nav-item active">
                            <a href="trangchu2.html">2</a>
                        </li>
                        
                    </ul>
                    
            </div>
            
            </div>
        </div>
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
       
       
    </body>
    </html>   
     
            
            
     
       
    
    
            
                
                
                    
            