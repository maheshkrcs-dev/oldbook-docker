<?php
require('auth.php');
require('../include/connection.inc.php');

$id = (int)$_GET['id'];

$stmt = $con->prepare("DELETE FROM login WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: users.php");
?>