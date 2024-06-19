<?php
require_once ModelDir."/Product.php";
require_once ModelDir."/Category.php";
require_once ModelDir."/Cart.php";
require_once ModelDir."/Wishlist.php";

$product = new Product();
$category = new Category();
$cart = new Cart();
$wishlist = new Wishlist();

$randomProducts = $product->getRandomTwentyFourProducts();
$specialOffers = $product->getSixMostDiscountItem();
$hotSales = $product->getSixMostOrderItem();
$categories = $category->getAll();
$cartProductAmount = $cart->getCartProductAmount($_SESSION["user_id"]);
$wishlistProductAmount = $wishlist->getWishlistProductAmount($_SESSION["user_id"]);

// Getting User Information
require_once ViewDir."/user/userInfo.php";
?>

<?php require_once ViewDir."/user/template/header.php"; ?>
<link rel="stylesheet" href="<?= url("assets/css/shop.css") ?>">

<!--Hot Section Start-->
<div class="container-fluid hot-section section my-3">
    <div class="container h-100">
        <div class="row h-100">

            <!--Left Hot Section Start-->
            <div class="col-3 h-100 px-0 d-flex justify-content-end">
                <div class="hot-category-container h-100">
                    <div class="title"><i class="bi bi-list-ul"></i><span>Categories</span></div>
                    <div class="list-container">
                        <?php foreach ($categories as $category) : ?>
                            <a class="list" href="<?= route('', ['category' => $category->id]) ?>"><?= $category->name ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!--Left Hot Section End-->

            <!--Right Hot Section Start-->
            <div class="col-9">
                <div class="row h-100">
                    <div class="col-12 links-jumper-container">
                        <a href="<?= route("products", ['f' => 'special']) ?>" class="link-jumper">SpecialDeals</a>
                        <a href="<?= route("products", ['f' => 'hot']) ?>" class="link-jumper">Hot Sale</a>
                    </div>

                    <div class="col-12 offer-profile-container">
                        <!--Hot Offer Carousel Start-->
                        <div id="hotOfferCarousel" class="carousel slide col-9 h-100" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#hotOfferCarousel" data-bs-slide-to="0"
                                        class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#hotOfferCarousel" data-bs-slide-to="1"
                                        aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#hotOfferCarousel" data-bs-slide-to="2"
                                        aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner h-100">
                                <div class="carousel-item active bg-black hot-offer-carousel-item h-100">
                                </div>
                                <div class="carousel-item bg-danger hot-offer-carousel-item h-100 ">
                                </div>
                                <div class="carousel-item bg-success hot-offer-carousel-item h-100">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#hotOfferCarousel"
                                    data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#hotOfferCarousel"
                                    data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <!--Hot Offer Carousel End-->

                        <!--User Profile Start-->
                        <div class="col-3 h-100 profile-main-container">
                            <div class="profile-container h-100"
                                 aria-checked="<?= checkLogin() ? "true" : "false" ?>">
                                <?php if (checkLogin()) : ?>

                                    <div class="w-100 d-flex flex-column align-items-center">
                                        <?php
                                        if ($userInfo->profile_img) {
                                            echo "<div class='text-center my-3'><img src='' class='profile-img' alt=''></div>";
                                        } else {
                                            if (count(explode(" ", $userInfo->name)) > 1) {
                                                $words = explode(" ", $userInfo->name);
                                                $name = "";
                                                foreach ($words as $word) {
                                                    $name .= substr($word, 0, 1);
                                                }
                                                echo "<div class='my-3 no-profile'><span class='no-profile-name'>".$name."</span></div>";
                                            } else {
                                                echo "<div class='my-3 no-profile'><span class='no-profile-name'>".substr($userInfo->name, 0, 2)."</span></div>";
                                            }
                                        }
                                        ?>
                                        <div class="text-center text-white fw-bold"><?= $userInfo->name ?></div>
                                        <a href="<?= route("cart") ?>" class="user-product-info-container">
                                            <div class="text-container"><i class="bi bi-cart"></i><span>Cart</span>
                                            </div>
                                            <span class="number"><?= $cartProductAmount->cartAmount ?></span>
                                        </a>
                                        <a href="<?= route("wishlist") ?>" class="user-product-info-container">
                                            <div class="text-container"><i class="bi bi-heart"></i><span>Wishlist</span>
                                            </div>
                                            <span class="number"><?= $wishlistProductAmount->wishlistAmount ?></span>
                                        </a>
                                    </div>

                                    <div class="profile-controls-container">
                                        <a class="profile-detail control-btn" href='<?= route("profile") ?>'><i
                                                    class="bi bi-person me-1"></i>Profile</a>
                                        <a class="profile-logout control-btn" href='<?= route("logout") ?>'>Logout</a>
                                    </div>
                                <?php else : ?>
                                    <div class="gain-more">Login to gain more access</div>
                                    <a class="login-signup" href='<?= route("login") ?>'>LOGIN/SIGNUP</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!--User Profile End-->
                    </div>
                </div>
            </div>
            <!--Right Hot Section End-->

        </div>
    </div>
</div>
<!--Hot Section End-->

<!--Discount Section Start-->
<div class="container-fluid discount-section">
    <div class="container p-0">
        <div class="discount-main-container">
            <div class="discount-header-container">
                <div>
                    <div class="section-title">Special <span style="color: var(--active-color)">Offers</span></div>
                    <div class="section-text">Up to 50% off - Shipped within 72 hours</div>
                </div>
                <a href="<?= route("products", ['f' => 'special']) ?>" class="discount-jumper">View More</a>
            </div>
            <div class="discounts-main-container">
                <div class="discounts-container">
                    <?php foreach ($specialOffers as $specialOffer) : ?>
                        <a href="<?= route('product', ['id' => $specialOffer->id]) ?>" class="product-container">
                            <div class="product-image"><img
                                        src="<?= '/assets/img/productImage/'.$specialOffer->product_img ?>" alt="">
                            </div>
                            <div class="product-text-container">
                                <div class="product-name mt-2"><?= $specialOffer->name ?></div>
                                <div class="product-price">
                                    Ks. <?= $specialOffer->price - $specialOffer->price * ($specialOffer->percentage / 100) ?></div>
                                <div class="product-discount"><span
                                            class="product-discount-price">Ks. <?= $specialOffer->price ?></span><span
                                            class="product-discount-percent">-<?= $specialOffer->percentage ?>%</span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Discount Section End-->

<!--Hot Sale Section Start-->
<div class="container-fluid discount-section">
    <div class="container p-0">
        <div class="discount-main-container">
            <div class="discount-header-container">
                <div>
                    <div class="section-title">Hot Sale</div>
                    <div class="section-text">Top Products, Incredible prices.</div>
                </div>
                <a href="<?= route("products", ['f' => 'hot']) ?>" class="discount-jumper">View More</a>
            </div>
            <div class="discounts-main-container">
                <?php foreach ($hotSales as $hotSale) : ?>
                    <a href="<?= route('product', ['id' => $hotSale->id]) ?>" class="product-container">
                        <div class="product-image"><img
                                    src="<?= '/assets/img/productImage/'.$hotSale->product_img ?>" alt="">
                        </div>
                        <div class="product-text-container">
                            <div class="product-name mt-2"><?= $hotSale->name ?></div>
                            <?php if(isset($hotSale->discount_id) && !empty($hotSale->discount_id)) : ?>
                                <div class="product-price">
                                    Ks. <?= $hotSale->price - $hotSale->price * ($hotSale->percentage / 100) ?></div>
                                <div class="product-discount"><span
                                            class="product-discount-price">Ks. <?= $hotSale->price ?></span><span
                                            class="product-discount-percent">-<?= $hotSale->percentage ?>%</span>
                                </div>
                            <?php else : ?>
                                <div class="product-price">
                                    Ks. <?= $hotSale->price ?></div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!--Hot Sale Section End-->

<!--Products Section Start-->
<div class="container-fluid product-section">
    <div class="container product-main-container p-0">
        <div class="product-main-title">
            <div class="text-bar"></div>
            <div class="text">Just For You</div>
            <div class="text-bar"></div>
        </div>
        <div class="products-container">
            <?php foreach ($randomProducts as $randomProduct) : ?>
                <a href="<?= route('product', ['id' => $randomProduct->id]) ?>" class="product-container">
                    <div class="product-image"><img src="<?= '/assets/img/productImage/'.$randomProduct->product_img ?>"
                                                    alt=""></div>
                    <div class="product-text-container">
                        <div class="product-name mt-2"><?= $randomProduct->name ?></div>
                        <?php if ($randomProduct->discount_id !== null and $randomProduct->active_discount) : ?>
                            <div class="product-price">
                                Ks. <?= $randomProduct->price - $randomProduct->price * ($randomProduct->percentage / 100) ?></div>
                            <div class="product-discount"><span
                                        class="product-discount-price">Ks. <?= $randomProduct->price ?></span><span
                                        class="product-discount-percent">-<?= $randomProduct->percentage ?>%</span>
                            </div>
                        <?php else: ?>
                            <div class="product-price">Ks. <?= $randomProduct->price ?></div>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="products-jumper-container">
            <a href="<?= route("products") ?>" class="product-jumper">View More</a>
        </div>
    </div>
</div>
<!--Products Section End-->

<?php require_once ViewDir."/user/template/footer.php"; ?>
