<?php
require_once ModelDir."/DBConfig.php";

class ProductCategoryRelation {
    private mysqli $db_connection;
    private object $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // CRUD functions
    public function create ($productId, $categoryId) : mysqli|bool {
        $query = "INSERT INTO product_category_relation (product_id, category_id) VALUES ($productId, $categoryId);";
        return $this->dbConfig->run($this->db_connection,$query);
    }
    public function delete ($productId, $categoryId) : mysqli|bool {
        $query = "DELETE FROM `product_category_relation` WHERE product_id=$productId AND category_id=$categoryId;";
        return $this->dbConfig->run($this->db_connection,$query);
    }
}