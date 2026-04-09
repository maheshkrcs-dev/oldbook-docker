<?php
require('include/header.inc.php');
require('include/connection.inc.php');
require('include/auth.inc.php');

$msg = "";

if(isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD']=="POST"){

    $stmt = $con->prepare("INSERT INTO bdata 
    (cat_id,user_id,B_name,B_img1,B_price,B_writer,B_pub,B_des,date,keyword,state,dist,pincode,seller_number,show_phone,status,`condition`)
    VALUES (?,?,?,?,?,?,?,?,NOW(),?,?,?,?,?,?,0,?)");

    $upload = uploadImage($_FILES['B_img1']);

    if(!$upload['status']){
        $msg = $upload['msg'];
    } else {

        $img = $upload['name'];

        $stmt->bind_param("iississssssssss",
            $_POST['cat'],
            $_SESSION['user_id'],
            $_POST['B_name'],
            $img,
            $_POST['B_price'],
            $_POST['B_writer'],
            $_POST['B_pub'],
            $_POST['B_des'],
            $_POST['B_key'],
            $_POST['state'],
            $_POST['dist'],
            $_POST['pin_code'],
            $_POST['s_mobile'],
            isset($_POST['on_number'])?'on':'off',
            $_POST['condition']
        );

        if($stmt->execute()){
            $_SESSION['toast'] = "Book posted successfully!";
            header("Location:index.php");
            exit();
        }else{
            $msg = "Error posting book";
        }
    }
}
?>

<div class="container mt-5">
<div class="card shadow-lg p-4 border-0">

<h3 class="mb-4 fw-bold">📚 Sell Your Book</h3>

<?php if($msg!=""){ ?>
<div class="alert alert-danger"><?php echo $msg; ?></div>
<?php } ?>

<form method="post" enctype="multipart/form-data" class="row g-3">

<input class="form-control" name="B_name" placeholder="Book Title" required>
<input class="form-control" name="B_writer" placeholder="Author" required>

<select name="cat" class="form-control" required>
<option value="">Select Category</option>
<?php
$res=mysqli_query($con,"SELECT * FROM categories");
while($row=mysqli_fetch_assoc($res)){
echo "<option value='".$row['id']."'>".$row['name']."</option>";
}
?>
</select>

<input class="form-control" name="B_pub" placeholder="Publisher">

<textarea class="form-control" name="B_des" placeholder="Description" required></textarea>

<input class="form-control" name="B_key" placeholder="Keywords">

<input class="form-control" name="B_price" type="number" placeholder="Price ₹" required>

<select name="condition" class="form-control" required>
<option value="">Condition</option>
<option>New</option>
<option>Like New</option>
<option>Good</option>
<option>Acceptable</option>
</select>

<input class="form-control" name="state" placeholder="State" required>
<input class="form-control" name="dist" placeholder="District" required>
<input class="form-control" name="pin_code" placeholder="Pincode" required>

<input class="form-control" name="s_mobile" placeholder="Mobile Number" required>

<div class="form-check">
<input type="checkbox" name="on_number" checked>
<label>Show phone number</label>
</div>

<input type="file" name="B_img1" class="form-control" required>

<button class="btn btn-success mt-3">🚀 Post Book</button>

</form>
</div>
</div>

<?php require('include/footer.inc.php'); ?>