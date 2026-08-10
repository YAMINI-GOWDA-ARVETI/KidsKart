<?php

session_start();

include "db.php";
include "navbar.php";

if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}


$user_id=$_SESSION['user_id'];



$result=mysqli_query($conn,

"SELECT * FROM wishlist 
WHERE user_id='$user_id'");


?>


<!DOCTYPE html>
<html>

<head>

<title>Wishlist</title>


<style>

body{
    margin:0;
    font-family:Arial;
    background:#fff5fa;
}


.container{
    padding:30px;
}

.cards{
    display:flex;
    flex-wrap:wrap;
    gap:25px;
    justify-content:center;
}

.card{
    width:240px;
    background:white;
    border-radius:15px;
    padding:15px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
    transition:.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card img{
    width:100%;
    height:180px;
    object-fit:cover;
    border-radius:12px;
}

.price{
    color:#ff4f81;
    font-size:20px;
    font-weight:bold;
}

.add-btn,
.remove-btn{
    width:100%;
    border:none;
    padding:10px;
    border-radius:8px;
    color:white;
    cursor:pointer;
    margin-top:10px;
}

.add-btn{
    background:#ff5c93;
}

.remove-btn{
    background:red;
}
</style>


</head>


<body>

<div class="cards">

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

?>

<div class="card">

<img src="uploads/<?php echo $row['image']; ?>">

<h3><?php echo $row['product_name']; ?></h3>

<p class="price">
₹<?php echo $row['price']; ?>
</p>

<!-- Add to Cart -->

<form action="user_add_cart.php" method="POST">

<input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

<input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">

<input type="hidden" name="price" value="<?php echo $row['price']; ?>">

<input type="hidden" name="image" value="<?php echo $row['image']; ?>">

<button class="add-btn" name="add_cart">
🛒 Add to Cart
</button>

</form>

<!-- Remove -->

<form action="remove_wishlist.php"
method="POST"
onsubmit="return confirm('Remove this product from wishlist?');">

<input type="hidden"
name="id"
value="<?php echo $row['id']; ?>">

<button class="remove-btn">
❌ Remove
</button>

</form>

</div>

<?php

}

}
else
{

echo "<h2 style='text-align:center;'>❤️ Your Wishlist is Empty</h2>";

}

?>
</div>
<!-- <?php include "footer.php";?> -->
</body>
</html>