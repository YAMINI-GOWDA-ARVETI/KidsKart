<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if (isset($_POST['add_wishlist'])) {

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $check = mysqli_query($conn,
        "SELECT * FROM wishlist
         WHERE user_id='$user_id'
         AND product_id='$product_id'");

    if (mysqli_num_rows($check) == 0) {

        mysqli_query($conn,
            "INSERT INTO wishlist
            (user_id, product_id, product_name, price, image)
            VALUES
            ('$user_id', '$product_id', '$product_name', '$price', '$image')");
    }

    header("Location: user_home.php");
    exit();
}
?>