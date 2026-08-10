<?php

include "db.php";

$data=[];

$sql="SELECT
status,
COUNT(*) total
FROM orders
GROUP BY status";

$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{
$data[]=$row;
}

echo json_encode($data);

?>