<?php
session_start();
require('include/header.inc.php');
require('include/connection.inc.php');
require('include/security.inc.php');

if (!isset($_SESSION['u_email'])) {
    header("Location: auth.php");
    exit();
}

$email = $_SESSION['u_email'];
$q = "SELECT * FROM login WHERE email = '$email'";
$result = mysqli_query($con, $q);
$user = mysqli_fetch_assoc($result);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white text-center">
                    <h4>My Account</h4>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($user['mobile']); ?></p>
                    
                    <hr>
                    <a href="edit_profile.php" class="btn btn-warning">Edit Profile</a>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('include/footer.inc.php'); ?>