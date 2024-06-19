<?php require_once ViewDir."/admin/header.php"?>

<!--Navbar Start-->
<div class="container-fluid navbar ps-0">
    <div class="px-4 py-2 d-flex justify-content-between align-items-center w-100">
        <div class="fs-4 fw-semibold">Stocks</div>
        <div class="d-flex justify-content-between align-items-center">
            <form class="input-group me-3 mb-0 search-input" method="get">
                <button class="input-group-text" id="search-icon"><i class="bi bi-search"></i></button>
                <input name="q" type="text" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="search-icon" value="<?= !empty($_GET) ? $_GET['q'] : '' ?>">
                <?php if (!empty($_GET)) : ?>
                    <a class="search-remove btn" href="<?= route('admin/stock') ?>"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<!--Navbar End-->
<?php require_once ViewDir."/admin/session_message.php"?>
<!--Fetching Products Data-->
<?php
require_once ModelDir."/Stock.php";
$stock = new Stock();
if (!empty($_GET)) {
    $productsStocks = $stock->getProductStockAll($_GET['q']);
} else {
    $productsStocks = $stock->getProductStockAll();
}
?>

<!--Table Start-->
<div class="container-fluid px-5 mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card px-3 py-2 border-0 shadow-sm">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STOCK ID</th>
                        <th>PRODUCT NAME</th>
                        <th>QUANTITY</th>
                        <th>LAST UPDATED</th>
                        <th>CONTROL</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($productsStocks as $productStock) : ?>
                        <tr>
                            <td><?= $productStock->stockId ?></td>
                            <td><?= $productStock->productName ?></td>
                            <td><?= $productStock->stockQuantity ?></td>
                            <td><?= $productStock->last_updated ?></td>
                            <td class="control-container">
                                <div class="detail-control-btn">
                                    <a href="<?= route('admin/stock-detail',['stockId' => $productStock->stockId,'productId' => $productStock->productId]) ?>"><i class="bi bi-file-earmark-text"></i></a>
                                </div>
                                <div class="edit-control-btn">
                                    <a href="<?= route('admin/stock-edit',['stockId' => $productStock->stockId,'productId' => $productStock->productId]) ?>"><i class="bi bi-pencil"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Table Emd-->

<?php require_once ViewDir."/admin/footer.php"?>
