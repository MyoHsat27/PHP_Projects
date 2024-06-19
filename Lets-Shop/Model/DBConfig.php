<?php

class DBConfig {
    private string $hostname = "localhost";
    private string $username = "myo";
    private string $pass = "yngWIE500";
    private string $database = "lets_shop";

    public function dropAllTable(): void {
        $query = $this->run($this->db_connection(), "SELECT CONCAT('DROP TABLE IF EXISTS ', TABLE_NAME, ';') AS drop_table FROM information_schema.TABLES WHERE TABLE_SCHEMA='{$this->database}';");
        for ($i = 0; $i < $query->num_rows; $i++) {
            $drop_sql = mysqli_fetch_object($query)->drop_table;
            $this->run($this->db_connection(), $drop_sql);
        }
        logger("All tables have dropped", 93);
    }

    public function run($connection, string $sql, bool $closeConnection = false): object|bool {
        try {
            $query = mysqli_query($connection, $sql);
            if ($closeConnection) mysqli_close($connection);
            return $query;
        } catch (Exception $error) {
            dd($error);
        }
    }

    public function db_connection(): mysqli {
        return new mysqli($this->hostname, $this->username, $this->pass, $this->database);
    }

    public function createTable(string $name, ...$columns): void {
        $this->run($this->db_connection(), "DROP TABLE IF EXISTS $name");
        logger($name." table Drop Successfully", 93);
        $sql = "CREATE TABLE `lets_shop`.`$name` (
              ".join(',', $columns).") 
              ENGINE = InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;";
        $this->run($this->db_connection(), $sql);
        logger($name." table Created Successfully");
    }

    public function seed() : void {

    }
}