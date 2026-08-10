<?php
session_start();
include "db.php";

if(isset($_POST['update_purchase']))
{
    $id = $_POST['id'];
    $product_id = $_POST['product_id'];
    $supplier_name = $_POST['supplier_name'];
    $new_quantity = $_POST['quantity'];
    $purchase_price = $_POST['purchase_price'];

    // Get old purchase details
    $old_purchase = mysqli_fetch_assoc(
        mysqli_query($conn,
        "SELECT * FROM purchases WHERE id='$id'")
    );

    $old_quantity = $old_purchase['quantity'];
    $old_product = $old_purchase['product_id'];

    // If product changed
    if($old_product != $product_id)
    {
        // Reduce stock from old product
        mysqli_query($conn,
        "UPDATE inventory
         SET quantity = quantity - '$old_quantity'
         WHERE id='$old_product'");

        // Add stock to new product
        mysqli_query($conn,
        "UPDATE inventory
         SET quantity = quantity + '$new_quantity'
         WHERE id='$product_id'");
    }
    else
    {
        // Same product, adjust stock difference
        $difference = $new_quantity - $old_quantity;

        mysqli_query($conn,
        "UPDATE inventory
         SET quantity = quantity + '$difference'
         WHERE id='$product_id'");
    }

    $total_amount = $new_quantity * $purchase_price;

    mysqli_query($conn,

    "UPDATE purchases SET

    product_id='$product_id',
    supplier_name='$supplier_name',
    quantity='$new_quantity',
    purchase_price='$purchase_price',
    total_amount='$total_amount'

    WHERE id='$id'");

    header("Location:purchases.php");
    exit();
}

if(!isset($_GET['id']))
{
    header("Location:purchases.php");
    exit();
}

$id = $_GET['id'];

$purchase = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT * FROM purchases WHERE id='$id'")
);

if(!$purchase)
{
    header("Location:purchases.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Purchase</title>

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

width:550px;
margin:40px auto;

}

.card{

background:white;
padding:30px;
border-radius:20px;
box-shadow:0 10px 20px rgba(0,0,0,.2);

}

h2{

text-align:center;
color:#ff4f81;
margin-bottom:25px;

}

label{

display:block;
margin-bottom:8px;
font-weight:bold;

}

input,
select{

width:100%;
padding:12px;
margin-bottom:18px;
border:1px solid #ccc;
border-radius:10px;
font-size:15px;

}

input:focus,
select:focus{

border-color:#ff6fa5;
outline:none;

}

button{

width:100%;
padding:14px;
background:#ff6fa5;
color:white;
border:none;
border-radius:10px;
font-size:16px;
cursor:pointer;

}

button:hover{

background:#ff4f81;

}

.back{

display:block;
margin-top:20px;
text-align:center;
text-decoration:none;
font-weight:bold;
color:#ff4f81;

}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h2>✏ Edit Purchase</h2>

<form method="POST">

<input type="hidden"
name="id"
value="<?php echo $purchase['id']; ?>">

<label>Product</label>

<select name="product_id" required>

<?php

$products = mysqli_query($conn,
"SELECT * FROM inventory");

while($row=mysqli_fetch_assoc($products))
{
?>

<option
value="<?php echo $row['id']; ?>"

<?php
if($purchase['product_id']==$row['id'])
echo "selected";
?>

>

<?php echo $row['product_name']; ?>

</option>

<?php
}
?>

</select>

<label>Supplier Name</label>

<input
type="text"
name="supplier_name"
value="<?php echo $purchase['supplier_name']; ?>"
required>

<label>Quantity</label>

<input
type="number"
name="quantity"
value="<?php echo $purchase['quantity']; ?>"
required>

<label>Purchase Price</label>

<input
type="number"
step="0.01"
name="purchase_price"
value="<?php echo $purchase['purchase_price']; ?>"
required>

<button
type="submit"
name="update_purchase">

Update Purchase

</button>

</form>

<a href="purchases.php" class="back">

⬅ Back to Purchases

</a>

</div>

</div>

</body>

</html>