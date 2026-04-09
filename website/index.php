<?php
require('include/header.inc.php');
require('include/connection.inc.php');

$res=mysqli_query($con,"SELECT * FROM bdata WHERE status=1 ORDER BY id DESC");
?>

<section class="hero text-center">
<div class="container">
<h1 class="fw-bold">Old Books. New Stories.</h1>
<p>Buy & sell books easily</p>
<a href="sell.php" class="btn btn-light mt-3">Sell Book</a>
</div>
</section>

<div class="container mt-5">
<div class="row g-4">

<?php while($row=mysqli_fetch_assoc($res)){ ?>

<div class="col-lg-3 col-md-6">
<div class="book-card">

<img src="assets/images/<?php echo $row['B_img1']; ?>" class="book-img">

<div class="book-body">

<h6><?php echo $row['B_name']; ?></h6>

<small><?php echo $row['B_writer']; ?></small>

<div class="text-success fw-bold">₹<?php echo $row['B_price']; ?></div>

<a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary w-100 mt-2">
View
</a>

</div>
</div>
</div>

<?php } ?>

</div>
</div>

<?php require('include/footer.inc.php'); ?>