<?php
require_once ModelDir."/Discount.php";
class DiscountController {
    private object $discount;

    public function __construct(){
        $this->discount = new Discount();
    }

    // View Functions
    public function index () : void {
        view("admin/discount/discount");
    }
    public function createView () : void {
        view("admin/discount/create");
    }
    public function updateView () : void {
        $discountData = $this->discount->getId($_GET['id']);
        if ($discountData) {
            view("admin/discount/update", ['data' => $discountData]);
        } else {
            redirect(route("admin/discount"),"No Such Discount Item", "error");
        }
    }
    public function addDiscountView () : void {
        $discountData = $this->discount->getId($_GET['id']);
        if ($discountData) {
            view("admin/discount/add", ['data' => $discountData]);
        } else {
            redirect(route("admin/discount"),"No Such Discount Item", "error");
        }
    }
    public function detailView () : void {
        $discountData = $this->discount->getId($_GET['id']);
        if ($discountData) {
            view("admin/discount/detail", ['discountData' => $discountData]);
        } else {
            redirect(route("admin/discount"),"No Such Discount Item", "error");
        }
    }

    // Operation Functions
    public function create () : void {
        if (isset($_POST)) {
            $discountName = $_POST['discountName'];
            $discountDescription = $_POST['discountDescription'];
            $discountPercentage = $_POST['discountPercentage'];
            $discountActive = isset($_POST['discountActive']) ? 1 : 0;

            $query = $this->discount->create($discountName,$discountDescription,$discountPercentage,$discountActive);

            if ($query) {
                redirect(route("admin/discount"),"$discountName created successfully");
            } else {
                redirectBack("Discount couldn't be created","error");
            }
        }
    }
    public function update () : void {
        if (isset($_POST)) {
            $discountId = $_POST['discountId'];
            $discountName = $_POST['discountName'];
            $discountDescription = $_POST['discountDescription'];
            $discountPercentage = $_POST['discountPercentage'];
            $discountActive = isset($_POST['discountActive']) ? 1 : 0;
            $query = $this->discount->update($discountName,$discountDescription,$discountPercentage,$discountActive,$discountId);

            if ($query) {
                redirect(route("admin/discount"),"$discountName updated successfully");
            } else {
                redirectBack("Discount couldn't be updated","error");
            }
        }
    }
    public function addDiscount () : void {
        if (isset($_POST)) {
            $discountId = $_POST['discountId'];
            $removedDiscountIds = $_POST['currentDiscount'] ?? []; // Get removed discount products id
            $result = null;

            // Adding New Discount
            if (isset($_POST['noDiscount'])) {
                $newDiscountIds = $_POST['noDiscount'];
                foreach ($newDiscountIds as $newDiscountId) {
                    $result = $this->discount->addNewDiscount($discountId, $newDiscountId);
                    if (!$result) {
                        redirectBack("Adding New Discount Failed", "error");
                    }
                }
            }
            // Remove Discount
            if (isset($_POST['currentDiscountHidden'])) {
                $discountedProductsId = $_POST['currentDiscountHidden'];
                foreach ($discountedProductsId as $discountedProductId) {
                    if (!in_array($discountedProductId, $removedDiscountIds)) {
                        $result = $this->discount->removeDiscount($discountedProductId);
                        if (!$result) {
                            redirectBack("Removing Discount Failed", "error");
                        }
                    }
                }
            }

            if ($result) {
                redirect(route("admin/discount"), "Discount Edited Successfully");
            }
        }
    }
    public function delete () : void {
    if (!empty($_POST)) {
        $discountId = $_POST['id'];
        $removeAllDiscount = $this->discount->removeAllDiscount($discountId);
        if ($removeAllDiscount) {
            $deleteDiscount = $this->discount->delete($discountId);
            if ($deleteDiscount) {
                redirect(route("admin/discount"), "Discount Deleted Successfully");
            } else {
                redirectBack("Remove Discount Successfully but Failed to Delete Discount", "error");
            }
        } else {
            redirectBack("Couldn't remove the discount from products", "error");
        }
    }
}

}