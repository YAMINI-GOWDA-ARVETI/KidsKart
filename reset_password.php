<?php
session_start();

header("Content-Type: application/json");

if(
!isset($_SESSION['verified'])
||
$_SESSION['verified'] !== true
){
    echo json_encode([
        "success"=>false,
        "message"=>"OTP not verified"
    ]);
    exit;
}

$conn = new mysqli(
"localhost",
"root",
"",
"kidskart"
);

if($conn->connect_error){

    echo json_encode([
        "success"=>false
    ]);
    exit;
}

$data =
json_decode(
file_get_contents("php://input"),
true
);

$password =
password_hash(
$data['password'],
PASSWORD_DEFAULT
);

$email = $_SESSION['email'];

$stmt =
$conn->prepare(
"UPDATE users
 SET password=?
 WHERE email=?"
);

$stmt->bind_param(
"ss",
$password,
$email
);

if($stmt->execute()){

    unset($_SESSION['otp']);
    unset($_SESSION['otp_time']);
    unset($_SESSION['verified']);
    unset($_SESSION['email']);

    echo json_encode([
        "success"=>true
    ]);

}else{

    echo json_encode([
        "success"=>false
    ]);
}

$stmt->close();
$conn->close();
?>