<?php

header("Content-type:Application/json");

$dir = "records";
$files = scandir($dir);
$result = [];

foreach ($files as $file) {
    if ($file !== "." && $file !== "..") {
        $data = json_decode(file_get_contents($dir."/".$file),true);
        $data['file'] = $file;
        $result[] = $data;
    }
}

$response = json_encode($result);
echo $response;