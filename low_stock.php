<?php

include "db.php";

$data=[];

$sql="SELECT
product_name,
quantity
FROM inventory
WHERE quantity<=10
ORDER BY quantity ASC";

$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{
$data[]=$row;
}

echo json_encode($data);

?>