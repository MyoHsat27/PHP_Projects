<?php
require_once "./core/function.php";
require_once "./core/connection.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $money = $_POST['money'];
    $sql = "UPDATE my SET name='$name', money=$money WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        session_start();
        $_SESSION['status'] = [ 'message' => "List Updated"];
        header("Location:list_index.php");
    } else {
        header("Location:list_update.php");
    }
}