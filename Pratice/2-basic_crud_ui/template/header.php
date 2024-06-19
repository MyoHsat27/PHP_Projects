<?php require_once "core/function.php";?>
<?php require_once "core/connection.php";?>
<?php session_start(); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Builder</title>
    <link rel="stylesheet" href="<?= url("node_modules/bootstrap/dist/css/bootstrap.min.css") ?>"
    <link rel="stylesheet" href="<?= url("node_modules/bootstrap-icons/font/bootstrap-icons.css") ?>"
    <link rel="stylesheet" href="<?= url("css/app.css") ?>"
</head>
<body>

<?php require_once "navbar.php";?>

