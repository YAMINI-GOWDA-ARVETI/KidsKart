<?php

header("Content-Type: application/json");

// DATABASE CONNECTION
$conn = new mysqli(
    "localhost",
    "root",
    "",
    "kidskart"
);

// CHECK CONNECTION
if ($conn->connect_error) {
    echo json_encode([
        "status" => "error",
        "message" => $conn->connect_error
    ]);
    exit;
}

// GET JSON DATA
$data = json_decode(file_get_contents("php://input"), true);

// CHECK DATA
if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "No data received"
    ]);
    exit;
}

// FETCH DATA
$firstname = $conn->real_escape_string($data['firstName']);
$lastname  = $conn->real_escape_string($data['lastName']);
$phone     = $conn->real_escape_string($data['phone']);
$email     = $conn->real_escape_string($data['email']);
$address   = $conn->real_escape_string($data['address']);
$role      = $conn->real_escape_string($data['role']);

$password = password_hash(
    $data['password'],
    PASSWORD_DEFAULT
);

// =====================
// USER REGISTER
// =====================
if ($role == "user") {

    $check = "SELECT id FROM users WHERE email='$email'";
    $result = $conn->query($check);

    if (!$result) {
        echo json_encode([
            "status" => "error",
            "message" => $conn->error
        ]);
        exit;
    }

    if ($result->num_rows > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Email already exists"
        ]);
        exit;
    }

    $sql = "INSERT INTO users
        (firstname, lastname, phone, email, password, role, address)
        VALUES
        ('$firstname', '$lastname', '$phone', '$email', '$password', 'user', '$address')";
}

// =====================
// ADMIN REGISTER
// =====================
else if ($role == "admin") {

    $check = "SELECT id FROM admin WHERE email='$email'";
    $result = $conn->query($check);

    if (!$result) {
        echo json_encode([
            "status" => "error",
            "message" => $conn->error
        ]);
        exit;
    }

    if ($result->num_rows > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Email already exists"
        ]);
        exit;
    }

    $sql = "INSERT INTO admin
            (name, email, password)
            VALUES
            ('$firstname', '$email', '$password')";
}

// =====================
// TEAM MEMBER REGISTER
// =====================
// =====================
// TEAM MEMBER REGISTER
// =====================
else if ($role == "team_member") {

    $check = "SELECT id FROM team_members WHERE email='$email'";
    $result = $conn->query($check);

    if (!$result) {
        echo json_encode([
            "status" => "error",
            "message" => $conn->error
        ]);
        exit;
    }

    if ($result->num_rows > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Email already exists"
        ]);
        exit;
    }

    $fullName = $firstname . " " . $lastname;

    $plainPassword = $data['password'];

    $sql = "INSERT INTO team_members
            (name, email, password)
            VALUES
            ('$fullName', '$email', '$plainPassword')";
}

// INVALID ROLE
else {
    echo json_encode([
        "status" => "error",
        "message" => "Select valid role"
    ]);
    exit;
}

// EXECUTE INSERT
if ($conn->query($sql)) {

    if ($role == "admin" || $role == "team_member") {
        echo json_encode([
            "status" => "success",
            "redirect" => "dashboard.php"
        ]);
    } else {
        echo json_encode([
            "status" => "success",
            "redirect" => "user_home.php"
        ]);
    }

} else {
    echo json_encode([
        "status" => "error",
        "message" => $conn->error
    ]);
}

$conn->close();

?>