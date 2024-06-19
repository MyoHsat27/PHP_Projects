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
$productsDiscountInfo = $product->getCurrentDiscountProductsInfo($discountData->id);
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
                    <div class="fs-4 fw-semibold">Discount / Detail</div>
                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="card form-container">
                    <div>
                        <div class="form-title">Detail</div>
                        <div class="product-info">Name : <?= $discountData->name ?></div>
                        <div class="product-info">ID : <?= $discountData->id ?></div>
                        <div class="product-info">Description : <?= $discountData->description ?></div>
                        <div class="product-info">Percentage : <?= $discountData->percentage ?>%</div>
                        <div class="product-info d-flex my-3">
                            <div>Active : </div>
                            <div class="status-container"><?= $discountData->active_discount ? "<i class='bi bi-check-circle active-check'></i>" : "<i class='bi bi-dash-circle inactive-check'></i>" ?></div>
                        </div>
                        <div>
                            <div class="form-label">Currently Discount Products</div>
                            <div class="detail-discount-container">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>UNIT PRICE</th>
                                            <th>DISCOUNT</th>
                                            <th>GRAND PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($productsDiscountInfo as $productDiscountInfo) : ?>
                                            <tr>
                                                <td><?= $productDiscountInfo->id ?></td>
                                                <td><?= $productDiscountInfo->name ?></td>
                                                <td><?= $productDiscountInfo->price ?></td>
                                                <td><?= ($productDiscountInfo->price / 100) * $discountData->percentage ?></td>
                                                <td><?= ($productDiscountInfo->price - ($productDiscountInfo->price / 100) * $discountData->percentage) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-btn-container  ">
                            <a href="<?= route('admin/discount') ?>" class="back-button btn d-flex">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="<?= url('bootstrap/js/bootstrap.bundle.js') ?>"></script>
</html>
