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
require_once ModelDir."/Location.php";
if (isset($_GET['id']) && $_GET['id']) {
    $locationId = $_GET['id'];
    $location = new Location();
    $stateData = $location->getStateId($locationId);
    $towns = $location->getRelatedTowns($locationId);
} else {
    redirect(route("admin/location"));
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
                    <div class="fs-4 fw-semibold">Location / Detail</div>

                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="card form-container">
                    <div>
                        <div>
                            <div class="mb-3">
                                <h4>Information</h4>
                                <div class="info-container">
                                    <div class="product-info">ID : <?= $stateData->id ?></div>
                                    <div class="product-info">Name : <?= $stateData->name ?></div>
                                    <div class="product-info d-flex my-3">
                                        <div>Active : </div>
                                        <div class="status-container"><?= $stateData->active_state ? "<i class='bi bi-check-circle active-check'></i>" : "<i class='bi bi-dash-circle inactive-check'></i>" ?></div>
                                    </div>
                                    <div class="product-info">Created At : <?= $stateData->created_at ?></div>
                                </div>
                            </div>
                            <div>
                                <div class="form-label">Currently Discount Products</div>
                                <div class="detail-discount-container">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>TOWN</th>
                                            <th>PRICE</th>
                                            <th>ADDED AT</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($towns) && $towns) : ?>
                                            <?php foreach ($towns as $town) : ?>
                                                <tr>
                                                    <td><?= $town->id ?></td>
                                                    <td><?= $town->name ?></td>
                                                    <td><?= $town->price ?></td>
                                                    <td><?= $town->added_at ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td class="text-center" colspan="4">No town have added Yet</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="4">
                                                    <div>Add more town</div>
                                                    <div class="add-control-btn mt-1">
                                                        <a class="p-1 rounded" href="<?= route('admin/location-add', ["id" => $stateData->id]) ?>"><i
                                                                    class="bi bi-plus-circle"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-btn-container  ">
                                <a href="<?= route('admin/location') ?>" class="back-button btn d-flex">Back</a>
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
