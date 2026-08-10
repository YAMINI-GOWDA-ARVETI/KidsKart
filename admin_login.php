<?php
session_start();
include "db.php";

$error="";

if(isset($_POST['login']))
{
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1)
    {
        $row = mysqli_fetch_assoc($result);

        if($password === $row['password'])
        {
            $_SESSION['admin'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['name'];

            header("Location: admin.php");
            exit();
        }
        else
        {
            $error = "Invalid Password";
        }
    }
    else
    {
        $error = "Admin Not Found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(
135deg,
#e6b2c3,
#ffd6e7,
#ffc0d9
);
}

.box{
width:420px;
background:white;
padding:40px;
border-radius:25px;
box-shadow:0 10px 30px rgba(255,79,129,0.25);
}

.admin-icon{
text-align:center;
font-size:60px;
margin-bottom:10px;
}

h2{
text-align:center;
color:#ff4f81;
margin-bottom:25px;
font-size:30px;
}

input{
width:100%;
padding:14px;
margin:12px 0;
border:2px solid #ffd6e7;
border-radius:12px;
font-size:15px;
outline:none;
transition:.3s;
}

input:focus{
border-color:#ff4f81;
box-shadow:0 0 10px rgba(255,79,129,.3);
}

button{
width:100%;
padding:14px;
background:#ff4f81;
color:white;
border:none;
border-radius:12px;
font-size:16px;
font-weight:bold;
cursor:pointer;
transition:.3s;
}

button:hover{
background:#e63d72;
transform:translateY(-2px);
}

.error{
color:red;
text-align:center;
margin-top:15px;
font-weight:bold;
}

.login-text{
text-align:center;
color:#777;
margin-bottom:20px;
font-size:14px;
}

</style>
</head>

<body>

<div class="box">
<div class="admin-icon">🌸</div>

<h2>KidsKart Admin</h2>

<p class="login-text">
Authorized Admin Access Only
</p>

<form method="POST">

<input
type="email"
name="email"
placeholder="Enter Admin Email"
required>

<input
type="password"
name="password"
placeholder="Enter Password"
required>

<button type="submit" name="login">
Login
</button>

</form>

<?php
if($error!="")
{
    echo "<p class='error'>$error</p>";
}
?>

</div>

</body>
</html>