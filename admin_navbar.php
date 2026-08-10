<?php
if(session_status()==PHP_SESSION_NONE)
{
    session_start();
}
?>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
    margin:0;
    padding:0;
    background:#f5f6fa;
    font-family:Arial,sans-serif;
}
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
</style>

<nav class="navbar">

    <div class="logo">
        🧸 KidsKart
    </div>

    <ul class="nav-links">

        <li><a href="dashboard.php">Home</a></li>

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
