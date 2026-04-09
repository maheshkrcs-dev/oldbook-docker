<?php
require('../include/connection.inc.php');
session_start();

if(!isset($_SESSION['admin'])){
    die("Access denied");
}

$id = intval($_GET['id']);

if($_GET['type']=='approve'){
    $stmt = $con->prepare("UPDATE bdata SET status=1 WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

if($_GET['type']=='reject'){
    $stmt = $con->prepare("UPDATE bdata SET status=2 WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

header("Location: dashboard.php");