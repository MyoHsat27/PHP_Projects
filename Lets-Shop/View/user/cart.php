<?php
// Check Auth
require_once ViewDir."/user/auth.php";
require_once ViewDir."/user/template/header.php";


// Get Products' ID from Cart
require_once ModelDir."/Cart.php";
$cart = new Cart();
$productsId = $cart->getCartProductsId($_SESSION['user_id']);

// Get Products' Information
require_once ModelDir."/Product.php";
require_once ModelDir."/Stock.php";
require_once ModelDir."/Wishlist.php";
$productObj = new Product();
$stockObj = new Stock();
$wishlistObj = new Wishlist();
$products = [];
$stocks = [];
$wishlists = [];
foreach ($productsId as $i => $productId) {
    $products[] = $productObj->getId($productId->product_id);
    $stocks[] = $stockObj->getId($products[$i]->stock_id);
    $wishlists[] = $wishlistObj->getWishlistData($productId->product_id, $_SESSION['user_id']);
}

require_once ModelDir."/Discount.php";
$discountObj = new Discount();
$includeOnlyActive = true; // Display Not Available Products' Header based on this variable
$includeOneActive = false;
$totalActiveProduct = 0;
foreach ($products as $product) {
    if (!$product->active_sale) {
        $includeOnlyActive = false;
    } else {
        $includeOneActive = true;
        $totalActiveProduct++;
    }
}

print_r($_SESSION);
?>
<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
<link rel="stylesheet" href="<?= url("assets/css/profile.css") ?>">
<link rel="stylesheet" href="<?= url("assets/css/cart.css") ?>">


<div class="main-container container">
    <div class="row">
        <div class="col-2">
            <?php require_once ViewDir."/user/template/profile_sidebar.php" ?>
        </div>
        <div class="col-10">
            <div class="content-head">My Cart</div>
            <div class="content-main-container row  mt-3">
                <div class="col-8">
                    <div class="cart-container mb-4">
                        <?php if ($includeOneActive) : ?>
                            <div class="cart-header-container">
                                <div class="cart-header-left">
                                    <label for="cart-select-all"> (<?= $totalActiveProduct ?>) ITEM(S)</label>
                                </div>
                                <div class="cart-header-right">
                                    <form action="<?= route("cart-remove-all") ?>" method="post">
                                        <input type="text" name="_method" value="delete" hidden>
                                        <button class="cart-delete-all"><i class="bi bi-trash
                                    cart-delete-icon"></i><span>DELETE</span></button>
                                    </form>
                                </div>
                            </div>
                        <?php else : ?>
                            <?php if (!count($products) > 0) : ?>
                                <div class="cart-header-container">
                                    <div class="w-100 fs-5 text-center py-4">
                                        <div class="text-center">
                                            Not Item in Cart yet
                                        </div>
                                        <a href="<?= route("shop") ?>" class="btn mt-2 btn-outline-primary">
                                            Shop Now
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php foreach ($products as $i => $product) : ?>
                            <?php if (isset($product->active_sale) && $product->active_sale) : ?>
                                <div class="cart-item-container">
                                    <div class="cart-item-left">
                                        <input type="checkbox" id="cart-select-all" class="form-check">
                                        <a href="<?= route("product", ["id" => $product->id]) ?>" class="text-decoration-none
                                        cart-item-img-container">
                                            <img class="cart-item-img"
                                                 src="<?= url("assets/img/productImage/".$product->product_img) ?>"
                                                 alt="">
                                        </a>
                                        <div class="cart-text-container">
                                            <div><?= $product->name ?></div>
                                            <div class="cart-description"><?= $product->description ?></div>
                                        </div>
                                    </div>
                                    <div class="cart-item-right">
                                        <div class="cart-item-price-container">
                                            <?php if ($product->discount_id) {
                                                $currentProductDiscount = $discountObj->getId($product->discount_id);
                                                if ($currentProductDiscount->active_discount) {
                                                    echo "<div class='cart-item-price'>Ks ".$product->price - $product->price * ($currentProductDiscount->percentage / 100)."</div>";
                                                } else {
                                                    echo "<div class='cart-item-price'>Ks ".$product->price."</div>";
                                                }
                                            } else {
                                                echo "<div class='cart-item-price'>Ks ".$product->price."</div>";
                                            }
                                            ?>
                                            <div class="cart-item-action-container">
                                                <?php if (isset($wishlists[$i]) && $wishlists[$i]) : ?>
                                                    <form action="<?= route("wishlist-remove") ?>" method="post">
                                                        <input type="text" value="delete" name="_method" hidden>
                                                        <input type="text" value="<?= $_SESSION['user_id'] ?>" name="userId" hidden>
                                                        <input type="text" value="<?= $product->id ?>" name="productId" hidden>
                                                        <button class="wishlist-btn in-wishlist"><i
                                                                    class="bi bi-heart-fill wish-icon in-wishlist"></i>
                                                        </button>
                                                    </form>
                                                <?php else : ?>
                                                    <form action="<?= route("wishlist-add") ?>" method="post">
                                                        <input type="text" value="<?= checkLogin() ? $_SESSION['user_id'] : "" ?>" name="userId"
                                                               hidden>
                                                        <input type="text" value="<?= $product->id ?>" name="productId" hidden>
                                                        <button class="wishlist-btn">
                                                            <i type="button" class="bi bi-heart wish-icon"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                                <form action="<?= route("cart-remove") ?>" method="post">
                                                    <input type="text" value="delete" name="_method" hidden>
                                                    <input type="text" value="<?= checkLogin() ? $_SESSION['user_id'] : "" ?>" name="userId"
                                                           hidden>
                                                    <input type="text" value="<?= $product->id ?>" name="productId" hidden>
                                                    <button class="delete-btn">
                                                        <i class="bi bi-trash delete-icon"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <?php if ($stocks[$i]->quantity > 0) : ?>
                                            <div class="cart-item-quantity-container">
                                                <button class="cart-item-quantity-btn btn-sm btn" id="decrease" disabled><i class="bi bi-dash-lg"></i>
                                                </button>
                                                <div class="cart-item-quantity" id="product-quantity" aria-valuemax="<?= $stocks[$i]->quantity ?>">1</div>
                                                <button class="cart-item-quantity-btn btn-sm btn" id="increase"><i class="bi bi-plus-lg"></i></button>
                                            </div>
                                        <?php else : ?>
                                        <div class="d-flex flex-column justify-content-between align-items-center">
                                            <div class="cart-item-quantity-container">
                                                <button class="cart-item-quantity-btn btn-sm btn" id="decrease" disabled><i class="bi bi-dash-lg"></i>
                                                </button>
                                                <div class="cart-item-quantity" id="product-quantity" aria-valuemax="0">0</div>
                                                <button class="cart-item-quantity-btn btn-sm btn" id="increase" disabled><i class="bi
                                                bi-plus-lg"></i></button>
                                            </div>

                                            <div class="quantity-empty mt-1">Out of Stock</div>

                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!$includeOnlyActive) : ?>
                        <div class="cart-not-available-container">
                            <div class="cart-header-container not-available">
                                <div class="cart-header-left">
                                    Not Available Products
                                </div>
                                <div class="cart-header-right">
                                    <form action="<?= route("nonacitve-cart-remove-all") ?>" method="post">
                                        <input type="text" name="_method" value="delete" hidden>
                                        <button class="cart-delete-all"><i class="bi bi-trash
                                    cart-delete-icon"></i><span>DELETE ALL</span></button>
                                    </form>
                                </div>
                            </div>

                            <?php foreach ($products as $i => $product) : ?>
                                <?php if (!$product->active_sale) : ?>
                                    <div class="cart-item-container not-available">
                                        <div class="cart-item-left">
                                            <a  href="<?= route("product", ["id" => $product->id]) ?>"  class="text-decoration-none cart-item-img-container">
                                                <img class="cart-item-img"
                                                     src="<?= url("assets/img/productImage/".$product->product_img) ?>"
                                                     alt="">
                                            </a>
                                            <div class="cart-text-container">
                                                <div><?= $product->name ?></div>
                                                <div class="cart-description"><?= $product->description ?></div>
                                            </div>
                                        </div>

                                        <div class="cart-item-right">
                                            <?php if ($product->discount_id) {
                                                $currentItemDiscount = $discountObj->getId($product->discount_id);
                                                if ($currentItemDiscount->active_discount) {
                                                    echo "<div class='cart-item-price'>Ks ".$product->price - $product->price * ($currentProductDiscount->percentage / 100)."</div>";
                                                } else {
                                                    echo "<div class='cart-item-price'>Ks ".$product->price."</div>";
                                                }
                                            } else {
                                                echo "<div class='cart-item-price'>Ks ".$product->price."</div>";
                                            }
                                            ?>
                                            <div class="cart-item-action-container">
                                                <?php if (isset($wishlists[$i]) && $wishlists[$i]) : ?>
                                                    <form action="<?= route("wishlist-remove") ?>" method="post">
                                                        <input type="text" value="delete" name="_method" hidden>
                                                        <input type="text" value="<?= $_SESSION['user_id'] ?>" name="userId" hidden>
                                                        <input type="text" value="<?= $product->id ?>" name="productId" hidden>
                                                        <button class="wishlist-btn not-available in-wishlist"><i
                                                                    class="bi bi-heart-fill wish-icon in-wishlist not-available"></i>
                                                        </button>
                                                    </form>
                                                <?php else : ?>
                                                    <form action="<?= route("wishlist-add") ?>" method="post">
                                                        <input type="text" value="<?= checkLogin() ? $_SESSION['user_id'] : "" ?>" name="userId"
                                                               hidden>
                                                        <input type="text" value="<?= $product->id ?>" name="productId" hidden>
                                                        <button class="wishlist-btn not-available">
                                                            <i type="button" class="bi bi-heart wish-icon not-available"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                                <form action="<?= route("nonactive-cart-remove") ?>" method="post">
                                                    <input type="text" value="delete" name="_method" hidden>
                                                    <input type="text" value="<?= checkLogin() ? $_SESSION['user_id'] : "" ?>" name="userId"
                                                           hidden>
                                                    <input type="text" value="<?= $product->id ?>" name="productId" hidden>
                                                    <button class="delete-btn">
                                                        <i class="bi bi-trash delete-icon"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-4">
                    <div class="summary-container mb-2">
                        <div class="summary-title">Order Summary</div>
                        <div class="mb-2">
                            <div class="summary-price-container">
                                <div class="name">Mongo Oxford Semi Borgue Shoe (6)</div>
                                <div class="price">Ks 28000</div>
                            </div>
                            <div class="summary-price-container">
                                <div class="name">Ear wax candle (12)</div>
                                <div class="price">Ks 13000</div>
                            </div>
                        </div>
                        <div class="summary-price-total-container">
                            <div class="name">Total</div>
                            <div class="price">Ks 42000</div>
                        </div>
                        <button class="checkout-btn">PROCESS TO CHECKOUT</button>
                    </div>
                    <div class="product-status success<?= !isset($_SESSION["wishlist-add-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["wishlist-add-success"] ?? "";
                        unset($_SESSION["wishlist-add-success"]) ?></div>
                    <div class="product-status success<?= !isset($_SESSION["cart-add-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["cart-add-success"] ?? "";
                        unset($_SESSION["cart-add-success"]) ?></div>
                    <div class="product-status remove<?= !isset($_SESSION["cart-remove-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["cart-remove-success"] ?? "";
                        unset($_SESSION["cart-remove-success"]) ?></div>
                    <div class="product-status remove <?= !isset($_SESSION["wishlist-remove-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["wishlist-remove-success"] ?? "";
                        unset($_SESSION["wishlist-remove-success"]) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= url("assets/js/cart.js") ?>"></script>
<?php require_once ViewDir."/user/template/footer.php" ?>

