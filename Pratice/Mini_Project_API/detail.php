<?php

header("Content-type:Application/json");
$dir = "records";

if (!empty($_GET['file'])) {
    $fileName = $_GET['file'];
    if (file_exists($dir . "/". $fileName)) {
        echo file_get_contents($dir. "/". $fileName);
    } else {
        echo json_encode(["error" => "No such file exist."]);
        header("HTTP/1.1 404 Not Found");
    }
}else {
    echo json_encode(["error" => "File is required"]);
}