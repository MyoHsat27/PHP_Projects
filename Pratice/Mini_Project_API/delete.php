<?php

header("Content-type:Application/json");
$dir = "records";

if ($_SERVER['REQUEST_METHOD'])
if (!empty($_GET['file'])) {
    $fileName = $_GET['file'];
    if (file_exists($dir . "/". $fileName)) {
        unlink($dir. "/". $fileName);
        echo json_encode(["message" => "File deleted."]);
        header("HTTP/1.1 202 Accepted");
    } else {
        echo json_encode(["error" => "No such file exist."]);
        header("HTTP/1.1 404 Not Found");
    }
}else {
    echo json_encode(["error" => "File is required"]);
}