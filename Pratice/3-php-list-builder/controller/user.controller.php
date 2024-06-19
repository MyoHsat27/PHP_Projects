<?php

function index () : void {
    $sql = "SELECT * FROM users";
    if (!empty($_GET['q'])) {
      $q = sanitize($_GET['q'], true) ;
      $sql .= " WHERE name LIKE '%$q%'";
    }
    responseJson(paginate($sql, 10));
}

function show () : void {
  $id = $_GET['id'];
  $sql = "SELECT * FROM users WHERE id=$id";
  responseJson(first($sql));
}

function store () : void {
  validationStart();
  $name = $_POST['name'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
  $address = $_POST['address'];

  if (empty($name)) {
    setError("name","Name is required");
  } elseif (strlen($name) < 3) {
    setError("name","Name is too short");
  } elseif (strlen($name) > 16) {
    setError("name","Name is too long");
  } elseif (!preg_match("/^(\w+\s)*\w+$/", $name)) {
    setError("name","Name isn't match");
  }

  if (empty($email)) {
    setError("email","Email is required");
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    setError("email","Incorrect email format");
  }

  if (empty($gender)) {
    setError("gender","Gender is required");
  } elseif (!in_array($gender, ['male','female'])) {
    setError("gender","Gender can only be male or female");
  }

  if (empty($address)) {
    setError("address","Address is required");
  } elseif (strlen($address) < 3) {
    setError("address","Address is too short");
  } elseif (strlen($address) > 40) {
    setError("address","Address is too long");
  }

  validationEnd(true);


    run("INSERT INTO users (name,email, gender, address) VALUES ('$name', '$email', '$gender', '$address')");

    $current = $GLOBALS['conn']->insert_id;
    $data = first("SELECT * FROM users WHERE id = $current");
    responseJson($data, 201);
}

function delete () : void {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id=$id";
    if (run($sql)) {
      responseJson("User Deleted Successfully");
    } else {
      responseJson("User couldn't be deleted", 400);
    }
}

function update () : void {
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_GET['id'];
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $gender = $_PUT['gender'];
    $address = sanitize($_POST['address']);
    $sql = "UPDATE users SET name='$name', email='$email', gender='$gender', address='$address' WHERE id=$id";
    if (run($sql)) {
      responseJson("User Updated Successfully");
    } else {
      responseJson("User couldn't be updated", 400);
    }
}
