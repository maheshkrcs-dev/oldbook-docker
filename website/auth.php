<?php
session_start();
require('include/connection.inc.php');

$msg = "";

/* ================= LOGIN ================= */
if(isset($_POST['login'])){

    $email = trim($_POST['login_email']);
    $password = trim($_POST['login_password']);

    if($email=="" || $password==""){
        $msg = "Please fill all fields";
    }else{

        $stmt = $con->prepare("SELECT id,name,password FROM login WHERE email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows > 0){
            $row = $res->fetch_assoc();

            if(password_verify($password,$row['password'])){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];

                header("Location:index.php");
                exit();
            }else{
                $msg = "Incorrect password";
            }

        }else{
            $msg = "User not found";
        }
    }
}

/* ================= REGISTER ================= */
if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);
    $cpass = trim($_POST['confirm_password']);

    if($name=="" || $email=="" || $pass==""){
        $msg = "All fields required";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg = "Invalid email format";
    }elseif(strlen($pass) < 6){
        $msg = "Password must be at least 6 characters";
    }elseif($pass !== $cpass){
        $msg = "Passwords do not match";
    }else{

        $stmt = $con->prepare("SELECT id FROM login WHERE email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows > 0){
            $msg = "Email already registered";
        }else{

            $hashed = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $con->prepare("INSERT INTO login(name,email,password) VALUES(?,?,?)");
            $stmt->bind_param("sss",$name,$email,$hashed);

            if($stmt->execute()){
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['user_name'] = $name;

                header("Location:index.php");
                exit();
            }else{
                $msg = "Registration failed";
            }
        }
    }
}

/* ================= FORGOT ================= */
if(isset($_POST['forgot'])){
    $msg = "Reset feature coming soon";
}
?>

<?php require('include/header.inc.php'); ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh;">

<div class="card shadow-lg p-4" style="width:400px; border-radius:12px;">

<h4 class="text-center mb-3 fw-bold">Account Access</h4>

<?php if($msg!=""){ ?>
<div class="alert alert-danger text-center">

<?php echo htmlspecialchars($msg); ?>

<?php if($msg=="User not found"){ ?>
<br>
<a href="#" onclick="showTab('register')" class="fw-bold text-primary">
👉 Register here
</a>
<?php } ?>

</div>
<?php } ?>

<!-- TABS -->
<ul class="nav nav-pills mb-3 justify-content-center">
<li class="nav-item">
<button class="nav-link active" onclick="showTab('login')">Login</button>
</li>
</ul>

<!-- LOGIN -->
<div id="loginTab" class="auth-tab">
<form method="post">

<input type="email" name="login_email" class="form-control mb-3" placeholder="📧 Email" required>

<input type="password" name="login_password" class="form-control mb-3" placeholder="🔒 Password" required>

<button name="login" class="btn btn-primary w-100">Login</button>

<div class="text-center mt-3">
<small>
New user? 
<a href="#" onclick="showTab('register')" class="fw-bold">Create account</a>
</small> </br>
<small>
    Forget Password?
    <a href="#" onclick="showTab('forget')" class="fw-bold">Reset Password</a>
</small>
</div>

</form>
</div>

<!-- REGISTER -->
<div id="registerTab" class="auth-tab d-none">
<form method="post">

<input type="text" name="name" class="form-control mb-3" placeholder="👤 Full Name" required>

<input type="email" name="email" class="form-control mb-3" placeholder="📧 Email" required>

<input type="password" name="password" class="form-control mb-3" placeholder="🔒 Password" required>

<input type="password" name="confirm_password" class="form-control mb-3" placeholder="🔒 Confirm Password" required>

<button name="register" class="btn btn-success w-100">Register</button>

</form>
</div>

<!-- FORGOT -->
<div id="forgotTab" class="auth-tab d-none">
<form method="post">

<input type="email" name="forgot_email" class="form-control mb-3" placeholder="📧 Enter your email" required>

<button name="forgot" class="btn btn-warning w-100">Reset Password</button>

</form>
</div>

</div>
</div>

<script>
function showTab(tab){

document.querySelectorAll('.auth-tab').forEach(el => el.classList.add('d-none'));
document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));

if(tab==='login'){
document.getElementById('loginTab').classList.remove('d-none');
document.querySelectorAll('.nav-link')[0].classList.add('active');
}

if(tab==='register'){
document.getElementById('registerTab').classList.remove('d-none');
document.querySelectorAll('.nav-link')[1].classList.add('active');
}

if(tab==='forgot'){
document.getElementById('forgotTab').classList.remove('d-none');
document.querySelectorAll('.nav-link')[2].classList.add('active');
}
}
</script>

<?php require('include/footer.inc.php'); ?>