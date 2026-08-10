<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BabyBloom Admin Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f5f7fb;
}

/* MAIN */
.main{
    padding:30px;
}

/* BACK BUTTON */
.top-actions{
    display:flex;
    justify-content:flex-end;
    margin-bottom:20px;
}

.back-btn{
    text-decoration:none;
    background:#ff4f81;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    font-weight:bold;
    transition:0.3s;
}
.logout-btn{
    text-decoration:none;
    background:#333;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    font-weight:bold;
    margin-left:10px;
    transition:0.3s;
}

.logout-btn:hover{
    background:#000;
}

.back-btn:hover{
    background:#e63d72;
}

/* ADMIN HEADER */.admin-title{
    display:inline-block;
    background:#ff4f81;
    color:white;
    padding:8px 20px;
    border-radius:12px;
    margin-bottom:20px;
    font-size:14px;
    font-weight:bold;
    letter-spacing:1px;

    /* 👇 THIS MAKES IT SMALL WIDTH */
    width:auto;
}

/* PROFILE */
.profile{
    background:white;
    border-radius:20px;
    padding:25px;
    display:flex;
    align-items:center;
    gap:25px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.profile img{
    width:140px;
    height:140px;
    border-radius:50%;
    border:5px solid #ff4f81;
    object-fit:cover;
    object-position:center;
}

.profile h2{
    color:#ff4f81;
    margin-bottom:10px;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.card h3{
    color:#ff4f81;
    margin-bottom:10px;
}

.card p{
    font-size:28px;
    font-weight:bold;
    color:#333;
}

/* TEAM SECTION */
.team-section{
    margin-top:50px;
}

.team-section h2{
    color:#ff4f81;
    margin-bottom:25px;
}

.team-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
    gap:20px;
    margin-top:20px;
}

.member-card{
    background:white;
    border-radius:20px;
    padding:20px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:.3s;
    width:100%;
    max-width:350px;
    margin:auto;
}

.member-card:hover{
    transform:translateY(-5px);
}

.member-card img{
    width:100px;
    height:100px;
    border-radius:50%;
    border:4px solid #ff4f81;
    object-fit:cover;
    margin-bottom:10px;
}

.member-card h3{
    color:#ff4f81;
    margin-bottom:10px;
}

.member-card p{
    margin:5px 0;
    word-wrap:break-word;
}

.member-actions{
    margin-top:15px;
    display:flex;
    justify-content:center;
    gap:10px;
}

.edit-btn{
    text-decoration:none;
    background:#28a745;
    color:white;
    padding:8px 15px;
    border-radius:8px;
}

.delete-btn{
    text-decoration:none;
    background:#dc3545;
    color:white;
    padding:8px 15px;
    border-radius:8px;
}

.edit-btn:hover{
    background:#218838;
}

.delete-btn:hover{
    background:#c82333;
}
</style>
</head>

<body>
<?php include "admin_navbar.php";?>
<div class="main">

    <!-- BACK BUTTON -->
     <div class="top-actions">

    <a href="dashboard.php" class="back-btn">
        Logout
    </a>

    <!-- <a href="admin_logout.php" class="logout-btn">
        Logout
    </a> -->

</div>

    <!-- ADMIN TITLE -->
    <div class="admin-title">
        ADMIN PANEL
    </div>

    

    <!-- ADMIN PROFILE -->
    <div class="profile">

        <img src="https://mooddp.com/wp-content/uploads/2025/12/best-anime-avatar.jpg">

        <div>
            <h2>Ganjikunta Swapna</h2>
            <p><b>Role:</b> Super Admin</p>
            <p><b>Location:</b> Andhra Pradesh, India</p>
        </div>

    </div>

    <!-- DASHBOARD CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Total Users</h3>
            <p>1250</p>
        </div>

        <div class="card">
            <h3>Total Orders</h3>
            <p>340</p>
        </div>

        <div class="card">
            <h3>Total Products</h3>
            <p>560</p>
        </div>

        <div class="card">
            <h3>Total Sales</h3>
            <p>₹50,000</p>
        </div>

    </div>

    <div style="margin:50px 0;">

    <a href="add_member.php"
    style="
    background:#ff4f81;
    color:white;
    padding:12px 20px;
    text-decoration:none;
    border-radius:10px;
    font-weight:bold;
    ">

    + Add Member

    </a>

    </div>

    <!-- TEAM MEMBERS -->
    <?php include "db.php"; ?>

<div class="team-section">

<h2>👥 Team Members</h2>

<div class="team-grid">

<?php

$result =
$conn->query(
"SELECT * FROM team_members"
);

while(
$row =
$result->fetch_assoc()
)
{
?>

 <div class="member-card">

<img
src="uploads/<?php
echo $row['photo'];
?>">

<h3>
<?php
echo $row['name'];
?>
</h3>

<p>
<b>Email:</b>
<?php
echo $row['email'];
?>
</p>

<p>
<b>Role:</b>
<?php
echo $row['role'];
?>
</p>

<p>
<?php
echo $row['description'];
?>
</p>

<div class="member-actions">

<a href="edit_member.php?id=<?php echo $row['id']; ?>" class="edit-btn">
    Edit
</a>

<a href="delete_member.php?id=<?php echo $row['id']; ?>"
class="delete-btn"
onclick="return confirm('Are you sure you want to delete this member?')">
    Delete
</a>

</div>
</div>

<?php
}
?>

</div>

</div>

</div>

</body>
</html>