<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location:login.html");
    exit();
}

// Total Revenue
$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(total) AS revenue FROM orders"));

// Total Orders
$totalOrders = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS orders FROM orders"));

// Total Products Sold
$totalProducts = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(quantity) AS qty FROM orders"));

// Sales List
$sales = mysqli_query($conn,

"SELECT orders.*, users.firstname, users.lastname

FROM orders

JOIN users

ON orders.user_id = users.id

ORDER BY orders.order_date DESC");
?>
<!DOCTYPE html>
<html>

<head>

<title>Sales Report</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
margin:0;
}

.container{
width:95%;
margin:30px auto;
}

.cards{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:20px;
margin-bottom:30px;
margin-top:20px;
}

.card{
background:white;
padding:25px;
border-radius:15px;
text-align:center;
box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.card h2{
color:#ff4f81;
}

.card p{
font-size:28px;
font-weight:bold;
}

table{
width:100%;
border-collapse:collapse;
background:white;
box-shadow:0 5px 15px rgba(0,0,0,.1);
}

th{
background:#ff4f81;
color:white;
padding:15px;
}

td{
padding:14px;
text-align:center;
border-bottom:1px solid #ddd;
}

tr:hover{
background:#fff5fa;
}

</style>

</head>

<body>
<?php include "admin_navbar.php";?>
<div class="container">

<h1>📈 Sales Report</h1>

<div class="cards">

<div class="card">
<h2>Total Orders</h2>
<p><?php echo $totalOrders['orders'] ?: 0; ?></p>
</div>

<div class="card">
<h2>Total Revenue</h2>
<p>₹<?php echo $totalRevenue['revenue'] ?: 0; ?></p>
</div>

<div class="card">
<h2>Products Sold</h2>
<p><?php echo $totalProducts['qty'] ?: 0; ?></p>
</div>

</div>

<table>

<tr>

<th>Order ID</th>

<th>Customer</th>

<th>Product</th>

<th>Qty</th>

<th>Price</th>

<th>Total</th>

<th>Payment</th>

<th>Status</th>

<th>Date</th>

</tr>
<?php

while($row=mysqli_fetch_assoc($sales))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>
<?php
echo $row['firstname']." ".$row['lastname'];
?>
</td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td>₹<?php echo $row['total']; ?></td>

<td><?php echo $row['payment_method']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo $row['order_date']; ?></td>

</tr>

<?php
}
?>

</table>

</div>

</body>

</html>