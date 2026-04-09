<?php
require('include/header.inc.php');
require('include/connection.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location:auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT orders.*, bdata.B_name, bdata.B_img1 
        FROM orders 
        JOIN bdata ON orders.book_id = bdata.id 
        WHERE orders.user_id=? 
        ORDER BY orders.id DESC";

$stmt = $con->prepare($sql);
$stmt->bind_param("i",$user_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="container mt-5">

<h3 class="section-title mb-4">📦 My Orders</h3>

<div class="row g-4">

<?php if($res->num_rows > 0){ 
while($row = $res->fetch_assoc()){ ?>

<div class="col-lg-3 col-md-6">

<div class="book-card">

<img src="assets/images/<?php echo $row['B_img1']; ?>" class="book-img">

<div class="book-body">

<div class="book-title"><?php echo $row['B_name']; ?></div>

<div class="book-price">₹<?php echo $row['price']; ?></div>

<div class="small text-muted">
Ordered on: <?php echo date('d M Y', strtotime($row['order_date'])); ?>
</div>

</div>

</div>

</div>

<?php } } else { ?>

<div class="text-center py-5">
<h5>No orders yet</h5>
</div>

<?php } ?>

</div>

</div>

<?php require('include/footer.inc.php'); ?>