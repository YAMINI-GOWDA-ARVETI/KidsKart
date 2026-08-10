<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location:login.html");
    exit();
}

$user_id=$_SESSION['user_id'];

if(!isset($_GET['product_id']))
{
    die("Invalid Product");
}

$product_id=$_GET['product_id'];

// Check if user purchased this product

$check=mysqli_query($conn,

"SELECT * FROM orders

WHERE user_id='$user_id'

AND product_id='$product_id'");

if(mysqli_num_rows($check)==0)
{
    die("You can review this product only after purchasing it.");
}

// Get Product Details

$product=mysqli_fetch_assoc(mysqli_query($conn,

"SELECT product_name

FROM inventory

WHERE id='$product_id'"));

if(isset($_POST['submit']))
{

$rating=$_POST['rating'];

$review=mysqli_real_escape_string($conn,$_POST['review']);

mysqli_query($conn,

"INSERT INTO reviews

(product_id,user_id,rating,review)

VALUES

('$product_id','$user_id','$rating','$review')");

echo "<script>

alert('Review Submitted Successfully');

window.location='my_orders.php';

</script>";

}
?>
<!DOCTYPE html>

<html>

<head>

<title>Write Review</title>

<style>

body{

font-family:Arial;
background:#f5f5f5;

}

.container{

width:500px;
margin:60px auto;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,.1);

}

h2{

text-align:center;
color:#ff4f81;
margin-bottom:20px;

}

label{

display:block;
margin-top:15px;
font-weight:bold;

}

select,
textarea{

width:100%;
padding:12px;
margin-top:8px;
border:1px solid #ccc;
border-radius:8px;

}

textarea{

height:150px;

}

button{

margin-top:20px;
width:100%;
padding:15px;
background:#ff4f81;
color:white;
border:none;
border-radius:10px;
font-size:17px;
cursor:pointer;

}

button:hover{

background:#e63d72;

}

</style>

</head>

<body>

<div class="container">

<h2>

Review

<?php echo $product['product_name']; ?>

</h2>

<form method="POST">

<label>Rating</label>

<select name="rating" required>

<option value="">Select</option>

<option value="5">⭐⭐⭐⭐⭐</option>

<option value="4">⭐⭐⭐⭐</option>

<option value="3">⭐⭐⭐</option>

<option value="2">⭐⭐</option>

<option value="1">⭐</option>

</select>

<label>Your Review</label>

<textarea
name="review"
required>

</textarea>

<button
type="submit"
name="submit">

Submit Review

</button>

</form>

</div>

</body>

</html>