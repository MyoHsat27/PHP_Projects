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
                    <div class="fs-4 fw-semibold">Staff / Create</div>
                    <a href="<?= route('admin/staff') ?>" class="cancel-btn d-flex"><i class="bi bi-x-circle"></i><span>Cancel</span></a>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="<?= url('bootstrap/js/bootstrap.bundle.js') ?>"></script>
</html>
