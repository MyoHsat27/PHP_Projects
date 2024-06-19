<?php

use JetBrains\PhpStorm\NoReturn;

require_once "global.php";

// die and dump
#[NoReturn] function dd($data, $showType = false) : void
{
    echo "<pre style='background-color: #1d1d1d; color: white; padding: 20px; margin: 10px; border-radius: 10px'>";
    if ($showType) {
        var_dump($data);
    } else {
        print_r($data);
    }
    echo "</pre>";
    die();
}

// File upload function
function url (string $path) : string {
    $url = isset($_SERVER['HTTPS']) ? "https" : "http";
    $url .= "://" . $_SERVER['HTTP_HOST'] . "/{$path}";
    return $url;
}

function response (mixed $data,int $status = 200): string
{
    header("Content-type:Application/json");
    http_response_code($status);
    if (is_array($data)) {
        return json_encode($data);
    }
    return json_encode(["message" => $data]);
}

function area (float $width,float $height) : float
{
    return $width * $height;
}

function extension (string $fileName) : string
{
    return pathinfo($fileName)['extension'];
}

function randomFileName (string $ext) : string
{
    return md5(uniqid()) . "." . $ext;
}

function upload (string $key,string $location ) : string
{
    $ext = extension($_FILES[$key]['name']);
    $newFileName = $location."/".randomFileName($ext);
    move_uploaded_file($_FILES[$key]['tmp_name'], $newFileName);
    return $newFileName;
}

function saveJson($text) : void {
    $newFilename = RECORD_DIR . "/" . randomFileName("json");
    $file = fopen($newFilename, "w");
    fwrite($file, $text);
    fclose($file);
}

function logger ($message, int $colorCode = 38) : void
{
    echo "\e[{$colorCode}m[LOG] " . "\e[{$colorCode}m" . $message . "\n";
}

function scan_file ($dir) : array {
    $files = scandir($dir);
    $result = [];

    foreach ($files as $file) {
        if ($file !== "." && $file !== "..") {
            $result[] = $file;
        }
    }
    return $result;
}