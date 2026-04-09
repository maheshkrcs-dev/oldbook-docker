<?php
require('include/header.inc.php');
require('include/connection.inc.php');

$id = intval($_GET['id']);

$stmt = $con->prepare("SELECT * FROM bdata WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
?>

<div class="container mt-5">
<div class="row">

<div class="col-md-5">
<img src="assets/images/<?php echo $row['B_img1']; ?>" class="img-fluid rounded shadow">
</div>

<div class="col-md-7">

<h2><?php echo $row['B_name']; ?></h2>
<p class="text-muted">By <?php echo $row['B_writer']; ?></p>

<h3 class="text-success">₹<?php echo $row['B_price']; ?></h3>

<p><?php echo $row['B_des']; ?></p>

<p><b>Location:</b> <?php echo $row['dist'].", ".$row['state']; ?></p>

<a href="chat.php?book_id=<?php echo $row['id']; ?>&seller_id=<?php echo $row['user_id']; ?>" 
class="btn btn-primary">
💬 Chat with Seller
</a>

<a href="index.php" class="btn btn-secondary">Back</a>

</div>
</div>
</div>

<?php require('include/footer.inc.php'); ?>