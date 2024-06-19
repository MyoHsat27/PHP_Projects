<?php
// Getting User Information
require_once ViewDir."/user/userInfo.php";
?>

<?php require_once ViewDir."/user/template/header.php"; ?>
<link rel="stylesheet" href="<?= url("assets/css/products.css") ?>">

<!--Hot Section Start-->
<div class="container-fluid hot-section section my-3">
    <div class="container">
        <div class="row border-bottom border-1 pb-3">
            <div>
                <a class="path-link" href="">Home</a>
                <span class="path-seperate">/</span>
                <a class="path-link" href="">Category</a>
            </div>
            <div class="mt-2">
                <span class="item-type">Search</span>
                <span class="item-no">- 420 items</span>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <div class="item-type filter-main-container d-flex align-items-center">FILTERS</div>
                <div class="products-main-container d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="filter-button">
                            <span>Category</span>
                            <i class="bi bi-chevron-down filter-icon"></i>
                        </div>
                        <div class="filter-button">
                            <span>Price</span>
                            <i class="bi bi-chevron-down filter-icon"></i>
                        </div>
                        <div class="filter-button">
                            <span>Discount</span>
                            <i class="bi bi-chevron-down filter-icon"></i>
                        </div>
                    </div>
                    <div class="sort-button-container d-flex justify-content-between align-items-center">
                        <div class="me-4">
                            <span class="sort-text-1">Sort by : </span>
                            <span class="sort-text-2">Recommended</span>
                        </div>
                        <div><i class="bi bi-chevron-down sort-icon"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="filter-main-container border-end border-1">
                <div class="filter-container">
                    <div class="filter-title">CATEGORIES</div>
                    <select name="category" class="category-select" id="category">
                        <option value="men">Men</option>
                    </select>
                </div>
                <div class="filter-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="filter-title price-title">PRICE</div>
                        <button class="price-button"><i class="bi bi-search price-icon"></i></button>
                    </div>
                    <div class="d-flex align-items-center">
                        <input type="number" name="price-min" placeholder="MIN" class="filter-input me-1">
                        <span class="price-text me-1">-</span>
                        <input type="number" name="price-max" placeholder="MAX" class="filter-input">
                    </div>
                </div>
                <div class="filter-container">
                    <div class="filter-title">DISCOUNT RANGE</div>
                    <div class="discount-container">
                        <input type="radio" id="percent-10" class="me-2">
                        <label for="percent-10">10% and above</label>
                    </div>
                    <div class="discount-container">
                        <input type="radio" id="percent-20" class="me-2">
                        <label for="percent-20">20% and above</label>
                    </div>
                    <div class="discount-container">
                        <input type="radio" id="percent-30" class="me-2">
                        <label for="percent-30">30% and above</label>
                    </div>
                    <div class="discount-container">
                        <input type="radio" id="percent-40" class="me-2">
                        <label for="percent-40">40% and above</label>
                    </div>
                    <div class="discount-container">
                        <input type="radio" id="percent-50" class="me-2">
                        <label for="percent-50">50% and above</label>
                    </div>
                    <div class="discount-container">
                        <input type="radio" id="percent-60" class="me-2">
                        <label for="percent-60">60% and above</label>
                    </div>
                    <div class="discount-container">
                        <input type="radio" id="percent-70" class="me-2">
                        <label for="percent-70">70% and above</label>
                    </div>
                    <div class="discount-container">
                        <input type="radio" id="percent-80" class="me-2">
                        <label for="percent-80">80% and above</label>
                    </div>
                    <div class="discount-container">
                        <input type="radio" id="percent-90" class="me-2">
                        <label for="percent-90">90% and above</label>
                    </div>
                </div>
            </div>
            <div class="products-main-container"></div>
        </div>
    </div>
</div>
<!--Hot Section End-->


<?php require_once ViewDir."/user/template/footer.php"; ?>
