<?php

include "db.php";

if(!isset($_GET['id'])){
    die("User ID not found");
}

$id = $_GET['id'];

$result = $conn->query(
    "SELECT * FROM users WHERE id='$id'"
);

if($result->num_rows == 0){
    die("User not found");
}

$user = $result->fetch_assoc();

if(isset($_POST['update'])){

    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $phone     = $_POST['phone'];
    $email     = $_POST['email'];

    $sql = "UPDATE users SET
            firstname='$firstname',
            lastname='$lastname',
            phone='$phone',
            email='$email'
            WHERE id='$id'";

    if($conn->query($sql) === TRUE){

        echo "<script>
        alert('User Updated Successfully');
        window.location.href='user_management.php';
        </script>";

        exit();

    }else{

        echo "Update Failed: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#ff4f81
}

.container{
    width:450px;
    background:#fff;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.25);
}

h2{
    text-align:center;
    color:#ff4f91;
    margin-bottom:25px;
}

.input-group{
    margin-bottom:15px;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:600;
    color:#333;
}

input{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:10px;
    font-size:15px;
}

input:focus{
    outline:none;
    border-color:#0d6efd;
    box-shadow:0 0 8px rgba(13,110,253,0.4);
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background: #ff4f81c0;
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

button:hover{
    transform:translateY(-2px);
}

.back{
    text-align:center;
    margin-top:15px;
}

.back a{
    text-decoration:none;
    color:#ff8c00;
    font-weight:bold;
}

.back a:hover{
    text-decoration:underline;
}

</style>
</head>

<body>

<div class="container">

<h2>Edit User</h2>

<form method="POST">

<div class="input-group">
<label>First Name</label>
<input
type="text"
name="firstname"
value="<?php echo $user['firstname']; ?>"
required>
</div>

<div class="input-group">
<label>Last Name</label>
<input
type="text"
name="lastname"
value="<?php echo $user['lastname']; ?>"
required>
</div>

<div class="input-group">
<label>Phone</label>
<input
type="text"
name="phone"
value="<?php echo $user['phone']; ?>"
required>
</div>

<div class="input-group">
<label>Email</label>
<input
type="email"
name="email"
value="<?php echo $user['email']; ?>"
required>
</div>

<button type="submit" name="update">
Update User
</button>

<div class="back">
<a href="user_management.php">
← Back to User Management
</a>
</div>

</form>

</div>

</body>
</html>