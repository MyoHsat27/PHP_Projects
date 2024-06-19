<?php
    require_once "./index.php";

$sql = "CREATE DATABASE Testing";

if (mysqli_query($conn, $sql)) {
    echo "Correct";
} else {
    echo "Incorrect";
}

