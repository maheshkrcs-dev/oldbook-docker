<?php
require('include/header.inc.php');
require('include/connection.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* FETCH CONVERSATIONS */
$stmt = $con->prepare("
SELECT c.*, b.B_name, u.name,

(
    SELECT message FROM messages 
    WHERE conversation_id=c.id 
    ORDER BY id DESC LIMIT 1
) as last_message,

(
    SELECT created_at FROM messages 
    WHERE conversation_id=c.id 
    ORDER BY id DESC LIMIT 1
) as last_time,

(
    SELECT COUNT(*) FROM messages 
    WHERE conversation_id=c.id AND is_read=0 AND sender_id!=?
) as unread_count

FROM conversations c
JOIN bdata b ON c.book_id=b.id
JOIN users u ON (
    CASE 
        WHEN c.sender_id=? THEN c.receiver_id = u.id
        ELSE c.sender_id = u.id
    END
)

WHERE c.sender_id=? OR c.receiver_id=?
ORDER BY last_time DESC
");

$stmt->bind_param("iiii",$user_id,$user_id,$user_id,$user_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="container mt-4">

<h4 class="mb-3">💬 Chats</h4>

<div class="chat-list">

<?php while($row = $res->fetch_assoc()){ ?>

<a href="chat.php?book_id=<?php echo $row['book_id']; ?>&seller_id=<?php echo ($row['sender_id']==$user_id ? $row['receiver_id'] : $row['sender_id']); ?>" 
class="chat-item">

<div class="d-flex justify-content-between">

<div>
<strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
<small><?php echo htmlspecialchars($row['last_message'] ?? 'Start chat'); ?></small>
</div>

<div class="text-end">

<small class="text-muted">
<?php 
echo $row['last_time'] ? date("h:i A", strtotime($row['last_time'])) : '';
?>
</small>

<?php if($row['unread_count'] > 0){ ?>
<div class="badge bg-success mt-1">
<?php echo $row['unread_count']; ?>
</div>
<?php } ?>

</div>

</div>

</a>

<?php } ?>

</div>

</div>

<style>

.chat-list{
    max-width:600px;
    margin:auto;
}

.chat-item{
    display:block;
    padding:15px;
    border-bottom:1px solid #eee;
    text-decoration:none;
    color:#000;
    transition:0.2s;
}

.chat-item:hover{
    background:#f1f5f9;
}

.badge{
    font-size:12px;
    border-radius:50%;
    padding:6px 10px;
}

</style>

<?php require('include/footer.inc.php'); ?>