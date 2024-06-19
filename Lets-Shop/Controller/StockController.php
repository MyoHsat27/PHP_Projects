<?php
require_once ModelDir."/Stock.php";
require_once ModelDir."/Product.php";
class StockController {
    private object $stock;

    public function __construct() {
        $this->stock = new Stock();
    }

    // View Functions
    public function index(): void {
        view("admin/stock/stock");
    }
    public function updateView(): void {
        $stock = $this->stock->getId($_GET['stockId']);
        if (!$stock) {
            redirect(route("admin/stock"),"No Such Stock Item", "error");
        }

        view("admin/stock/update", ['stock' => $stock]);
    }
    public function detailView(): void {
    $stock = $this->stock->getId($_GET['stockId']);
    if (!$stock) {
        redirect(route("admin/stock"),"No Such Stock Item", "error");
    }

    view("admin/stock/detail", ['stock' => $stock]);
}

    // Operation Functions
    public function create (int $quantity = 0) : int|bool {
        $query = $this->stock->create($quantity);
        $result =  $query['result'];
        $stockId = $query['stockId'];

        if ($result) {
            return $stockId;
        } else {
            redirectBack("Create Failed", "error");
        }
    }
    public function update () : void {
        if (!empty($_POST)) {
            $productName = $_POST['productName'];
            $stockId = $_POST['stockId'];
            $addQuantity = $_POST['addQuantity'];
            $currentStock = $this->stock->getCurrentStock($stockId);
            $newStock = $addQuantity + $currentStock->quantity;
            $query = $this->stock->update($stockId,$newStock);

            if ($query) {
                redirect(route("admin/stock"),"Successfully added $stockQuantity stock to product : $productName");
            } else {
                redirectBack("Update Failed", "error");
            }
        }
    }
    public function delete ($stockId) : bool {
        $result = $this->stock->delete($stockId);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}