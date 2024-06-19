<?php
if (checkAdminLogin()) {
    redirect(route("admin/product"));
}

?>
<link rel="stylesheet" href="<?= url("assets/css/user-navbar.css") ?>">
<div class="container-fluid navbar ps-0">
    <div class="container p-0">
        <div class="py-2 d-flex justify-content-between align-items-center w-100">
            <div class="d-flex align-items-center">
                <div>logo</div>
                <div class="fs-5 fw-bold ms-2"> Lets Shop</div>
                <div class="links-container">
                    <a href="<?= route() ?>">Home</a>
                    <a href="<?= route('shop') ?>">Shop</a>
                </div>
            </div>
            <div class="right-nav-container">
                <div class="search-container">
                    <div class="search">
                        <i class="bi bi-search"></i>
                        <input type="text" class="search-input" placeholder="Search for products, categories and more">
                    </div>
                </div>
                <div class="right-nav-link-container">
                    <div class="right-nav-link account-icon">

                        <div class='account-info'>
                            <div>Welcome to Lets Shop</div>
                            <div><?= $userInfo->name ?? 'To access account and manage orders' ?></div>
                            <?php if (checkLogin()) : ?>
                                <a href='<?= route("profile") ?>'>Profile</a>
                                <a href='<?= route("logout") ?>'>Logout</a>
                            <?php else : ?>
                                <a href='<?= route("login") ?>'>LOGIN/SIGNUP</a>
                            <?php endif; ?>
                        </div>

                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </div>
                    <a href="<?= route("wishlist") ?>" class="right-nav-link wishlist">
                        <i class="bi bi-heart"></i>
                        <span>Wishlist</span>
                    </a>
                    <a href="<?= route("cart") ?>" class="right-nav-link">
                        <i class="bi bi-cart"></i>
                        <span>Cart</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
