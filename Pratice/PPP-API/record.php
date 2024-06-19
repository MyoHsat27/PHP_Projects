<?php

require_once "function.php";

$data = array_map(function ($file) {
    $currentFile = json_decode(file_get_contents(RECORD_DIR . "/" . $file), true);
    $currentFile['file'] = $file;
    $currentFile['location'] = url(RECORD_DIR . "/" . $file);
    return $currentFile;
}, scan_file(RECORD_DIR));

dd($data);