<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#fff0f6;
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
padding:20px;
}

.container{
width:520px;
background:#ffffff;
padding:35px;
border-radius:25px;
box-shadow:0 15px 35px rgba(255,105,180,0.18);
border-top:8px solid #ff4f91;
}

h2{
text-align:center;
margin-bottom:25px;
color:#ff4f91;
font-size:32px;
font-weight:700;
letter-spacing:1px;
}

.input-group{
margin-bottom:18px;
}

label{
display:block;
margin-bottom:7px;
font-weight:600;
color:#666;
}

input{
width:100%;
padding:14px;
border:2px solid #ffd6e7;
border-radius:14px;
font-size:15px;
outline:none;
background:#fffafb;
transition:.3s;
}

input:focus{
border-color:#ff6fa5;
box-shadow:0 0 12px rgba(255,111,165,0.25);
background:white;
}

input[type="file"]{
cursor:pointer;
}

button{
width:100%;
padding:15px;
border:none;
border-radius:14px;
background:#ff4f91;
color:white;
font-size:16px;
font-weight:700;
cursor:pointer;
transition:.3s;
}

button:hover{
background:#e84384;
transform:translateY(-2px);
}

.back{
text-align:center;
margin-top:20px;
}

.back a{
text-decoration:none;
color:#ff4f91;
font-weight:700;
}

.back a:hover{
color:#e84384;
}

</style>
</head>
<body>

<div class="container">

<h2>Add Product</h2>

<form action="save_product.php"
method="POST"
enctype="multipart/form-data">

<div class="input-group">
<label>Product Name</label>
<input type="text"
name="product_name"
required>
</div>

<div class="input-group">
<label>Category</label>
<input type="text"
name="category"
required>
</div>

<div class="input-group">
<label>Price</label>
<input type="number"
step="0.01"
name="price"
required>
</div>

<div class="input-group">
<label>Quantity</label>
<input type="number"
name="quantity"
required>
</div>

<div class="input-group">
<label>Product Image</label>
<input type="file"
name="image"
required>
</div>

<button type="submit">
Add Product
</button>

</form>

<div class="back">
<a href="inventory.php">
← Back to Inventory
</a>
</div>

</div>

</body>
</html>