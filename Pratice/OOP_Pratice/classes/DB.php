<?php

class DB {
  private object $conn;
  public string $tableName;

  public function __construct(string $tableName) {
    $hostname = "localhost";
    $username = "myo";
    $password = "yngWIE500";
    $database = "oop_test";
    $this->tableName = $tableName;

    $this->conn = mysqli_connect($hostname,$username,$password,$database);
  }

  public function create (array $data) : mysqli|bool
  {
    // "INSERT INTO Users () VALUES ();
    $sql = "INSERT INTO ".$this->tableName." ";
    $sql .= "(`".join("`,`",array_keys($data))."`) VALUES   ";
    $sql .= "('".join("','",array_values($data))."');";
    mysqli_query($this->conn,$sql);
    return $this->conn->insert_id;
  }

  public function index () : array {
    $sql = "SELECT * FROM $this->tableName";
    $query = mysqli_query($this->conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_object($query)) {
      $rows[] = $row;
    }
    return $rows;
  }

  public function show (int $id) : object {
    $sql = "SELECT * FROM $this->tableName WHERE id=$id";
    $query = mysqli_query($this->conn,$sql);
    return mysqli_fetch_object($query);
  }

  public function __destruct(){
    mysqli_close($this->conn);
  }

}
