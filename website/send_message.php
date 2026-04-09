<?php
require('include/connection.inc.php');
session_start();

$user_id = $_SESSION['user_id'];

$msg = trim($_POST['message']);
$conversation_id = intval($_POST['conversation_id']);

if($msg != ''){

    $stmt = $con->prepare("INSERT INTO messages(conversation_id,sender_id,message,is_read) VALUES(?,?,?,0)");
    $stmt->bind_param("iis",$conversation_id,$user_id,$msg);
    $stmt->execute();
}