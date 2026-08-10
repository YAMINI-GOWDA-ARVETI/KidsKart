<?php

session_start();

include "db.php";


if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}


$user_id=$_SESSION['user_id'];


// USER DATA

$user=mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT * FROM users WHERE id='$user_id'")
);



// CART COUNT

$cart=mysqli_query($conn,
"SELECT id FROM cart WHERE user_id='$user_id'");

$cartCount=mysqli_num_rows($cart);



// WISHLIST COUNT

$wish=mysqli_query($conn,
"SELECT id FROM wishlist WHERE user_id='$user_id'");

$wishCount=mysqli_num_rows($wish);




// STOCK DATA

$lowItems=[];
$highItems=[];
$outItems=[];


$stock=mysqli_query($conn,
"SELECT product_name,quantity FROM inventory");


while($row=mysqli_fetch_assoc($stock))
{

    if($row['quantity']==0)
    {
        $outItems[]=$row;
    }

    elseif($row['quantity']<=5)
    {
        $lowItems[]=$row;
    }

    else
    {
        $highItems[]=$row;
    }

}



?>



<!DOCTYPE html>

<html>

<head>


<title>BabyBloom</title>


<style>


*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}



body{


background:

linear-gradient(
rgba(255,255,255,.8),
rgba(255,255,255,.8)
),

url("https://images.unsplash.com/photo-1516627145497-ae6968895b74?w=1600");


background-size:cover;

background-attachment:fixed;

}




.navbar{
    background:#ff5c93;
    height:75px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 40px;
    position:sticky;
    top:0;
    z-index:1000;
    box-shadow:0 3px 10px rgba(0,0,0,0.15);
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:30px;
    color:white;
    font-weight:bold;
}

.nav-links{
    display:flex;
    align-items:center;
    gap:25px;
}

.nav-links a{
    color:white;
    text-decoration:none;
    font-size:18px;
    font-weight:bold;
    transition:.3s;
}

.nav-links a:hover{
    color:#ffe4ef;
}

.count{
    background:white;
    color:#ff5c93;
    padding:2px 8px;
    border-radius:20px;
    font-size:13px;
    margin-left:4px;
}

.logout{
    background:#ff1f5a;
    padding:10px 18px;
    border-radius:10px;
}



.bell{

position:relative;

display:inline-block;

cursor:pointer;

font-size:22px;

margin-left:20px;

}



.bell span{

position:absolute;

top:-10px;

right:-10px;

background:red;

width:20px;

height:20px;

border-radius:50%;

font-size:12px;

display:flex;

align-items:center;

justify-content:center;

}




.notification{


display:none;

position:fixed;

right:30px;

top:90px;

background:white;

width:320px;

padding:20px;

border-radius:20px;

box-shadow:0 5px 20px #aaa;

z-index:999;


}



.low{

color:#ff9800;

}


.high{

color:green;

}


.out{

color:red;

}
.profile{
    width:90%;
    margin:25px auto;
    background:white;
    padding:20px 30px;
    border-radius:18px;
    box-shadow:0 5px 15px rgba(0,0,0,.12);
}

.profile h2{
    font-size:30px;
    margin-bottom:10px;
}

.profile p{
    font-size:18px;
}
.container{

padding:20px 40px;

}
.product-grid{
display:grid;

grid-template-columns:
repeat(auto-fit,minmax(220px,1fr));

gap:25px;

}
.product{
    background:#fff;
    border-radius:18px;
    padding:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.12);
    transition:.3s;
    text-align:center;
    overflow:hidden;
}

.product:hover{
    transform:translateY(-8px);
    box-shadow:0 10px 25px rgba(0,0,0,.18);
}

.product img{
    width:100%;
    height:200px;
    object-fit:cover;
    border-radius:15px;
}

.product h3{
    margin-top:12px;
    font-size:24px;
    color:#333;
}

.price{
    color:#ff4f81;
    font-size:24px;
    font-weight:bold;
    margin:10px 0;
}

.stock{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-size:14px;
    font-weight:bold;
    margin-bottom:15px;
}

.instock{
    background:#d4edda;
    color:#155724;
}

.lowstock{
    background:#fff3cd;
    color:#856404;
}

.outstock{
    background:#f8d7da;
    color:#721c24;
}

button{


background:#ff6fa5;

color:white;

border:none;

padding:12px 25px;

border-radius:20px;

cursor:pointer;

margin-top:10px;

}



.heart{

background:white;

color:red;

font-size:25px;

}

.search-section{
    width:100%;
    display:flex;
    justify-content:center;
    margin:25px 0;
}

.search-box{
    width:500px;
    padding:12px 20px;
    border:2px solid #ff5c93;
    border-radius:30px;
    outline:none;
    font-size:16px;
}

.search-box:focus{
    border-color:#ff2d6d;
}

.wish-btn{
    width:100%;
    background:white;
    color:#ff4f81;
    border:2px solid #ff4f81;
    padding:10px;
    border-radius:10px;
    font-size:16px;
    margin-bottom:10px;
    cursor:pointer;
}

.wish-btn:hover{
    background:#ff4f81;
    color:white;
}

.cart-btn{
    width:100%;
    background:#ff4f81;
    color:white;
    border:none;
    padding:10px;
    border-radius:10px;
    font-size:16px;
    cursor:pointer;
}

.cart-btn:hover{
    background:#ff2d6d;
}

.footer{
    background:#ff5c93;
    color:white;
    margin-top:60px;
    padding:50px 40px 20px;
}

.footer-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:30px;
}

.footer-box h2,
.footer-box h3{
    margin-bottom:15px;
}

.footer-box p{
    line-height:1.8;
    font-size:15px;
}

.footer-box a{
    display:block;
    color:white;
    text-decoration:none;
    margin:10px 0;
    transition:.3s;
}

.footer-box a:hover{
    color:#ffe6ef;
    padding-left:8px;
}

.footer hr{
    margin:30px 0 20px;
    border:1px solid rgba(255,255,255,.3);
}

.footer-bottom{
    text-align:center;
    font-size:15px;
}
</style>
</head>
<body>
<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        🧸 <span>KidsKart</span>
    </div>

    <div class="nav-links">

        <a href="user_home.php">🏠 Home</a>

        <a href="wishlist.php">
            ❤️ Wishlist
            <span class="count"><?php echo $wishCount; ?></span>
        </a>

        <a href="cart.php">
            🛒 Cart
            <span class="count"><?php echo $cartCount; ?></span>
        </a>

        <div class="bell" onclick="showNotification()">
            🔔
            <span>
                <?php
                echo count($lowItems)+count($highItems)+count($outItems);
                ?>
            </span>
        </div>

        <a href="my_orders.php">📦 Orders</a>

        <a href="profile.php">👤 Profile</a>

        <a href="contact_us.php">Contact Us</a>

        <a href="logout.php" class="logout">Logout</a>

    </div>

</div>

<div class="search-section">

    <input
        type="text"
        class="search-box"
        id="search"
        placeholder="🔍 Search Baby Products..."
        onkeyup="searchProducts()">

</div>
<!-- NOTIFICATION POPUP -->

<div class="notification" id="notify">

<h3>
🔔 Stock Notification
</h3>
<?php
foreach($outItems as $i)
{

echo "

<p class='out'>

🔴 ".$i['product_name']." Out Of Stock

</p>";

}
foreach($lowItems as $i)
{

echo "

<p class='low'>

🟠 ".$i['product_name']."

Low Stock

(".$i['quantity']." left)

</p>";

}
foreach($highItems as $i)
{

echo "

<p class='high'>

🟢 ".$i['product_name']."

High Stock

(".$i['quantity'].")

</p>";

}
?>
</div>
<div class="profile">

    <h2>
        👋 Welcome,
        <?php echo htmlspecialchars($user['firstname']); ?>
    </h2>

    <p>
        📧 <?php echo htmlspecialchars($user['email']); ?>
    </p>

    <p style="margin-top:10px;color:#ff5c93;font-weight:bold;">
        Happy Shopping! 💖
    </p>

</div>

<div class="container">


<h1 style="color:#ff4f81;">

🛍 Baby Products

</h1>

<br>



<div class="product-grid">



<?php


$products=mysqli_query($conn,

"SELECT * FROM inventory");


while($p=mysqli_fetch_assoc($products))
{

?>

<div class="product">

<a href="product_details.php?id=<?php echo $p['id']; ?>">
    <img src="uploads/<?php echo $p['image']; ?>">
</a>

<h3>
<a href="product_details.php?id=<?php echo $p['id']; ?>"
style="text-decoration:none;color:black;">
<?php echo $p['product_name']; ?>
</a>
</h3>

<p class="price">
₹<?php echo $p['price']; ?>
</p>

<?php

if($p['quantity']==0)
{
    echo "<span class='stock outstock'>Out of Stock</span>";
}
elseif($p['quantity']<=5)
{
    echo "<span class='stock lowstock'>Only ".$p['quantity']." Left</span>";
}
else
{
    echo "<span class='stock instock'>In Stock</span>";
}

?>

<div style="margin-top:15px;">

<form action="user_add_wishlist.php" method="POST">

<input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
<input type="hidden" name="product_name" value="<?php echo $p['product_name']; ?>">
<input type="hidden" name="price" value="<?php echo $p['price']; ?>">
<input type="hidden" name="image" value="<?php echo $p['image']; ?>">

<button class="wish-btn" name="add_wishlist">
❤️ Wishlist
</button>

</form>

<form action="user_add_cart.php" method="POST">

<input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
<input type="hidden" name="product_name" value="<?php echo $p['product_name']; ?>">
<input type="hidden" name="price" value="<?php echo $p['price']; ?>">
<input type="hidden" name="image" value="<?php echo $p['image']; ?>">

<button class="cart-btn" name="add_cart">
🛒 Add to Cart
</button>

</form>

<a href="product_reviews.php?product_id=<?php echo $p['id']; ?>"
style="
display:block;
margin-top:10px;
text-decoration:none;
background:#28a745;
color:white;
padding:10px;
border-radius:10px;
font-weight:bold;
text-align:center;">
⭐ View Reviews
</a>

</div>

</div>
<?php
}
?>
</div>
</div>

<footer class="footer">

    <div class="footer-container">

        <div class="footer-box">

            <h2>🧸 KidsKart</h2>

            <p>
                KidsKart is your trusted online store for baby products.
                We provide safe, quality and affordable products for your little ones.
            </p>

        </div>

        <div class="footer-box">

            <h3>Quick Links</h3>

            <a href="user_home.php">🏠 Home</a>
            <a href="products.php">🛍 Products</a>
            <a href="wishlist.php">❤️ Wishlist</a>
            <a href="cart.php">🛒 Cart</a>

        </div>

        <div class="footer-box">

            <h3>Customer</h3>

            <a href="my_orders.php">📦 My Orders</a>
            <a href="profile.php">👤 My Profile</a>
            <a href="#">❓ Help Center</a>
            <a href="contact_us.php">📞 Contact Us</a>

        </div>

        <div class="footer-box">

            <h3>Follow Us</h3>

            <p>📧 support@babybloom.com</p>
            <p>📱 +91 98765 43210</p>
            <p>📍 Hyderabad, India</p>

        </div>

    </div>

    <hr>

    <div class="footer-bottom">

        © 2026 KidsKart | Made with ❤️ for Happy Babies

    </div>

</footer>

<script>
function showNotification()
{

let box=document.getElementById("notify");


if(box.style.display=="block")
{
box.style.display="none";
}
else
{
box.style.display="block";
}
}
</script>

<script>
function searchProducts()
{
    let input = document.getElementById("search").value.toLowerCase();

    let products = document.getElementsByClassName("product");

    for(let i=0;i<products.length;i++)
    {
        let title = products[i].getElementsByTagName("h3")[0].innerText.toLowerCase();

        if(title.indexOf(input)>-1)
        {
            products[i].style.display="block";
        }
        else
        {
            products[i].style.display="none";
        }
    }
}
</script>
</body>
</html>