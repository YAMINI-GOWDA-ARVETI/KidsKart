<?php
session_start();

include "db.php";

if(isset($_POST['id']))
{

$id=(int)$_POST['id'];

$user_id=(int)$_SESSION['user_id'];

mysqli_query($conn,

"DELETE FROM wishlist
WHERE id='$id'
AND user_id='$user_id'");

}

header("Location:wishlist.php");
exit();
?>