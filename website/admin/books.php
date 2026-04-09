<?php
require('auth.php');
require('../include/connection.inc.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';

$stmt = $con->prepare("SELECT * FROM bdata WHERE B_name LIKE ? ORDER BY B_id DESC");
$searchParam = "%$search%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Books</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-wrapper">

<div class="sidebar">
    <h3>Admin</h3>
    <a href="dashboard.php">Dashboard</a>
    <a href="books.php">Books</a>
    <a href="users.php">Users</a>
    <a href="logout.php">Logout</a>
</div>

<div class="content">

<h2>📚 Books</h2>

<form method="get">
    <input type="text" name="search" placeholder="Search..." class="form-control mb-2">
</form>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>
<td><?php echo $row['B_id']; ?></td>

<td>
<img src="../assets/images/<?php echo htmlspecialchars($row['B_img1']); ?>" width="60">
</td>

<td><?php echo htmlspecialchars($row['B_name']); ?></td>
<td>₹ <?php echo $row['B_price']; ?></td>

<td>
<a href="edit.php?id=<?php echo $row['B_id']; ?>" class="btn btn-warning">Edit</a>

<a href="delete.php?id=<?php echo $row['B_id']; ?>" 
class="btn btn-danger"
onclick="return confirm('Delete this book?')">
Delete
</a>
</td>

</tr>

<?php } ?>

</table>

</div>
</div>

</body>
</html>