<?php

session_start();

include "db.php";

include "navbar.php";

if(!isset($_SESSION['user_id']))
{
    header("Location:login.html");
    exit();
}

if(!isset($_GET['id']))
{
    header("Location:user_home.php");
    exit();
}

$id=(int)$_GET['id'];

$product=mysqli_query($conn,
"SELECT * FROM inventory WHERE id='$id'");

if(mysqli_num_rows($product)==0)
{
    echo "Product Not Found";
    exit();
}

$p=mysqli_fetch_assoc($product);

?>
<!DOCTYPE html>

<html>

<head>

<title><?php echo $p['product_name']; ?></title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#fff5fa;
}

.container{

width:90%;
max-width:1200px;
margin:40px auto;

}

.product-box{

background:white;

border-radius:20px;

box-shadow:0 5px 20px rgba(0,0,0,.15);

padding:35px;

display:grid;

grid-template-columns:420px 1fr;

gap:40px;

}

.product-image{

text-align:center;

}

.product-image img{

width:100%;

max-width:380px;

height:380px;

object-fit:cover;

border-radius:20px;

border:2px solid #ffd6e5;

}

.details h1{

color:#ff4f81;

margin-bottom:10px;

}

.rating{

color:#ffb400;

font-size:22px;

margin:15px 0;

}

.price{

font-size:32px;

color:#ff4f81;

font-weight:bold;

margin-bottom:15px;

}

.stock{

display:inline-block;

padding:8px 15px;

border-radius:20px;

font-weight:bold;

margin-bottom:20px;

}

.instock{

background:#d4edda;

color:green;

}

.lowstock{

background:#fff3cd;

color:#856404;

}

.outstock{

background:#f8d7da;

color:#c82333;

}

.desc{

margin-top:20px;

line-height:1.8;

font-size:16px;

color:#555;

}

.qty-box{

margin-top:30px;

display:flex;

align-items:center;

gap:15px;

}

.qty-btn{

width:40px;

height:40px;

border:none;

border-radius:50%;

background:#ff4f81;

color:white;

font-size:22px;

cursor:pointer;

}

#qty{

width:60px;

text-align:center;

font-size:18px;

border:1px solid #ddd;

border-radius:8px;

padding:8px;

}

.buttons{

display:flex;

gap:20px;

margin-top:35px;

}

.buttons button{

padding:14px 25px;

border:none;

border-radius:30px;

font-size:16px;

cursor:pointer;

color:white;

}

.cart{

background:#ff4f81;
padding:10px 15px;
border-radius:30px;
border:none;

}

.wish{

background:#ff9800;

}

.buttons button:hover{

opacity:.9;

transform:scale(1.03);

transition:.3s;

}

@media(max-width:850px){

.product-box{

grid-template-columns:1fr;

}

.product-image img{

height:300px;

}

}

</style>

</head>

<body>

<div class="container">

<div class="product-box">

<div class="product-image">

<img src="uploads/<?php echo $p['image']; ?>">

</div>

<div class="details">

<h1><?php echo $p['product_name']; ?></h1>

<div class="rating">
⭐⭐⭐⭐⭐ (4.8)
</div>

<div class="price">
₹<?php echo $p['price']; ?>
</div>

<?php

if($p['quantity']==0)
{
echo "<div class='stock outstock'>🔴 Out Of Stock</div>";
}
elseif($p['quantity']<=5)
{
echo "<div class='stock lowstock'>🟠 Low Stock (".$p['quantity']." left)</div>";
}
else
{
echo "<div class='stock instock'>🟢 In Stock</div>";
}

?>

<div class="desc">

<b>Description</b>

<br><br>

<?php echo nl2br(htmlspecialchars($p['description'])); ?>

</div>
<div class="qty-box">

<b>Quantity</b>

<button type="button" class="qty-btn" onclick="minusQty()">−</button>

<input type="text" id="qty" value="1" readonly>

<button type="button" class="qty-btn" onclick="plusQty()">+</button>

</div>

<div class="buttons">

<form action="user_add_cart.php" method="POST">

<input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">

<input type="hidden" name="product_name" value="<?php echo $p['product_name']; ?>">

<input type="hidden" name="price" value="<?php echo $p['price']; ?>">

<input type="hidden" name="image" value="<?php echo $p['image']; ?>">

<input type="hidden" id="cartQty" name="quantity" value="1">

<button class="cart" name="add_cart">
🛒 Add To Cart
</button>

</form>

<form action="user_add_wishlist.php" method="POST">

<input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">

<input type="hidden" name="product_name" value="<?php echo $p['product_name']; ?>">

<input type="hidden" name="price" value="<?php echo $p['price']; ?>">

<input type="hidden" name="image" value="<?php echo $p['image']; ?>">

<button class="wish" name="add_wishlist">
❤️ Wishlist
</button>

</form>

</div>

</div>

</div>

<br><br>

<h2 style="color:#ff4f81;">Related Products</h2>

<br>

<div style="display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:25px;">

<?php

$related=mysqli_query($conn,
"SELECT * FROM inventory
WHERE id!='$id'
LIMIT 4");

while($r=mysqli_fetch_assoc($related))
{

?>

<div style="background:white;
padding:15px;
border-radius:15px;
text-align:center;
box-shadow:0 5px 15px rgba(0,0,0,.15);">

<a href="product_details.php?id=<?php echo $r['id']; ?>">

<img
src="uploads/<?php echo $r['image']; ?>"
style="width:100%;
height:180px;
object-fit:cover;
border-radius:12px;">

</a>

<h3 style="margin:12px 0;">

<?php echo $r['product_name']; ?>

</h3>

<p style="color:#ff4f81;
font-size:20px;
font-weight:bold;">

₹<?php echo $r['price']; ?>

</p>

<a href="product_details.php?id=<?php echo $r['id']; ?>">

<button class="cart">

View Product

</button>

</a>

</div>

<?php

}

?>

</div>

</div>

<?php include "footer.php"; ?>

<script>

let qty=1;

function plusQty()
{
    qty++;

    document.getElementById("qty").value=qty;

    document.getElementById("cartQty").value=qty;
}

function minusQty()
{
    if(qty>1)
    {
        qty--;

        document.getElementById("qty").value=qty;

        document.getElementById("cartQty").value=qty;
    }
}

</script>

</body>

</html>