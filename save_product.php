<?php

include "db.php";

$product_name = $_POST['product_name'];
$category = $_POST['category'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

$image = $_FILES['image']['name'];

move_uploaded_file(
$_FILES['image']['tmp_name'],
"uploads/".$image
);

$sql = "INSERT INTO inventory
(product_name,category,price,quantity,image)
VALUES
('$product_name','$category','$price','$quantity','$image')";

if($conn->query($sql)===TRUE){

echo "<script>
alert('Product Added Successfully');
window.location.href='inventory.php';
</script>";

}else{

echo $conn->error;

}
?>