<?php

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "KidsKart"
);

if($conn->connect_error){
    die("Connection Failed");
}

?>