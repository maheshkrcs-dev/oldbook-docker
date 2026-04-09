<?php
require('auth.php');
require('../include/connection.inc.php');

$result = mysqli_query($con, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Users</title>
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

<h2>👥 Users</h2>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Email</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>

<td>
<a href="delete_user.php?id=<?php echo $row['id']; ?>" 
class="btn btn-danger"
onclick="return confirm('Delete user?')">
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