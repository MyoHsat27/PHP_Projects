<?php
// Check Auth
require_once ViewDir."/user/auth.php";

// Getting User Information
require_once ViewDir."/user/userInfo.php";
require_once ViewDir."/user/template/header.php";
require_once ModelDir."/Product.php";
require_once ModelDir."/Discount.php";
require_once ModelDir."/Profile.php";
require_once ModelDir."/Address.php";
require_once ModelDir."/Location.php";

// Getting Product Information
$productObj = new Product();
$discountObj = new Discount();
$productId = $_POST['productId'];
$quantity = $_POST['quantity'];
$singleProduct = $productObj->getId($productId);
// Getting Product Price
if ($singleProduct->discount_id) {
    $singleDiscount = $discountObj->getId($singleProduct->discount_id);
    $pricePerUnit = $singleProduct->price;
    $totalPrice = $pricePerUnit * $_POST['quantity'];
    $discountPerUnit = $pricePerUnit * ($singleDiscount->percentage / 100);
    $totalDiscount = $discountPerUnit * $_POST['quantity'];
    $productPrice = $pricePerUnit - $discountPerUnit;
} else {
    $productPrice = $singleProduct->price;
    $totalPrice = $productPrice * $_POST['quantity'];
}

// Get User Address
$profileObj = new Profile();
$addressObj = new Address();
$locationObj = new Location();
$defaultAddressId = $profileObj->getDefaultAddress($_POST['userId'])->default_delivery_address_id ?? null;

$addresses = $addressObj->getAddresses($_POST['userId']);
foreach ($addresses as $i => $address) {
    $states[] = $locationObj->getStateId($address->state_id);
    $towns[] = $locationObj->getTownId($address->town_id);
}

// Get Available Delivery States and Towns
$avaStates = $locationObj->getStateIdName();
$avaTowns = $locationObj->getTownIdName();

print_r($_SESSION);
print_r($_POST);
?>
    <link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/css/orderNow.css") ?>">

    <div class="container mt-5">
        <div class="row">
            <div class="col-8">
                <div class="content-main-container">
                    <div class="content-head">Checkout</div>
                    <div class="cart-container">
                        <div class="cart-item-container">
                            <div class="cart-item-left">
                                <img class="cart-item-img"
                                     src="<?= url("assets/img/productImage/".$singleProduct->product_img) ?>" alt="">
                                <div class="cart-text-container">
                                    <div><?= $singleProduct->name ?></div>
                                    <div class="cart-description"><?= $singleProduct->description ?></div>
                                </div>
                            </div>

                            <div class="cart-item-right">
                                <?php if ($singleProduct->discount_id): ?>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="cart-item-old-price">Ks <?= $singleProduct->price ?></div>
                                        <div class="cart-item-price">
                                            Ks <?= $productPrice ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="cart-item-price">
                                        Ks <?= $productPrice ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div>Qty : <?= $quantity ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-4">
                <div class="summary-container mb-2">
                    <div class="summary-title">Shipping & Billing</div>
                    <div class="billing-info-container">
                        <div class="billing-info">
                            <i class="bi bi-geo-alt-fill me-2 address-icon"></i>
                            <?php if (!empty($addresses)): ?>
                                <div>
                                    <?php if (isset($defaultAddressId) && !empty($defaultAddressId)): ?>
                                        <?php foreach ($addresses as $i => $address): ?>
                                            <?php if ($address->id === $defaultAddressId): ?>
                                                <div class="mb-1"><span class="address-name" id="display-state-town"><?= $states[$i]->name ?>,
                                    <?= $towns[$i]->name ?></span>
                                                </div>
                                                <div class="address-info" id="display-detail-address"><?= $address->detail_address ?></div>
                                                <?php $currentAddressId = $address->id;
                                                $deliPrice = $towns[$i]->delivery_price ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="mb-1"><span class="address-name" id="display-state-town"><?= $states[0]->name ?>,
                                    <?= $towns[0]->name ?></span></div>
                                        <div id="display-detail-address" class="address-info"><?= $addresses[0]->detail_address ?></div>
                                        <?php $currentAddressId = $addresses[0]->id;
                                        $deliPrice = $towns[0]->delivery_price ?>
                                    <?php endif; ?>
                                </div>
                                <div class="ms-auto">
                                    <button type="button" class="modal-edit-button" data-bs-toggle="modal"
                                            data-bs-target="#editAddressModal">
                                        Edit
                                    </button>
                                </div>
                            <?php else: ?>
                                <div>
                                    Add Address
                                </div>
                                <button type="button" class="modal-edit-button ms-auto" data-bs-toggle="modal"
                                        data-bs-target="#editAddressModal">
                                    Edit
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="billing-info-container">
                        <div class="billing-info d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-telephone-fill me-2 address-icon"></i>
                                <?php if (!empty($addresses)): ?>
                                <div>
                                    <?php if (isset($defaultAddressId) && !empty($defaultAddressId)): ?>
                                        <?php foreach ($addresses as $i => $address): ?>
                                            <?php if ($address->id === $defaultAddressId): ?>
                                                <div id="display-phone">
                                                    <?= $address->phone_num ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div id="display-phone">
                                            <?= $addresses[0]->phone_num ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php else: ?>
                                        <div>
                                            #None
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="order-summary-title">Order Summary</div>
                        <div>
                            <div class="summary-price-container">
                                <div class="name">Items Total(<?= $_POST['quantity'] ?>)</div>
                                <div class="price">Ks <span id="billPrice"><?= $productPrice * $_POST['quantity'] ?></span></div>
                            </div>
                            <div class="summary-price-container mb-2">
                                <div class="name">Delivery Fees</div>
                                <div class="price" id="display-delivery-price">
                                    <?php if (!empty($addresses)): ?>
                                        Ks <?= $deliPrice ?>
                                    <?php else: ?>
                                        #None
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="summary-price-total-container">
                            <div class="name">Total</div>
                            <div class="price">Ks <span id="billTotalPrice"><?= ($productPrice * $_POST['quantity']) + $deliPrice ?></span></div>
                        </div>
                        <form action="<?= route("order-create") ?>" method="post">
                            <?php if ($singleProduct->discount_id) : ?>
                                <input type="text" name="productId" value="<?= $productId ?>" hidden>
                                <input type="text" name="quantity" value="<?= $_POST['quantity'] ?>" hidden>
                                <input type="text" name="pricePerUnit" value="<?= $pricePerUnit ?>" hidden>
                                <input type="text" name="totalPrice" value="<?= $totalPrice ?>" hidden>
                                <input type="text" name="discountPerUnit" value="<?= $discountPerUnit ?>" hidden>
                                <input type="text"
                                       name="totalDiscount" value="<?= $totalDiscount ?>"
                                       hidden>
                                <input type="text" id="postDeliPrice" name="deliveryPrice" value="<?= $deliPrice ?>" hidden>
                                <input type="text" id="postTotalPrice" name="grandTotal" value="<?= $totalPrice + $deliPrice - $totalDiscount ?>"
                                       hidden>
                                <input type="text" id="deliveryInfoId" name="deliveryInfoId" value="<?= $currentAddressId ?>" hidden>
                            <?php else : ?>
                                <input type="text" name="productId" value="<?= $productId ?>" hidden>
                                <input type="text" name="quantity" value="<?= $_POST['quantity'] ?>" hidden>
                                <input type="text" name="pricePerUnit" value="<?= $productPrice ?>" hidden>
                                <input type="text" name="totalPrice" value="<?= $totalPrice ?>" hidden>
                                <input type="text" id="postDeliPrice" name="deliveryPrice" value="<?= $deliPrice ?>" hidden>
                                <input type="text" id="postTotalPrice" name="grandTotal" value="<?= $totalPrice + $deliPrice ?>" hidden>
                                <input type="text" id="deliveryInfoId" name="deliveryInfoId" value="<?= $currentAddressId ?>" hidden>
                            <?php endif; ?>
                            <button class="checkout-btn">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Address Modal Start -->
        <div class="modal fade" id="editAddressModal" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="editAddressLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" id="editAddressLabel">Edit Address</div>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>Detail Address</td>
                                <td>Location</td>
                                <td>Phone</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($addresses as $i => $address): ?>
                                <tr>
                                    <td class="d-none" id="addressId"><?= $address->id ?></td>
                                    <td id="detailAddress"><?= $address->detail_address ?></td>
                                    <td id="location"><?= $states[$i]->name ?> . <?= $towns[$i]->name ?></td>
                                    <td id="deliPrice" class="d-none"><?= $towns[$i]->delivery_price ?></td>
                                    <td id="phoneNum"><?= $address->phone_num ?></td>
                                    <td>
                                        <div id="addressChangeBtn"
                                             class="text-end address-change-btn <?= $address->id == $currentAddressId ? "d-none" : "" ?>">
                                            CHANGE
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <a class="btn address-edit-btn" href="<?= route("address") ?>">Add New Address
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn address-edit-btn" data-bs-dismiss="modal">Done</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Address Modal End -->
    </div>

    <script src="<?= url("assets/js/order-now.js") ?>"></script>

<?php require_once ViewDir."/user/template/footer.php"; ?>