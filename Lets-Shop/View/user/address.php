<?php
// Check Auth
require_once ViewDir."/user/auth.php";

// Getting User Information
require_once ViewDir."/user/userInfo.php";
require_once ViewDir."/user/template/header.php";

require_once ModelDir."/Location.php";
require_once ModelDir."/Address.php";

$location = new Location();
$states = $location->getStateIdName();
$towns = $location->getTownIdName();

$address = new Address();
$delivery_addresses = $address->getAddresses($_SESSION['user_id']);
$default_address_id = $address->getDefaultDeliveryAddressId($_SESSION['user_id'])->id;

print_r($_SESSION);
?>

<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
<link rel="stylesheet" href="<?= url("assets/css/profile.css") ?>">

<div class="main-container container">
    <div class="row">
        <div class="col-2">
            <?php require_once ViewDir."/user/template/profile_sidebar.php" ?>
        </div>
        <div class="col-10">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="content-head">
                    Address Book
                </div>

                <form action="<?= route("profile-update-default-address") ?>" class="d-flex justify-content-end align-items-center"
                      method="post">
                    <input type="text" name="_method" value="put" hidden>
                    <select onchange="this.form.submit()" name="defaultAddress" class="form-control w-100" id="default-address">?>
                        <option disabled selected="selected">Select Default Address</option>
                        <?php foreach ($delivery_addresses as $delivery_address) : ?>
                            <option value="<?= $delivery_address->id ?>"><?= substr($delivery_address->detail_address, 0, 50) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <div class="row">
                <div class="bg-white recent-order-container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="recent-head">Address</div>
                        <div class="address-status success <?= !isset($_SESSION["address-create-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["address-create-success"] ?? "";
                            unset($_SESSION["address-create-success"]) ?></div>
                        <div class="address-status not-exist <?= !isset($_SESSION["address-not-exist"]) ? "d-none" : "" ?>"><?php echo $_SESSION["address-not-exist"] ?? "";
                            unset($_SESSION["address-not-exist"]) ?></div>
                        <div class="address-status success <?= !isset($_SESSION["address-edit-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["address-edit-success"] ?? "";
                            unset($_SESSION["address-edit-success"]) ?></div>
                        <div class="address-status not-exist <?= !isset($_SESSION["address-delete-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["address-delete-success"] ?? "";
                            unset($_SESSION["address-delete-success"]) ?></div>
                        <div class="address-status success <?= !isset($_SESSION["default-set-success"]) ? "d-none" : "" ?>"><?php echo $_SESSION["default-set-success"] ?? "";
                            unset($_SESSION["default-set-success"]) ?></div>
                    </div>
                    <div class="address-table">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Address</th>
                                <th scope="col">
                                    <Re></Re>
                                    gion
                                </th>
                                <th scope="col">Phone No</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($delivery_addresses) : ?>
                                <?php foreach ($delivery_addresses as $delivery_address) : ?>
                                    <tr>
                                        <td><?= substr($delivery_address->detail_address, 0, 40) ?><?= strlen($delivery_address->detail_address) > 40 ? "....." : "" ?></td>
                                        <td>
                                            <div><?= $location->getStateName($delivery_address->state_id)->name ?>
                                                . <?= $location->getTownName($delivery_address->town_id)->name ?></div>
                                        </td>
                                        <td><?= $delivery_address->phone_num ?></td>
                                        <td class="default-address"><?= $delivery_address->id === $default_address_id ? "DEFAULT DELIVERY ADDRESS" : "" ?></td>
                                        <td class="d-flex align-items-center justify-content-end">
                                            <a href="<?= route("address-edit", ['address-id' => $delivery_address->id]) ?>"
                                               class="edit-btn">EDIT</a>
                                            <form action="<?= route("address-delete") ?>" method="post">
                                                <input type="text" name="_method" value="delete" hidden>
                                                <input type="text" name="currentId" value="<?= $delivery_address->id ?>" hidden>
                                                <button onclick="return confirm('Are you sure you want to delete this address?')"
                                                        class="address-delete-btn"><i class="bi bi-trash address-delete-i"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">No Address have added yet</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end">
                            <div class="add-address-btn" id="add-address">ADD NEW ADDRESS</div>
                        </div>
                    </div>
                    <div class="add-address d-none">
                        <form action="<?= route('address-create') ?>" method="post">
                            <div class="input-container row">
                                <div class="col-6">
                                    <label for="region" class="form-label">Region</label>
                                    <select class="form-select" name="state" id="region" required>
                                        <option value="" selected disabled>Please choose your
                                            region
                                        </option>
                                        <?php foreach ($states as $state) : ?>
                                            <option value="<?= $state->id ?>"><?= $state->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="township" class="form-label">Township</label>
                                    <select class="form-select" name="township" id="township"
                                            required>
                                        <option value=""
                                                class="town-select-placeholder" selected
                                                disabled>
                                            Please choose your region first
                                        </option>
                                        <?php foreach ($towns as $town) : ?>
                                            <option class="town-option"
                                                    value="<?= $town->id ?>"
                                                    data-region-id="<?= $town->state_id ?>"><?= $town->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="input-container row">
                                <div class="col-6">
                                    <label for="detail-address" class="form-label">Detail
                                        Address</label>
                                    <input required name="address" type="text" id="detail-address"
                                           class="form-control"
                                           placeholder="Example: House# 123, Street# 123, ABC Road">
                                </div>
                                <div class="col-6">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input required name="mobile" type="text" id="mobile"
                                           class="form-control"
                                           placeholder="Please enter your phone number">
                                </div>
                            </div>
                            <div class="input-container row mt-3">
                                <div class="col-6">
                                </div>
                                <div class="col-6">
                                    <div class="d-flex flex-column
                                    justify-content-end">

                                        <div class="form-check">
                                            <input name="defaultAddress"
                                                   class="form-check-input"
                                                   type="checkbox"
                                                   value="true"
                                                   id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Default Address Book
                                            </label>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center mt-2">
                                            <div class="close-add-address me-3">CLOSE</div>
                                            <button class="add-address-btn">Add Address</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<script src="<?= url('assets/js/address.js') ?>"></script>

<?php require_once ViewDir."/user/template/footer.php" ?>

