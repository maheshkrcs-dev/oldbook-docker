<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$hostname = "db";
$username = "root";
$password = "root123";
$database = "oldbook";

$con = mysqli_connect($hostname, $username, $password, $database);

if(!$con){
    die("Database Connection Failed: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");
?>