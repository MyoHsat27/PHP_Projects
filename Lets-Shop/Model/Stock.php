<?php
require_once ModelDir."/DBConfig.php";

class Stock {
    private mysqli $db_connection;
    private object $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // CRUD functions
    public function create (int $quantity) : array {
        $query = "INSERT INTO stocks (`quantity`) VALUES ($quantity);";
        return ["result" => $this->dbConfig->run($this->db_connection, $query),"stockId" => $this->db_connection->insert_id];
    }
    public function update ($id, int $quantity) : mysqli|bool {
    $query = "UPDATE `stocks` SET `quantity` = $quantity WHERE id = $id";
    return $this->dbConfig->run($this->db_connection, $query);
    }
    public function delete ($id) : mysqli|bool {
        $query = "DELETE FROM `stocks` WHERE id=$id;";
        return $this->dbConfig->run($this->db_connection, $query);
    }

    // Common functions
    private function fetchMultiple (string $query) : array {
        $data = $this->dbConfig->run($this->db_connection, $query);
        $lists = [];
        while ($row = mysqli_fetch_object($data)) {
            $lists[] = $row;
        }
        return $lists;
    }

    // Fetching functions
    public function getProductStockAll (string $q = null) : array {
        $query = "SELECT stocks.id as 'stockId', stocks.quantity as 'stockQuantity', stocks.last_updated as 'last_updated', products.id as 'productId', products.name as 'productName' FROM products INNER JOIN stocks ON products.stock_id = stocks.id";
        if (isset($q)) {
            $query .= " WHERE products.name LIKE '%$q%'";
        }
        $query .= ";";
        return $this->fetchMultiple($query);
    }
    public function getStockByProductId ($productId) : object|null {
        $query = "SELECT s.id, s.quantity FROM stocks s JOIN products p ON s.id = p.stock_id";
        $data = $this->dbConfig->run($this->db_connection,$query);
        return mysqli_fetch_object($data);
    }
    public function getId ($id) : object|null {
        $query = "SELECT * FROM stocks WHERE id=$id;";
        $data = $this->dbConfig->run($this->db_connection,$query);
        return mysqli_fetch_object($data);
    }
    public function getCurrentStock ($id) : object {
        $query = "SELECT quantity FROM stocks WHERE id=$id;";
        $data = $this->dbConfig->run($this->db_connection,$query);
        return mysqli_fetch_object($data);
    }

}