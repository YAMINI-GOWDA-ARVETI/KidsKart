<?php

session_start();
include "db.php";

if(!isset($_SESSION['user_id']))
{
    header("Location:login.html");
    exit();
}

$user_id=$_SESSION['user_id'];

$current=$_POST['current_password'];
$new=$_POST['new_password'];
$confirm=$_POST['confirm_password'];

$result=mysqli_query($conn,
"SELECT password FROM users WHERE id='$user_id'");

$user=mysqli_fetch_assoc($result);

if(!$user)
{
    echo "<script>
    alert('User not found');
    window.location='profile.php';
    </script>";
    exit();
}

// Check current password
if(!password_verify($current,$user['password']))
{
    echo "<script>
    alert('Current Password is incorrect');
    window.location='profile.php';
    </script>";
    exit();
}

// Check new passwords match
if($new!=$confirm)
{
    echo "<script>
    alert('New Password and Confirm Password do not match');
    window.location='profile.php';
    </script>";
    exit();
}

// Hash new password
$newPassword=password_hash($new,PASSWORD_DEFAULT);

// Update password
mysqli_query($conn,
"UPDATE users
SET password='$newPassword'
WHERE id='$user_id'");

echo "<script>
alert('Password Changed Successfully');
window.location='profile.php';
</script>";

?>