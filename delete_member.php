<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];

$conn->query("DELETE FROM team_members WHERE id='$id'");

header("Location: admin.php");
exit();
?>