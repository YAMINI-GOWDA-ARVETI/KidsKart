<?php

include "db.php";

$sales = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT IFNULL(SUM(total),0) total FROM orders WHERE status='Delivered'"));

$purchase = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT IFNULL(SUM(total_price),0) total FROM purchases"));

$totalSales = $sales['total'];
$totalPurchase = $purchase['total'];
$revenue = $totalSales - $totalPurchase;

echo json_encode([
    "sales"=>$totalSales,
    "purchase"=>$totalPurchase,
    "revenue"=>$revenue
]);

?>