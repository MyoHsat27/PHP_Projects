<?php
require_once ModelDir."/DBConfig.php";
class Cart {
    private DBConfig $dbConfig;
    private mysqli $db_connection;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // CRUD Functions
    public function checkCart ($productId, $userId) : bool {
        $stmt = $this->db_connection->prepare("SELECT * FROM carts WHERE carts.product_id = ? AND carts.user_id = ?");
        $stmt->bind_param("ii", $productId, $userId);
        $stmt->execute();
        $data = $stmt->get_result();
        if ($data->fetch_object()) {
            return true;
        }
        return false;
    }
    public function create ($productId, $userId) : mysqli|bool {
        $stmt = $this->db_connection->prepare("INSERT INTO carts (product_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $productId, $userId);
        return $stmt->execute();
    }
    public function remove ($productId, $userId) : mysqli|bool {
        $stmt = $this->db_connection->prepare("DELETE FROM carts WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $productId, $userId);
        return $stmt->execute();
    }
    public function removeAll ($userId) : mysqli|bool {
        $stmt = $this->db_connection->prepare("DELETE FROM carts WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }
    public function removeNonActive ($productId, $userId) : mysqli|bool {
        $stmt = $this->db_connection->prepare("DELETE FROM carts WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $productId, $userId);
        return $stmt->execute();
    }


    // Fetching Functions
    public function getCartProductsId ($userId) : array {
        $stmt = $this->db_connection->prepare("SELECT product_id FROM carts WHERE carts.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $data = $stmt->get_result();
        $lists = [];
        while ($row = $data->fetch_object()) {
            $lists[] = $row;
        }
        return $lists;
    }
    public function getCartProductAmount ($userId) : object|bool {
        $stmt = $this->db_connection->prepare("SELECT COUNT(product_id) as cartAmount FROM carts WHERE carts.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object();
    }


}