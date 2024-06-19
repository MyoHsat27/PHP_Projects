<?php

$port = 8000;

if (strtoupper(PHP_OS) === "LINUX") {
  system("cd Public;php -S localhost:$port");
}
