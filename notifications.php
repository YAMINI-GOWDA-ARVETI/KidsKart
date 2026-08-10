<?php

include "db.php";


$lowItems=[];
$highItems=[];
$outItems=[];


$result=$conn->query(
"SELECT product_name,quantity FROM inventory"
);


while($row=$result->fetch_assoc())
{


if($row['quantity']==0)
{

$outItems[]=$row;

}
elseif($row['quantity']<=5)
{

$lowItems[]=$row;

}
elseif($row['quantity']>10)
{

$highItems[]=$row;

}


}

?>


<!DOCTYPE html>
<html>

<head>

<title>Inventory Notifications</title>


<style>


body{

background:#fff7fb;
font-family:Arial;
padding:30px;

}


.box{

background:white;
padding:25px;
border-radius:20px;
box-shadow:0 5px 15px #aaa;
max-width:600px;
margin:auto;

}


h1{

color:#ff4f81;

}


.alert{

padding:15px;
margin:15px 0;
border-radius:12px;
font-weight:bold;

}


.low{

background:#fff3cd;
color:#ff9800;

}


.high{

background:#d4edda;
color:green;

}


.out{

background:#f8d7da;
color:red;

}


.back{

display:inline-block;
margin-top:20px;
padding:10px 20px;
background:#ff4f81;
color:white;
text-decoration:none;
border-radius:10px;

}


</style>


</head>


<body>


<div class="box">


<h1>🔔 Inventory Notifications</h1>


<?php


foreach($outItems as $item)
{

echo "

<div class='alert out'>

🔴 ".$item['product_name']." Out of Stock

</div>";

}



foreach($lowItems as $item)
{

echo "

<div class='alert low'>

🟠 ".$item['product_name']." Low Stock

(Only ".$item['quantity']." left)

</div>";

}



foreach($highItems as $item)
{

echo "

<div class='alert high'>

🟢 ".$item['product_name']." High Stock

(".$item['quantity']." available)

</div>";

}



if(count($lowItems)==0 && count($highItems)==0 && count($outItems)==0)
{

echo "No Notifications";

}


?>


<a href="dashboard.php" class="back">
← Dashboard
</a>


</div>


</body>

</html>