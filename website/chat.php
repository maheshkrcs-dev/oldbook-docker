<?php
require('include/header.inc.php');
require('include/connection.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_GET['book_id']);
$seller_id = intval($_GET['seller_id']);

/* FIND OR CREATE CHAT */
$stmt = $con->prepare("SELECT id FROM conversations 
WHERE book_id=? AND 
((sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?))");

$stmt->bind_param("iiiii",$book_id,$user_id,$seller_id,$seller_id,$user_id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows > 0){
    $row = $res->fetch_assoc();
    $conversation_id = $row['id'];
} else {
    $stmt = $con->prepare("INSERT INTO conversations(book_id,sender_id,receiver_id) VALUES(?,?,?)");
    $stmt->bind_param("iii",$book_id,$user_id,$seller_id);
    $stmt->execute();
    $conversation_id = $stmt->insert_id;
}
?>

<div class="container mt-4">
    
<?php
$other_user = ($user_id == $seller_id) ? $_GET['buyer_id'] : $seller_id;
$res = mysqli_query($con,"SELECT name,last_seen FROM users WHERE id='$seller_id'");
$user = mysqli_fetch_assoc($res);

$online = (strtotime($user['last_seen']) > time() - 10);
?>

<div class="chat-container">

<!-- HEADER -->
<div class="chat-header">
💬 <?php echo htmlspecialchars($name); ?>

<br>
<span style="font-size:12px;color:#ccc;">
<?php echo $online ? "🟢 Online" : "⚪ Offline"; ?>
</span>

<div id="typingStatus" style="font-size:12px;color:#ccc;"></div>
</div>

<div id="typingStatus" style="font-size:12px;color:#ccc;"></div>

<!-- CHAT BODY -->
<div id="chatBox" class="chat-body"></div>

<!-- INPUT -->
<form id="chatForm" class="chat-input">
<input type="hidden" id="conversation_id" value="<?php echo $conversation_id; ?>">

<input type="text" id="message" placeholder="Type a message..." required>

<button>➤</button>
</form>

</div>
</div>

<script>

/* LOAD MESSAGES */
function loadMessages(){

    let id = document.getElementById("conversation_id").value;

    fetch('fetch_messages.php?conversation_id='+id)
    .then(res => res.text())
    .then(data => {
        document.getElementById("chatBox").innerHTML = data;
        document.getElementById("chatBox").scrollTop = 99999;
    });
}

setInterval(loadMessages, 1000);
loadMessages();

/* SEND MESSAGE */
document.getElementById("chatForm").addEventListener("submit", function(e){
    e.preventDefault();

    let msg = document.getElementById("message").value;
    let id = document.getElementById("conversation_id").value;

    fetch('send_message.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`message=${encodeURIComponent(msg)}&conversation_id=${id}`
    }).then(()=>{
        document.getElementById("message").value='';
        loadMessages();
    });
});

/* ===== TYPING DETECTION ===== */

let typingTimer;

document.getElementById("message").addEventListener("input", function(){

    let id = document.getElementById("conversation_id").value;

    fetch('typing.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`conversation_id=${id}&typing=1`
    });

    clearTimeout(typingTimer);

    typingTimer = setTimeout(()=>{
        fetch('typing.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`conversation_id=${id}&typing=0`
        });
    }, 1000);
});

<?php
/* GET OTHER USER CORRECTLY */
$other_user_id = ($user_id == $seller_id) ? $seller_id : $seller_id;

$stmt = $con->prepare("SELECT name,last_seen FROM users WHERE id=?");
$stmt->bind_param("i",$seller_id);
$stmt->execute();
$res = $stmt->get_result();

$user = $res->fetch_assoc();

/* SAFE FALLBACK */
$name = $user['name'] ?? 'User';
$last_seen = $user['last_seen'] ?? null;

$online = false;

if($last_seen){
    $online = (strtotime($last_seen) > time() - 10);
}
?>

/* ===== CHECK TYPING ===== */
function checkTyping(){

    let id = document.getElementById("conversation_id").value;

    fetch('check_typing.php?conversation_id='+id)
    .then(res => res.text())
    .then(data=>{
        document.getElementById("typingStatus").innerText = data;
    });
}

setInterval(checkTyping,1000);

</script>

<?php require('include/footer.inc.php'); ?>