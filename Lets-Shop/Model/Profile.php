<?php require_once ModelDir."/DBConfig.php";

class Profile {
    private mysqli $db_connection;
    private DBConfig $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // Default Address Operations
    public function removeDefaultAddress (int $userId) : int|bool|mysqli {
        $stmt = $this->db_connection->prepare("UPDATE `users` SET default_delivery_address_id = null WHERE users.id = ?");
        $stmt->bind_param("i", $userId);
        return $stmt->execute() ?? false;
    }
    public function addDefaultAddress (int $userId, int $addressId) : mysqli|bool {
        $query = "UPDATE users SET default_delivery_address_id = $addressId WHERE users.id = $userId";
        return $this->dbConfig->run($this->db_connection, $query);
    }

    // Fetching Functions
    public function getUserProfile(int $id): object|bool {
        $stmt = $this->db_connection->prepare("SELECT users.name, users.email, users.phone, users.gender, users.default_delivery_address_id, users.profile_img FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object();
    }
    public function getDefaultAddress(int $id) : object|bool {
        $stmt = $this->db_connection->prepare("SELECT users.default_delivery_address_id FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object();
    }
}
