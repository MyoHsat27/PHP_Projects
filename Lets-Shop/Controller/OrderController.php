<?php
require_once ModelDir."/Order.php";
require_once ModelDir."/Stock.php";

class OrderController {
    // Admin View
    public function index () : void {
        view("admin/order/order");
    }

    // User View
    public function orderView () : void {
        view("user/orders");
    }
    public function orderNowView () : void {
        view("user/orderNow");
    }

    // CRUD Functions
    public function createOrder() : void {
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];
        $pricePerUnit = $_POST['pricePerUnit'];
        $totalPrice = $_POST['totalPrice'];
        $discountPerUnit = $_POST['discountPerUnit'] ?? 0;
        $totalDiscount = $_POST['totalDiscount'] ?? 0;
        $deliveryPrice = $_POST['deliveryPrice'];
        $grandTotal = $_POST['grandTotal'];
        $deliveryInfoId = $_POST['deliveryInfoId'];

        $stockObj = new Stock();
        $stock = $stockObj->getStockByProductId($productId);
        $newQuantity = $stock->quantity - $quantity;
        $stockObj->update($stock->id, $newQuantity);

        $order = new Order();
        $result = $order->create($productId,$quantity,$pricePerUnit,$totalPrice,$discountPerUnit,$totalDiscount,$deliveryPrice,$grandTotal,
            $deliveryInfoId, $_SESSION['user_id']);
        if ($result) {
            redirect(route("orders"),"Order Successfully");
        }

    }

    // Fetching Functions

}