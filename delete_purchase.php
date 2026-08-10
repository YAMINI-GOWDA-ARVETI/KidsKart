<?php

include "db.php";

$id = $_GET['id'];

$purchase = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT * FROM purchases WHERE id='$id'")
);

$product_id = $purchase['product_id'];
$quantity = $purchase['quantity'];

mysqli_query($conn,

"UPDATE inventory
SET quantity = quantity - '$quantity'
WHERE id='$product_id'");

mysqli_query($conn,

"DELETE FROM purchases
WHERE id='$id'");

header("Location:purchases.php");

?>