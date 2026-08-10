<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}

include "db.php";

if(isset($_POST['add']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $description = $_POST['description'];

    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    move_uploaded_file(
        $tmp,
        "uploads/".$photo
    );

    $sql = "INSERT INTO team_members
    (name,email,password,role,description,photo)
    VALUES
    (
        '$name',
        '$email',
        '$password',
        '$role',
        '$description',
        '$photo'
    )";

    if($conn->query($sql))
    {
        echo "<script>
        alert('Member Added Successfully');
        window.location='admin.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Team Member</title>

<style>

body{
    background:#f5f7fb;
    font-family:'Segoe UI',sans-serif;
    margin:0;
    padding:20px 0;
}

.container{
    width:50%;
    max-width:450px;
    margin:auto;
    background:#fff;
    padding:20px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

h2{
    text-align:center;
    color:#ff4f81;
    font-size:32px;
    margin-bottom:25px;
}

form{
    display:flex;
    flex-direction:column;
    gap:12px;
}

input[type="text"],
input[type="email"],
input[type="password"],
textarea{
    width:100%;
    padding:14px;
    border:2px solid #e5e5e5;
    border-radius:12px;
    font-size:16px;
    box-sizing:border-box;
}

textarea{
    height:80px;
    resize:none;
}

.file-box{
    padding:12px;
    border:2px dashed #ff4f81;
    border-radius:12px;
}

button{
    background:#ff4f81;
    color:white;
    border:none;
    padding:14px;
    font-size:18px;
    border-radius:12px;
    cursor:pointer;
}

button:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(255,79,129,0.3);
}

button:active{
    transform:scale(.98);
}

.back-btn{
    display:inline-block;
    text-decoration:none;
    background:#333;
    color:white;
    padding:10px 20px;
    border-radius:10px;
    margin-bottom:px;
}

.back-btn:hover{
    background:#000;
}
</style>

</head>
<body>

<div class="container">

<a href="admin.php" class="back-btn">← Back to Admin</a>
<h2>Add Team Member</h2>

<form method="POST" enctype="multipart/form-data">

<input
type="text"
name="name"
placeholder="Name"
required>

<input
type="email"
name="email"
placeholder="Email"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<input
type="text"
name="role"
placeholder="Role"
required>

<textarea
name="description"
placeholder="Description">
</textarea>

<div class="file-box">
    <input type="file" name="photo" required>
</div>

<button
type="submit"
name="add">
Add Member
</button>

</form>

</div>

</body>
</html>