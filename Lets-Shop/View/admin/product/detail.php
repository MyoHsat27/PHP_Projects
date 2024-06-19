<?php require_once ViewDir."/admin/auth.php"?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= url("bootstrap/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/css/admin.css") ?>">
    <link rel="stylesheet" href="<?= url("bootstrap-icons/font/bootstrap-icons.css") ?>">

    <title>Let's Shop</title>
</head>
<body>
<?php
require_once ModelDir."/Product.php";
require_once ModelDir."/Discount.php";
$product = new Product();
if (isset($productData->discount_id)) {
    $discount = new Discount();
    $discountData = $discount->getId($productData->discount_id);
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 d-flex flex-column justify-content-between left-side p-0 sidebar-container">
            <div>
                <div class="icon-container py-3 d-flex flex-column justify-content-center align-items-center">
                    <div class="fs-2 text-center text-white">HERE IS FUCKING LOGO</div>
                    <div class="fs-4 logo">Lets Shop</div>
                </div>
            </div>
        </div>
        <div class="col-10 right-side p-0">
            <div class="container-fluid navbar ps-0">
                <div class="px-4 py-2 d-flex justify-content-between align-items-center w-100">
                    <div class="fs-4 fw-semibold">Product / Detail</div>

                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="card form-container">
                    <div>
                        <div>
                            <div class="product-img-container"><img src="<?= '/assets/img/productImage/'.$productData->product_img ?>" alt=""></div>
                            <div class="mb-3">
                                <h4>Information</h4>
                                <div class="info-container">
                                    <div class="product-info">ID : <?= $productData->id ?></div>
                                    <div class="product-info">Name : <?= $productData->name ?></div>
                                    <div class="product-info">Description : <?= $productData->description ?></div>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="product-info me-1">Categories :</div>
                                        <div class="">
                                            <?php
                                            $categories = $product->getCategories($productData->id);
                                            if (!empty($categories)) {
                                                foreach ($categories as $category) {
                                                    echo "<span class='category-tag'>".$category->name."</span>";
                                                }
                                            } else {
                                                echo "<span class='category-tag bg-danger'>None</span>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="product-info">On Stock : <?= $quantity->quantity ?></div>
                                    <div class="product-info d-flex my-2">
                                        <div>Sale Active : </div>
                                        <div class="status-container"><?= $productData->active_sale ? "<i class='bi bi-check-circle active-check'></i>" : "<i class='bi bi-dash-circle inactive-check'></i>" ?></div>
                                    </div>
                                    <div class="product-info">Created at : <?= $productData->created_at ?></div>
                                </div>
                            </div>
                            <div>
                                <h4>Pricing</h4>
                                <div class="info-container">
                                    <div class="product-info">Unit Price : <?= $productData->price ?></div>
                                    <?php if (isset($discountData)) : ?>
                                    <div class="product-info">Discount ID : <?= $discountData->id ?></div>
                                    <div class="product-info">Discount Name : <?= $discountData->name ?></div>
                                    <div class="product-info">Percentage : <?= $discountData->percentage ?>%</div>
                                    <div class="product-info">Discount : <?= ($productData->price / 100) * $discountData->percentage ?></div>
                                    <div class="product-info">Grand Price : <?= ($productData->price - ($productData->price / 100) * $discountData->percentage) ?></div>
                                    <div class="status-container product-info">Discount Active : <?= $discountData->active_discount ? "<i class='bi bi-check-circle active-check'></i>" : "<i class='bi bi-dash-circle inactive-check'></i>" ?></div>
                                    <?php else: ?>
                                        <div class="product-info">Discount : Not Available</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-btn-container  ">
                                <a href="<?= route('admin/product') ?>" class="back-button btn d-flex">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
<script src="<?= url('bootstrap/js/bootstrap.bundle.js') ?>"></script>
</html>
