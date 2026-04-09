<?php
session_start();
require('include/connection.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

if(isset($_POST['verify'])){
    $otp = $_POST['otp'];

    $stmt = $con->prepare("SELECT otp, otp_expiry FROM login WHERE id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if($otp == $res['otp']){
        
        if(strtotime($res['otp_expiry']) > time()){

            $stmt = $con->prepare("UPDATE login SET is_verified=1, otp=NULL WHERE id=?");
            $stmt->bind_param("i",$user_id);
            $stmt->execute();

            $msg = "Email verified successfully";
        }else{
            $msg = "OTP expired";
        }

    }else{
        $msg = "Invalid OTP";
    }
}
?>

<?php require('include/header.inc.php'); ?>

<div class="container mt-5">

<div class="card p-4 shadow mx-auto" style="max-width:400px;">

<h4 class="mb-3 text-center">🔐 Verify Email</h4>

<?php if($msg!=""){ ?>
<div class="alert alert-info"><?php echo $msg; ?></div>
<?php } ?>

<form method="post">

<input type="text" name="otp" class="form-control mb-3" placeholder="Enter OTP" required>

<button name="verify" class="btn btn-primary w-100">
Verify
</button>

</form>

</div>

</div>

<?php require('include/footer.inc.php'); ?>