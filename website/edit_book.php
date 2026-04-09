<?php
require('include/header.inc.php');
require('include/connection.inc.php');
require('include/helper.inc.php');

if(!isset($_SESSION['user_id'])){
    header("Location:auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id'])){
    header("Location:dashboard.php");
    exit();
}

$id = intval($_GET['id']);

/* FETCH BOOK */
$stmt = $con->prepare("SELECT * FROM bdata WHERE id=? AND user_id=?");
$stmt->bind_param("ii",$id,$user_id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows == 0){
    header("Location:dashboard.php");
    exit();
}

$row = $res->fetch_assoc();

/* UPDATE */
if($_SERVER['REQUEST_METHOD']=='POST'){

    $B_name   = $_POST['B_name'];
    $B_writer = $_POST['B_writer'];
    $B_price  = $_POST['B_price'];
    $B_pub    = $_POST['B_pub'];
    $B_des    = $_POST['B_des'];
    $B_key    = $_POST['B_key'];
    $cat_id   = $_POST['cat'];
    $state    = $_POST['state'];
    $dist     = $_POST['dist'];
    $pin_code = $_POST['pin_code'];
    $phone    = $_POST['s_mobile'];
    $show_phone = isset($_POST['on_number']) ? 'on' : 'off';

    $image = $row['B_img1']; // default = old image

    /* ================= IMAGE HANDLING ================= */
    if(!empty($_FILES['B_img1']['name'])){

        // check if same file name (prevent duplicate upload)
        if($_FILES['B_img1']['name'] != $row['B_img1']){

            $upload = uploadImage($_FILES['B_img1']);

            if(!$upload['status']){
                die($upload['msg']);
            }

            $new_image = $upload['name'];

            // DELETE OLD IMAGE
            $old_path = "assets/images/" . $row['B_img1'];
            if(file_exists($old_path)){
                unlink($old_path);
            }

            $image = $new_image;
        }
    }

    /* ================= UPDATE ================= */
    $stmt = $con->prepare("UPDATE bdata SET 
        cat_id=?, B_name=?, B_writer=?, B_price=?, B_pub=?, B_des=?, keyword=?, state=?, dist=?, pincode=?, seller_number=?, show_phone=?, B_img1=? 
        WHERE id=? AND user_id=?");

    $stmt->bind_param("ississsssssssii",
        $cat_id,
        $B_name,
        $B_writer,
        $B_price,
        $B_pub,
        $B_des,
        $B_key,
        $state,
        $dist,
        $pin_code,
        $phone,
        $show_phone,
        $image,
        $id,
        $user_id
    );

    $stmt->execute();

    header("Location:dashboard.php");
    exit();
}
?>

<div class="container mt-5">

<h3>Edit Book</h3>

<form method="post" enctype="multipart/form-data">

<!-- IMAGE PREVIEW -->
<div class="mb-3">
<img src="assets/images/<?php echo htmlspecialchars($row['B_img1']); ?>" 
style="width:150px;height:200px;object-fit:cover;border-radius:8px;">
</div>

<input type="text" name="B_name" class="form-control mb-2"
value="<?php echo htmlspecialchars($row['B_name']); ?>" placeholder="Book Name">

<input type="text" name="B_writer" class="form-control mb-2"
value="<?php echo htmlspecialchars($row['B_writer']); ?>" placeholder="Author">

<input type="number" name="B_price" class="form-control mb-2"
value="<?php echo htmlspecialchars($row['B_price']); ?>" placeholder="Price">

<input type="text" name="B_pub" class="form-control mb-2"
value="<?php echo htmlspecialchars($row['B_pub']); ?>" placeholder="Publisher">

<textarea name="B_des" class="form-control mb-2"
placeholder="Description"><?php echo htmlspecialchars($row['B_des']); ?></textarea>

<input type="text" name="B_key" class="form-control mb-2"
value="<?php echo htmlspecialchars($row['keyword']); ?>" placeholder="Keywords">

<select name="cat" class="form-control mb-2">
<option value="1" <?php if($row['cat_id']==1) echo "selected"; ?>>Programming</option>
<option value="2" <?php if($row['cat_id']==2) echo "selected"; ?>>Engineering</option>
<option value="3" <?php if($row['cat_id']==3) echo "selected"; ?>>Fiction</option>
</select>

<input type="text" name="state" class="form-control mb-2"
value="<?php echo htmlspecialchars($row['state']); ?>" placeholder="State">

<input type="text" name="dist" class="form-control mb-2"
value="<?php echo htmlspecialchars($row['dist']); ?>" placeholder="District">

<input type="text" name="pin_code" class="form-control mb-2"
value="<?php echo htmlspecialchars($row['pincode']); ?>" placeholder="Pincode">

<input type="file" name="B_img1" class="form-control mb-2">

<input type="text" name="s_mobile" class="form-control mb-2"
value="<?php echo htmlspecialchars($row['seller_number']); ?>" placeholder="Mobile Number">

<div class="form-check mb-2">
<input type="checkbox" name="on_number" class="form-check-input"
<?php if($row['show_phone']=='on') echo "checked"; ?>>
<label class="form-check-label">Show phone number</label>
</div>

<button class="btn btn-success">Update</button>

</form>

</div>

<?php require('include/footer.inc.php'); ?>