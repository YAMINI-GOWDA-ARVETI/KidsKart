<?php

session_start();

include "db.php";


if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}


if(isset($_POST['add_cart']))
{

$user_id=$_SESSION['user_id'];

$product_name=$_POST['product_name'];
$price=$_POST['price'];


$email=mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT email FROM users WHERE id='$user_id'")
)['email'];



$check=mysqli_query($conn,

"SELECT * FROM cart 
WHERE user_id='$user_id'
AND product_name='$product_name'");


if(mysqli_num_rows($check)>0)
{


mysqli_query($conn,

"UPDATE cart SET quantity=quantity+1

WHERE user_id='$user_id'
AND product_name='$product_name'");


}

else
{


mysqli_query($conn,

"INSERT INTO cart
(user_id,product_name,quantity,price,email)

VALUES

('$user_id',
'$product_name',
1,
'$price',
'$email')");


}



header("Location:user_cart.php");

exit();

}

?>