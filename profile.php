<?php

session_start();

include "db.php";
include "navbar.php";

if(!isset($_SESSION['user_id']))
{
    header("Location: login.html");
    exit();
}


$user_id=$_SESSION['user_id'];



// UPDATE PROFILE

if(isset($_POST['save']))
{


$name=$_POST['name'];

$phone=$_POST['phone'];

$address=$_POST['address'];



if(mysqli_query($conn,

"UPDATE users SET

firstname='$name',

phone='$phone',

address='$address'

WHERE id='$user_id'"))
{
    echo "<script>alert('Profile updated successfully!');</script>";
}


}



$user=mysqli_fetch_assoc(

mysqli_query($conn,

"SELECT * FROM users WHERE id='$user_id'")

);
?>
<!DOCTYPE html>
<html>
<head>

<title>My Profile</title>

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
    width:100%;
    display:flex;
    justify-content:center;
    padding:30px 15px;
}

.profile-card{
    width:100%;
    max-width:620px;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 5px 18px rgba(0,0,0,.15);
}

.top{
    background:linear-gradient(135deg,#ff6fa5,#ff4f81);
    text-align:center;
    color:white;
    padding:22px;
}

.avatar{
    width:85px;
    height:85px;
    border-radius:50%;
    border:4px solid white;
    object-fit:cover;
    background:white;
}

.top h2{
    margin-top:10px;
    font-size:24px;
}

.top p{
    margin-top:5px;
    font-size:14px;
}

.content{
    padding:25px;
}

.email-box{
    background:#fff0f6;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

.row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

label{
    display:block;
    margin-bottom:5px;
    font-weight:bold;
    color:#555;
    font-size:14px;
}

input,
textarea{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
    font-size:14px;
    margin-bottom:15px;
}

textarea{
    resize:none;
    height:75px;
}

.save-btn{
    width:100%;
    padding:12px;
    background:#ff4f81;
    color:white;
    border:none;
    border-radius:25px;
    cursor:pointer;
    font-size:15px;
}

.save-btn:hover{
    background:#ff2d6d;
}

.password-box{
    margin-top:25px;
    border-top:1px solid #eee;
    padding-top:20px;
}

.password-box h3{
    color:#ff4f81;
    margin-bottom:15px;
}

.pass-group{
    position:relative;
}

.eye{
    position:absolute;
    right:15px;
    top:30px;
    cursor:pointer;
    font-size:16px;
}

.pass-btn{
    width:100%;
    padding:12px;
    background:#444;
    color:white;
    border:none;
    border-radius:25px;
    cursor:pointer;
    font-size:15px;
}

.pass-btn:hover{
    background:black;
}

@media(max-width:650px){

.row{
    grid-template-columns:1fr;
}

}

</style>

</head>

<body>

<div class="container">

<div class="profile-card">

<div class="top">

<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="avatar">

<h2><?php echo htmlspecialchars($user['firstname']); ?></h2>

<p><?php echo htmlspecialchars($user['email']); ?></p>

</div>

<div class="content">

<div class="email-box">

<b>Email Address</b>

<br><br>

<?php echo htmlspecialchars($user['email']); ?>

</div>

<form method="POST">

<div class="row">

<div>

<label>Full Name</label>

<input
type="text"
name="name"
value="<?php echo htmlspecialchars($user['firstname']); ?>"
required>

</div>

<div>

<label>Phone Number</label>

<input
type="text"
name="phone"
value="<?php echo htmlspecialchars($user['phone']); ?>"
required>

</div>

</div>

<label>Address</label>

<textarea
name="address"
placeholder="Enter your address"><?php echo htmlspecialchars($user['address']); ?></textarea>

<button
type="submit"
name="save"
class="save-btn">
💾 Save Profile
</button>

</form>

<div class="password-box">

<h3>🔒 Change Password</h3>

<form action="change_password.php" method="POST">

<div class="pass-group">

<label>Current Password</label>

<input
type="password"
name="current_password"
id="current_password"
required>

<span
class="eye"
onclick="togglePassword('current_password',this)">
👁️
</span>

</div>

<div class="pass-group">

<label>New Password</label>

<input
type="password"
name="new_password"
id="new_password"
required>

<span
class="eye"
onclick="togglePassword('new_password',this)">
👁️
</span>

</div>

<div class="pass-group">

<label>Confirm Password</label>

<input
type="password"
name="confirm_password"
id="confirm_password"
required>

<span
class="eye"
onclick="togglePassword('confirm_password',this)">
👁️
</span>

</div>

<button
type="submit"
class="pass-btn">

🔑 Update Password

</button>

</form>

</div>

</div>

</div>

</div>

<script>

function togglePassword(id,icon)
{
    let input=document.getElementById(id);

    if(input.type==="password")
    {
        input.type="text";
        icon.innerHTML="🙈";
    }
    else
    {
        input.type="password";
        icon.innerHTML="👁️";
    }
}

</script>

</body>

</html>
