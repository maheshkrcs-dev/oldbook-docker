<?php
require('include/header.inc.php');
require('include/connection.inc.php');
require('include/security.inc.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$q = "SELECT * FROM bdata WHERE B_id = $id";
$result = mysqli_query($con, $q);
$book = mysqli_fetch_assoc($result);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-5">
            <img src="<?php echo htmlspecialchars($book['B_img1']); ?>" class="img-fluid rounded" alt="Book Image">
        </div>
        <div class="col-lg-7">
            <h2><?php echo htmlspecialchars($book['B_name']); ?></h2>
            <h5 class="text-muted">by <?php echo htmlspecialchars($book['B_writer']); ?></h5>
            <h3 class="text-success">₹ <?php echo $book['B_price']; ?></h3>
            
            <p><strong>Publisher:</strong> <?php echo htmlspecialchars($book['B_pub'] ?? 'Not mentioned'); ?></p>
            <p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($book['B_des'])); ?></p>
            
            <p><strong>Seller Contact:</strong> <?php echo htmlspecialchars($book['seller_number']); ?></p>
            
            <a href="title.php" class="btn btn-primary">Back to All Books</a>
        </div>
    </div>
</div>

<?php require('include/footer.inc.php'); ?>