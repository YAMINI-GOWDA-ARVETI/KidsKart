<?php

if(session_status()==PHP_SESSION_NONE)
{
    session_start();
}

include "db.php";

$user_id=$_SESSION['user_id'];

// Cart Count
$cart=mysqli_query($conn,"SELECT id FROM cart WHERE user_id='$user_id'");
$cartCount=mysqli_num_rows($cart);

// Wishlist Count
$wish=mysqli_query($conn,"SELECT id FROM wishlist WHERE user_id='$user_id'");
$wishCount=mysqli_num_rows($wish);

?>

<style>

.navbar{
    background:#ff5c93;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 35px;
    position:sticky;
    top:0;
    z-index:999;
    box-shadow:0 3px 10px rgba(0,0,0,.15);
    margin-bottom:20px;
}

.logo{
    color:white;
    font-size:28px;
    font-weight:bold;
}

.nav-links{
    display:flex;
    align-items:center;
    gap:20px;
}

.nav-links a{
    color:white;
    text-decoration:none;
    font-size:17px;
    font-weight:bold;
}

.nav-links a:hover{
    color:#ffe6ef;
}

.count{
    background:white;
    color:#ff5c93;
    padding:2px 8px;
    border-radius:50px;
    font-size:13px;
    margin-left:4px;
}

.logout{
    background:#ff2d55;
    padding:10px 16px;
    border-radius:8px;
}

.search-box{
    width:300px;
    padding:10px 15px;
    border:none;
    border-radius:25px;
    outline:none;
    font-size:15px;
}

</style>

<div class="navbar">

<div class="logo">
🧸 BabyBloom
</div>



<div class="nav-links">

<a href="user_home.php">
🏠 Home
</a>

<a href="wishlist.php">
❤️ Wishlist
<span class="count">
<?php echo $wishCount; ?>
</span>
</a>

<a href="cart.php">
🛒 Cart
<span class="count">
<?php echo $cartCount; ?>
</span>
</a>

<a href="my_orders.php">
📦 Orders
</a>

<a href="profile.php">
👤 Profile
</a>

<a href="logout.php" class="logout">
Logout
</a>

</div>

</div>