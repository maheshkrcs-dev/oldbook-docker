<?php
require('include/header.inc.php');
require('include/connection.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location:auth.php");
    exit();
}

if(isset($_POST['checkout'])){

    $stmt = $con->prepare("SELECT * FROM cart WHERE user_id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $cart_res = $stmt->get_result();

    while($cart = $cart_res->fetch_assoc()){

        $book_id = $cart['book_id'];

        // get price
        $stmt2 = $con->prepare("SELECT B_price FROM bdata WHERE id=?");
        $stmt2->bind_param("i",$book_id);
        $stmt2->execute();
        $price_res = $stmt2->get_result();
        $price_row = $price_res->fetch_assoc();

        $price = $price_row['B_price'];

        // insert order
        $stmt3 = $con->prepare("INSERT INTO orders(user_id,book_id,price,order_date) VALUES(?,?,?,NOW())");
        $stmt3->bind_param("iid",$user_id,$book_id,$price);
        $stmt3->execute();
    }
    echo "<script>showToast('Order placed successfully 🎉')</script>";

    // clear cart
    $stmt = $con->prepare("DELETE FROM cart WHERE user_id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();

    header("Location: orders.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT bdata.* FROM cart 
JOIN bdata ON cart.book_id = bdata.id 
WHERE cart.user_id = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("i",$user_id);
$stmt->execute();
$res = $stmt->get_result();

$total = 0;
?>

<div class="container mt-5">

<h3 class="section-title mb-4">🛒 My Cart</h3>

<div class="row g-4">

<?php if($res->num_rows > 0){ 
while($row = $res->fetch_assoc()){ 
$total += $row['B_price'];
?>

<div class="col-lg-3 col-md-6">

<div class="book-card">

<div class="position-relative">
<img src="assets/images/<?php echo $row['B_img1']; ?>" class="book-img">
</div>

<div class="book-body">

<div class="book-title"><?php echo $row['B_name']; ?></div>

<div class="book-price">₹<?php echo $row['B_price']; ?></div>

<a href="action.php?type=remove_cart&id=<?php echo $row['id']; ?>" 
class="btn btn-danger btn-sm w-100 mb-2">
Remove
</a>

</div>

</div>

</div>

<?php } } else { ?>

<div class="text-center py-5">
<h5>Your cart is empty</h5>
</div>

<?php } ?>

</div>

<?php if($total > 0){ ?>

<div class="mt-4 text-end">
<h4>Total: ₹<?php echo $total; ?></h4>
<form method="post">
 <button name="checkout" class="btn btn-success">Checkout</button>
</form>
</div>

<?php } ?>

</div>

<?php require('include/footer.inc.php'); ?>