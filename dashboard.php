<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}


include "db.php";

// Dashboard Statistics

$userResult = mysqli_query($conn,"SELECT COUNT(*) AS total FROM users");
$totalUsers = mysqli_fetch_assoc($userResult)['total'];

$productResult = mysqli_query($conn,"SELECT COUNT(*) AS total FROM inventory");
$totalProducts = mysqli_fetch_assoc($productResult)['total'];

$orderResult = mysqli_query($conn,"SELECT COUNT(*) AS total FROM orders");
$totalOrders = mysqli_fetch_assoc($orderResult)['total'];

$revenueResult = mysqli_query($conn,"SELECT SUM(total) AS revenue FROM orders");
$revenue = mysqli_fetch_assoc($revenueResult)['revenue'];

if($revenue=="")
{
    $revenue=0;
}

// Pending Orders
$pendingResult = mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders WHERE status='Pending'");
$pendingOrders = mysqli_fetch_assoc($pendingResult)['total'];

// Confirmed Orders
$confirmedResult = mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders WHERE status='Confirmed'");
$confirmedOrders = mysqli_fetch_assoc($confirmedResult)['total'];

// Delivered Orders
$deliveredResult = mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders WHERE status='Delivered'");
$deliveredOrders = mysqli_fetch_assoc($deliveredResult)['total'];

// Cancelled Orders
$cancelledResult = mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders WHERE status='Cancelled'");
$cancelledOrders = mysqli_fetch_assoc($cancelledResult)['total'];

// Recent Orders

$recentOrders = mysqli_query($conn,

"SELECT orders.*, users.firstname, users.lastname
FROM orders
INNER JOIN users
ON orders.user_id = users.id
ORDER BY orders.order_date DESC
LIMIT 10");

// Low Stock Products

$lowStockProducts = mysqli_query($conn,

"SELECT *
FROM inventory
WHERE quantity < 10
ORDER BY quantity ASC");

$lowItems = [];
$highItems = [];
$outItems = [];


$sql = "SELECT product_name, quantity FROM inventory";

$result = $conn->query($sql);


while($row = $result->fetch_assoc())
{

    if($row['quantity']==0)
    {
        $outItems[] = $row;
    }
    elseif($row['quantity']<=5)
    {
        $lowItems[] = $row;
    }
    elseif($row['quantity']>10)
    {
        $highItems[] = $row;
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BabyBloom Dashboard</title>

<style>

/* GLOBAL */

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:"Lucida Sans","Lucida Grande","Lucida Sans Unicode",sans-serif;
}

body{
  background:#fff7fb;
  overflow-x:hidden;
}

/* BEAUTIFUL BACKGROUND */

body::before{
  content:"";
  position:fixed;
  inset:0;
  background:
  linear-gradient(rgba(255,255,255,0.88),rgba(255,255,255,0.88)),
  url("https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=1600&auto=format&fit=crop");
  background-size:cover;
  background-position:center;
  z-index:-1;
}

/* SIDEBAR */
/* HORIZONTAL NAVBAR */

.navbar{
    width:100%;
    background:linear-gradient(135deg,#ff6fa5,#ffb6c1);
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 30px;
    position:sticky;
    top:0;
    z-index:1000;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

.logo{
    color:white;
    font-size:28px;
    font-weight:bold;
}

.nav-links{
    display:flex;
    list-style:none;
    gap:15px;
}

.nav-links li a{
    text-decoration:none;
    color:white;
    padding:10px 15px;
    border-radius:8px;
    transition:0.3s;
    font-size:16px;
    font-weight:bold;
}

.nav-links li a:hover{
    background:rgba(255,255,255,0.2);
}

.logout{
    background:red;
    border-radius:8px;
}

.logout:hover{
    background:darkred;
}

/* REMOVE SIDEBAR MARGIN */

.topbar,
.hero,
.cards,
.products,
.gallery{
    margin-left:0;
}

/* MOBILE */

@media(max-width:768px){

    .navbar{
        flex-direction:column;
        padding:15px;
    }

    .nav-links{
        flex-wrap:wrap;
        justify-content:center;
        margin-top:10px;
    }
}

/* MAIN */

.main{
  width:100%;
  padding:25px;
}

/* TOPBAR */

.topbar{
  margin-left:80px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  background:rgba(255,255,255,0.9);
  padding:18px 22px;
  border-radius:20px;
  margin-bottom:35px;
  box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

/* SEARCH */

.search-box{
  width:55%;
}

.search-box input{
  width:100%;
  padding:14px;
  border:none;
  border-radius:30px;
  outline:none;
  font-size:16px;
  box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

/* PROFILE */

.profile{
  display:flex;
  align-items:center;
  gap:12px;
  font-size:18px;
  color:#444;
}

.profile img{
  width:50px;
  height:50px;
  border-radius:50%;
  border:3px solid #ff7aa2;
}

/* HERO */

.hero{
  margin-left:80px;
  height:280px;
  border-radius:30px;
  background:
  linear-gradient(rgba(255,111,165,0.45),rgba(255,182,193,0.45)),
  url("https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=1600&auto=format&fit=crop");
  background-size:cover;
  background-position:center;
  display:flex;
  align-items:center;
  padding:45px;
  color:white;
  margin-bottom:40px;
  box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.hero h1{
  font-size:48px;
  margin-bottom:12px;
}

.hero p{
  font-size:20px;
  max-width:600px;
  line-height:1.6;
}

/* DASHBOARD CARDS */

.cards{
  margin-left:80px;
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
  gap:20px;
  margin-bottom:45px;
}

.card{
  background:linear-gradient(135deg,#ffffff,#ffe6ef);
  padding:22px;
  border-radius:22px;
  text-align:center;
  box-shadow:0 5px 15px rgba(0,0,0,0.1);
  transition:0.3s;
}

.card:hover{
  transform:translateY(-5px);
}

.card h3{
  color:#ff4f81;
  margin-bottom:10px;
  font-size:20px;
}

.card p{
  font-size:24px;
  color:#555;
  font-weight:bold;
}

/* PRODUCTS */

.products{
  margin-left:80px;
}

.products h2{
  color:#ff4f81;
  font-size:36px;
  margin-bottom:30px;
}

.category{
  margin-bottom:50px;
}

.category-title{
  font-size:26px;
  color:#ff4f81;
  margin-bottom:20px;
  background:linear-gradient(90deg,#fff,#ffe3ec);
  padding:14px 18px;
  border-left:6px solid #ff7aa2;
  border-radius:12px;
  font-weight:bold;
}

/* SMALL PRODUCT SIZE */

.product-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
  gap:18px;
}

.product{
  background:white;
  border-radius:18px;
  padding:12px;
  text-align:center;
  box-shadow:0 4px 12px rgba(0,0,0,0.1);
  transition:0.3s;
}

.product:hover{
  transform:translateY(-5px);
}

.product img{
  width:100%;
  height:170px;
  object-fit:cover;
  border-radius:14px;
}

.product h4{
  margin-top:10px;
  font-size:18px;
  color:#444;
}

.product p{
  margin-top:6px;
  font-size:16px;
  color:#ff4f81;
  font-weight:bold;
}

.product button{
  margin-top:10px;
  padding:9px 15px;
  border:none;
  border-radius:10px;
  background:linear-gradient(135deg,#ff5f8f,#ff8db2);
  color:white;
  font-size:14px;
  cursor:pointer;
  transition:0.3s;
}

.product button:hover{
  opacity:0.9;
}

/* SEARCH RESULT */

#notFound{
  display:none;
  color:red;
  font-size:22px;
  margin-bottom:20px;
  text-align:center;
  font-weight:bold;
}

/* GALLERY */

.gallery{
  margin-left:80px;
  margin-top:50px;
}

.gallery h2{
  color:#ff4f81;
  margin-bottom:25px;
  font-size:34px;
}

.gallery-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:18px;
}

.gallery-grid img{
  width:100%;
  height:240px;
  object-fit:cover;
  border-radius:20px;
  box-shadow:0 5px 15px rgba(0,0,0,0.1);
  transition:0.3s;
}

.gallery-grid img:hover{
  transform:scale(1.03);
}

/* MOBILE */

@media(max-width:768px){

  .topbar,
  .hero,
  .cards,
  .products,
  .gallery{
    margin-left:0;
  }

  .hero{
    height:auto;
    padding:30px;
  }

  .hero h1{
    font-size:34px;
  }

}
/* FOOTER */

.footer{
  margin-top:60px;
  background:linear-gradient(135deg,#ff6fa5,#ffb6c1);
  color:white;
  padding:50px 20px 20px;
}

.footer-container{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:30px;
}

.footer-box h3{
  margin-bottom:15px;
  font-size:24px;
}

.footer-box p{
  line-height:1.8;
  color:#fff;
}

.footer-box a{
  display:block;
  text-decoration:none;
  color:white;
  margin-bottom:10px;
  transition:0.3s;
}

.footer-box a:hover{
  transform:translateX(5px);
}

.socials{
  display:flex;
  gap:12px;
  margin-top:10px;
}

.socials a{
  width:45px;
  height:45px;
  background:rgba(255,255,255,0.2);
  border-radius:50%;
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:20px;
}

.footer-bottom{
  margin-top:35px;
  text-align:center;
  border-top:1px solid rgba(255,255,255,0.3);
  padding-top:15px;
  font-size:15px;
}

.logout-btn{
    background:red;
    color:white;
    padding:10px 20px;
    text-decoration:none;
    border-radius:5px;
}

.logout-btn:hover{
    background:darkred;
}
.bell{

position:relative;
font-size:30px;
cursor:pointer;
text-decoration:none;
color:black;
margin-right:15px;

}


.bell span{

position:absolute;

top:22px;
right:-12px;

background:red;
color:white;

font-size:13px;
font-weight:bold;

width:22px;
height:22px;

border-radius:50%;

display:flex;
align-items:center;
justify-content:center;

}
.stock-alert{

display:none;
position:absolute;
right:40px;
top:90px;
width:420px;
background:white;
padding:20px;
border-radius:20px;
box-shadow:0 5px 20px rgba(0,0,0,0.2);
z-index:999;

}

.stock-alert h2{

color:#ff4f81;
margin-bottom:15px;

}


.alert{

padding:15px;
border-radius:12px;
margin:10px 0;
font-weight:bold;

}


.low-alert{

background:#fff3cd;
color:#ff9800;

}


.high-alert{

background:#d4edda;
color:#198754;

}


.out-alert{

background:#f8d7da;
color:#dc3545;

}

/* RECENT ORDERS */

.orders-section{

margin:50px 80px;

}

.orders-section h2{

color:#ff4f81;
margin-bottom:20px;

}

.orders-table{

width:100%;
border-collapse:collapse;
background:white;
border-radius:15px;
overflow:hidden;
box-shadow:0 5px 15px rgba(0,0,0,.1);

}

.orders-table th{

background:#ff4f81;
color:white;
padding:15px;

}

.orders-table td{

padding:12px;
text-align:center;
border-bottom:1px solid #eee;

}

.pending{

color:red;
font-weight:bold;

}

.confirmed{

color:green;
font-weight:bold;

}

/* LOW STOCK */

.low-stock{

margin:50px 80px;

}

.low-stock h2{

color:#ff4f81;
margin-bottom:20px;

}

.stock-table{

width:100%;
background:white;
border-collapse:collapse;
border-radius:15px;
overflow:hidden;
box-shadow:0 5px 15px rgba(0,0,0,.1);

}

.stock-table th{

background:#ff9800;
color:white;
padding:15px;

}

.stock-table td{

padding:12px;
text-align:center;
border-bottom:1px solid #eee;

}

.danger{

color:red;
font-weight:bold;

}

.warning{

color:orange;
font-weight:bold;

}
</style>
</head>

<body>

<!-- MENU BUTTON -->

<!-- HORIZONTAL NAVBAR -->

<nav class="navbar">

    <div class="logo">
        🧸 KidsKart
    </div>

    <ul class="nav-links">

        
        <li><a href="admin_login.php">Admin</a></li>

        <li><a href="user_management.php"> Users</a></li>

        <li><a href="inventory_login.php">Inventory</a></li>

        <li><a href="sales.php">Sales</a></li>

        <li><a href="purchases.php">Purchases</a></li>

        <li><a href="admin_orders.php">Orders</a></li>

        <li><a href="reports.php"> Reports</a></li>

        <li><a href="contact.php">Contact</a></li>

        <li>
            <a href="logout.php" class="logout">
                Logout
            </a>
        </li>

    </ul>

</nav>

<!-- MAIN -->

<div class="main">

  <!-- TOPBAR -->

  <div class="topbar">

    <div class="search-box">
       <input type="text"
      id="searchInput"
      placeholder="Search baby products..."
      onkeyup="searchProducts()">
    </div>

    <div class="profile">

<a href="notifications.php" class="bell">

🔔

<span>
<?php echo count($lowItems)+count($outItems)+count($highItems); ?>
</span>

</a>



<span>Welcome User</span>


<img src="https://i.pravatar.cc/100" alt="">


</div>
  </div>

  <!-- HERO -->

  <div class="hero">

    <div>
      <h1>KidsKart Collection 🌸</h1>

      <p>
        Explore premium baby products with cute colors,
        aesthetic styles, and lovable collections for babies.
      </p>
    </div>

  </div>

  <div class="stock-alert" id="stockAlert">


<h2>📦 Inventory Notification</h2>


<?php


foreach($outItems as $item)
{

echo "

<div class='alert out-alert'>

🔴 ".$item['product_name']." is Out of Stock

</div>";

}



foreach($lowItems as $item)
{

echo "

<div class='alert low-alert'>

🟠 ".$item['product_name']."
 is Low Stock
(Only ".$item['quantity']." left)

</div>";

}



foreach($highItems as $item)
{

echo "

<div class='alert high-alert'>

🟢 ".$item['product_name']."
 has High Stock
(".$item['quantity']." available)

</div>";

}



if(count($outItems)==0 && count($lowItems)==0 && count($highItems)==0)
{

echo "No Stock Alerts";

}


?>


</div>
  <!-- DASHBOARD CARDS -->

<div class="cards">

<div class="card">
<h3>👥 Total Users</h3>
<p><?php echo $totalUsers; ?></p>
</div>

<div class="card">
<h3>📦 Products</h3>
<p><?php echo $totalProducts; ?></p>
</div>

<div class="card">
<h3>🛒 Orders</h3>
<p><?php echo $totalOrders; ?></p>
</div>

<div class="card">
<h3>💰 Revenue</h3>
<p>₹<?php echo $revenue; ?></p>
</div>

<div class="card">
<h3>⏳ Pending</h3>
<p><?php echo $pendingOrders; ?></p>
</div>

<div class="card">
<h3>✔ Confirmed</h3>
<p><?php echo $confirmedOrders; ?></p>
</div>

<div class="card">
<h3>🚚 Delivered</h3>
<p><?php echo $deliveredOrders; ?></p>
</div>

<div class="card">
<h3>❌ Cancelled</h3>
<p><?php echo $cancelledOrders; ?></p>
</div>

</div>

<div class="orders-section">

<h2>🛒 Recent Orders</h2>

<table class="orders-table">

<tr>

<th>Order ID</th>
<th>Customer</th>
<th>Product</th>
<th>Quantity</th>
<th>Total</th>
<th>Payment</th>
<th>Status</th>

</tr>

<?php

while($order=mysqli_fetch_assoc($recentOrders))
{

?>

<tr>

<td><?php echo $order['id']; ?></td>

<td>
<?php
echo $order['firstname']." ".$order['lastname'];
?>
</td>

<td><?php echo $order['product_name']; ?></td>

<td><?php echo $order['quantity']; ?></td>

<td>₹<?php echo $order['total']; ?></td>

<td><?php echo $order['payment_method']; ?></td>

<td>

<?php

if($order['status']=="Pending")
{

echo "<span class='pending'>Pending</span>";

}
else
{

echo "<span class='confirmed'>Confirmed</span>";

}

?>

</td>

</tr>

<?php

}

?>

</table>

</div>

<div class="low-stock">

<h2>⚠️ Low Stock Products</h2>

<table class="stock-table">

<tr>

<th>ID</th>

<th>Product Name</th>

<th>Category</th>

<th>Price</th>

<th>Quantity</th>

</tr>

<?php

while($product=mysqli_fetch_assoc($lowStockProducts))
{

?>

<tr>

<td><?php echo $product['id']; ?></td>

<td><?php echo $product['product_name']; ?></td>

<td><?php echo $product['category']; ?></td>

<td>₹<?php echo $product['price']; ?></td>

<td>

<?php

if($product['quantity']<=5)
{
    echo "<span class='danger'>".$product['quantity']."</span>";
}
else
{
    echo "<span class='warning'>".$product['quantity']."</span>";
}

?>

</td>

</tr>

<?php

}

?>

</table>

</div>

<!-- PRODUCTS -->

<div class="products">

  <h2>🛍 Baby Product Categories</h2>

  <div id="notFound">
    ❌ Product Not Found
  </div>

  <!-- BATH PRODUCTS -->

  <div class="category">

    <div class="category-title">
      🛁 Bath Products
    </div>

    <div class="product-grid">

      <div class="product">
        <img src="https://media.vyaparify.com/vcards/blogs/95995/Baby-care.jpg">
        <h4>Baby Soap</h4>
        <p>₹199</p>
        <button>Add to Cart</button>
      </div>

      <div class="product">
        <img src="https://www.karobargain.com/wp-content/uploads/2022/02/Johnson-and-Johnson-Baby-Shampoo.png">
        <h4>Baby Shampoo</h4>
        <p>₹349</p>
        <button>Add to Cart</button>
      </div>

    </div>

  </div>

  <!-- BABY CLOTHES -->

  <div class="category">

    <div class="category-title">
      👕 Baby Clothes
    </div>

    <div class="product-grid">

      <div class="product">
        <img src="https://images.unsplash.com/photo-1519238359922-989348752efb?q=80&w=1200&auto=format&fit=crop">
        <h4>Baby Dress</h4>
        <p>₹899</p>
        <button>Add to Cart</button>
      </div>

      <div class="product">
        <img src="uploads\toy1.jpg">
        <h4>Baby Romper</h4>
        <p>₹699</p>
        <button>Add to Cart</button>
      </div>

    </div>

  </div>

  <!-- BABY FOOD -->

  <div class="category">

    <div class="category-title">
      🍼 Baby Food
    </div>

    <div class="product-grid">

      <div class="product">
        <img src="https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?q=80&w=1200&auto=format&fit=crop">
        <h4>Baby Cereal</h4>
        <p>₹299</p>
        <button>Add to Cart</button>
      </div>

      <div class="product">
        <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?q=80&w=1200&auto=format&fit=crop">
        <h4>Fruit Puree</h4>
        <p>₹199</p>
        <button>Add to Cart</button>
      </div>

    </div>

  </div>

</div>

<!-- GALLERY -->

<div class="gallery">

  <h2>✨ Baby Moments</h2>

  <div class="gallery-grid">

    <img src="https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=1200&auto=format&fit=crop">

    <img src="https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=1200&auto=format&fit=crop">

    <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=1200&auto=format&fit=crop">

    <img src="https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?q=80&w=1200&auto=format&fit=crop">

  </div>

</div>
 
<!-- WAVE FOOTER -->

<!-- FOOTER -->

<footer class="footer">

  <div class="footer-container">

    <div class="footer-box">
      <h3>🧸 KidsKart</h3>
      <p>
        Premium baby products with cute collections,
        safe materials, and lovable styles for babies.
      </p>
    </div>

    <div class="footer-box">
      <h3>📌 Quick Links</h3>
      <a href="#">Home</a>
      <a href="#">Products</a>
      <a href="#">Sales</a>
      <a href="#">Contact</a>
    </div>

    <div class="footer-box">
      <h3>📞 Contact</h3>
      <p>Email: babybloom@gmail.com</p>
      <p>Phone: +91 98765 43210</p>
      <p>Location: India</p>
    </div>

    <div class="footer-box">
      <h3>🌸 Follow Us</h3>
      <div class="socials">
        <a href="#">🌐</a>
        <a href="#">📘</a>
        <a href="#">📸</a>
        <a href="#">▶️</a>
      </div>
    </div>

  </div>

  <div class="footer-bottom">
    © 2026 BabyBloom | All Rights Reserved
  </div>

</footer>

<!-- SCRIPT -->


<script>

/* SIDEBAR TOGGLE */


/* SEARCH PRODUCTS */

function searchProducts(){

  let input = document
  .getElementById("searchInput")
  .value
  .toLowerCase();

  let products = document.querySelectorAll(".product");

  let found = false;

  products.forEach(product => {

    let text = product.innerText.toLowerCase();

    if(text.includes(input)){

      product.style.display = "block";
      found = true;

    }else{

      product.style.display = "none";

    }

  });

  if(found){

    document.getElementById("notFound").style.display = "none";

  }else{

    document.getElementById("notFound").style.display = "block";
  }
}

/* SHOW ADMIN DETAILS */

function showAdminSection(){

  let adminSection = document.getElementById("admin");

  adminSection.scrollIntoView({
    behavior:"smooth"
  });

}


function showNotification(){

let box=document.getElementById("stockAlert");


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



</body>
</html>