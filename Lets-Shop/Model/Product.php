<?php
require_once ModelDir."/DBConfig.php";

class Product {
    private mysqli $db_connection;
    private object $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // CRUD functions
    public function create(string $productName, string $productDescription, int $productPrice, int $productStockId, string $saleActive, string $productImage): array {
        $query = "INSERT INTO products (`name`, `description`, `price`, `stock_id`, `active_sale`, `product_img`) VALUES ('$productName','$productDescription',$productPrice,$productStockId,$saleActive,'$productImage') ";
        return ["result" => $this->dbConfig->run($this->db_connection, $query), "productId" => $this->db_connection->insert_id];
    }

    public function update($productId, string $productName, string $productDescription, int $productPrice, string $saleActive, string $productImage): array {
        $query = "UPDATE `products` SET name='$productName', description='$productDescription', price=$productPrice, active_sale=$saleActive, product_img='$productImage' WHERE id=$productId";
        return ["result" => $this->dbConfig->run($this->db_connection, $query), "productId" => $this->db_connection->insert_id];
    }

    public function delete($productId): mysqli|bool {
        $query = "DELETE FROM `products` WHERE id = $productId;";
        return $this->dbConfig->run($this->db_connection, $query);
    }

    // Common functions

    public function getAll(string $q = null): array {
        $query = "SELECT * FROM products";
        if (isset($q)) {
            $query .= " WHERE name LIKE '%$q%'";
        }
        $query .= ";";

        return $this->fetchMultiple($query);
    }

    // Fetching functions

    private function fetchMultiple(string $query): array {
        $data = $this->dbConfig->run($this->db_connection, $query);
        $lists = [];
        while ($row = mysqli_fetch_object($data)) {
            $lists[] = $row;
        }
        return $lists;
    }

    public function getId($id): object|null {
        $query = "SELECT * FROM `products` WHERE id=$id;";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data);
    }

    public function getIdDiscount($id): object|null { // fetch currently discounted product info by discount ID
        $query = "SELECT discounts.active_discount,discounts.percentage FROM products INNER JOIN discounts ON products.discount_id = discounts.id WHERE discount_id=$id;";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data);
    }

    public function getIdQuantity($productId): object|null {
        $query = "SELECT stocks.quantity as 'quantity' FROM products INNER JOIN stocks ON products.stock_id = stocks.id WHERE products.id=$productId;";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data);
    }

    public function getNoDiscountProducts(): array { // fetch product that doesn't have discount
        $query = "SELECT products.id,products.name FROM products WHERE products.discount_id IS NULL;";
        return $this->fetchMultiple($query);
    }

    public function getCurrentDiscountProductsInfo($id): array { // fetch currently discounted product info by discount ID
        $query = "SELECT products.id,products.name,products.price,discounts.active_discount FROM products INNER JOIN discounts ON products.discount_id = discounts.id WHERE discount_id=$id;";
        return $this->fetchMultiple($query);
    }

    public function getQuantities(): array { // fetch product stock quantity
        $query = "SELECT stocks.quantity as 'quantity' FROM products INNER JOIN stocks ON products.stock_id = stocks.id";
        return $this->fetchMultiple($query);
    }

    public function getCategories($productId): array { // fetch product categories
        $query = "SELECT c.name as name,c.id as id FROM products p INNER JOIN product_category_relation pcr ON p.id = pcr.product_id INNER JOIN categories c ON pcr.category_id = c.id WHERE p.id = $productId;";
        return $this->fetchMultiple($query);
    }

    public function getSixMostDiscountItem(): array {
        $query = "SELECT discounts.percentage, products.name, products.price, products.product_img, products.id FROM products INNER JOIN discounts ON products.discount_id = discounts.id WHERE products.discount_id IS NOT NULL AND products.active_sale = 1 AND discounts.active_discount = 1 ORDER BY discounts.percentage LIMIT 6;";
        return $this->fetchMultiple($query);
    }

    public function getSixMostOrderItem(): array {
        $query = "SELECT p.id, p.name, p.price, p.product_img, p.discount_id,  d.percentage, COUNT(o.product_id) as orderAmount FROM products p INNER JOIN orders o ON p.id = o.product_id LEFT JOIN discounts d on p.discount_id = d.id GROUP BY p.id, p.name, p.price, p.product_img, p.discount_id, d.percentage ORDER BY orderAmount DESC LIMIT 6";
        return $this->fetchMultiple($query);
    }

    public function getRandomTwentyFourProducts(): array {
        $query = "SELECT products.id as id, products.name as name, products.price as price, products.product_img as product_img, products.discount_id as discount_id, d.percentage as percentage, d.active_discount as active_discount FROM products LEFT JOIN discounts d on products.discount_id = d.id WHERE products.active_sale = 1 ORDER BY RAND() LIMIT 24;";
        return $this->fetchMultiple($query);
    }
}