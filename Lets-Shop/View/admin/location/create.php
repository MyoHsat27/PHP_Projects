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
                    <div class="fs-4 fw-semibold">State / Create</div>

                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="card form-container">
                    <form action="<?= route('admin/location-store') ?>" method="post">
                        <div class="form-title">Add New State</div>
                        <div class="input-container">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="stateName">
                        </div>
                        <div class="town-container">
                            <div>
                                <div class="add-control-btn d-flex justify-content-end">
                                    <button type="button" id="add-town-btn" class="btn btn-outline-primary"><i class="bi bi-plus-circle me-1"></i><span>Add Town</span></button>
                                </div>
                                <div id="town-container" class="state-form-main-container">
                                    <div id="town-form-1" class="state-form-container d-flex town-form">
                                        <div class="state-form-no">1</div>
                                        <label class="state-input">
                                            <input type="text" class="form-control me-3" name="townName[]" placeholder="Town Name">
                                        </label>
                                        <label class="state-input">
                                            <input type="number" pattern="[0-9]" class="form-control me-3" name="townPrice[]" placeholder="Price">
                                        </label>
                                        <button type="button" class="state-delete-btn mt-0"><i class="bi bi-trash3"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="locationActive" value="active" id="location-now">
                            <label class="form-check-label" for="location-now">
                                Avaliable
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
