<?php

session_start();
include "db.php";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    /* Check Admin */

    $admin = $conn->query(
    "SELECT * FROM admin
    WHERE email='$email'
    AND password='$password'"
    );

    if($admin->num_rows > 0)
    {
        $_SESSION['inventory_access'] = true;
        $_SESSION['user_type'] = 'admin';

        header("Location: inventory.php");
        exit();
    }

    /* Check Team Members */

    $member = $conn->query(
    "SELECT * FROM team_members
    WHERE email='$email'
    AND password='$password'"
    );

    if($member->num_rows > 0)
    {
        $_SESSION['inventory_access'] = true;
        $_SESSION['user_type'] = 'team_member';

        header("Location: inventory.php");
        exit();
    }

    $error = "Invalid Email or Password";
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>KidsKart Inventory Login</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#fff7fb;
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
padding:20px;
}

.login-box{
width:420px;
background:#fff;
padding:35px;
border-radius:25px;
box-shadow:0 10px 30px rgba(255,111,165,.15);
border-top:8px solid #ff4f91;
}

.logo{
text-align:center;
margin-bottom:20px;
}

.logo h1{
color:#ff4f91;
font-size:34px;
margin-bottom:5px;
}

.logo p{
color:#777;
font-size:14px;
}

.input-group{
margin-bottom:18px;
}

label{
display:block;
margin-bottom:6px;
font-weight:600;
color:#555;
}

input{
width:100%;
padding:14px;
border:2px solid #ffd6e7;
border-radius:12px;
font-size:15px;
outline:none;
transition:.3s;
}

input:focus{
border-color:#ff6fa5;
box-shadow:0 0 10px rgba(255,111,165,.15);
}

.login-btn{
width:100%;
padding:14px;
background:#ff4f91;
border:none;
border-radius:12px;
color:white;
font-size:16px;
font-weight:bold;
cursor:pointer;
transition:.3s;
}

.login-btn:hover{
background:#e84384;
}

.error{
background:#ffe5ec;
color:#d6336c;
padding:12px;
border-radius:10px;
margin-bottom:15px;
text-align:center;
font-weight:600;
}

.footer{
text-align:center;
margin-top:15px;
font-size:13px;
color:#777;
}

.footer span{
color:#ff4f91;
font-weight:bold;
}

</style>

</head>
<body>

<div class="login-box">

<div class="logo">
<h1>🧸 KidsKart</h1>
<p>Inventory Management Login</p>
</div>

<?php
if(isset($error))
{
    echo "<div class='error'>$error</div>";
}
?>

<form method="POST">

<div class="input-group">
<label>Email Address</label>
<input
type="email"
name="email"
placeholder="Enter Email"
required>
</div>

<div class="input-group">
<label>Password</label>
<input
type="password"
name="password"
placeholder="Enter Password"
required>
</div>

<button
type="submit"
name="login"
class="login-btn">
Login
</button>

</form>

<div class="footer">
Only <span>Admins</span> and
<span>Team Members</span>
can access Inventory
</div>

</div>

</body>
</html>