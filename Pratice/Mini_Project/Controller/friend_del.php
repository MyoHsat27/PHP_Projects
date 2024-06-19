<?php


$friends = [];
$fileName = "../View/fdata.json";

if (file_exists($fileName) && filesize($fileName) > 0) {
    $friends = json_decode(file_get_contents($fileName), true);
}

unlink("../View/".$friends[$_GET['index']]['photo']);
array_splice($friends, $_GET['index'], 1);
file_put_contents($fileName, json_encode($friends));

header("Location: ../View/card.php");