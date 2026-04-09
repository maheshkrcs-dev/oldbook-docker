<?php
require('../include/connection.inc.php');
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM bdata ORDER BY id DESC";
$res = mysqli_query($con,$sql);
?>

<link rel="stylesheet" href="admin.css">

<h2>📊 Admin Panel</h2>

<table border="1" cellpadding="10">

<tr>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($res)){ ?>

<tr>

<td>
<img src="../assets/images/<?php echo $row['B_img1']; ?>" width="80">
</td>

<td><?php echo $row['B_name']; ?></td>

<td>
<?php if($row['status']==3){ ?>
<span class="status price">Price</span>
<?php } ?>

<td>
<?php if($row['status']==0){ ?>
<span class="status pending">Pending</span>
<?php } ?>

<?php if($row['status']==1){ ?>
<span class="status approved">Approved</span>
<?php } ?>

<?php if($row['status']==2){ ?>
<span class="status rejected">Rejected</span>
<?php } ?>
</td>

<td>

<a href="action.php?type=approve&id=<?php echo $row['id']; ?>" 
class="action-btn approve-btn">Approve</a>

<a href="action.php?type=reject&id=<?php echo $row['id']; ?>" 
class="action-btn reject-btn">Reject</a>


</td>

</tr>

<?php } ?>

</table>