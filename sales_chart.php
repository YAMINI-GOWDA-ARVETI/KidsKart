<?php

include "db.php";

$data=[];

$sql="SELECT
MONTHNAME(order_date) month,
SUM(total_amount) total
FROM orders
WHERE status='Delivered'
GROUP BY MONTH(order_date)
ORDER BY MONTH(order_date)";

$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{
    $data[]=$row;
}

echo json_encode($data);

?>