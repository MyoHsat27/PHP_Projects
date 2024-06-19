<?php
require_once ModelDir."/Address.php";
require_once ModelDir."/Profile.php";

class AddressController {

    // View Function
    public function addressView(): void {
        view("user/address");
    }

    public function updateView(): void {
        view("user/addressUpdate");
    }

    // Operation Functions
    public function createAddress(): void {

        if (!empty($_POST)) {
            $stateId = $_POST['state'];
            $townshipId = $_POST['township'];
            $detailAddress = $_POST['address'];
            $mobile = $_POST['mobile'];
            $defaultAddress = isset($_POST['defaultAddress']) ?? false;

            $address = new Address();
            $addressId = $address->addAddress($stateId, $townshipId, $detailAddress, $mobile, $_SESSION['user_id']);
            $result = $addressId ?? false;

            if ($defaultAddress) {
                $profile = new Profile();
                $result = $profile->addDefaultAddress($_SESSION['user_id'], $addressId);
            }

            if ($result) {
                redirectBack("Address created successfully", "address-create-success");
            }

        } else {
            dd("Not Information");
        }
    }

    public function createAddressAjax(): void {
        $stateId = $_POST['state'];
        $townshipId = $_POST['township'];
        $detailAddress = $_POST['address'];
        $mobile = $_POST['mobile'];
        $address = new Address();
        $insertedAddress = $address->addAddressAjax($stateId, $townshipId, $detailAddress, $mobile, $_SESSION['user_id']);
        $result = $insertedAddress ?? false;

        if ($result) {
            echo json_encode($insertedAddress);
        }
    }

    public function updateAddress(): void {
        $currentId = $_POST['currentId'];
        $stateId = $_POST['state'];
        $townshipId = $_POST['township'];
        $detailAddress = $_POST['address'];
        $mobile = $_POST['mobile'];
        $defaultAddress = isset($_POST['defaultAddress']) ?? false;

        $address = new Address();
        $profile = new Profile();

        $result = $address->updateAddress($currentId, $stateId, $townshipId, $detailAddress, $mobile);
        $currentDefaultAddressId = $address->getDefaultDeliveryAddressId($_SESSION['user_id'])->id;

        if ((!$defaultAddress) && $currentId == $currentDefaultAddressId) {
            $result = $profile->removeDefaultAddress($_SESSION['user_id']);
        }
        if ($defaultAddress) {
            $result = $profile->addDefaultAddress($_SESSION['user_id'], $currentId);
        }

        if ($result) {
            redirect("address", "Address edited successfully", "address-edit-success");
        } else {
            redirectBack("Could not edit the address", "address-edit-fail");
        }
    }

    public function deleteAddress(): void {
        $currentId = $_POST['currentId'];
        $address = new Address();
        $profile = new Profile();

        $currentDefaultAddressId = $address->getDefaultDeliveryAddressId($_SESSION['user_id'])->id;

        if ($currentDefaultAddressId == $currentId) {
            $profile->removeDefaultAddress($_SESSION['user_id']);
        }

        $result = $address->deleteAddress($currentId);

        if ($result) {
            redirect("address", "Address deleted successfully", "address-delete-success");
        } else {
            redirectBack("Could not delete the address", "address-delete-fail");
        }

    }

}
