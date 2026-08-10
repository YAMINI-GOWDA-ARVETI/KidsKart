<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';

if(empty($email)){
    echo json_encode(["success"=>false]);
    exit;
}

$conn = new mysqli(
"localhost",
"root",
"",
"kidskart"
);

$stmt = $conn->prepare(
"SELECT id FROM users WHERE email=?"
);

$stmt->bind_param("s",$email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){

    echo json_encode([
        "success"=>false,
        "error"=>"Email not registered"
    ]);
    exit;
}

$otp = rand(100000,999999);

$_SESSION['otp'] = $otp;
$_SESSION['email'] = $email;
$_SESSION['otp_time'] = time();
$_SESSION['otp_attempts'] = 0;

$mail = new PHPMailer(true);

try{

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'ganjikuntaswapna12@gmail.com';
    $mail->Password = 'henylxzzjuhapvwv';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom(
        'ganjikuntaswapna12@gmail.com',
        'KidsKart'
    );

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject =
    'KidsKart Password Reset OTP';

    $mail->Body =
    "
    <h2>KidsKart OTP Verification</h2>
    <p>Your OTP is:</p>
    <h1>$otp</h1>
    <p><b>This OTP will expire in 1 minute.</b></p>
    ";
    $mail->send();

    echo json_encode([
        "success"=>true
    ]);

}catch(Exception $e){

    echo json_encode([
        "success"=>false,
        "error"=>$mail->ErrorInfo
    ]);
}
?>