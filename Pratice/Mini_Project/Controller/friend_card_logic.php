<?php
$friends = [];
$fileName = "fdata.json";

if (is_file($fileName) && filesize($fileName) > 0) {
    $friends = json_decode(file_get_contents($fileName));
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if ($_FILES['photo']['error'] === 0) {
        $dir = "friend_zone";
        $newFileName = $dir . "/" . uniqid() . "_friend." . pathinfo($_FILES['photo']['name'])['extension'];
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        move_uploaded_file($_FILES['photo']['tmp_name'], $newFileName);
        $info = $_POST;
        $info['photo'] = $newFileName;

        $friends[] = $info;
        $fdata = fopen($fileName, "w");
        fwrite($fdata, json_encode($friends));
        fclose($fdata);

    }


}