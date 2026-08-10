<?php
$conn = new mysqli("localhost", "root", "", "inventory_db");

$id = $_GET['id'];

$conn->query("UPDATE orders SET status='Completed' WHERE id=$id");

header("Location: orders.php");
?>