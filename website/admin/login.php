<?php
session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){

    $user = $_POST['username'];
    $pass = $_POST['password'];

    if($user == 'admin' && $pass == 'admin123'){
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit();
    }
}
?>

<form method="post">
<input type="text" name="username" placeholder="Admin Username">
<input type="password" name="password" placeholder="Password">
<button>Login</button>
</form>