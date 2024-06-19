<?php

function url (string $path = null) : string {
    $url = isset($_SERVER['HTTPS']) ? "https" : "http";
    $url .= "://" . $_SERVER['HTTP_HOST'];
    if (isset($path)) {
        $url .= "/"  . $path;
    }
    return $url;
}

function alert (string $message, string $color = 'success') : string {
    return "<div class='alert-$color alert'>$message</div>";
}

function showDateTime (string $sqlTimeStamp, string $format = 'j-M-Y | h :i:s') :string {
    return date($format, strtotime($sqlTimeStamp));
}