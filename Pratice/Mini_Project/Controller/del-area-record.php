<?php
$filePath = "../View/" . $_GET['name'];
if (is_file($filePath)) {
    unlink($filePath);
}
$location = "../View/area.php";
header("Location: {$location}");

