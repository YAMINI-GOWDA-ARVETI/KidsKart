<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}

if(isset($_POST['id']))
{
    $id = (int)$_POST['id'];
    $user_id = (int)$_SESSION['user_id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM cart WHERE id=? AND user_id=?");
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("Location: cart.php");
    exit();
}

header("Location: cart.php");
exit();
?>