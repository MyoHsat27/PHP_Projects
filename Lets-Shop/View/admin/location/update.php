<?php require_once ViewDir."/admin/auth.php"?>
<?php print_r($_SESSION) ?>
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
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-a
    </style>
</head>
<body>

<?php
require_once ModelDir."/Location.php";
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
                    <div class="fs-4 fw-semibold">State / Edit</div>

                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="card form-container">
                    <form action="<?= route('admin/location-update') ?>" method="post">
                        <input type="hidden" name="_method" value="put">
                        <input type="hidden" name="stateId" value="<?= $stateData->id ?>">
                        <div class="form-title">Edit State</div>
                        <div class="form-label">State ID : <?= $stateData->id ?></div>
                        <div class="input-container">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="stateName"
                                   value="<?= $stateData->name ?>">
                        </div>
                        <div class="town-container">
                            <div>
                                <div class="add-control-btn d-flex justify-content-end">
                                    <button type="button" id="add-new-town-btn" class="btn btn-outline-primary"><i
                                                class="bi bi-plus-circle me-1"></i><span>Add Town</span></button>
                                </div>
                                <div id="town-container" class="state-form-main-container">
                                    <?php if ($towns) : ?>
                                        <?php foreach ($towns as $town) : ?>
                                                <input type="text" name="townId[]" hidden value="<?= $town->id ?>">
                                                <input type="text" name="townName[]" hidden value="<?= $town->name ?>">
                                                <input type="number" name="townPrice[]" hidden value="<?= $town->price ?>">
                                        <?php endforeach; ?>
                                        <?php foreach ($towns as $index => $town) : ?>
                                            <div id="town-form-<?= $town->id ?>"
                                                 class="town-form state-form-container d-flex">
                                                <input type="text" name="townNewId[]" hidden value="<?= $town->id ?>">
                                                <div class="state-form-no"><?= $index + 1 ?></div>
                                                <label class="state-input">
                                                    <input type="text" class="form-control me-3" name="townNewName[]"
                                                           placeholder="Town Name" value="<?= $town->name ?>">
                                                </label>
                                                <label class="state-input">
                                                    <input type="number" pattern="[0-9]" class="form-control me-3"
                                                           name="townNewPrice[]" placeholder="Price"
                                                           value="<?= $town->price ?>">
                                                </label>
                                                <button type="button" class="state-delete-btn mt-0"><i
                                                            class="bi bi-trash3"></i></button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div id="town-form-1" class="town-form state-form-container d-flex">
                                            <input type="text" name="townNewId[]" hidden value="1">
                                            <div class="state-form-no">1</div>
                                            <label class="state-input">
                                                <input type="text" class="form-control me-3" name="townNewName[]"
                                                       placeholder="Town Name">
                                            </label>
                                            <label class="state-input">
                                                <input type="number" pattern="[0-9]" class="form-control me-3"
                                                       name="townNewPrice[]" placeholder="Price">
                                            </label>
                                            <button type="button" class="state-delete-btn mt-0"><i
                                                        class="bi bi-trash3"></i></button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="locationActive" value="active"
                                   id="location-now" <?= $stateData->active_state ? 'checked' : '' ?>>
                            <label class="form-check-label" for="location-now">
                                Available
                            </label>
                        </div>
                        <div class="form-btn-container">
                            <a href="<?= route('admin/location') ?>" class="cancel-btn d-flex">Cancel</a>
                            <button type="submit" class="form-button btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
<script src="<?= url('bootstrap/js/bootstrap.bundle.js') ?>"></script>
<script src="<?= url('assets/js/town_add.js') ?>"></script>
</html>
