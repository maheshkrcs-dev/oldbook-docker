<?php
require('include/connection.inc.php');
session_start();

$user_id = $_SESSION['user_id'];
$conversation_id = $_POST['conversation_id'];
$typing = $_POST['typing'];

mysqli_query($con,"
INSERT INTO typing_status(conversation_id,user_id,is_typing)
VALUES('$conversation_id','$user_id','$typing')
ON DUPLICATE KEY UPDATE is_typing='$typing'
");