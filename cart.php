<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn,"SELECT * FROM cart WHERE user_id='$user_id'");

$grand_total = 0;
?>

<!DOCTYPE html>
<html>
<head>

<title>My Cart</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f8f8f8;
}

h1{
    text-align:center;
    margin-bottom:25px;
    font-size:34px;
}

/* Product Cards */

.cart-container{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:20px;
}

.cart-box{
    width:250px;
    background:#fff;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.12);
    padding:15px;
    text-align:center;
    transition:.3s;
}

.cart-box:hover{
    transform:translateY(-4px);
}

.cart-box img{
    width:100%;
    height:150px;
    object-fit:cover;
    border-radius:10px;
}

.cart-box h2{
    margin:10px 0;
    font-size:22px;
    color:#333;
}

.price{
    font-size:18px;
    margin:8px 0;
}

/* Quantity */

.quantity{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:12px;
    margin:15px 0;
}

.qty-btn{
    width:32px;
    height:32px;
    border:none;
    border-radius:50%;
    background:#ff4f81;
    color:#fff;
    font-size:18px;
    cursor:pointer;
}

.qty-btn:hover{
    background:#ff2f6d;
}

.qty{
    font-size:18px;
    font-weight:bold;
    min-width:20px;
}

/* Subtotal */

.subtotal{
    font-size:18px;
    margin-bottom:15px;
}

.subtotal span{
    color:#ff4f81;
    font-weight:bold;
}

/* Remove Button */

.remove-btn{
    background:#ff4f81;
    color:#fff;
    border:none;
    padding:8px 18px;
    border-radius:20px;
    cursor:pointer;
    font-size:15px;
}

.remove-btn:hover{
    background:#ff2f6d;
}

/* Grand Total */

.total{
    margin-top:35px;
    border-top:1px solid #ddd;
    padding-top:20px;
    text-align:center;
}

.total h2{
    font-size:30px;
    color:#ff4f81;
}

/* Bottom Buttons */

.bottom-buttons{
    margin-top:20px;
    margin-bottom:20px;
    display:flex;
    justify-content:center;
    gap:15px;
}

.bottom-buttons button{
    border:none;
    background:#ff4f81;
    color:#fff;
    padding:10px 20px;
    border-radius:25px;
    cursor:pointer;
    font-size:16px;
}

.bottom-buttons button:hover{
    background:#ff2f6d;
}
.empty{
    text-align:center;
    font-size:28px;
    color:#777;
    margin-top:80px;
}

</style>

</head>

<body>
<?php include "navbar.php"; ?>
<h1>🛒 My Cart</h1>

<div class="cart-container">

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

$subtotal = $row['price'] * $row['quantity'];
$grand_total += $subtotal;

?>

<div class="cart-box">

<img src="uploads/<?php echo $row['image']; ?>">

<h2><?php echo $row['product_name']; ?></h2>

<p class="price">
Price : ₹<?php echo $row['price']; ?>
</p>

<div class="quantity">

<a href="update_cart.php?id=<?php echo $row['id']; ?>&action=minus">
<button class="qty-btn">−</button>
</a>

<span class="qty">
<?php echo $row['quantity']; ?>
</span>

<a href="update_cart.php?id=<?php echo $row['id']; ?>&action=plus">
<button class="qty-btn">+</button>
</a>

</div>

<p class="subtotal">
Subtotal :
<span>₹<?php echo $subtotal; ?></span>
</p>

<form action="remove_cart.php" method="POST"
onsubmit="return confirm('Are you sure you want to remove this item from your cart?');">

<input type="hidden" name="id"
value="<?php echo $row['id']; ?>">

<button type="submit" class="remove-btn">
🗑 Remove
</button>

</form>

</div>

<?php

}

}
else
{

echo "<div class='empty'>Your Cart is Empty</div>";

}

?>

</div>

<?php

if($grand_total>0)
{

?>

<div class="total">

<h2>
Grand Total : ₹<?php echo $grand_total; ?>
</h2>

<div class="bottom-buttons">

<a href="user_home.php">
<button>
⬅ Continue Shopping
</button>
</a>

<a href="checkout.php">
<button>
🛒 Proceed to Checkout
</button>
</a>

</div>

</div>

<?php
}
?>

</body>
</html>