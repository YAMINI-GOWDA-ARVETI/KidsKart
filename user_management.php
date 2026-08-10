<?php

include "db.php";

$result = $conn->query("SELECT * FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Management</title>

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
    padding:30px;
}

.container{
    max-width:1200px;
    margin:20px auto;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.header h2{
    color:#ff4f81;
    font-size:36px;
    font-weight:bold;
}

.back-btn{
    text-decoration:none;
    background:#333;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    font-weight:bold;
    transition:.3s;
}

.back-btn:hover{
    background:#000;
}

.table-box{
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#ff4f81;
    color:white;
    padding:16px;
    text-align:center;
    font-size:16px;
}

th:first-child{
    border-top-left-radius:10px;
}

th:last-child{
    border-top-right-radius:10px;
}

td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #f0f0f0;
    color:#444;
}

tr:hover{
    background:#fff5f8;
}

.btn{
    text-decoration:none;
    color:white;
    padding:8px 16px;
    border-radius:8px;
    font-size:14px;
    font-weight:bold;
    transition:.3s;
    margin-left:10px;
}

.edit{
    background:#28a745;
}

.edit:hover{
    background:#218838;
}

.delete{
    background:#dc3545;
}

.delete:hover{
    background:#c82333;
}

.user-count{
    background:white;
    padding:15px 20px;
    border-radius:15px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    color:#ff4f81;
    font-weight:bold;
    font-size:18px;
}

@media(max-width:768px){

    body{
        padding:15px;
    }

    .header{
        flex-direction:column;
        gap:15px;
        text-align:center;
    }

    .header h2{
        font-size:28px;
    }

    .btn{
        display:block;
        margin:5px 0;
    }
}
</style>

</head>

<body>
<?php include "admin_navbar.php";?>
<div class="container">

    <div class="header">

        <h2>User Management</h2>

        <!-- <a href="dashboard.php" class="back-btn">
            ← Back Dashboard
        </a> -->

    </div>
    
    <div class="user-count">
    Total Users:
    <?php echo $result->num_rows; ?>
    </div>

    <div class="table-box">

        <table>

            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>

            <?php
            if($result->num_rows > 0){

                while($row = $result->fetch_assoc()){
            ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['firstname']; ?></td>

                <td><?php echo $row['lastname']; ?></td>

                <td><?php echo $row['phone']; ?></td>

                <td><?php echo $row['email']; ?></td>

                <td>

                    <a
                    class="btn edit"
                    href="edit_user.php?id=<?php echo $row['id']; ?>">
                    Edit
                    </a>

                    <a
                    class="btn delete"
                    href="delete_user.php?id=<?php echo $row['id']; ?>"
                    onclick="return confirm('Are you sure you want to delete this user?');">
                    Delete
                    </a>

                </td>

            </tr>

            <?php
                }
            }else{
            ?>

            <tr>
                <td colspan="6">
                    No Users Found
                </td>
            </tr>

            <?php
            }
            ?>

        </table>

    </div>

</div>

</body>
</html>