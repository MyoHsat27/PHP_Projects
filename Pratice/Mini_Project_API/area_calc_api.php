<?php

header("Content-type:Application/json");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $result = [
      "width" => $_POST['width'] . "ft",
      "height" => $_POST['height'] . 'ft',
      "area" => $_POST["width"] * $_POST['height'] . "sqft"
    ];

    $dir = "records";
    $photoDir = "photo_dir";
    // store photo
    if (!file_exists($photoDir)) {
        mkdir($photoDir);
    }

    if ($_FILES['photo']['error'] === 0) {
        $newPhotoName = $photoDir . "/photo-" . uniqid() . "." . pathinfo($_FILES['photo']['name'])['extension'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $newPhotoName);
        $result['photo'] = $newPhotoName;
    }

    // store data
    if (!is_dir($dir)) {
        mkdir($dir);
    }

    $response = json_encode($result);
    $newFilename = $dir . "/r-".uniqid()."-".time().".json";
    $file = fopen($newFilename, "w");
    fwrite($file, $response);
    fclose($file);

    header("HTTP/1.1 201 File Created");


}

