<?php

header("Content-type:Application/json");
$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . "/";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $dir = "photo_dir";
    if (!file_exists($dir)) {
        mkdir($dir);
    }
    $response = [];
    foreach ($_FILES['photos']['name'] as $key=>$photo) {
        $newFileName = $dir . "/photo-" . uniqid() . "." . pathinfo($photo)["extension"];
        if (move_uploaded_file($_FILES['photos']['tmp_name'][$key], $newFileName)) {
            $response[] = $baseUrl. $newFileName;
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 500 Internal Server Error");
        }
    }

    echo json_encode($response);
}