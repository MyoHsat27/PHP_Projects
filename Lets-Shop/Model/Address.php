<?php
require_once ModelDir."/DBConfig.php";

class Address {
    private mysqli $db_connection;
    private object $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // CRUD Functions
    public function addAddress(int $state, int $township, string $address, string $mobile, int $userId): int|bool|mysqli {
        $stmt = $this->db_connection->prepare("INSERT INTO delivery_addresses (state_id, town_id, detail_address, phone_num, user_id) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iissi", $state, $township, $address, $mobile, $userId);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function addAddressAjax(int $state, int $township, string $address, string $mobile, int $userId): int|bool|object {
        $stmt = $this->db_connection->prepare("INSERT INTO delivery_addresses (state_id, town_id, detail_address, phone_num, user_id) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iissi", $state, $township, $address, $mobile, $userId);
        $stmt->execute();
        return $this->getAddressId($stmt->insert_id);
    }

    public function getAddressId(int $addressId): object|bool {
        $stmt = $this->db_connection->prepare("SELECT * FROM delivery_addresses WHERE delivery_addresses.id = ?");
        $stmt->bind_param("i", $addressId);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object() ?? false;
    }

    public function updateAddress(int $currentId, int $state, int $township, string $address, string $mobile,): int|bool|mysqli {
        $stmt = $this->db_connection->prepare("UPDATE `delivery_addresses` SET state_id=?, town_id=?, detail_address=?, phone_num=? WHERE id=?");
        $stmt->bind_param("iissi", $state, $township, $address, $mobile, $currentId);
        return $stmt->execute() ?? false;
    }

    // Fetching Functions

    public function deleteAddress(int $currentId): int|bool|mysqli {
        $stmt = $this->db_connection->prepare("DELETE FROM `delivery_addresses` WHERE id = ?");
        $stmt->bind_param("i", $currentId);
        return $stmt->execute() ?? false;
    }

    public function getAddresses(int $userId): array {
        $stmt = $this->db_connection->prepare("SELECT * FROM delivery_addresses WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $data = $stmt->get_result();
        $lists = [];
        while ($row = $data->fetch_object()) {
            $lists[] = $row;
        }
        return $lists;
    }

    public function getDefaultDeliveryAddressId(int $userId): object|bool|string {
        $stmt = $this->db_connection->prepare("SELECT da.id FROM delivery_addresses da JOIN users u ON da.id = u.default_delivery_address_id WHERE u.id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object() ?? false;
    }

    public function getDefaultDeliveryAddress(int $id): object|bool {
        $stmt = $this->db_connection->prepare("SELECT da.id, da.state_id, da.detail_address, da.phone_num FROM delivery_addresses da JOIN users u ON da.id = u.default_delivery_address_id WHERE u.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result();
        return $data->fetch_object();
    }

}