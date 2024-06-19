<?php
system("clear");
$db = "db.sqlite";
$tableName = "users";
$name = "Test";

try {
    $conn = new SQLite3($db);
    $sql = "INSERT INTO users (name) VALUES (:name);";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
} catch (Exception $e) {
    print_r($e);
}