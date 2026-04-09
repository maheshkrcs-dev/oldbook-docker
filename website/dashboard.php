<?php
require('include/header.inc.php');
require('include/connection.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location:auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* DELETE */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    $stmt = $con->prepare("SELECT B_img1 FROM bdata WHERE id=? AND user_id=?");
    $stmt->bind_param("ii",$id,$user_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows > 0){
        $row = $res->fetch_assoc();

        $path = "assets/images/".$row['B_img1'];
        if(file_exists($path)){
            unlink($path);
        }

        $stmt = $con->prepare("DELETE FROM bdata WHERE id=? AND user_id=?");
        $stmt->bind_param("ii",$id,$user_id);
        $stmt->execute();
    }

    header("Location:dashboard.php");
    exit();
}

/* FETCH */
$stmt = $con->prepare("SELECT * FROM bdata WHERE user_id=? ORDER BY id DESC");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="container mt-5">

<h3 class="section-title mb-4">📊 My Books</h3>

<div class="row g-4">

<?php while($row = $res->fetch_assoc()){ ?>

<div class="col-lg-3 col-md-6">

<div class="book-card">

<div class="position-relative">

<img src="assets/images/<?php echo htmlspecialchars($row['B_img1']); ?>" class="book-img">

<div class="badge bg-success position-absolute" style="top:10px;left:10px;">
₹<?php echo htmlspecialchars($row['B_price']); ?>
</div>

</div>

<div class="book-body">

<div class="book-title">
<?php echo htmlspecialchars($row['B_name']); ?>
</div>

<div class="d-flex justify-content-between mt-2">

<a href="edit_book.php?id=<?php echo $row['id']; ?>" 
class="btn btn-warning btn-sm">Edit</a>

<a href="dashboard.php?delete=<?php echo $row['id']; ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this book?')">Delete</a>

</div>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

<?php require('include/footer.inc.php'); ?>