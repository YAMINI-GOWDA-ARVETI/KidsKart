<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}

if(!isset($_POST['address']))
{
    header("Location: checkout.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$address = mysqli_real_escape_string($conn,$_POST['address']);

$cart = mysqli_query($conn,
"SELECT * FROM cart WHERE user_id='$user_id'");

$grandTotal = 0;
?>
<!DOCTYPE html>
<html>
<head>

<title>Payment</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f7f7f7;
}

.container{

width:90%;
max-width:900px;
margin:40px auto;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,.1);

}

h2{

text-align:center;
color:#ff4f81;
margin-bottom:25px;

}

table{

width:100%;
border-collapse:collapse;
margin-bottom:25px;

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

.payment-box{

margin-top:20px;

}

.payment-box label{

display:block;
margin:12px 0;
font-size:18px;

}

button{

width:100%;
padding:15px;
background:#ff4f81;
color:white;
border:none;
border-radius:10px;
font-size:18px;
cursor:pointer;

}

button:hover{

background:#e63d72;

}

.total{

text-align:right;
font-size:22px;
font-weight:bold;
margin-bottom:25px;

}

</style>

</head>

<body>

<div class="container">

<h2>Payment</h2>

<form action="place_order.php" method="POST">

<input type="hidden" name="address"
value="<?php echo htmlspecialchars($address); ?>">

<table>

<tr>

<th>Product</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>

</tr>
<?php

while($row=mysqli_fetch_assoc($cart))
{

$total=$row['price']*$row['quantity'];

$grandTotal += $total;

?>

<tr>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td>₹<?php echo $total; ?></td>

</tr>

<?php

}

?>
</table>

<div class="total">

Grand Total : ₹<?php echo $grandTotal; ?>

</div>

<div class="payment-box">

<h3>Select Payment Method</h3>

<label>

<input
type="radio"
name="payment_method"
value="Cash on Delivery"
required>

Cash on Delivery

</label>

<label>

<input
type="radio"
name="payment_method"
value="UPI">

UPI

</label>

<label>

<input
type="radio"
name="payment_method"
value="Credit/Debit Card">

Credit / Debit Card

</label>

</div>

<br>

<button
type="submit"
name="place_order">

Proceed to Pay

</button>

</form>

</div>

</body>
</html>