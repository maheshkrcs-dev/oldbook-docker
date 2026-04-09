<?php
session_start();
require('include/connection.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

/* ================= FETCH USER ================= */
$stmt = $con->prepare("SELECT * FROM login WHERE id=?");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

/* ================= UPDATE NAME ================= */
if(isset($_POST['update_name'])){
    $name = trim($_POST['name']);

    if($name==""){
        $msg = "Name cannot be empty";
    }else{
        $stmt = $con->prepare("UPDATE login SET name=? WHERE id=?");
        $stmt->bind_param("si",$name,$user_id);
        $stmt->execute();

        $_SESSION['user_name'] = $name;
        $msg = "Name updated successfully";
    }
}

/* ================= CHANGE PASSWORD ================= */
if(isset($_POST['change_password'])){
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if(!password_verify($current,$user['password'])){
        $msg = "Current password incorrect";
    }elseif($new !== $confirm){
        $msg = "Passwords do not match";
    }else{
        $hash = password_hash($new,PASSWORD_DEFAULT);

        $stmt = $con->prepare("UPDATE login SET password=? WHERE id=?");
        $stmt->bind_param("si",$hash,$user_id);
        $stmt->execute();

        $msg = "Password updated successfully";
    }
}

/* ================= PROFILE IMAGE ================= */
if(isset($_POST['upload_image'])){
    if(!empty($_FILES['image']['name'])){

        $file = $_FILES['image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if(in_array($ext,['jpg','jpeg','png'])){
            $file_name = "user_".$user_id."_".time().".".$ext;
            $path = "assets/profile/".$file_name;

            if(move_uploaded_file($file['tmp_name'],$path)){
                $stmt = $con->prepare("UPDATE login SET profile_image=? WHERE id=?");
                $stmt->bind_param("si",$file_name,$user_id);
                $stmt->execute();

                $msg = "Profile image updated";
            }else{
                $msg = "Upload failed";
            }
        }else{
            $msg = "Only JPG, PNG allowed";
        }
    }
}

/* ================= CHANGE EMAIL + OTP ================= */
if(isset($_POST['change_email'])){
    $email = trim($_POST['email']);

    if($email==""){
        $msg = "Email cannot be empty";
    }else{

        // generate OTP
        $otp = rand(100000,999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // save email + OTP
        $stmt = $con->prepare("UPDATE login SET email=?, otp=?, otp_expiry=?, is_verified=0 WHERE id=?");
        $stmt->bind_param("sssi",$email,$otp,$expiry,$user_id);
        $stmt->execute();

        // TEMP: show OTP (since mail() may not work)
        $_SESSION['otp_debug'] = $otp;

        header("Location: verify.php");
        exit();
    }
}
?>

<?php require('include/header.inc.php'); ?>

<div class="container mt-5">

<h3 class="mb-4">👤 My Profile</h3>

<?php if($msg!=""){ ?>
<div class="alert alert-info"><?php echo htmlspecialchars($msg); ?></div>
<?php } ?>

<div class="row">

<!-- LEFT SIDE -->
<div class="col-md-4">
<div class="profile-card p-3 text-center">

<?php if(!empty($user['profile_image'])){ ?>
<img src="assets/profile/<?php echo htmlspecialchars($user['profile_image']); ?>" class="rounded-circle mb-3" width="120">
<?php } else { ?>
<div style="width:120px;height:120px;background:#38bdf8;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:40px;margin:auto;">
<?php echo strtoupper(substr($user['name'],0,1)); ?>
</div>
<?php } ?>

<h5><?php echo htmlspecialchars($user['name']); ?></h5>
<p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>

<form method="post" enctype="multipart/form-data">
<input type="file" name="image" class="form-control mb-2">
<button name="upload_image" class="btn btn-primary w-100">Upload Image</button>
</form>

</div>
</div>

<!-- RIGHT SIDE -->
<div class="col-md-8">

<!-- NAME -->
<div class="form-card mb-4">
<h5>Update Name</h5>
<form method="post">
<input type="text" name="name" class="form-control mb-2"
value="<?php echo htmlspecialchars($user['name']); ?>">
<button name="update_name" class="btn btn-primary">Update</button>
</form>
</div>

<!-- EMAIL -->
<div class="form-card mb-4">
<h5>Change Email</h5>
<form method="post">
<input type="email" name="email" class="form-control mb-2"
value="<?php echo htmlspecialchars($user['email']); ?>">
<button name="change_email" class="btn btn-info">Send OTP</button>
</form>
</div>

<!-- PASSWORD -->
<div class="form-card mb-4">
<h5>Change Password</h5>
<form method="post">
<input type="password" name="current_password" class="form-control mb-2" placeholder="Current Password" required>
<input type="password" name="new_password" class="form-control mb-2" placeholder="New Password" required>
<input type="password" name="confirm_password" class="form-control mb-2" placeholder="Confirm Password" required>
<button name="change_password" class="btn btn-warning">Change Password</button>
</form>
</div>

</div>

</div>

</div>

<?php require('include/footer.inc.php'); ?>