<?php
require('include/header.inc.php');
require('include/connection.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location:auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT bdata.* FROM wishlist 
JOIN bdata ON wishlist.book_id = bdata.id 
WHERE wishlist.user_id = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("i",$user_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="container mt-5">

<h3 class="section-title mb-4">❤️ My Wishlist</h3>

<div class="row g-4">

<?php if($res->num_rows > 0){ 
while($row = $res->fetch_assoc()){ ?>

<div class="col-lg-3 col-md-6">

<div class="book-card">

<div class="position-relative">
<img src="assets/images/<?php echo $row['B_img1']; ?>" class="book-img">
</div>

<div class="book-body">

<div class="book-title"><?php echo $row['B_name']; ?></div>

<div class="book-price">₹<?php echo $row['B_price']; ?></div>

<a href="action.php?type=like&id=<?php echo $row['id']; ?>" 
class="btn btn-danger btn-sm w-100 mb-2">
Remove
</a>

<a href="view.php?id=<?php echo $row['id']; ?>" 
class="btn btn-outline-primary btn-sm w-100">
View
</a>

</div>

</div>

</div>

<?php } } else { ?>

<div class="text-center py-5">
<h5>No items in wishlist</h5>
</div>

<?php } ?>

</div>

</div>

<?php require('include/footer.inc.php'); ?>