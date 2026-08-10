<?php

include "db.php";

$name = mysqli_real_escape_string($conn,$_POST['name']);
$email = mysqli_real_escape_string($conn,$_POST['email']);
$subject = mysqli_real_escape_string($conn,$_POST['subject']);
$message = mysqli_real_escape_string($conn,$_POST['message']);

$sql="INSERT INTO contact_messages
(name,email,subject,message)
VALUES
('$name','$email','$subject','$message')";

if(mysqli_query($conn,$sql))
{
    echo "<script>
    alert('Message Sent Successfully!');
    window.location='contact_us.php';
    </script>";
}
else
{
    echo "<script>
    alert('Something went wrong!');
    window.history.back();
    </script>";
}

?>