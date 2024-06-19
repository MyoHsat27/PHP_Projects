<?php

require_once "./index.php";

$sql = "INSERT INTO myStudent (name) VALUES ('kk')";

if (mysqli_query($conn, $sql)) {
    echo "Correct";
} else {
    echo "Incorrect";
}