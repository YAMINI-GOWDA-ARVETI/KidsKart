<?php
session_start();
include "db.php";

if(!isset($_GET['product_id']))
{
    die("Invalid Product");
}

$product_id = (int)$_GET['product_id'];

$product = mysqli_fetch_assoc(mysqli_query($conn,

"SELECT product_name
FROM inventory
WHERE id='$product_id'"));

$reviews = mysqli_query($conn,

"SELECT r.rating,
r.review,
r.created_at,
u.firstname,
u.lastname

FROM reviews r

JOIN users u
ON r.user_id=u.id

WHERE r.product_id='$product_id'

ORDER BY r.created_at DESC");
?>
<!DOCTYPE html>
<html>

<head>

<title>Product Reviews</title>

<style>

body{

font-family:Arial;
background:#f5f5f5;

}

.container{

width:80%;
margin:40px auto;

}

h1{

text-align:center;
color:#ff4f81;

}

.review{

background:white;
padding:20px;
margin:20px 0;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,.1);

}

.name{

font-weight:bold;
font-size:18px;

}

.rating{

color:#ff9800;
font-size:20px;
margin:10px 0;

}

.date{

color:gray;
font-size:14px;

}

</style>

</head>

<body>

<div class="container">

<h1>

Reviews for

<?php echo $product['product_name']; ?>

</h1>
<?php

if(mysqli_num_rows($reviews)>0)
{

while($row=mysqli_fetch_assoc($reviews))
{

echo "

<div class='review'>

<div class='name'>

".$row['firstname']." ".$row['lastname']."

</div>

<div class='rating'>";

for($i=1;$i<=$row['rating'];$i++)
{
echo "⭐";
}

echo "</div>

<p>".$row['review']."</p>

<div class='date'>

".$row['created_at']."

</div>

</div>";

}

}
else
{

echo "<h3>No Reviews Yet</h3>";

}

?>

</div>

</body>

</html>