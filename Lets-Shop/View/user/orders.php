<?php
// Check Auth
require_once ViewDir."/user/auth.php";

// Getting User Information
require_once ViewDir."/user/userInfo.php";
require_once ViewDir."/user/template/header.php";

require_once ModelDir."/Order.php";
$orderObj = new Order();
$orders = $orderObj->getOrderInfo($_SESSION['user_id']);
?>
<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
<link rel="stylesheet" href="<?= url("assets/css/profile.css") ?>">
<link rel="stylesheet" href="<?= url("assets/css/orders.css") ?>">


<div class="main-container container">
    <div class="row">
        <div class="col-2">
            <?php require_once ViewDir."/user/template/profile_sidebar.php" ?>
        </div>
        <div class="col-10">
            <div class="content-head">My Orders</div>
            <div class="content-main-container">
                <div class="filter-container">
                    <div class="filter-link-container">
                        <a class="filter-link active" href="">All</a>
                        <a class="filter-link" href="">To Receive</a>
                        <a class="filter-link" href="">Finished</a>
                    </div>
                </div>
                <div class="order-main-container">
                    <?php foreach ($orders as $i => $order) : ?>
                        <div class="order-container">
                            <div class="order-info-container">
                                <div>
                                    <div class="order-id">Order <span>#<?= $order->orderId ?></span></div>
                                    <div class="order-time">Placed on 06 <?= $order->ordered_at ?></div>
                                </div>
                                <?php if ($order->is_confirmed) : ?>
                                    <div class="order-status finish">Finished</div>
                                <?php else : ?>
                                    <div class="order-status waiting">Waiting</div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info-container">
                                <div class="product-info-left-container">
                                    <div class="product-img-container">
                                        <img src="<?= url("assets/img/productImage")."/".$order->productImg ?>" class="product-img"></img>
                                    </div>
                                    <div class="product-name"><?= $order->productName ?></div>
                                </div>
                                <div class="product-info-right-container">
                                    <div class="product-quantity">Qty : <?= $order->quantity_sold ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once ViewDir."/user/template/footer.php" ?>

