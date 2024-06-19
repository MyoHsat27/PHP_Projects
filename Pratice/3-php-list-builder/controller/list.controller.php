<?php

function index () : void {
    $sql = "SELECT * FROM my";
    if (!empty($_GET['q'])) {
      $q = sanitize($_GET['q'], true);
      $sql .= " WHERE name LIKE '%$q%'";
    }
    view("list/index", ['lists' => paginate($sql, 10)]);
}

function create () : void {
    view("list/create");
}

function store () : void {
    $name = sanitize($_POST['name']);
    $money = $_POST['money'];
    $sql = "INSERT INTO my (name,money) VALUES ('$name', $money)";
    if (run($sql)) {
        redirect(route("list"),"List Created Successfully");
    } else {
        redirect(route("list-create"));
    }
}

function delete () : void {
    $id = $_POST['id'];
    $sql = "DELETE FROM my WHERE id=$id";
    if (run($sql)) {
      redirect($_SERVER['HTTP_REFERER'], "List Deleted Successfully");
    }
}

function edit () : void {
    $id = $_GET['id'];
    $sql = "SELECT * FROM my WHERE id=$id";
    view("list/edit", ['list' => first($sql)]);
}

function update () : void {
    $id = $_POST['id'];
    $name = sanitize($_POST['name']);
    $money = $_POST['money'];
    $sql = "UPDATE my SET name='$name', money=$money WHERE id=$id";
    if (run($sql)) {
        redirect(route("list"),"List Updated Successfully");
    } else {
        redirect(route("list-edit") );
    }
}
