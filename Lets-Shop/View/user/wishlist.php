<?php
// Check Auth
require_once ViewDir."/user/auth.php";

// Getting User Information
require_once ViewDir."/user/userInfo.php";
require_once ViewDir."/user/template/header.php";
?>
<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
<link rel="stylesheet" href="<?= url("assets/css/profile.css") ?>">


<div class="main-container container">
    <div class="row">
        <div class="col-2">
            <?php require_once ViewDir."/user/template/profile_sidebar.php" ?>
        </div>
        <div class="col-10">
            <div class="content-head">My Wishlist</div>
            <div class="content-main-container">
                <div class="input-head">Username</div>
                <div>Myo Hsat</div>
                <div class="input-head">Email</div>
            </div>
        </div>
    </div>
</div>

<?php require_once ViewDir."/user/template/footer.php" ?>

