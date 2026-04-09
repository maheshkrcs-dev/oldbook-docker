<?php
require('auth.php');
require('../include/connection.inc.php');

$id = (int)$_GET['id'];

$stmt = $con->prepare("SELECT B_img1 FROM bdata WHERE B_id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if($row){
    $file = "../assets/images/" . $row['B_img1'];
    if(file_exists($file)){
        unlink($file);
    }
}

$stmt = $con->prepare("DELETE FROM bdata WHERE B_id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: books.php");
?>