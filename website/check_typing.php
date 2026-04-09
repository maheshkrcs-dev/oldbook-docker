<?php
require('include/connection.inc.php');
session_start();

$user_id = $_SESSION['user_id'];
$conversation_id = $_GET['conversation_id'];

$res = mysqli_query($con,"
SELECT is_typing FROM typing_status 
WHERE conversation_id='$conversation_id' AND user_id!='$user_id'
");

$row = mysqli_fetch_assoc($res);

echo ($row && $row['is_typing']) ? "typing..." : "";