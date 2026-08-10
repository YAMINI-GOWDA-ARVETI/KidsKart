<?php

session_start();

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // =========================
    // ADMIN LOGIN
    // =========================
    if ($role == "admin")
    {

        $sql = "SELECT * FROM admin WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0)
        {

            $row = mysqli_fetch_assoc($result);

            // Admin password is stored as plain text
            if ($password == $row['password'])
            {

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = "admin";

                header("Location: dashboard.php");
                exit();
            }
        }
    }

    // =========================
    // TEAM MEMBER LOGIN
    // =========================
    else if ($role == "team_member")
    {

        $sql = "SELECT * FROM team_members WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0)
        {

            $row = mysqli_fetch_assoc($result);

            // Team member password is stored as plain text
            if ($password == $row['password'])
            {

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = "team_member";

                header("Location: dashboard.php");
                exit();
            }
        }
    }

    // =========================
    // USER LOGIN
    // =========================
    else if ($role == "user")
    {

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0)
        {

            $row = mysqli_fetch_assoc($result);

            // User password is hashed
            if (password_verify($password, $row['password']))
            {

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = "user";

                header("Location: user_home.php");
                exit();
            }
        }
    }

    // =========================
    // INVALID LOGIN
    // =========================

    echo "
    <script>
        alert('Invalid Email, Password or Role');
        window.location='login.html';
    </script>
    ";

}

?>