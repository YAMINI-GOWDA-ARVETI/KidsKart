<?php
include "db.php";

$result = mysqli_query($conn,"SELECT * FROM admin_details WHERE id=1");
$admin = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $name = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $admin_id = $_POST['admin_id'];
    $location = $_POST['location'];
    $access_level = $_POST['access_level'];

    $photo = $admin['photo'];

    if(!empty($_FILES['photo']['name']))
    {
        $filename = time().'_'.$_FILES['photo']['name'];

        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            'uploads/'.$filename
        );

        $photo = 'uploads/'.$filename;
    }

    $stmt = $conn->prepare(
        "UPDATE admin_details
        SET
        name=?,
        role=?,
        email=?,
        phone=?,
        admin_id=?,
        location=?,
        access_level=?,
        photo=?
        WHERE id=1"
    );

    $stmt->bind_param(
        "ssssssss",
        $name,
        $role,
        $email,
        $phone,
        $admin_id,
        $location,
        $access_level,
        $photo
    );

    $stmt->execute();

    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Admin</title>

<style>

body{
    background:#fff4f8;
    font-family:Arial,sans-serif;
    padding:30px;
}

.container{
    max-width:700px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    color:#ff4f81;
    margin-bottom:25px;
}

label{
    display:block;
    margin-top:15px;
    font-weight:bold;
}

input{
    width:100%;
    padding:12px;
    margin-top:5px;
    border:1px solid #ddd;
    border-radius:10px;
}

.profile-img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    display:block;
    margin:0 auto 20px;
}

button{
    width:100%;
    padding:14px;
    margin-top:20px;
    border:none;
    border-radius:10px;
    background:#ff4f81;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    opacity:0.9;
}

</style>

</head>
<body>

<div class="container">

<h2>Edit Admin Details</h2>

<img
src="<?php echo $admin['photo']; ?>"
class="profile-img"
alt="Admin">

<form method="POST" enctype="multipart/form-data">

<label>Name</label> <input
type="text"
name="name"
value="<?php echo $admin['name']; ?>"
required>

<label>Role</label> <input
type="text"
name="role"
value="<?php echo $admin['role']; ?>"
required>

<label>Email</label> <input
type="email"
name="email"
value="<?php echo $admin['email']; ?>"
required>

<label>Phone</label> <input
type="text"
name="phone"
value="<?php echo $admin['phone']; ?>"
required>

<label>Admin ID</label> <input
type="text"
name="admin_id"
value="<?php echo $admin['admin_id']; ?>"
required>

<label>Location</label> <input
type="text"
name="location"
value="<?php echo $admin['location']; ?>"
required>

<label>Access Level</label> <input
type="text"
name="access_level"
value="<?php echo $admin['access_level']; ?>"
required>

<label>Profile Photo</label> <input
type="file"
name="photo">

<button
type="submit"
name="update">
Update Admin </button>

</form>

</div>

</body>
</html>
