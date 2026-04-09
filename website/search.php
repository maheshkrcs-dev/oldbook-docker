<?php
require('include/header.inc.php');
require('include/connection.inc.php');

/* FILTER VALUES */
$search = isset($_GET['search']) ? $_GET['search'] : '';
$cat    = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
$min    = isset($_GET['min']) ? intval($_GET['min']) : 0;
$max    = isset($_GET['max']) ? intval($_GET['max']) : 0;
$state  = isset($_GET['state']) ? $_GET['state'] : '';

/* BASE QUERY */
$sql = "SELECT * FROM bdata WHERE status=1";
$params = [];
$types  = "";

/* SEARCH */
if(!empty($search)){
    $sql .= " AND (B_name LIKE ? OR B_writer LIKE ?)";
    $searchTerm = "%".$search."%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "ss";
}

/* CATEGORY */
if($cat > 0){
    $sql .= " AND cat_id=?";
    $params[] = $cat;
    $types .= "i";
}

/* PRICE */
if($min > 0){
    $sql .= " AND B_price >= ?";
    $params[] = $min;
    $types .= "i";
}

if($max > 0){
    $sql .= " AND B_price <= ?";
    $params[] = $max;
    $types .= "i";
}

/* LOCATION */
if(!empty($state)){
    $sql .= " AND state LIKE ?";
    $params[] = "%".$state."%";
    $types .= "s";
}

/* ORDER */
$sql .= " ORDER BY id DESC";

/* PREPARE */
$stmt = $con->prepare($sql);

if(!empty($params)){
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$res = $stmt->get_result();
?>

<div class="container mt-5">

<h3 class="section-title mb-4">🔍 Search Results</h3>

<!-- 🔥 FILTER FORM -->
<form method="GET" class="row g-2 mb-4">

<div class="col-md-3">
<input type="text" name="search" class="form-control" placeholder="Search"
value="<?php echo htmlspecialchars($search); ?>">
</div>

<div class="col-md-2">
<select name="cat" class="form-control">
<option value="0">Category</option>
<option value="1" <?php if($cat==1) echo "selected"; ?>>Programming</option>
<option value="2" <?php if($cat==2) echo "selected"; ?>>Engineering</option>
<option value="3" <?php if($cat==3) echo "selected"; ?>>Fiction</option>
</select>
</div>

<div class="col-md-2">
<input type="number" name="min" class="form-control" placeholder="Min ₹"
value="<?php echo $min; ?>">
</div>

<div class="col-md-2">
<input type="number" name="max" class="form-control" placeholder="Max ₹"
value="<?php echo $max; ?>">
</div>

<div class="col-md-2">
<input type="text" name="state" class="form-control" placeholder="State"
value="<?php echo htmlspecialchars($state); ?>">
</div>

<div class="col-md-1">
<button class="btn btn-primary w-100">Go</button>
</div>

</form>

<!-- 🔥 RESULTS -->
<div class="row g-4">

<?php if($res->num_rows > 0){
while($row = $res->fetch_assoc()){ ?>

<div class="col-lg-3 col-md-6">

<div class="book-card">

<div class="position-relative">

<img src="assets/images/<?php echo htmlspecialchars($row['B_img1']); ?>" class="book-img">

<div class="badge bg-success position-absolute" style="top:10px;left:10px;">
₹<?php echo htmlspecialchars($row['B_price']); ?>
</div>

</div>

<div class="book-body">

<div class="book-title"><?php echo htmlspecialchars($row['B_name']); ?></div>

<div class="small text-muted">✍ <?php echo htmlspecialchars($row['B_writer']); ?></div>

<div class="small text-muted">📍 <?php echo htmlspecialchars($row['state']); ?></div>

<a href="view.php?id=<?php echo $row['id']; ?>" 
class="btn btn-outline-primary btn-sm w-100 mt-2">
View Details
</a>

</div>

</div>

</div>

<?php } } else { ?>

<div class="text-center py-5">
<h5>No results found</h5>
</div>

<?php } ?>

</div>

</div>

<?php require('include/footer.inc.php'); ?>