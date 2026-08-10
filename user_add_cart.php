<?php

session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location:login.html");
    exit();
}

$user_id=$_SESSION['user_id'];

$product_id=$_POST['product_id'];
$product_name=$_POST['product_name'];
$price=$_POST['price'];
$image=$_POST['image'];

$quantity=isset($_POST['quantity'])
    ? (int)$_POST['quantity']
    : 1;

// Check if product already exists in cart
$check=mysqli_query($conn,
"SELECT * FROM cart
WHERE user_id='$user_id'
AND product_id='$product_id'");

if(mysqli_num_rows($check)>0)
{
    mysqli_query($conn,
    "UPDATE cart
    SET quantity=quantity+$quantity
    WHERE user_id='$user_id'
    AND product_id='$product_id'");
}
else
{
    mysqli_query($conn,
    "INSERT INTO cart
    (user_id,product_id,product_name,price,image,quantity)
    VALUES
    ('$user_id','$product_id','$product_name','$price','$image','$quantity')");
}

header("Location:cart.php");
exit();

?>