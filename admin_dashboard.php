<?php
session_start();
include "db.php";

/* ---------- Admin Login Check ---------- */

if (!isset($_SESSION['admin_id']))
{
    header("Location: admin_login.php");
    exit();
}

/* ---------- Dashboard Statistics ---------- */

// Total Users
$userQuery = mysqli_query($conn,
"SELECT COUNT(*) AS total_users FROM users");
$totalUsers = mysqli_fetch_assoc($userQuery)['total_users'];

// Total Products
$productQuery = mysqli_query($conn,
"SELECT COUNT(*) AS total_products FROM inventory");
$totalProducts = mysqli_fetch_assoc($productQuery)['total_products'];

// Total Orders
$orderQuery = mysqli_query($conn,
"SELECT COUNT(*) AS total_orders FROM orders");
$totalOrders = mysqli_fetch_assoc($orderQuery)['total_orders'];

// Total Revenue
$revenueQuery = mysqli_query($conn,
"SELECT SUM(total) AS revenue FROM orders");
$revenue = mysqli_fetch_assoc($revenueQuery)['revenue'];

if($revenue=="")
{
    $revenue=0;
}

// Pending Orders
$pendingQuery = mysqli_query($conn,
"SELECT COUNT(*) AS pending FROM orders
WHERE status='Pending'");
$pendingOrders = mysqli_fetch_assoc($pendingQuery)['pending'];

// Confirmed Orders
$confirmedQuery = mysqli_query($conn,
"SELECT COUNT(*) AS confirmed FROM orders
WHERE status='Confirmed'");
$confirmedOrders = mysqli_fetch_assoc($confirmedQuery)['confirmed'];

// Low Stock
$lowQuery = mysqli_query($conn,
"SELECT COUNT(*) AS low_stock
FROM inventory
WHERE quantity<10");

$lowStock = mysqli_fetch_assoc($lowQuery)['low_stock'];

// Out Of Stock
$outQuery = mysqli_query($conn,
"SELECT COUNT(*) AS out_stock
FROM inventory
WHERE quantity=0");

$outStock = mysqli_fetch_assoc($outQuery)['out_stock'];

?>

<!DOCTYPE html>
<html>

<head>

<title>KidsKart Admin Dashboard</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f4f6f9;
}

.header{
background:#4a00e0;
color:white;
padding:20px;
text-align:center;
font-size:28px;
font-weight:bold;
}

.container{
width:95%;
margin:auto;
padding:25px;
}

.cards{

display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;

}

.card{

background:white;
border-radius:10px;
padding:25px;
box-shadow:0 5px 15px rgba(0,0,0,.15);
transition:.3s;

}

.card:hover{

transform:translateY(-5px);

}

.card h2{

font-size:35px;
margin-bottom:10px;

}

.card p{

font-size:18px;
color:#555;

}

.users{
border-left:8px solid #3498db;
}

.products{
border-left:8px solid #2ecc71;
}

.orders{
border-left:8px solid #e67e22;
}

.revenue{
border-left:8px solid #9b59b6;
}

.pending{
border-left:8px solid #e74c3c;
}

.confirmed{
border-left:8px solid #27ae60;
}

.low{
border-left:8px solid orange;
}

.out{
border-left:8px solid black;
}

.buttons{

margin-top:35px;
display:flex;
flex-wrap:wrap;
gap:15px;

}

.buttons a{

text-decoration:none;
background:#4a00e0;
color:white;
padding:14px 22px;
border-radius:8px;
font-weight:bold;
transition:.3s;

}

.buttons a:hover{

background:#2d008d;

}

</style>

</head>

<body>

<div class="header">

KidsKart Admin Dashboard

</div>

<div class="container">

<div class="cards">
    <div class="card users">
<h2><?php echo $totalUsers; ?></h2>
<p>Total Users</p>
</div>

<div class="card products">
<h2><?php echo $totalProducts; ?></h2>
<p>Total Products</p>
</div>

<div class="card orders">
<h2><?php echo $totalOrders; ?></h2>
<p>Total Orders</p>
</div>

<div class="card revenue">
<h2>₹<?php echo $revenue; ?></h2>
<p>Total Revenue</p>
</div>

<div class="card pending">
<h2><?php echo $pendingOrders; ?></h2>
<p>Pending Orders</p>
</div>

<div class="card confirmed">
<h2><?php echo $confirmedOrders; ?></h2>
<p>Confirmed Orders</p>
</div>

<div class="card low">
<h2><?php echo $lowStock; ?></h2>
<p>Low Stock Products</p>
</div>

<div class="card out">
<h2><?php echo $outStock; ?></h2>
<p>Out Of Stock</p>
</div>

</div>
<div class="buttons">

<a href="inventory.php">Inventory</a>

<a href="admin_orders.php">Orders</a>

<!-- <a href="users.php">Users</a> -->

<a href="add_product.php">Add Product</a>

<a href="logout.php">Logout</a>

</div>
<?php

$recentOrders = mysqli_query($conn,

"SELECT orders.*, users.firstname, users.lastname
FROM orders
INNER JOIN users
ON orders.user_id = users.id
ORDER BY orders.order_date DESC
LIMIT 10");

?>

<br><br>

<h2 style="margin-bottom:15px;">Recent Orders</h2>

<table width="100%" cellpadding="12" style="border-collapse:collapse;background:white;box-shadow:0 5px 15px rgba(0,0,0,.1);">

<tr style="background:#4a00e0;color:white;">

<th>ID</th>
<th>Customer</th>
<th>Product</th>
<th>Qty</th>
<th>Total</th>
<th>Payment</th>
<th>Status</th>
<th>Date</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($recentOrders))
{

?>

<tr style="text-align:center;border-bottom:1px solid #ddd;">

<td><?php echo $row['id']; ?></td>

<td>

<?php

echo $row['firstname']." ".$row['lastname'];

?>

</td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo $row['total']; ?></td>

<td><?php echo $row['payment_method']; ?></td>

<td>

<?php

if($row['status']=="Pending")
{
echo "<span style='color:red;font-weight:bold;'>Pending</span>";
}
else
{
echo "<span style='color:green;font-weight:bold;'>Confirmed</span>";
}

?>

</td>

<td><?php echo $row['order_date']; ?></td>

</tr>

<?php

}

?>

</table>
<?php

$lowStockProducts = mysqli_query($conn,

"SELECT *
FROM inventory
WHERE quantity<10
ORDER BY quantity ASC");

?>

<br><br>

<h2 style="margin-bottom:15px;">

Low Stock Products

</h2>

<table width="100%" cellpadding="12"

style="border-collapse:collapse;
background:white;
box-shadow:0 5px 15px rgba(0,0,0,.1);">

<tr style="background:#e74c3c;color:white;">

<th>ID</th>

<th>Product</th>

<th>Category</th>

<th>Price</th>

<th>Quantity</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($lowStockProducts))
{

?>

<tr style="text-align:center;border-bottom:1px solid #ddd;">

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['category']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td>

<?php

if($row['quantity']<=5)
{

echo "<span style='color:red;font-weight:bold;'>".$row['quantity']."</span>";

}
else
{

echo "<span style='color:orange;font-weight:bold;'>".$row['quantity']."</span>";

}

?>

</td>

</tr>

<?php

}

?>

</table>
<br><br>

<div style="text-align:center;
padding:20px;
background:#4a00e0;
color:white;
margin-top:40px;">

© 2026 KidsKart Admin Panel

</div>

</div>

</body>

</html>