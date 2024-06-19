<?php
require_once ModelDir."/DBConfig.php";

class Wishlist {
    private mysqli $db_connection;
    private DBConfig $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // Operation functions
    public function create($productId, $userId): mysqli|bool {
        $stmt = $this->db_connection->prepare("INSERT INTO wishes (product_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $productId, $userId);
        return $stmt->execute();
    }

    public function remove($productId, $userId): mysqli|bool {
        $stmt = $this->db_connection->prepare("DELETE FROM wishes WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $productId, $userId);
        return $stmt->execute();
    }

    // Fetching functions
    public function checkWish($productId, $userId): bool {
        $stmt = $this->db_connection->prepare("SELECT * FROM wishes WHERE wishes.product_id = ? AND wishes.user_id = ?");
        $stmt->bind_param("ii", $productId, $userId);
        $stmt->execute();
        $data = $stmt->get_result();
        if ($data->fetch_object()) {
            return true;
        }
        return false;
    }

    public function getWishlistData($productId, $userId): bool|object {
        $stmt = $this->db_connection->prepare("SELECT * FROM wishes WHERE wishes.product_id = ? AND wishes.user_id = ?");
        $stmt->bind_param("ii", $productId, $userId);
        $stmt->execute();
        $data = $stmt->get_result();
        if ($row = $data->fetch_object()) {
            return $row;
        }
        return false;
    }

    public function getWishlistProductAmount($userId): object|bool {
        $stmt = $this->db_connection->prepare("SELECT COUNT(product_id) as wishlistAmount FROM wishes WHERE wishes.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object();
    }

}