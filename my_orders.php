<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location:login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$orders = mysqli_query($conn,

"SELECT * FROM orders

WHERE user_id='$user_id'

ORDER BY id DESC");

?>

<!DOCTYPE html>

<html>

<head>

<title>My Orders</title>

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f8f8f8;
}

.container{
    width:95%;
    margin:30px auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,.1);
}

th{
    background:#ff5c93;
    color:white;
    padding:16px;
    font-size:18px;
}

td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#fff5fa;
}

.status{
    background:#ffc107;
    color:#000;
    padding:6px 14px;
    border-radius:20px;
    font-weight:bold;
}

.invoice-btn{

background:#28a745;
color:white;
padding:8px 15px;
text-decoration:none;
border-radius:8px;
font-weight:bold;
transition:.3s;

}

.invoice-btn:hover{

background:#218838;

}

.review-btn{

background:#ff9800;
color:white;
padding:8px 15px;
border-radius:8px;
text-decoration:none;
font-weight:bold;

}

.review-btn:hover{

background:#f57c00;

}
</style>

</head>

<body>
<?php include "navbar.php"; ?>
<div class="container">
<h2>📦 My Orders</h2>

<table>

<tr>

<th>ID</th>
<th>Product</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>
<th>Invoice</th>
<th>Review</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($orders))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td>₹<?php echo $row['total']; ?></td>

<td>

<span class="status">

<?php echo $row['status']; ?>

</span>

</td>

<td><?php echo $row['order_date']; ?></td>

<td>

<a href="invoice.php?id=<?php echo $row['id']; ?>" class="invoice-btn">

🧾 View Invoice

</a>

</td>

<td>

<a href="review.php?product_id=<?php echo $row['product_id']; ?>"

class="review-btn">

⭐ Review

</a>

</td>

</tr>

<?php
}
?>

</table>
</div>
</body>

</html>