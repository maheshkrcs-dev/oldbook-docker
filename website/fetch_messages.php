<?php
require('include/connection.inc.php');
session_start();

$user_id = $_SESSION['user_id'];
$conversation_id = intval($_GET['conversation_id']);

/* MARK AS READ */
$stmt = $con->prepare("UPDATE messages SET is_read=1 WHERE conversation_id=? AND sender_id!=?");
$stmt->bind_param("ii",$conversation_id,$user_id);
$stmt->execute();

/* FETCH MESSAGES */
$stmt = $con->prepare("SELECT * FROM messages WHERE conversation_id=? ORDER BY id ASC");
$stmt->bind_param("i",$conversation_id);
$stmt->execute();
$res = $stmt->get_result();

while($row = $res->fetch_assoc()){

    $time = date("h:i A", strtotime($row['created_at']));

    if($row['sender_id'] == $user_id){

        echo "<div style='text-align:right;margin:8px;'>
        <span style='background:#dcf8c6;padding:10px;border-radius:10px;display:inline-block;max-width:70%;'>
        ".htmlspecialchars($row['message'])."
        <br><small style='font-size:10px;'>$time ✓</small>
        </span></div>";

    } else {

        echo "<div style='text-align:left;margin:8px;'>
        <span style='background:#fff;padding:10px;border-radius:10px;display:inline-block;max-width:70%;'>
        ".htmlspecialchars($row['message'])."
        <br><small style='font-size:10px;'>$time</small>
        </span></div>";
    }
}