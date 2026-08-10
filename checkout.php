<?php
session_start();
include "db.php";
include "navbar.php";
if(!isset($_SESSION['user_id']))
{
    header("Location:login.html");
    exit();
}

$user_id=$_SESSION['user_id'];

$user=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM users WHERE id='$user_id'"));

$cart=mysqli_query($conn,
"SELECT * FROM cart WHERE user_id='$user_id'");

$total=0;
?>

<!DOCTYPE html>
<html>
<head>

<title>Checkout</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{

background:
linear-gradient(rgba(255,255,255,.85),rgba(255,255,255,.85)),
url("https://images.unsplash.com/photo-1516627145497-ae6968895b74?w=1600");

background-size:cover;
background-attachment:fixed;

}

.container{

width:90%;
margin:30px auto;

}

.card{

background:white;
padding:25px;
border-radius:20px;
box-shadow:0 10px 20px rgba(0,0,0,.2);

}

h2{

color:#ff4f81;
margin-bottom:20px;

}

table{

width:100%;
border-collapse:collapse;
margin-top:20px;

}

th{

background:#ff6fa5;
color:white;
padding:12px;

}

td{

padding:12px;
text-align:center;
border-bottom:1px solid #ddd;

}

img{

width:70px;
height:70px;
border-radius:10px;

}

.address{

margin:20px 0;

}

textarea{

width:100%;
height:100px;
padding:12px;
border-radius:10px;
border:1px solid #ccc;
resize:none;

}

select{

width:100%;
padding:12px;
margin-top:15px;
border-radius:10px;
border:1px solid #ccc;

}

button{

width:100%;
padding:15px;
margin-top:20px;
background:#ff6fa5;
color:white;
border:none;
border-radius:10px;
font-size:18px;
cursor:pointer;

}

button:hover{

background:#ff4f81;

}

.total{

text-align:right;
font-size:22px;
font-weight:bold;
color:#ff4f81;
margin-top:20px;

}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h2>🛒 Checkout</h2>

<form action="payment.php" method="POST">

<table>

<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($cart))
{

$sub=$row['price']*$row['quantity'];

$total+=$sub;

?>

<tr>

<td>

<img src="uploads/<?php echo $row['image']; ?>">

</td>

<td>

<?php echo $row['product_name']; ?>

</td>

<td>

₹<?php echo $row['price']; ?>

</td>

<td>

<?php echo $row['quantity']; ?>

</td>

<td>

₹<?php echo $sub; ?>

</td>

</tr>

<?php
}
?>

</table>

<div class="total">

Grand Total :
₹<?php echo $total; ?>

</div>

<div class="address">

<h3>Delivery Address</h3>

<textarea
name="address"
required><?php echo $user['address']; ?></textarea>

</div>

<h3>Payment Method</h3>

<select name="payment_method">

<option>

Cash On Delivery

</option>

</select>

<button name="place_order">

✅ Place Order

</button>

</form>

</div>

</div>

</body>
</html>