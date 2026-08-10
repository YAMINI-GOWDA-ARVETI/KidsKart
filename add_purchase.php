<?php
session_start();
include "db.php";

if(isset($_POST['add_purchase']))
{
    $product_id = $_POST['product_id'];
    $supplier_name = $_POST['supplier_name'];
    $quantity = $_POST['quantity'];
    $purchase_price = $_POST['purchase_price'];

    $total_amount = $quantity * $purchase_price;

    mysqli_query($conn,

    "INSERT INTO purchases
    (product_id,supplier_name,quantity,purchase_price,total_amount)

    VALUES

    ('$product_id',
    '$supplier_name',
    '$quantity',
    '$purchase_price',
    '$total_amount')");



    mysqli_query($conn,

    "UPDATE inventory
    SET quantity = quantity + '$quantity'
    WHERE id='$product_id'");



    header("Location:purchases.php");
    exit();
}
?>