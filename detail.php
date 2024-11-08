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
<?php
  include './connect_db.php';
  $result = mysqli_query($con, "SELECT * FROM `product` WHERE ProductID = ".$_GET['ProductID']);
  $detail = mysqli_fetch_assoc($result);
?>

    <div class="modal product-detail open">
        <button class="modal-close close-popup"><i class="fa-thin fa-xmark"></i></button>
        <div class="modal-container mdl-cnt" id="product-detail-content">
            <div class="modal-header">
                <img class="product-image" src="./<?= $detail['ProductImage'] ?>" alt="">
            </div>
            <div class="modal-body">
                <h2 class="product-title"><?= $detail['ProductName'] ?></h2>
                <div class="product-control">
                    <div class="priceBox">
                        <span class="current-price"><?= number_format($detail['Price'], 0, ",", ".") ?> VND</span>
                    </div>
                    <div class="buttons_added">
                        <input class="minus is-form" type="button" value="-">
                        <input class="input-qty" max="100" min="1" name="" type="number" value="1">
                        <input class="plus is-form" type="button" value="+" >
                    </div>
                </div>
                <p class="product-description"><?= $detail['Description'] ?></p>
            </div>
            <div class="notebox">
                <p class="notebox-title">Ghi chú</p>
                <textarea class="text-note" id="popup-detail-note" placeholder="Nhập thông tin cần lưu ý..."></textarea>
            </div>
            <div class="modal-footer">
                <div class="price-total">
                    <span class="thanhtien">Thành tiền</span>
                    <span class="price">200.000&nbsp;₫</span>
                </div>
                <div class="modal-footer-control">
                    <button class="button-dathangngay" data-product="1">Đặt hàng ngay</button>
                    <button class="button-dat" id="add-cart" ><i class="fa-light fa-basket-shopping"></i></button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
</body>  
</html>