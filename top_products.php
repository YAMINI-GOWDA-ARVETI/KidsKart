<?php

include "db.php";

$data = [];

$sql = "SELECT
product_name,
SUM(quantity) AS sold
FROM order_items
GROUP BY product_name
ORDER BY sold DESC
LIMIT 10";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result))
{
    $data[] = $row;
}

echo json_encode($data);

?>