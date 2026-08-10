<?php

include "db.php";

if(isset($_GET['id'])){

$id = $_GET['id'];

$result = $conn->query(
"SELECT image FROM inventory WHERE id='$id'"
);

if($result->num_rows > 0){

$row = $result->fetch_assoc();

$imagePath = "uploads/".$row['image'];

if(file_exists($imagePath)){

unlink($imagePath);

}

}

$conn->query(
"DELETE FROM inventory WHERE id='$id'"
);

echo "<script>
alert('Product Deleted Successfully');
window.location.href='inventory.php';
</script>";

}else{

echo "Invalid Product ID";

}

?>