<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location:login.html");
    exit();
}

if(isset($_POST['place_order']))
{
    $user_id = $_SESSION['user_id'];

    $address = mysqli_real_escape_string($conn,$_POST['address']);

    $payment_method = $_POST['payment_method'];

    // Get Cart Items
    $cart = mysqli_query($conn,
    "SELECT * FROM cart WHERE user_id='$user_id'");

    while($row = mysqli_fetch_assoc($cart))
    {

        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $quantity = $row['quantity'];
        $price = $row['price'];

        $product = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT quantity FROM inventory WHERE id='$product_id'"));

    if($product['quantity'] < $quantity)
    {
        echo "<script>
        alert('$product_name has only ".$product['quantity']." item(s) available.');
        window.location='cart.php';
        </script>";
        exit();
    }

        $total = $price * $quantity;

        // Save Order
        mysqli_query($conn,

        "INSERT INTO orders

        (user_id,
        product_id,
        product_name,
        quantity,
        price,
        total,
        address,
        payment_method)

        VALUES

        ('$user_id',
        '$product_id',
        '$product_name',
        '$quantity',
        '$price',
        '$total',
        '$address',
        '$payment_method')");

        // Reduce Inventory Stock
        mysqli_query($conn,

        "UPDATE inventory

        SET quantity = quantity - '$quantity'

        WHERE id='$product_id'");

    }

    // Clear Cart
    mysqli_query($conn,

    "DELETE FROM cart

    WHERE user_id='$user_id'");

    header("Location: payment_success.php");
    exit();

}
?>