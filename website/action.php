<?php
require('include/connection.inc.php');
session_start();

if(!isset($_SESSION['user_id'])){
    die("login_required");
}

$user_id = $_SESSION['user_id'];

/* ===== GET REFERRER (IMPORTANT) ===== */
$redirect_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

if(isset($_GET['type']) && isset($_GET['id'])){

    $book_id = intval($_GET['id']);

    // ================= LIKE =================
    if($_GET['type'] == 'like'){

        $stmt = $con->prepare("SELECT id FROM wishlist WHERE user_id=? AND book_id=?");
        $stmt->bind_param("ii",$user_id,$book_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows > 0){
            $stmt = $con->prepare("DELETE FROM wishlist WHERE user_id=? AND book_id=?");
            $stmt->bind_param("ii",$user_id,$book_id);
            $stmt->execute();

            $_SESSION['toast'] = "💔 Removed from wishlist";
        } else {
            $stmt = $con->prepare("INSERT INTO wishlist(user_id,book_id) VALUES(?,?)");
            $stmt->bind_param("ii",$user_id,$book_id);
            $stmt->execute();

            $_SESSION['toast'] = "❤️ Added to wishlist";
        }
    }

    // ================= CART =================
    if($_GET['type'] == 'cart'){

        $stmt = $con->prepare("SELECT id FROM cart WHERE user_id=? AND book_id=?");
        $stmt->bind_param("ii",$user_id,$book_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows == 0){
            $stmt = $con->prepare("INSERT INTO cart(user_id,book_id) VALUES(?,?)");
            $stmt->bind_param("ii",$user_id,$book_id);
            $stmt->execute();

            $_SESSION['toast'] = "🛒 Book added to cart!";
        } else {
            $_SESSION['toast'] = "⚠ Already in cart";
        }
    }

    // ================= REMOVE CART =================
    if($_GET['type'] == 'remove_cart'){
        $stmt = $con->prepare("DELETE FROM cart WHERE user_id=? AND book_id=?");
        $stmt->bind_param("ii",$user_id,$book_id);
        $stmt->execute();

        $_SESSION['toast'] = "❌ Removed from cart";
    }

    /* ===== REDIRECT BACK ===== */
    header("Location: " . $redirect_page);
    exit();
}
?>