<?php
session_start();
require('include/header.inc.php');
require('include/connection.inc.php');
require('include/security.inc.php');

if (!isset($_SESSION['u_email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['u_email'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape($con, $_POST['name']);
    $mobile = escape($con, $_POST['mobile']);

    $sql = "UPDATE login SET name='$name', mobile='$mobile' WHERE email='$email'";
    if (mysqli_query($con, $sql)) {
        $msg = "Profile updated successfully!";
    } else {
        $msg = "Error updating profile.";
    }
}

$q = "SELECT * FROM login WHERE email = '$email'";
$result = mysqli_query($con, $q);
$user = mysqli_fetch_assoc($result);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-center">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <?php if($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>
                    <form method="post">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="tel" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('include/footer.inc.php'); ?>