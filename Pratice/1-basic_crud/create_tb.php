<?php
require_once "./index.php";

$sql = "CREATE TABLE `myStudent` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(20) NOT NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ";


if (mysqli_query($conn, $sql)) {
    echo "Correct";
} else {
    echo "Incorrect";
}

