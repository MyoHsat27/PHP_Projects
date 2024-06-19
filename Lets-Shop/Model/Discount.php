<?php
require_once ModelDir."/DBConfig.php";

class Discount {
    private mysqli $db_connection;
    private object $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // CRUD functions
    public function create (string $discountName, string $discountDescription, int $discountPercentage,$discountActive) : mysqli|bool {
        $query = "INSERT INTO `discounts` (`name`, `description`, `percentage`, `active_discount`) VALUES ('$discountName','$discountDescription' ,'$discountPercentage',$discountActive);";
        return $this->dbConfig->run($this->db_connection,$query);
    }
    public function update (string $discountName, string $discountDescription, int $discountPercentage,string $discountActive, $discountId) : mysqli|bool {
        $query = "UPDATE `discounts` SET name='$discountName', description='$discountDescription', percentage=$discountPercentage, active_discount='$discountActive' WHERE id = $discountId;";
        return $this->dbConfig->run($this->db_connection,$query);
    }
    public function delete ($discountId) : mysqli|bool { // Delete the current discount itself
        $query = "DELETE FROM `discounts` WHERE id=$discountId;";
        return $this->dbConfig->run($this->db_connection,$query);
    }
    public function addNewDiscount ($discountId, $productId) : mysqli|bool { // Add current discount to a single product
        $query = "UPDATE `products` SET discount_id=$discountId WHERE id=$productId;";
        return $this->dbConfig->run($this->db_connection,$query);
    }
    public function removeDiscount ($productId) : mysqli|bool { // Remove discount from a single product relating to current discount
        $query = "UPDATE `products` SET discount_id=null WHERE id=$productId;";
        return $this->dbConfig->run($this->db_connection,$query);
    }
    public function removeAllDiscount ($discountId) : mysqli|bool { // Remove discount from every product relating to current discount
        $query = "UPDATE `products` SET discount_id=null WHERE discount_id=$discountId";
        return $this->dbConfig->run($this->db_connection,$query);
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
    public function getAll (string $q = null) : array {
        $query = "SELECT * FROM `discounts`";
        if (isset($q)) {
            $query .= " WHERE name LIKE '%$q%'";
        }
        $query .= ";";
        return $this->fetchMultiple($query);
    }
    public function getId ($id) : object|null {
        $query = "SELECT * FROM `discounts` WHERE id=$id;";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data);
    }
    public function getDiscountActiveProductsQuantity () : array { // fetch discount id and that discount's added product quantity
        $query = "SELECT discount_id, COUNT(discount_id) as 'active_product' FROM `products` WHERE discount_id IS NOT NULL GROUP BY discount_id;";
        return $this->fetchMultiple($query);
    }
}