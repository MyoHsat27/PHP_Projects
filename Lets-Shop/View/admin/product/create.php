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
require_once ModelDir."/Category.php";
$category = new Category();
$categories = $category->getAllCategories();
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
                    <div class="fs-4 fw-semibold">Product / Create</div>

                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="card form-container">
                    <form action="<?= route('admin/product-store') ?>" method="post" enctype="multipart/form-data">
                        <div class="form-title">Add New Product</div>
                        <div class="input-container">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="productName">
                        </div>
                        <div class="input-container">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="productImage" accept="image/jpeg,image/png">
                        </div>
                        <div class="input-container">
                            <label for="categories" class="form-label">Category</label>
                            <select name="productCategories[]" class="form-select" id="categories" multiple>
                                <?php foreach ($categories as $category) : ?>
                                <option name="category" value="<?= $category->id ?>"><?= $category->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-container">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" name="productDescription"></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="input-container">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="productPrice">
                            </div>
                            <div class="input-container">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="productStock">
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="productSaleNow" value="active" id="sale-now">
                            <label class="form-check-label" for="sale-now">
                                Sale Now
                            </label>
                        </div>
                        <div class="form-btn-container">
                            <a href="<?= route('admin/product') ?>" class="cancel-btn d-flex">Cancel</a>
                            <button class="form-button btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
<script src="<?= url('bootstrap/js/bootstrap.bundle.js') ?>"></script>
</html>
