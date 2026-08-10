<?php

session_start();

include "db.php";


if(!isset($_SESSION['user_id']))
{
header("Location:login.html");
exit();
}


?>


<h1>
🛍 All Baby Products
</h1>


<?php


$result=mysqli_query($conn,
"SELECT * FROM inventory");


while($p=mysqli_fetch_assoc($result))
{

?>


<div>


<img src="uploads/<?php echo $p['image']; ?>"
width="200">



<h3>
<?php echo $p['product_name']; ?>
</h3>



<p>
₹<?php echo $p['price']; ?>
</p>




<form action="user_add_cart.php" method="POST">


<input type="hidden"
name="product_id"
value="<?php echo $p['id'];?>">


<input type="hidden"
name="product_name"
value="<?php echo $p['product_name'];?>">


<input type="hidden"
name="price"
value="<?php echo $p['price'];?>">


<input type="hidden"
name="image"
value="<?php echo $p['image'];?>">



<button name="add_cart">

Add Cart

</button>


</form>


</div>


<?php

}

?>