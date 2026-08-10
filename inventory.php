<?php

session_start();

if(!isset($_SESSION['inventory_access']))
{
    header("Location: inventory_login.php");
    exit();
}

include "db.php";

$totalProducts = $conn->query(
"SELECT COUNT(*) AS total FROM inventory"
)->fetch_assoc()['total'];

$lowStock = $conn->query(
"SELECT COUNT(*) AS total FROM inventory
WHERE quantity <= 5 AND quantity > 0"
)->fetch_assoc()['total'];

$outOfStock = $conn->query(
"SELECT COUNT(*) AS total FROM inventory
WHERE quantity = 0"
)->fetch_assoc()['total'];

$totalValue = $conn->query(
"SELECT SUM(price * quantity) AS total
FROM inventory"
)->fetch_assoc()['total'];

$result = $conn->query(
"SELECT * FROM inventory"
);

$result = $conn->query("SELECT * FROM inventory");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventory Management</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:"Poppins",sans-serif;
}

body{
background:#fff7fb;
padding:30px;
min-height:100vh;
}

.container{
max-width:1300px;
margin:30px auto;
margin-left:5px;
}

/* HEADER */

.header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
}

.header h2{
font-size:32px;
color:#ff6fa5;
font-weight:700;
}

.add-btn{
background:#ff6fa5;
color:white;
padding:12px 20px;
text-decoration:none;
border-radius:10px;
font-weight:600;
}

.add-btn:hover{
background:#ff4f91;
}

/* CARDS */

.cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
margin-bottom:25px;
}

.card{
padding:25px;
border-radius:15px;
color:white;
box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.card h3{
font-size:18px;
margin-bottom:10px;
}

.card p{
font-size:30px;
font-weight:bold;
}

.total{
background:#ff6fa5;
}

.low{
background:#ffb347;
}

.out{
background:#ff6b6b;
}

.value{
background:#8e7dff;
}

/* TABLE */

.table-box{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
overflow-x:auto;
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#ff6fa5;
color:white;
padding:15px;
}

td{
padding:12px;
text-align:center;
border-bottom:1px solid #eee;
}

tr:hover{
background:#fff0f6;
}

/* IMAGE */

.product-img{
width:70px;
height:70px;
object-fit:cover;
border-radius:10px;
border:2px solid #ffd6e7;
}

/* BUTTONS */

.btn{
padding:8px 14px;
border-radius:6px;
text-decoration:none;
color:white;
font-size:14px;
font-weight:bold;
margin:0 3px;
}

.edit{
background:#28a745;
}

.edit:hover{
background:#218838;
}

.delete{
background:#dc3545;
}

.delete:hover{
background:#c82333;
}

/* STOCK STATUS */

.stock-good{
color:#28a745;
font-weight:bold;
}

.stock-low{
color:#ff9800;
font-weight:bold;
}

.stock-out{
color:#dc3545;
font-weight:bold;
}

/* BACK BUTTON */

.back{
margin-top:20px;
}

.back a{
background:#ff6fa5;
padding:10px 18px;
border-radius:8px;
text-decoration:none;
color:white;
font-weight:bold;
}

.back a:hover{
background:#ff4f91;
}
</style>

</head>
<body>
<?php include "admin_navbar.php";?>
<div class="container">

<div class="header">

<h2>Inventory Management</h2>

<div>

<a href="add_product.php" class="add-btn">
+ Add Product
</a>

<a href="inventory_logout.php" class="add-btn"
style="background:#dc3545;margin-left:10px;">
Logout
</a>

</div>

</div>

<!-- PASTE DASHBOARD CARDS HERE -->

<div class="cards">

<div class="card total">
<h3>Total Products</h3>
<p><?php echo $totalProducts; ?></p>
</div>

<div class="card low">
<h3>Low Stock</h3>
<p><?php echo $lowStock; ?></p>
</div>

<div class="card out">
<h3>Out Of Stock</h3>
<p><?php echo $outOfStock; ?></p>
</div>

<div class="card value">
<h3>Total Inventory Value</h3>
<p>₹<?php echo number_format($totalValue,2); ?></p>
</div>

</div>

<!-- TABLE STARTS HERE -->

<div class="table-box">

<table>

<div class="table-box">

<table>

<tr>
<th>ID</th>
<th>Image</th>
<th>Product Name</th>
<th>Category</th>
<th>Price</th>
<th>Quantity</th>
<th>Status</th>
<th>Actions</th>
</tr>

<?php

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>
<img
src="uploads/<?php echo $row['image']; ?>"
class="product-img">
</td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['category']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>

<?php

if($row['quantity']==0){

echo "<span class='stock-out'>Out of Stock</span>";

}elseif($row['quantity']<=5){

echo "<span class='stock-low'>Low Stock</span>";

}else{

echo "<span class='stock-good'>Available</span>";

}

?>

</td>

<td>

<a
class="btn edit"
href="edit_product.php?id=<?php echo $row['id']; ?>">
Edit
</a>

<a
class="btn delete"
href="delete_product.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete Product?')">
Delete
</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>
<td colspan="8">
No Products Found
</td>
</tr>

<?php } ?>

</table>

</div>

<div class="back">

<a href="dashboard.php">
← Back Dashboard
</a>

</div>

</div>

</body>
</html>