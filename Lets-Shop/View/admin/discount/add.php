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
$product = new Product();
$noDiscountProducts = $product->getNoDiscountProducts();
$productsDiscountInfo = $product->getCurrentDiscountProductsInfo($data->id);
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
                    <div class="fs-4 fw-semibold">Discount / Add Discount</div>
                </div>
            </div>
            <?php require_once ViewDir."/admin/session_message.php"?>
            <div class="container d-flex justify-content-center">
                <div class="card form-container">
                    <form action="<?= route('admin/discount-added') ?>" method="post">
                        <input type="hidden" name="_method" value="put">
                        <input type="hidden" name="discountId" value="<?= $data->id ?>">
                        <div class="form-title">Add Discount</div>
                        <div class="border-bottom mb-3">
                            <div class="form-label">Name : <?= $data->name ?></div>
                            <div class="form-label">Description : <?= $data->description ?></div>
                            <div class="form-label">Percentage : <?= $data->percentage ?></div>
                            <div class="input-container d-flex justify-content-start mt-3 mb-2">
                                <label class="form-label" for="discount-now">Active : </label>
                                <div class="status-container"><?= $data->active_discount ? "<i class='bi bi-check-circle active-check'></i>" : "<i class='bi bi-dash-circle inactive-check'></i>" ?></div>
                            </div>
                        </div>
                        <div>
                            <div class="form-label">Currently Discount Products</div>
                            <div class="current-discount-container ">
                                <?php foreach ($productsDiscountInfo as $productDiscountInfo) : ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="hidden" id="currentDiscountHidden<?= $productDiscountInfo->id ?>" name="currentDiscountHidden[]" value="<?= $productDiscountInfo->id ?>">
                                        <input class="form-check-input" type="checkbox" id="currentDiscount<?= $productDiscountInfo->id ?>" name="currentDiscount[]" value="<?= $productDiscountInfo->id ?>" checked>
                                        <label class="form-check-label" for="currentDiscount<?= $productDiscountInfo->id ?>"><?= $productDiscountInfo->name ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <div class="form-label">No Discount Products</div>
                            <div class="current-discount-container ">
                                <?php foreach ($noDiscountProducts as $noDiscountProduct) : ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="noDiscount<?= $noDiscountProduct->id ?>" name="noDiscount[]" value="<?= $noDiscountProduct->id ?>">
                                        <label class="form-check-label" for="noDiscount<?= $noDiscountProduct->id ?>"><?= $noDiscountProduct->name ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="form-btn-container">
                            <a href="<?= route('admin/discount') ?>" class="cancel-btn d-flex">Cancel</a>
                            <button class="form-button btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?= url('bootstrap/js/bootstrap.bundle.js') ?>"></script>
</html>
