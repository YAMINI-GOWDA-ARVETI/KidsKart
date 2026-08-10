<?php
session_start();
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>

<title>Purchases</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{

background:
linear-gradient(rgba(255,255,255,.8),rgba(255,255,255,.8)),
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

.top{

display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
flex-wrap:wrap;

}

.top h2{

color:#ff4f81;

}

.btn{

background:#ff6fa5;
color:white;
padding:12px 20px;
text-decoration:none;
border-radius:10px;
font-weight:bold;

}

.btn:hover{

background:#ff4f81;

}

.search{

padding:10px;
width:250px;
border:1px solid #ccc;
border-radius:10px;

}

table{

width:100%;
border-collapse:collapse;
margin-top:20px;

}

th{

background:#ff6fa5;
color:white;
padding:15px;

}

td{

padding:12px;
text-align:center;
border-bottom:1px solid #ddd;

}

tr:hover{

background:#fff0f5;

}

.edit{

background:#4CAF50;
color:white;
padding:8px 12px;
text-decoration:none;
border-radius:8px;
margin-right: 5px;

}

.delete{

background:red;
color:white;
padding:8px 12px;
text-decoration:none;
border-radius:8px;

}

</style>

</head>

<body>
<?php include "admin_navbar.php";?>
<div class="container">

<div class="card">

<div class="top">

<h2>🛒 Purchases</h2>

<a href="purchase_form.php" class="btn">

➕ Add Purchase

</a>

</div>

<input
type="text"
id="search"
class="search"
placeholder="Search Product..."
onkeyup="searchTable()">

<table id="myTable">

<tr>

<th>ID</th>
<th>Product</th>
<th>Supplier</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>
<th>Date</th>
<th>Action</th>

</tr>

<?php

$sql=mysqli_query($conn,

"SELECT purchases.*,
inventory.product_name

FROM purchases

JOIN inventory

ON purchases.product_id=inventory.id

ORDER BY purchases.id DESC");

while($row=mysqli_fetch_assoc($sql))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['supplier_name']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo $row['purchase_price']; ?></td>

<td>₹<?php echo $row['total_amount']; ?></td>

<td><?php echo $row['purchase_date']; ?></td>

<td>

<a
href="edit_purchase.php?id=<?php echo $row['id'];?>"
class="edit">

Edit

</a>

<a
href="delete_purchase.php?id=<?php echo $row['id'];?>"
class="delete"
onclick="return confirm('Delete this purchase?')">

Delete

</a>

</td>

</tr>

<?php
}
?>

</table>

</div>

</div>

<script>

function searchTable(){

let input=document.getElementById("search").value.toUpperCase();

let table=document.getElementById("myTable");

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