
<?php
require_once ViewDir."/user/auth.php";
require_once ModelDir."/Profile.php";

if (checkLogin()) {
    $profile = new Profile();
    $userInfo = $profile->getUserProfile($_SESSION['user_id']);
}

require_once ViewDir."/user/template/header.php";

if (!empty($userInfo->default_delivery_address)) {
    $defaultAddress = "test";
}

print_r($userInfo);

?>
<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
<link rel="stylesheet" href="<?= url("assets/css/profile.css") ?>">

<style>
    .profile-image-container {
        background: <?= !empty($userInfo->profile_img) ? "url('assets/img/$userInfo->profile_img')" : "url('assets/img/background-01.jpg')" ?>;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
    }
</style>

<div class="main-container container">
    <div class="row">
        <div class="col-2">
            <?php require_once ViewDir."/user/template/profile_sidebar.php" ?>
        </div>
        <div class="col-10 ">
            <div class="content-head">My profile</div>
            <div class="content-main-container profile-main-container">
                <div class="row">
                    <div class="col-4 mb-3 me-4 px-0 bg-white pb-4">
                        <div class="profile-image-container">
                            <div class="profile-image-background"></div>
                            <?php if (empty($userInfo->profile_img)) : ?>
                                <div class="change-profile-container">
                                    <img class="profile-image " src="<?= "assets/img/productImage/22f5fde0ff1e047a771c33855957adee.jpg" ?>"
                                         alt="">
                                    <div class="change-profile">Change Profile Image</div>
                                </div>
                            <?php else : ?>
                                <div class="profile-image-text change-profile-container">
                                    <?php
                                        if (count(explode(" ", $userInfo->name)) > 1) {
                                            $words = explode(" ", $userInfo->name);
                                            $name = "";
                                            foreach ($words as $word) {
                                                $name .= substr($word, 0, 1);
                                            }
                                            echo $name;
                                        } else {
                                            echo substr($userInfo->name, 0, 2);
                                        }
                                    ?>
                                    <div class="change-profile">Change Profile Image</div>
                                </div>

                            <?php endif; ?>
                            </div>
                        <div class="input-head px-4">
                            <span>Personal Profile</span>
                            |
                            <span class="input-change input-head profile-edit-btn">Edit</span>
                        </div>
                        <div class="input-value px-4">Username - <?= $userInfo->name ?></div>
                        <div class="input-value px-4">Email - <?= $userInfo->email ?></div>
                    </div>
                    <div class="col-7 mb-3 bg-white p-4 h-100">
                        <div class="row">
                            <div class="col-7">
                                <div>Address Book</div>
                                <div class="input-title">DEFAULT DELIVERY ADDRESS</div>
                                <div class="input-value">
                                    <?php if (empty($defaultAddress)) : ?>
                                        <span>No default address</span>
                                    <?php else : ?>
                                        <span class="d-block"><?= $defaultAddress ?></span>
                                        <span><?= $defaultAddress ?> - <?= $defaultAddress ?></span>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="col-5">
                                <div class="input-head">
                                    <span>Mobile</span>
                                </div>
                                <div class="input-value"><?= $userInfo->phone ?? "Enter mobile number" ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-11 bg-white recent-order-container">
                        <div class="recent-head">Recent Order</div>
                        <div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Placed On</th>
                                    <th scope="col">Items</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">#5632</th>
                                    <td>20/10/2023</td>
                                    <td>
                                        <div>gehwehnhei</div>
                                    </td>
                                    <td>Ks.24050</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-main-container profile-edit-container d-none">
                <div class="row">
                    <form method="post" action="<?= route("profile-edit") ?>" class="col-8 mb-3 me-4
                     bg-white
                    p-4">
                        <div class="input-container row">
                            <div class="col-6 mb-2">
                                <label for="username" class="form-label">Username</label>
                                <input required name="username" type="text" id="username"
                                       class="form-control" value="<?= $userInfo->name ?>"
                                       placeholder="Please
                                       enter your
                                       username">
                            </div>
                            <div class="col-6 mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input required name="email" type="text" id="email"
                                       class="form-control" value="<?= $userInfo->email ?>"
                                       placeholder="Please enter your email">
                            </div>
                        </div>
                        <div class="input-container row">
                            <div class="col-6 mb-2">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input required name="mobile" type="text" id="mobile"
                                       class="form-control" value="<?= $userInfo->phone ?>"
                                       placeholder="Please enter your mobile">
                            </div>
                            <div class="col-6 mb-2">
                                <label for="gender" class="form-label">Gender</label>
                                <select required class="form-select" name="gender" id="gender">
                                    <option value="" <?= !isset($userInfo->gender) ? "selected" : "" ?>
                                            disabled>
                                        Select
                                    </option>
                                    <option value="male" <?= $userInfo->gender == "male" ? "selected" : "" ?>>
                                        Male
                                    </option>
                                    <option value="female" <?= $userInfo->gender == "female" ? "selected" : "" ?>>
                                        Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="close-add-address me-3">CLOSE</div>
                            <button class="add-address-btn">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= url("/assets/js/profile.js") ?>"></script>

<?php require_once ViewDir."/user/template/footer.php" ?>

