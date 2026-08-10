<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Latest Order */

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id']))
{
    die("Invalid Order");
}

$order_id = (int)$_GET['id'];

$order = mysqli_query($conn,

"SELECT *

FROM orders

WHERE id='$order_id'

AND user_id='$user_id'");

$data = mysqli_fetch_assoc($order);

if(!$data)
{
    die("Order Not Found");
}

/* User Details */

$user = mysqli_query($conn,

"SELECT firstname,lastname,email
FROM users
WHERE id='$user_id'");

$userData = mysqli_fetch_assoc($user);
?>
<!DOCTYPE html>
<html>

<head>

<title>Invoice</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f2f2f2;
padding:40px;
}

.invoice{

max-width:850px;
margin:auto;
background:white;
padding:35px;
border-radius:12px;
box-shadow:0 5px 20px rgba(0,0,0,.15);

}

.header{

display:flex;
justify-content:space-between;
align-items:center;
border-bottom:2px solid #ddd;
padding-bottom:20px;
margin-bottom:25px;

}

.logo{

font-size:30px;
font-weight:bold;
color:#ff4f81;

}

table{

width:100%;
border-collapse:collapse;
margin-top:20px;

}

table th{

background:#ff4f81;
color:white;
padding:12px;

}

table td{

padding:12px;
border-bottom:1px solid #ddd;
text-align:center;

}

.info{

margin:20px 0;

}

.total{

text-align:right;
font-size:22px;
font-weight:bold;
margin-top:25px;

}

.btn{

margin-top:30px;
padding:12px 25px;
background:#ff4f81;
color:white;
border:none;
cursor:pointer;
border-radius:8px;
font-size:16px;

}

.btn:hover{

background:#e63d72;

}

</style>

</head>

<body>

<div class="invoice">

<div class="header">

<div class="logo">

🧸 KidsKart

</div>

<div>

<h2>INVOICE</h2>

<p>Invoice #: INV<?php echo $data['id']; ?></p>

</div>

</div>
<div class="info">

<h3>Customer Details</h3>

<p>
<strong>Name:</strong>

<?php
echo $userData['firstname']." ".$userData['lastname'];
?>

</p>

<p>

<strong>Email:</strong>

<?php echo $userData['email']; ?>

</p>

<p>

<strong>Address:</strong>

<?php echo $data['address']; ?>

</p>

<p>

<strong>Payment:</strong>

<?php echo $data['payment_method']; ?>

</p>

<p>

<strong>Order Date:</strong>

<?php echo $data['order_date']; ?>

</p>

</div>
<table>

<tr>

<th>Product</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>

</tr>

<tr>

<td><?php echo $data['product_name']; ?></td>

<td><?php echo $data['quantity']; ?></td>

<td>₹<?php echo $data['price']; ?></td>

<td>₹<?php echo $data['total']; ?></td>

</tr>

</table>

<div class="total">

Grand Total : ₹<?php echo $data['total']; ?>

</div>
<button
class="btn"
onclick="window.print()">

🖨 Print Invoice

</button>

</div>

</body>

</html>