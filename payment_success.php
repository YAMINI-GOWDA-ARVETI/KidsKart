<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Payment Successful</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f5f5f5;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.success-box{

width:500px;
background:white;
padding:40px;
text-align:center;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,.15);

}

.icon{

font-size:70px;
margin-bottom:20px;

}

h1{

color:#28a745;
margin-bottom:15px;

}

p{

font-size:18px;
margin:10px 0;
color:#555;

}

.btn{

display:inline-block;
margin-top:25px;
padding:12px 25px;
background:#ff4f81;
color:white;
text-decoration:none;
border-radius:8px;
font-size:18px;
margin-right:10px;

}

.btn:hover{

background:#e63d72;

}

</style>

</head>

<body>

<div class="success-box">

<div class="icon">
✅
</div>

<h1>Payment Successful</h1>

<p>Your order has been placed successfully.</p>

<p>Thank you for shopping with KidsKart.</p>

<a href="my_orders.php" class="btn">
My Orders
</a>

<a href="user_home.php" class="btn">
Continue Shopping
</a>

</div>

</body>
</html>