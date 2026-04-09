<?php
session_start();
require('include/connection.inc.php');
require('include/header.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location: auth.php");
    exit();
}

$book_id = (int)$_GET['id'];

// Fetch book with category + user
$stmt = $con->prepare("
    SELECT books.*, categories.name AS category_name, users.name AS seller_name
    FROM books
    JOIN categories ON books.category_id = categories.id
    JOIN users ON books.user_id = users.id
    WHERE books.id = ? AND books.status='active'
");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "<div class='container mt-5'><div class='alert alert-warning'>Book not found</div></div>";
    require('include/footer.inc.php');
    exit();
}

$book = $result->fetch_assoc();
?>

<div class="container mt-5">

<div class="row">

<!-- IMAGE -->
<div class="col-md-5">
    <img src="assets/images/<?php echo htmlspecialchars($book['image']); ?>" 
         class="img-fluid rounded shadow" style="width:100%; height:350px; object-fit:cover;">
</div>

<!-- DETAILS -->
<div class="col-md-7">

<h2><?php echo htmlspecialchars($book['name']); ?></h2>

<p class="text-muted">
    Author: <?php echo htmlspecialchars($book['author']); ?>
</p>

<p class="text-success h4">
    ₹<?php echo htmlspecialchars($book['price']); ?>
</p>

<p class="badge badge-info">
    <?php echo htmlspecialchars($book['category_name']); ?>
</p>

<hr>

<p><strong>Publisher:</strong> <?php echo htmlspecialchars($book['publisher']); ?></p>

<p><strong>Description:</strong><br>
<?php echo nl2br(htmlspecialchars($book['description'])); ?>
</p>

<p><strong>Keywords:</strong> <?php echo htmlspecialchars($book['keywords']); ?></p>

<hr>

<p><strong>Location:</strong> 
<?php echo htmlspecialchars($book['district']); ?>, 
<?php echo htmlspecialchars($book['state']); ?> - 
<?php echo htmlspecialchars($book['pincode']); ?>
</p>

<p><strong>Seller:</strong> <?php echo htmlspecialchars($book['seller_name']); ?></p>

<?php if($book['show_phone'] == 'on'){ ?>
    <p><strong>Phone:</strong> 
        <a href="tel:<?php echo htmlspecialchars($book['seller_phone']); ?>">
            <?php echo htmlspecialchars($book['seller_phone']); ?>
        </a>
    </p>
<?php } else { ?>
    <p class="text-muted">Phone number hidden</p>
<?php } ?>

</div>

</div>

</div>

<?php require('include/footer.inc.php'); ?>