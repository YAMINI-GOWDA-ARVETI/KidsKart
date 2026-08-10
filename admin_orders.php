<?php
session_start();
include "db.php";

$sql = mysqli_query($conn,

"SELECT orders.*, users.firstname, users.lastname

FROM orders

JOIN users

ON orders.user_id = users.id

ORDER BY orders.id DESC");

?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Orders</title>

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

width:95%;
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

.search{

width:300px;
padding:12px;
border:1px solid #ccc;
border-radius:10px;
margin-bottom:20px;

}

table{

width:100%;
border-collapse:collapse;

}

th{

background:#ff6fa5;
color:white;
padding:14px;

}

td{

padding:12px;
text-align:center;
border-bottom:1px solid #ddd;

}

tr:hover{

background:#fff0f5;

}

select{

padding:8px;
border-radius:8px;

}

button{

background:#ff6fa5;
color:white;
border:none;
padding:8px 15px;
border-radius:8px;
cursor:pointer;

}

button:hover{

background:#ff4f81;

}

</style>

</head>

<body>
<?php include "admin_navbar.php";?>
<div class="container">

<div class="card">

<h2>📦 Customer Orders</h2>

<input
type="text"
id="search"
class="search"
placeholder="Search Customer..."
onkeyup="searchTable()">

<table id="ordersTable">

<tr>

<th>ID</th>
<th>Customer</th>
<th>Product</th>
<th>Qty</th>
<th>Total</th>
<th>Payment</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($sql))
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

<td>₹<?php echo $row['total']; ?></td>

<td><?php echo $row['payment_method']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo $row['order_date']; ?></td>

<td>

<form
action="update_order_status.php"
method="POST">

<input
type="hidden"
name="id"
value="<?php echo $row['id']; ?>">

<select name="status">

<option
<?php if($row['status']=="Pending") echo "selected"; ?>>
Pending
</option>

<option
<?php if($row['status']=="Confirmed") echo "selected"; ?>>
Confirmed
</option>

<option
<?php if($row['status']=="Shipped") echo "selected"; ?>>
Shipped
</option>

<option
<?php if($row['status']=="Delivered") echo "selected"; ?>>
Delivered
</option>

<option
<?php if($row['status']=="Cancelled") echo "selected"; ?>>
Cancelled
</option>

</select>

<button>

Update

</button>

</form>

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>
<!-- <a href="dashboard.php"><--- back to dashboard</a> -->
<script>

function searchTable(){

let input=document.getElementById("search").value.toUpperCase();

let table=document.getElementById("ordersTable");

let tr=table.getElementsByTagName("tr");

for(let i=1;i<tr.length;i++)
{

let td=tr[i].getElementsByTagName("td")[1];

if(td)
{

let txt=td.textContent||td.innerText;

tr[i].style.display=

txt.toUpperCase().indexOf(input)>-1?

"": "none";

}

}

}

</script>

</body>

</html>