<?php
require_once "./core/function.php";
require_once "./core/connection.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $sql = "DELETE FROM my WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        session_start();
        $_SESSION['status'] = [ 'message' => "List Deleted"];
        header("Location:list_index.php");
    }
}