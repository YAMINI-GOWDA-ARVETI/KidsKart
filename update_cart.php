<?php
session_start();
include "db.php";

if(isset($_GET['id']) && isset($_GET['action']))
{
    $id = $_GET['id'];
    $action = $_GET['action'];

    // Get cart item
    $cart = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM cart WHERE id='$id'"));

    if(!$cart)
    {
        header("Location:cart.php");
        exit();
    }

    $qty = $cart['quantity'];
    $product_id = $cart['product_id'];

    // Get available stock
    $product = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT quantity FROM inventory WHERE id='$product_id'"));

    $stock = $product['quantity'];

    if($action == "plus")
    {
        if($qty < $stock)
        {
            $qty++;
        }
        else
        {
            echo "<script>
            alert('Only $stock item(s) available in stock.');
            window.location='cart.php';
            </script>";
            exit();
        }
    }

    if($action == "minus")
    {
        if($qty > 1)
        {
            $qty--;
        }
    }

    mysqli_query($conn,
    "UPDATE cart
     SET quantity='$qty'
     WHERE id='$id'");

    header("Location:cart.php");
    exit();
}
?>