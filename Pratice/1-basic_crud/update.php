<?php

require_once "./index.php";

if (!$conn) {
    die("Connection failed" . mysqli_connect_error());
}

$sql = "UPDATE myStudent SET name = 'mm' WHERE id = 6";

if (mysqli_query($conn, $sql)) {
    echo "Updated";
} else {
    echo "Error";
}

$result = mysqli_query($conn,"SELECT * FROM myStudent");
while($row  = mysqli_fetch_assoc($result)) {
    print_r($row);
}
