<?php
require_once ModelDir."/Profile.php";
class ProfileController {

    // View Function
    public function profileView(): void {
        view("user/profile");
    }
    public function orderView(): void {
        view("user/orders");
    }

    // Operation Functions
    public function profileEdit(): void {
        dd($_POST);
    }
    public function updateAddress () : void {
        if (checkCustomerLogin()) {
            $addressId = $_POST['defaultAddress'];
            print_r($_SESSION);
            $profile = new Profile();
            $result = $profile->addDefaultAddress($_SESSION["user_id"], $addressId);

            if ($result) {
                redirect(route("address"),"Default address set successfully", "default-set-success");
            } else {
                redirectBack("Could not set the default address", "default-set-fail");
            }
        }
    }


}