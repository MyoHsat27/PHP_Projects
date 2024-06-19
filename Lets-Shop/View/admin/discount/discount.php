<?php require_once ViewDir."/admin/header.php"?>

<!--Navbar Start-->
<div class="container-fluid navbar ps-0">
    <div class="px-4 py-2 d-flex justify-content-between align-items-center w-100">
        <div class="fs-4 fw-semibold">Discounts</div>
        <div class="d-flex justify-content-between align-items-center">
            <form class="input-group me-3 mb-0 search-input">
                <button class="input-group-text" id="search-icon"><i class="bi bi-search"></i></button>
                <input name="q" type="text" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="search-icon" value="<?= !empty($_GET) ? $_GET['q'] : '' ?>">
                <?php if (!empty($_GET)) : ?>
                    <a class="search-remove btn" href="<?= route('admin/discount') ?>"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </form>
            <a href="<?= route('admin/discount-create') ?>" class="create-btn d-flex
            align-items-center justify-content-center"><i
                        class="bi bi-plus-square"></i><span>Create</span></a>
        </div>
    </div>
</div>
<!--Navbar End-->

<?php require_once ViewDir."/admin/session_message.php"?>

<!--Table Start-->
<?php
require_once ModelDir."/Discount.php";

$discount = new Discount();
if (isset($_GET['q'])) {
    $lists = $discount->getAll($_GET['q']);
} else {
    $lists = $discount->getAll();
}
$discountActiveProductsQuantity = $discount->getDiscountActiveProductsQuantity();
?>

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
                            <th>DISCOUNT</th>
                            <th>ACTIVE PRODUCT</th>
                            <th>ACTIVE</th>
                            <th>CREATED AT</th>
                            <th>CONTROL</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php for ($i = 0; $i < count($lists); $i++) : ?>
                        <tr>
                            <td><?= $lists[$i]->id ?></td>
                            <td><?= $lists[$i]->name ?></td>
                            <td><?= $lists[$i]->description ?></td>
                            <td><?= $lists[$i]->percentage ?> %</td>
                            <td><?= $discountActiveProductsQuantity[$i]->active_product ?? 0 ?></td>
                            <td class="status-container"><?= $lists[$i]->active_discount ? "<i class='bi bi-check-circle active-check'></i>" : "<i class='bi bi-dash-circle inactive-check'></i>" ?></td>
                            <td><?= $lists[$i]->created_at ?></td>
                            <td class="control-container">
                                <div class="detail-control-btn">
                                    <a href="<?= route('admin/discount-detail',['id'=>$lists[$i]->id]) ?>"><i class="bi bi-file-earmark-text"></i></a>
                                </div>
                                <div class="add-control-btn">
                                    <a href="<?= route('admin/discount-add',['id'=>$lists[$i]->id]) ?>"><i class="bi bi-tag"></i></a>
                                </div>
                                <div class="edit-control-btn">
                                    <a href="<?= route('admin/discount-edit',['id'=>$lists[$i]->id]) ?>"><i class="bi bi-pencil"></i></a>
                                </div>
                                <form action="<?= route('admin/discount-delete') ?>" method="post">
                                    <button class="delete-control-btn btn" onclick="return confirm('Are you sure you want to delete this category?')"><i class="bi bi-trash3"></i></button>
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="<?= $lists[$i]->id ?>">
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
<!-- Table End -->

<?php require_once ViewDir."/admin/footer.php"?>
