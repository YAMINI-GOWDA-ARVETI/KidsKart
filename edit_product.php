<?php

include "db.php";

$id = $_GET['id'];

$result = $conn->query(
"SELECT * FROM inventory WHERE id='$id'"
);

$product = $result->fetch_assoc();

if(isset($_POST['update'])){

$product_name = $_POST['product_name'];
$category = $_POST['category'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

if($_FILES['image']['name']!=""){

$image = $_FILES['image']['name'];

move_uploaded_file(
$_FILES['image']['tmp_name'],
"uploads/".$image
);

$sql = "UPDATE inventory SET
product_name='$product_name',
category='$category',
price='$price',
quantity='$quantity',
image='$image'
WHERE id='$id'";

}else{

$sql = "UPDATE inventory SET
product_name='$product_name',
category='$category',
price='$price',
quantity='$quantity'
WHERE id='$id'";

}

if($conn->query($sql)===TRUE){

echo "<script>
alert('Product Updated Successfully');
window.location.href='inventory.php';
</script>";

}

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>

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
width:550px;
background:#ffffff;
padding:35px;
border-radius:25px;
box-shadow:0 15px 35px rgba(255,111,165,.18);
border-top:8px solid #ff4f91;
}

h2{
text-align:center;
margin-bottom:25px;
color:#ff4f91;
font-size:32px;
font-weight:700;
}

/* Product Image */

img{
width:130px;
height:130px;
object-fit:cover;
border-radius:15px;
border:4px solid #ffd6e7;
padding:4px;
background:white;
margin-bottom:20px;
}

/* Input Groups */

.input-group{
margin-bottom:18px;
}

label{
display:block;
margin-bottom:6px;
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
box-shadow:0 0 12px rgba(255,111,165,.20);
background:white;
}

input[type="file"]{
cursor:pointer;
}

/* Update Button */

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

/* Responsive */

@media(max-width:600px){

.container{
width:100%;
padding:25px;
}

h2{
font-size:26px;
}

img{
width:110px;
height:110px;
}

}

</style>

</head>
<body>

<div class="container">

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

<center>
<img src="uploads/<?php echo $product['image']; ?>">
</center>

<div class="input-group">
<label>Product Name</label>
<input type="text"
name="product_name"
value="<?php echo $product['product_name']; ?>"
required>
</div>

<div class="input-group">
<label>Category</label>
<input type="text"
name="category"
value="<?php echo $product['category']; ?>"
required>
</div>

<div class="input-group">
<label>Price</label>
<input type="number"
step="0.01"
name="price"
value="<?php echo $product['price']; ?>"
required>
</div>

<div class="input-group">
<label>Quantity</label>
<input type="number"
name="quantity"
value="<?php echo $product['quantity']; ?>"
required>
</div>

<div class="input-group">
<label>Change Image</label>
<input type="file" name="image">
</div>

<button type="submit" name="update">
Update Product
</button>

</form>

</div>

</body>
</html>