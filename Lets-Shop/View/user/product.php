<?php
// Getting User Information
require_once ViewDir."/user/userInfo.php";
require_once ViewDir."/user/template/header.php";

require_once ModelDir."/Product.php";
require_once ModelDir."/Profile.php";
require_once ModelDir."/Wishlist.php";
require_once ModelDir."/Cart.php";
require_once ModelDir."/Address.php";
require_once ModelDir."/Location.php";

$product = new Product();

if (!isset($_GET['id'])) {
    redirect(url("shop"));
}

// Get Product Information
$currentProduct = $product->getId($_GET['id']);
$currentStock = $product->getIdQuantity($currentProduct->id);
$productCategories = $product->getCategories($currentProduct->id);

// Get Product's Discount Status
if ($currentProduct->discount_id) {
    $productDiscount = $product->getIdDiscount($currentProduct->discount_id);
}

// Get Product price
$normalPrice = $currentProduct->price;
if (isset($currentProduct->discount_id) && $productDiscount->active_discount) {
    $productPrice = $currentProduct->price - $currentProduct->price * ($productDiscount->percentage / 100);
}

// Check if the product is in Cart or Wishlist
if (checkCustomerLogin()) {
    $wishlist = new Wishlist();
    $cart = new Cart();
    $inWishlist = $wishlist->checkWish($currentProduct->id, $_SESSION['user_id']);
    $inCart = $cart->checkCart($currentProduct->id, $_SESSION['user_id']);
}

// Getting Location and Delivery Information
$location = new Location();
$states = $location->getStateIdName();
$towns = $location->getTownIdName();
$deliveryPrices = $location->getDeliveryPrices();

// unset($_SESSION["login-to-process"]);

print_r($_SESSION);
?>
<link rel="stylesheet" href="<?= url("assets/css/product.css") ?>">

<?php if ($currentProduct) : ?>
    <div class="container-fluid product-section mt-5">
        <div class="container product-container d-flex">
            <div class="col-9">
                <div class="product-detail-container">
                    <div class="product-img-container">
                        <img class="product-img" src="<?= '/assets/img/productImage/'.$currentProduct->product_img ?>"
                             alt="">
                    </div>
                    <div class="product-content-container">
                        <div class="product-content-top">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="content-header"><?= $currentProduct->name ?></div>

                                <?php if (isset($inWishlist) && $inWishlist) : ?>
                                    <form action="<?= route("wishlist-remove") ?>" method="post">
                                        <input type="text" value="delete" name="_method" hidden>
                                        <input type="text" value="<?= $_SESSION['user_id'] ?>" name="userId" hidden>
                                        <input type="text" value="<?= $currentProduct->id ?>" name="productId" hidden>
                                        <button class="wishlist-btn in-wishlist"><i
                                                    class="bi bi-heart-fill wish-icon in-wishlist"></i>
                                        </button>
                                    </form>
                                <?php else : ?>
                                    <form action="<?= route("wishlist-add") ?>" method="post">
                                        <input type="text" value="<?= checkLogin() ? $_SESSION['user_id'] : "" ?>" name="userId" hidden>
                                        <input type="text" value="<?= $currentProduct->id ?>" name="productId" hidden>
                                        <button class="wishlist-btn">
                                            <i type="button" class="bi bi-heart wish-icon"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            </div>
                            <div class="content-description"><?= $currentProduct->description ?></div>
                            <hr>
                            <?php if (isset($currentProduct->discount_id) && $productDiscount->active_discount) : ?>
                                <div class="product-price">Ks <?= $productPrice ?></div>
                                <div class="price-container">
                                    <div class="product-normal">Ks <?= $normalPrice ?></div>
                                    <div class="discount-tag">(<?= $productDiscount->percentage ?>% OFF)</div>
                                </div>
                            <?php else: ?>
                                <div class="product-price">Ks <?= $normalPrice ?></div>
                            <?php endif; ?>
                            <?php if ($currentStock->quantity > 0) : ?>
                                <div class="product-quantity-container mt-5">
                                    <input type="hidden" name="stock" value="<?= $currentStock->quantity ?>">
                                    <div class="quantity-container">
                                        <div class="quantity-text">Quantity</div>
                                        <button class="quantity-btn btn" id="decrease" disabled><i class="bi bi-dash-lg"></i></button>
                                        <div class="quantity" id="product-quantity" aria-valuemax="<?= $currentStock->quantity ?>">1</div>
                                        <button class="quantity-btn btn" id="increase"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="product-quantity-container mt-5">
                                    <input type="hidden" name="stock" value="<?= $currentStock->quantity ?>">
                                    <div class="quantity-container">
                                        <div class="quantity-text">Quantity</div>
                                        <button class="quantity-btn btn" id="decrease" disabled><i class="bi bi-dash-lg"></i></button>
                                        <div class="quantity" id="product-quantity" aria-valuemax="0">0</div>
                                        <button class="quantity-btn btn" id="increase" disabled><i class="bi bi-plus-lg"></i></button>
                                        <div class="ms-3 quantity-empty">Out of Stock</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="product-order-container mt-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <?php if (isset($inCart) && $inCart) : ?>
                                        <div class="d-flex flex-column justify-content-center align-items-end mx-1 w-50">
                                            <a href="<?= route("cart") ?>" class="product-action-btn add-cart-btn btn w-100">GO TO CART</a>
                                            <div class="m-2 mt-1 opacity-100">Already in the cart</div>
                                        </div>
                                    <?php else : ?>
                                        <form action="<?= route("cart-add") ?>" class="w-50 me-1" method="post">
                                            <input type="text" value="<?= checkLogin() ? $_SESSION['user_id'] : "" ?>" name="userId" hidden>
                                            <input type="text" value="<?= $currentProduct->id ?>" name="productId" hidden>
                                            <button class="product-action-btn add-cart-btn btn w-100">ADD TO CART</button>
                                            <div class="m-2 mt-1 opacity-0">Already in the cart</div>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ( $currentStock->quantity > 0) : ?>
                                        <form action="<?= route("order") ?>" class="w-50 ms-1" method="post">
                                            <input type="text" value="<?= checkLogin() ? $_SESSION['user_id'] : "" ?>" name="userId" hidden>
                                            <input type="text" value="<?= $currentProduct->id ?>" name="productId" hidden>
                                            <input type="text" class="quantity-send" value="1" name="quantity" hidden>
                                            <button id="buy-now-btn" class="product-action-btn buy-now-btn btn w-100">
                                                BUY NOW
                                            </button>
                                        </form>
                                    <?php endif; ?>


                                </div>
                            </div>
                        </div>
                        <div class="product-content-foot mb-1">
                            <div class="category-head">Category</div>
                            <div class="category-container">
                                <?php foreach ($productCategories as $productCategory) : ?>
                                    <a href="" class="category"><?= $productCategory->name ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="info-container">
                    <div class="user-info-title">DELIVERY</div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="user-info-icon bi bi-geo-alt me-2"></i>
                            <select class="form-select me-2" name="state" id="region" required>
                                <?php foreach ($states as $state) : ?>
                                    <option value="<?= $state->id ?>"><?= $state->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-select" name="township" id="township"
                                    required>
                                <?php foreach ($towns as $town) : ?>
                                    <option class="town-option"
                                            value="<?= $town->id ?>"
                                            data-option-id="<?= $town->state_id ?>"><?= $town->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="info-container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="user-info-icon bi bi-truck"></i>
                            <div class="user-info-text">Delivery Price</div>
                        </div>
                        <?php foreach ($deliveryPrices as $deliveryPrice) : ?>
                            <div class="delivery-price" data-option-id="<?= $deliveryPrice->id ?>">Ks <?= $deliveryPrice->delivery_price ?></div>
                        <?php endforeach; ?>

                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center mt-2">
                            <i class="user-info-icon bi bi-cash-stack"></i>
                            <div class="user-info-text">Cash on Delivery Available</div>
                        </div>
                    </div>
                </div>
                <div class="info-container">
                    <div class="user-info-title">SERVICE</div>
                    <div class="d-flex justify-content-start align-items-center">
                        <i class="user-info-icon bi bi-7-circle"></i>
                        <div class="d-flex flex-column align-items-start ms-2">
                            <div class="user-info-text ms-0">7 Day Returns</div>
                            <div class="user-info-text-option">Change of mind is not applicable</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center mt-2">
                        <i class="user-info-icon bi bi-7-circle"></i>
                        <div class="user-info-text">Warranty not available</div>
                    </div>
                </div>

                <div class="product-status success mt-2 <?= !isset($_SESSION["wishlist-add-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["wishlist-add-success"] ?? "";
                    unset($_SESSION["wishlist-add-success"]) ?></div>
                <div class="product-status success mt-2 <?= !isset($_SESSION["cart-add-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["cart-add-success"] ?? "";
                    unset($_SESSION["cart-add-success"]) ?></div>
                <div class="product-status remove mt-2 <?= !isset($_SESSION["cart-remove-success"]) ? "d-none" : "" ?>"><?php echo
                        $_SESSION["cart-remove-success"] ?? "";
                    unset($_SESSION["cart-remove-success"]) ?></div>
                <div class="product-status remove mt-2 <?= !isset($_SESSION["wishlist-remove-success"]) ? "d-none" : "" ?>"><?php echo
                        $_SESSION["wishlist-remove-success"] ?? "";
                    unset($_SESSION["wishlist-remove-success"]) ?></div>
                <div class="product-status remove mt-2 <?= !isset($_SESSION["login-to-process"]) ? "d-none" : "" ?>"><?php echo
                        $_SESSION["login-to-process"] ?? "";
                    unset($_SESSION["login-to-process"]) ?></div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container-fluid product-section mt-5">
        <div class="container product-container py-5">
            <div class="not-exist-text">PRODUCT DOESN'T EXIST</div>
        </div>
    </div>
<?php endif; ?>

<script src="<?= url("assets/js/product.js") ?>"></script>

<?php require_once ViewDir."/user/template/footer.php"; ?>
