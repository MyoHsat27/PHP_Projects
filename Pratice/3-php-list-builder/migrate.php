<?php
system("clear");
require_once "./core/connection.php";
require_once "./core/functions.php";

dropAllTable("Testing");

createTable("my", "name varchar(100) NOT NULL", "money int(11) NOT NULL");
createTable("inventories", "name varchar(50) NOT NULL", "price int(11) NOT NULL", "stock int(11) NOT NULL");
createTable("users", "name varchar(20) NOT NULL","email varchar(50) NOT NULL","gender enum('male','female') NOT NULL","address TEXT NOT NULL");
