<?php
$port = 8000;
if (strtoupper(PHP_OS) === "LINUX") {
    system("cd public;php -S localhost:$port");
}