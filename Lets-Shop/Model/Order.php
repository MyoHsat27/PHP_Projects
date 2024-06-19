<?php
require_once ModelDir."/DBConfig.php";

class Order {
    private mysqli $db_connection;
    private object $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // CRUD Functions
    public function create(int $productId, int $quantity, int $pricePerUnit, int $totalPrice,int $discountPerUnit, int $totalDiscount, int
    $deliveryPrice,
                           int $grandTotal, int $deliveryInfoId, int $userId): mysqli|bool {
        $stmt = $this->db_connection->prepare("INSERT INTO orders (product_id, quantity_sold, price_per_unit, total_price, discount_per_unit, total_discount, delivery_price, grand_total, delivery_info_id, is_confirmed, user_id) VALUES ($productId, $quantity, $pricePerUnit, $totalPrice, $discountPerUnit, $totalDiscount, $deliveryPrice, $grandTotal, $deliveryInfoId, FALSE, $userId)");
        return $stmt->execute();
    }

    // Fetching Functions
    public function getOrderInfo(int $userId): array {
        $stmt = $this->db_connection->prepare("SELECT o.id as orderId, quantity_sold, is_confirmed, ordered_at, p.id as productId, p.name as productName, p.product_img as productImg  FROM orders o JOIN products p ON o.product_id = p.id WHERE o.user_id = $userId");
        $stmt->execute();
        $data = $stmt->get_result();
        $lists = [];
        while ($row = $data->fetch_object()) {
            $lists[] = $row;
        }
        return $lists;
    }
}