<?php

session_start();
session_destroy();

header("Location: inventory_login.php");
exit();

?>