<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location:login.html");
    exit();
}

include "db.php";

/* ---------------- Monthly Sales ---------------- */

$salesLabels=[];
$salesData=[];

$sales=mysqli_query($conn,"
SELECT
MONTHNAME(order_date) month,
SUM(total) total
FROM orders
WHERE status='Confirmed'
GROUP BY MONTH(order_date)
ORDER BY MONTH(order_date)
");

while($row=mysqli_fetch_assoc($sales))
{
    $salesLabels[]=$row['month'];
    $salesData[]=$row['total'];
}

/* ---------------- Monthly Purchases ---------------- */

$purchaseLabels=[];
$purchaseData=[];

$purchase=mysqli_query($conn,"
SELECT
MONTHNAME(purchase_date) month,
SUM(total_amount) total
FROM purchases
GROUP BY MONTH(purchase_date)
ORDER BY MONTH(purchase_date)
");

while($row=mysqli_fetch_assoc($purchase))
{
    $purchaseLabels[]=$row['month'];
    $purchaseData[]=$row['total'];
}

/* ---------------- Top Selling Products ---------------- */

$productLabels=[];
$productData=[];

$top=mysqli_query($conn,"
SELECT
product_name,
SUM(quantity) sold
FROM orders
GROUP BY product_name
ORDER BY sold DESC
LIMIT 10
");

while($row=mysqli_fetch_assoc($top))
{
    $productLabels[]=$row['product_name'];
    $productData[]=$row['sold'];
}

/* ---------------- Low Stock ---------------- */

$stockLabels=[];
$stockData=[];

$stock=mysqli_query($conn,"
SELECT
product_name,
quantity
FROM inventory
WHERE quantity<=10
ORDER BY quantity ASC
");

while($row=mysqli_fetch_assoc($stock))
{
    $stockLabels[]=$row['product_name'];
    $stockData[]=$row['quantity'];
}

/* ---------------- Revenue ---------------- */

$sales = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT IFNULL(SUM(total),0) total FROM orders WHERE status='Confirmed'"));

$purchases = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT IFNULL(SUM(total_amount),0) total FROM purchases"));

$totalSales = $sales['total'];
$totalPurchase = $purchases['total'];
$revenue = $totalSales - $totalPurchase;

/* ---------------- Order Status ---------------- */

$statusLabel=[];
$statusData=[];

$status=mysqli_query($conn,"
SELECT
status,
COUNT(*) total
FROM orders
GROUP BY status
");

while($row=mysqli_fetch_assoc($status))
{
    $statusLabel[]=$row['status'];
    $statusData[]=$row['total'];
}
?>
<!DOCTYPE html>
<html>

<head>

<title>Reports Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:"Segoe UI", sans-serif;
}

body{
background:#f6f7fb;
color:#333;
}

/* PAGE WRAPPER */
.container{
width:95%;
margin:auto;
padding:25px;
}

/* TITLE */
h1{
text-align:center;
font-size:34px;
color:#ff4f81;
margin-bottom:25px;
font-weight:700;
}

/* GRID LAYOUT */
.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
gap:20px;
}

/* CARD DESIGN */
.card{
background:#fff;
border-radius:18px;
padding:20px;
box-shadow:0 6px 18px rgba(0,0,0,0.08);
transition:0.3s;
}

.card:hover{
transform:translateY(-5px);
box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.card h2{
font-size:18px;
margin-bottom:15px;
color:#ff4f81;
}

/* CHART SIZE */
canvas{
max-height:240px !important;
width:100% !important;
}

/* REVENUE BOX */
.revenue{
display:flex;
gap:15px;
justify-content:space-between;
flex-wrap:wrap;
}

.box{
flex:1;
min-width:120px;
background:linear-gradient(135deg,#ffe3ec,#fff);
padding:15px;
border-radius:12px;
text-align:center;
border:1px solid #ffd1dc;
}

.box h2{
font-size:14px;
color:#666;
margin-bottom:8px;
}

.box h3{
font-size:22px;
color:#ff4f81;
}

/* RESPONSIVE */
@media(max-width:768px){

.container{
padding:15px;
}

h1{
font-size:26px;
}

.revenue{
flex-direction:column;
}

.card{
padding:15px;
}

canvas{
max-height:200px !important;
}
}
</style>

</head>

<body>
<?php include "admin_navbar.php";?>
<div class="container">

<h1>📊 Reports Dashboard</h1>

<div class="grid">

<div class="card">

<h2>Monthly Sales</h2>

<canvas id="salesChart"></canvas>

</div>

<div class="card">

<h2>Monthly Purchases</h2>

<canvas id="purchaseChart"></canvas>

</div>

<div class="card">

<h2>Top Selling Products</h2>

<canvas id="productChart"></canvas>

</div>

<div class="card">

<h2>Low Stock Products</h2>

<canvas id="stockChart"></canvas>

</div>

<div class="card">

<h2>Revenue Report</h2>

<div class="revenue">

<div class="box">

<h2>Total Sales</h2>

<h3>₹<?php echo number_format($totalSales); ?></h3>

</div>

<div class="box">

<h2>Total Purchases</h2>

<h3>₹<?php echo number_format($totalPurchase); ?></h3>

</div>

<div class="box">

<h2>Profit</h2>

<h3>₹<?php echo number_format($revenue); ?></h3>

</div>

</div>

</div>

<div class="card">

<h2>Order Status</h2>

<canvas id="statusChart"></canvas>

</div>

</div>
<script>

// ---------------- Monthly Sales ----------------

new Chart(document.getElementById("salesChart"),{

type:"line",

data:{

labels:<?php echo json_encode($salesLabels); ?>,

datasets:[{

label:"Monthly Sales",

data:<?php echo json_encode($salesData); ?>,

borderWidth:3,

fill:false,

tension:0.3

}]

},

options:{

responsive:true,

plugins:{
legend:{
display:true
}
}

}

});

// ---------------- Monthly Purchases ----------------

new Chart(document.getElementById("purchaseChart"),{

type:"bar",

data:{

labels:<?php echo json_encode($purchaseLabels); ?>,

datasets:[{

label:"Monthly Purchases",

data:<?php echo json_encode($purchaseData); ?>,

borderWidth:1

}]

},

options:{

responsive:true,

scales:{

y:{

beginAtZero:true

}

}

}

});

</script>
<script>

// ================= TOP SELLING PRODUCTS =================

new Chart(document.getElementById("productChart"),{

type:"bar",

data:{

labels:<?php echo json_encode($productLabels); ?>,

datasets:[{

label:"Products Sold",

data:<?php echo json_encode($productData); ?>,

borderWidth:1

}]

},

options:{

responsive:true,

indexAxis:'y',

scales:{
x:{
beginAtZero:true
}
}

}

});

// ================= LOW STOCK PRODUCTS =================

new Chart(document.getElementById("stockChart"),{

type:"bar",

data:{

labels:<?php echo json_encode($stockLabels); ?>,

datasets:[{

label:"Stock Available",

data:<?php echo json_encode($stockData); ?>,

borderWidth:1

}]

},

options:{

responsive:true,

scales:{
y:{
beginAtZero:true
}
}

}

});

// ================= ORDER STATUS =================

new Chart(document.getElementById("statusChart"),{

type:"pie",

data:{

labels:<?php echo json_encode($statusLabel); ?>,

datasets:[{

data:<?php echo json_encode($statusData); ?>

}]

},

options:{

responsive:true,

plugins:{

legend:{
position:"bottom"
}

}

}

});

</script>
</div>

</body>
</html>