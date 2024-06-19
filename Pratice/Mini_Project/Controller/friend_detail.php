<?php
$friends = [];
$fileName = "fdata.json";

if (file_exists($fileName) && filesize($fileName)) {
    $friends = json_decode(file_get_contents($fileName), true);
}

print_r($friends[$_GET['index']]);