<?php
function area($width, $height)
{
    return $width * $height;
}

function exchange($amount, $from, $to)
{
    $mmk = $amount * $from;
    return round($mmk / $to, 2) . " " . $_POST['to'];
}
