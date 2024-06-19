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
require_once ModelDir.'/Product.php';
$product = new Product();
$productData = $product->getId($_GET['productId']);
if (!$productData) {
    redirect(route("admin/stock"),"No Such Product Item", "error");
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
                    <div class="fs-4 fw-semibold">Stock / Add</div>

                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="card form-container">
                    <form action="<?= route('admin/stock-update') ?>" method="post">
                        <input type="hidden" name="_method" value="put">
                        <input type="hidden" name="stockId" value="<?= $stock->id ?>">
                        <input type="hidden" name="productName" value="<?= $productData->name ?>">
                        <div class="form-title">Edit Stock</div>
                            <div class="product-img-container"><img src="<?= '/assets/img/productImage/'.$productData->product_img ?>" alt=""></div>
                        <div class="product-info">Name : <?= $productData->name ?></div>
                        <div class="product-info">ID : <?= $productData->id ?></div>
                        <div class="product-info">Stock ID : <?= $stock->id ?></div>
                        <div class="product-info">Current Stock : <?= $stock->quantity ?></div>
                        <div class="product-info">Last Filled : <?= $stock->last_updated ?></div>
                        <div class="input-container">
                            <label for="name" class="form-label">Add : </label>
                            <input type="text" class="form-control" id="name" name="addQuantity">
                        </div>
                        <div class="form-btn-container">
                            <a href="<?= route('admin/stock') ?>" class="cancel-btn d-flex">Cancel</a>
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
