<?php

require_once "function.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = [
        "width" => $_POST['width'] . "ft",
        "height" => $_POST['height'] . "ft",
        "area" => area($_POST['width'], $_POST['height']) . "sqft"
    ];

    if (!empty($_FILES) && $_FILES['photo']['error'] === 0 ) {
          $photoName = upload('photo', PHOTO_DIR);
          $data['photo'] = url($photoName);
    }

    saveJson(json_encode($data));

    echo  response($data);

}