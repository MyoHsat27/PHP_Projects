<?php require_once ViewDir."/user/template/header.php" ?>
<?php require_once ViewDir."/user/auth.php" ?>
    <link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/css/profile.css") ?>">

<?php
require_once ModelDir."/Location.php";
require_once ModelDir."/Address.php";

if (isset($_GET['address-id']) && !empty($_GET['address-id'])) {
    $addressId = $_GET['address-id'];

    $location = new Location();
    $states = $location->getStateIdName();
    $towns = $location->getTownIdName();

    $address = new Address();
    $delivery_addresses = $address->getAddresses($_SESSION['user_id']);
    $default_address_id = $address->getDefaultDeliveryAddressId($_SESSION['user_id'])->id;
    $currentAddress = $address->getAddressId($addressId);

    if (empty($currentAddress)) {
        redirect(route("address"), "Address does not exist", "address-not-exist");
    }
} else {
    redirect(route("address"));
}
?>
    <div class="main-container container">
        <div class="row">
            <div class="col-2">
                <?php require_once ViewDir."/user/template/profile_sidebar.php" ?>
            </div>
            <div class="col-10">

                <div class="content-head">
                    Address Book
                </div>
                <div class="row">
                    <div class="bg-white recent-order-container">
                        <form action="<?= route('address-update') ?>" method="post">
                            <input type="text" value="<?= $currentAddress->id ?>" name="currentId" hidden>
                            <input type="text" value="put" name="_method" hidden>
                            <div class="input-container row">
                                <div class="col-6">
                                    <label for="region" class="form-label">Region</label>
                                    <select class="form-select" name="state" id="region" required>
                                        <option value="" selected disabled>Please choose your
                                            region
                                        </option>
                                        <?php foreach ($states as $state) : ?>
                                            <?php if ($state->id == $currentAddress->state_id) : ?>
                                                <option selected="selected" value="<?= $state->id ?>"><?= $state->name ?></option>
                                            <?php else : ?>
                                                <option value="<?= $state->id ?>"><?= $state->name ?></option>
                                            <?php endif; ?>
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

                                            <?php if ($town->id == $currentAddress->town_id) : ?>
                                                <option selected="selected" class="town-option"
                                                        value="<?= $town->id ?>"
                                                        data-option-id="<?= $town->state_id ?>"><?= $town->name ?></option>
                                            <?php else : ?>
                                                <option class="town-option"
                                                        value="<?= $town->id ?>"
                                                        data-option-id="<?= $town->state_id ?>"><?= $town->name ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="input-container row">
                                <div class="col-6">
                                    <label for="detail-address" class="form-label">Detail
                                        Address</label>
                                    <input required name="address" value="<?= $currentAddress->detail_address ?>" type="text" id="detail-address"
                                           class="form-control"
                                           placeholder="Example: House# 123, Street# 123, ABC Road">
                                </div>
                                <div class="col-6">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input required name="mobile" value="<?= $currentAddress->phone_num ?>" type="text" id="mobile"
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
                                                   id="flexCheckDefault" <?= $default_address_id == $currentAddress->id ? "checked" : "" ?>>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Default Address Book
                                            </label>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center mt-2">
                                            <a href="<?= route("address") ?>" class="close-add-address me-3 text-decoration-none">CANCLE</a>
                                            <button class="add-address-btn">EDIT</button>
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

    <script src="<?= url('assets/js/address-update.js') ?>"></script>

<?php require_once ViewDir."/user/template/footer.php" ?>