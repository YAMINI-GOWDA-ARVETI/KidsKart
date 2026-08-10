<?php
session_start();

header("Content-Type: application/json");

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$userOtp = $data['otp'] ?? '';

if(!isset($_SESSION['otp'])){

    echo json_encode([
        "success"=>false,
        "message"=>"No OTP found"
    ]);
    exit;
}

/* CHECK OTP EXPIRY FIRST */

if(
    !isset($_SESSION['otp_time']) ||
    (time() - $_SESSION['otp_time']) > 60
){

    unset($_SESSION['otp']);
    unset($_SESSION['otp_time']);
    unset($_SESSION['verified']);
    unset($_SESSION['email']);

    echo json_encode([
        "success"=>false,
        "message"=>"OTP Expired"
    ]);
    exit;
}

if(!isset($_SESSION['otp_attempts'])){
    $_SESSION['otp_attempts'] = 0;
}

if($_SESSION['otp_attempts'] >= 5){

    echo json_encode([
        "success"=>false,
        "message"=>"Maximum OTP attempts reached"
    ]);
    exit;
}

/* THEN CHECK OTP */

if($userOtp == $_SESSION['otp']){

    $_SESSION['verified'] = true;
    $_SESSION['otp_attempts'] = 0;

    echo json_encode([
        "success"=>true,
        "message"=>"OTP Verified"
    ]);

}else{

    $_SESSION['otp_attempts']++;
    echo json_encode([
        "success"=>false,
        "message"=>"Invalid OTP"
    ]);
}
?>