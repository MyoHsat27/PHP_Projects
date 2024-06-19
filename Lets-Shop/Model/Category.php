<?php
require_once ModelDir."/DBConfig.php";

class Category {
    private mysqli $db_connection;
    private object $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // CRUD functions
    public function create (string $categoryName,string $categoryDescription) : mysqli|bool {
        $query = "INSERT INTO `categories` (`name`, `description`) VALUES ('$categoryName', '$categoryDescription');";
        return $this->dbConfig->run($this->db_connection, $query);
    }
    public function update (string $categoryId, string $categoryName,string $categoryDescription) : mysqli|bool {
        $query = "UPDATE `categories` SET `name`='$categoryName', `description`='$categoryDescription' WHERE id=$categoryId";
        return $this->dbConfig->run($this->db_connection, $query);
    }
    public function delete (string $categoryId) : mysqli|bool {
        $query = "DELETE FROM `categories` WHERE id=$categoryId;";
        return $this->dbConfig->run($this->db_connection,$query);
    }

    // Common Functions
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
        $query = "SELECT * FROM `categories`";
        if (isset($q)) {
            $query .= " WHERE name LIKE '%$q%'";
        }
        $query .= ";";

        return $this->fetchMultiple($query);
    }
    public function getId ($id) : object|null {
        $query = "SELECT * FROM `categories` WHERE id=$id;";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data);
    }
    public function getAllCategories () : array {
        $query = "SELECT `id`,`name` FROM `categories`;";
        return $this->fetchMultiple($query);
    }
}