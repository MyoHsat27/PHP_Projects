<?php

function index () : void {
    $sql = "SELECT * FROM inventories";
    if (!empty($_GET['q'])) {
      $q = sanitize($_GET['q'],true);
      $sql .= " WHERE name LIKE '%$q%'";
    }
    view("inventory/index", ['lists' => paginate($sql, 10)]);
}

function create () : void {
    view("inventory/create");
}

function store () : void {
  validationStart();
  $name = sanitize($_POST['name']);
  $price = sanitize($_POST['price']);
  $stock = sanitize($_POST['stock']);

    if (empty($name)) {
      setError("name","Name is required");
    } elseif (strlen($name) < 3) {  
      setError("name","Name is too short");
    } elseif (strlen($name) > 16) {
      setError("name","Name is too long");
    } elseif (!preg_match("/^(\w+\s)*\w+$/", $name)) {
      setError("name","Name isn't match");
    }

  if (empty($price)) {
    setError("price","Price is required");
  } elseif (!is_numeric($price)) {
    setError("price","Price must be number");
  } elseif ($price < 100) {
    setError("price","Price must be greater than 100");
  } elseif ($price > 9999) {
    setError("price","Price must be less than 10000");
  }

  if (empty($stock)) {
    setError("stock","Stock is required");
  } elseif (!is_numeric($stock)) {
    setError("stock","Stock must be number");
  } elseif ($stock < 1) {
    setError("stock","Stock must be greater than 1");
  } elseif ($stock > 1000) {
    setError("stock","Stock must be less than 999");
  }


  validationEnd();

    $sql = "INSERT INTO inventories (name,price, stock) VALUES ('$name', $price, $stock)";
    if (run($sql)) {
        redirect(route("inventory"),"Item Created Successfully");
    } else {
        redirectBack("Item Create Failed");
    }
}

function delete () : void { 
    $id = $_POST['id'];
    $sql = "DELETE FROM inventories WHERE id=$id";
    if (run($sql)) {
      redirectBack("Item Deleted Successfully");
    } else {
      redirectBack("Item Can't be deleted");
    }
}

function edit () : void {
    $id = $_GET['id'];
    $sql = "SELECT * FROM inventories WHERE id=$id";
    view("inventory/edit", ['list' => first($sql)]);
}

function update () : void {
    $id = $_POST['id'];
    $name = sanitize($_POST['name']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $sql = "UPDATE inventories SET name='$name', price=$price, stock=$stock WHERE id=$id";
    if (run($sql)) {
        redirect(route("inventory"),"Item Updated Successfully");
    } else {
        redirectBack("Item Update Failed");
    }
}
