<?php require_once ViewDir."/admin/header.php"?>

<!--Navbar Start-->
<div class="container-fluid navbar ps-0">
    <div class="px-4 py-2 d-flex justify-content-between align-items-center w-100">
        <div class="fs-4 fw-semibold">Products</div>
        <div class="d-flex justify-content-between align-items-center">
            <form class="input-group me-3 mb-0 search-input" method="get">
                <button class="input-group-text" id="search-icon"><i class="bi bi-search"></i></button>
                <input name="q" type="text" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="search-icon" value="<?= !empty($_GET) ? $_GET['q'] : '' ?>">
                <?php if (!empty($_GET)) : ?>
                    <a class="search-remove btn" href="<?= route('admin/product') ?>"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </form>
            <a href="<?= route('admin/product-create') ?>" class="create-btn d-flex d-flex
            align-items-center justify-content-center"><i class="bi
            bi-plus-square"></i><span>Create</span></a>
        </div>
    </div>
</div>
<!--Navbar End-->
<?php require_once ViewDir."/admin/session_message.php"?>
<!--Fetching Products Data-->
<?php
require_once ModelDir."/Product.php";
$product = new Product();
if (!empty($_GET)) {
    $lists = $product->getAll($_GET['q']);
} else {
    $lists = $product->getAll();
}
$stocks = $product->getQuantities();
?>

<!--Table Start-->
<div class="container-fluid px-5 mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card px-3 py-2 border-0 shadow-sm">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>DESCRIPTION</th>
                        <th>PRICE</th>
                        <th>STOCK</th>
                        <th>CATEGORY</th>
                        <th>ACTIVE</th>
                        <th>HAVE DISCOUNT</th>
                        <th>CREATED AT</th>
                        <th>CONTROL</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php for ($i = 0; $i < count($lists); $i++) : ?>
                    <tr>
                        <td><?= $lists[$i]->id ?></td>
                        <td><?= $lists[$i]->name ?></td>
                        <td class="td-description" title="<?= $lists[$i]->description ?>"><?= $lists[$i]->description ?></td>
                        <td><?= $lists[$i]->price ?></td>
                        <td><?= $stocks[$i]->quantity ?></td>
                        <td>
                            <?php
                                $categories = $product->getCategories($lists[$i]->id);
                                if (!empty($categories)) {
                                    foreach ($categories as $category) {
                                        echo "<span class='category-tag'>".$category->name."</span>";
                                    }
                                } else {
                                    echo "<span class='category-tag bg-danger'>None</span>";
                                }
                            ?>
                        </td>
                        <td class="status-container"><?= $lists[$i]->active_sale ? "<i class='bi bi-check-circle active-check'></i>" : "<i class='bi bi-dash-circle inactive-check'></i>" ?></td>
                        <td class="status-container"><?= $lists[$i]->discount_id ? "<i class='bi bi-check-circle active-check'></i>" : "<i class='bi bi-dash-circle inactive-check'></i>" ?></td>
                        <td><?= $lists[$i]->created_at ?></td>
                        <td class="control-container">
                            <div class="detail-control-btn">
                                <a href="<?= route('admin/product-detail',['id'=>$lists[$i]->id]) ?>"><i class="bi bi-file-earmark-text"></i></a>
                            </div>
                            <div class="edit-control-btn">
                                <a href="<?= route('admin/product-edit',['id'=>$lists[$i]->id]) ?>"><i class="bi bi-pencil"></i></a>
                            </div>
                            <form action="<?= route('admin/product-delete') ?>" method="post">
                                <button class="delete-control-btn btn" onclick="return confirm('Are you sure you want to delete this category?')"><i class="bi bi-trash3"></i></button>
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="productId" value="<?= $lists[$i]->id ?>">
                                <input type="hidden" name="productImage" value="<?= $lists[$i]->product_img ?>">
                                <input type="hidden" name="stockId" value="<?= $lists[$i]->stock_id ?>">
                                <?php if (!empty($categories)) : ?>
                                    <select hidden name="productCategories[]" class="form-select" id="categories" multiple>
                                        <?php foreach ($categories as $category) : ?>
                                            <option name="oldCategory" value="<?= $category->id ?>" selected><?= $category->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Table Emd-->
<?php require_once ViewDir."/admin/footer.php"?>
