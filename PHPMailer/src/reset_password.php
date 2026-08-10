<?php
session_start();

$conn = new mysqli("localhost", "root", "", "KidsKart");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$otp = $_POST['otp'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password != $confirm_password) {
    echo "<script>
    alert('Passwords do not match');
    window.history.back();
    </script>";
    exit();
}

if (!isset($_SESSION['otp'])) {
    echo "<script>
    alert('OTP Expired');
    window.location.href='forpass.html';
    </script>";
    exit();
}

if ($otp != $_SESSION['otp']) {
    echo "<script>
    alert('Invalid OTP');
    window.history.back();
    </script>";
    exit();
}

$sql = "UPDATE users SET password='$new_password' WHERE email='$email'";

if ($conn->query($sql) === TRUE) {

    unset($_SESSION['otp']);

    echo "<script>
    alert('Password Reset Successful');
    window.location.href='register.html';
    </script>";

} else {

    echo "<script>
    alert('Error Updating Password');
    window.history.back();
    </script>";
}

$conn->close();
?>