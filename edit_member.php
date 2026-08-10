<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];

$result = mysqli_query(
$conn,
"SELECT * FROM team_members WHERE id='$id'"
);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $email = $_POST['password'];
    $role = $_POST['role'];

    if(!empty($_FILES['photo']['name']))
    {
        $photo = $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];

        move_uploaded_file(
            $tmp,
            "uploads/".$photo
        );

        $sql = "UPDATE team_members SET
                name='$name',
                email='$email',
                email='$password',
                role='$role',
                photo='$photo'
                WHERE id='$id'";
    }
    else
    {
        $sql = "UPDATE team_members SET
                name='$name',
                email='$email',
                email='$password',
                role='$role'
                WHERE id='$id'";
    }

    mysqli_query($conn,$sql);

    echo "
    <script>
    alert('Member Updated Successfully');
    window.location='admin.php';
    </script>
    ";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Team Member</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f5f7fb;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.container{
    width:100%;
    max-width:550px;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.back-btn{
    display:inline-block;
    text-decoration:none;
    background:#333;
    color:white;
    padding:10px 18px;
    border-radius:10px;
    margin-bottom:20px;
}

.back-btn:hover{
    background:#000;
}

h2{
    text-align:center;
    color:#ff4f81;
    margin-bottom:25px;
}

.input-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
    color:#444;
}

input[type=text],
input[type=email],
input[type=password]{
    width:100%;
    padding:14px;
    border:2px solid #e5e5e5;
    border-radius:10px;
    font-size:16px;
}

input[type=text]:focus,
input[type=email]:focus,
input[type=password]:focus{
    outline:none;
    border-color:#ff4f81;
}


input[type=file]{
    width:100%;
    padding:12px;
    border:2px dashed #ff4f81;
    border-radius:10px;
    background:#fafafa;
}

.update-btn{
    width:100%;
    background:#ff4f81;
    color:white;
    border:none;
    padding:15px;
    border-radius:10px;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

.update-btn:hover{
    background:#e63d72;
}

</style>

</head>

<body>

<div class="container">

<a href="admin.php" class="back-btn">
← Back
</a>

<h2>Edit Team Member</h2>

<form method="POST" enctype="multipart/form-data">

<div class="input-group">
<label>Name</label>
<input
type="text"
name="name"style
value="<?php echo $row['name']; ?>"
required>
</div>

<div class="input-group">
<label>Email</label>
<input
type="email"
name="email"
value="<?php echo $row['email']; ?>"
required>
</div>

<div class="input-group">
<label>Password</label>
<input
type="password"
name="password"
value="<?php echo $row['password']; ?>"
required>
</div>

<div class="input-group">
<label>Role</label>
<input
type="text"
name="role"
value="<?php echo $row['role']; ?>"
required>
</div>


<div class="input-group">
<label>Upload New Photo</label>

<input
type="file"
name="photo">
</div>

<button
type="submit"
name="update"
class="update-btn">

Update Member

</button>

</form>

</div>

</body>
</html>