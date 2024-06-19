<?php
$data = 27 . " OR 1=1;";

try {
    $conn = new PDO("mysql:host=localhost;dbname=kbtc_test", "myo", "yngWIE500");
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("DELETE FROM customer WHERE `customer`.`id` = :id");
    $stmt->bindParam(":id", $data);
    print_r($stmt->execute());
} catch(PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
}
