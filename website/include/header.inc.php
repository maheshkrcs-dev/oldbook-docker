<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require('connection.inc.php');

// Update last seen
if(isset($_SESSION['user_id'])){
    $stmt = $con->prepare("UPDATE users SET last_seen=NOW() WHERE id=?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>OldBook Exchange</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- TOAST -->
<?php if(isset($_SESSION['toast'])){ ?>
<div id="toast">
    <?php 
    echo htmlspecialchars($_SESSION['toast']); 
    unset($_SESSION['toast']);
    ?>
</div>
<script>
setTimeout(()=>document.getElementById("toast")?.remove(),2500);
</script>
<?php } ?>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom">
<div class="container d-flex align-items-center justify-content-between">

<!-- LOGO -->
<a class="logo text-decoration-none" href="index.php">
📚 OldBook
</a>

<!-- SEARCH -->
<form method="GET" action="search.php" class="search-box d-flex">
    <input type="text" name="search" class="form-control search-input"
        placeholder="Search books..."
        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button class="search-btn">Search</button>
</form>

<!-- RIGHT -->
<div class="d-flex align-items-center gap-2">

<?php if(isset($_SESSION['user_id'])){ ?>

<a href="sell.php" class="btn btn-sm btn-light">Sell</a>

<a href="wishlist.php" class="btn btn-sm btn-outline-light">
    <i class="bi bi-heart"></i>
</a>

<a href="cart.php" class="btn btn-sm btn-outline-light">
    <i class="bi bi-cart"></i>
</a>

<a href="inbox.php" class="btn btn-sm btn-outline-light">
    <i class="bi bi-chat-dots"></i>
</a>

<!-- PROFILE -->
<div class="dropdown">
<button class="btn btn-outline-light d-flex align-items-center gap-2" data-bs-toggle="dropdown">
    <div class="avatar">
        <?php echo strtoupper(substr($_SESSION['user_name'],0,1)); ?>
    </div>
    <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
</button>

<ul class="dropdown-menu dropdown-menu-end shadow">
    <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
    <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
    <li><a class="dropdown-item" href="orders.php">My Orders</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
</ul>
</div>

<?php } else { ?>

<a href="auth.php" class="btn btn-light">Login</a>

<?php } ?>

</div>
</div>
</nav>