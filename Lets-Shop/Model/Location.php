<?php
require_once ModelDir."/DBConfig.php";

class Location {
    private mysqli $db_connection;
    private object $dbConfig;

    public function __construct() {
        $this->dbConfig = new DBConfig();
        $this->db_connection = $this->dbConfig->db_connection();
    }

    // CRUD functions
    public function createState(string $name, bool $active_state): int|bool {
        $stmt = $this->db_connection->prepare("INSERT INTO states (name, active_state) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $active_state);

        if (!$stmt->execute()) {
            return false;
        }
        return $this->db_connection->insert_id;
    }

    public function createTown(string $name, int $price, int $state_id): bool {
        $stmt = $this->db_connection->prepare("INSERT INTO towns (name, delivery_price, state_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $name, $price, $state_id);

        return $stmt->execute();
    }

    public function updateState (string $name, bool $active_state, int $state_id) : int {
        $stmt = $this->db_connection->prepare("UPDATE states SET `name` = ?, `active_state` = ? WHERE `states`.id = ?");
        $stmt->bind_param("sii", $name, $active_state, $state_id);
        return $stmt->execute();
    }

    public function updateTown (string $name, int $price, int $state_id, int $town_id) : int {
        $stmt = $this->db_connection->prepare("UPDATE towns SET `name` = ?, delivery_price = ?, state_id = ? WHERE towns.id = ?");
        $stmt->bind_param("sdii", $name, $price, $state_id, $town_id);
        return $stmt->execute();
    }

    public function deleteTown (int $town_id) : bool {
        $stmt = $this->db_connection->prepare("DELETE FROM towns WHERE id = ?");
        $stmt->bind_param("i",$town_id);

        return $stmt->execute();
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
    public function getAllStates (string $q = null) : array {
        $query = "SELECT s.id, s.name, s.active_state, s.created_at, COUNT(t.name) as town_count FROM states s LEFT JOIN towns t ON s.id = t.state_id";
        if (isset($q)) {
            $query .= " WHERE s.name LIKE '%$q%'";
        }
        $query .= " GROUP BY s.id, s.name, s.active_state, s.created_at;";
        return $this->fetchMultiple($query);
    }
    public function getStateId (int $id) : object {
        $query = "SELECT * FROM states WHERE states.id = $id";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data);
    }
    public function getStateName (int $id) : object {
        $query = "SELECT states.name FROM states WHERE states.id = $id";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data);
    }
    public function getRelatedTowns (int $id) : array|null {
        $query = "SELECT t.id, t.name, t.delivery_price price, t.added_at FROM states s INNER JOIN towns t on s.id = t.state_id WHERE s.id = $id";
        return $this->fetchMultiple($query);
    }
    public function getStateIdName () : array {
        $query = "SELECT s.id, s.name, s.active_state FROM states s";
        return $this->fetchMultiple($query);
    }
    public function getTownId (int $id) : object {
        $query = "SELECT * FROM towns WHERE towns.id = $id";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data);
    }
    public function getTownIdName () : array {
        $query = "SELECT towns.id, towns.name, towns.state_id FROM towns";
        return $this->fetchMultiple($query);
    }
    public function getTownName (int $id) : object {
        $query = "SELECT towns.name FROM towns WHERE towns.id = $id";
        $data = $this->dbConfig->run($this->db_connection, $query);
        return mysqli_fetch_object($data);
    }
    public function getDeliveryPrices () : array|null {
        $query = "SELECT towns.id, towns.delivery_price FROM towns";
        return $this->fetchMultiple($query);
    }
}