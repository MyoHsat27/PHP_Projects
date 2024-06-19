<?php

require_once "./index.php";

if (!$conn) {
    die("Connection failed" . mysqli_connect_error());
}

$sql = "SELECT * FROM myStudent";
$result = mysqli_query($conn, $sql);

while($row  = mysqli_fetch_assoc($result)) {
    print_r($row);
}
