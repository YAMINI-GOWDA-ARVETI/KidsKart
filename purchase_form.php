<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Purchase</title>

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

    width:500px;
    margin:50px auto;
}

.card{

    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}

.card h2{

    text-align:center;
    color:#ff4f81;
    margin-bottom:25px;
}

label{

    display:block;
    margin-bottom:8px;
    font-weight:bold;
    color:#555;
}

input,
select{

    width:100%;
    padding:12px;
    margin-bottom:20px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:15px;
    outline:none;
    transition:.3s;
}

input:focus,
select:focus{

    border-color:#ff6fa5;
    box-shadow:0 0 8px rgba(255,111,165,.4);
}

button{

    width:100%;
    padding:14px;
    background:#ff6fa5;
    color:white;
    border:none;
    border-radius:10px;
    font-size:17px;
    cursor:pointer;
    transition:.3s;
}

button:hover{

    background:#ff4f81;
}

.back{

    display:block;
    text-align:center;
    margin-top:20px;
    text-decoration:none;
    color:#ff4f81;
    font-weight:bold;
}

.back:hover{

    text-decoration:underline;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h2>🛒 Add Purchase</h2>

<form action="add_purchase.php" method="POST">

<label>Select Product</label>

<select name="product_id" required>

<option value="">Choose Product</option>

<?php

$product=mysqli_query($conn,"SELECT * FROM inventory");

while($row=mysqli_fetch_assoc($product))
{
?>

<option value="<?php echo $row['id']; ?>">

<?php echo $row['product_name']; ?>

</option>

<?php
}
?>

</select>

<label>Supplier Name</label>

<input type="text"
name="supplier_name"
placeholder="Enter Supplier Name"
required>

<label>Quantity</label>

<input type="number"
name="quantity"
placeholder="Enter Quantity"
required>

<label>Purchase Price</label>

<input type="number"
step="0.01"
name="purchase_price"
placeholder="Enter Purchase Price"
required>

<button type="submit"
name="add_purchase">

 Save Purchase

</button>

</form>

<a href="purchases.php" class="back">

⬅ Back to Purchases

</a>

</div>

</div>

</body>
</html>