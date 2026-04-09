<?php
require('include/header.inc.php');
require('include/connection.inc.php');
require('include/security.inc.php');

$cat_id = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
?>

<div class="container mt-5">
    <h3 class="text-center mb-4">Books in this Category</h3>
    <div class="row">
        <?php
        $q = "SELECT * FROM bdata WHERE cat_id = $cat_id ORDER BY B_id DESC";
        $result = mysqli_query($con, $q);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <img src="<?php echo htmlspecialchars($row['B_img1']); ?>" class="card-img-top" height="200" style="object-fit: cover;">
                    <div class="card-body">
                        <h5><?php echo htmlspecialchars($row['B_name']); ?></h5>
                        <p class="text-muted">by <?php echo htmlspecialchars($row['B_writer'] ?? 'Unknown'); ?></p>
                        <h6 class="text-success">₹ <?php echo $row['B_price']; ?></h6>
                    </div>
                    <div class="card-footer">
                        <a href="details.php?id=<?php echo $row['B_id']; ?>" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
            echo "<p class='col-12 text-center'>No books found in this category.</p>";
        }
        ?>
    </div>
</div>

<?php require('include/footer.inc.php'); ?>