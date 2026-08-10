<?php

session_start();

include "db.php";

// Fetch all messages
$result = mysqli_query($conn,
"SELECT * FROM contact_messages ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html>

<head>

<title>Customer Contact Messages</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{

background:#f5f7fb;
padding:30px auto;

}

.container{

width:95%;
margin:auto;

background:white;

padding:25px;

border-radius:18px;

box-shadow:0 10px 25px rgba(0,0,0,.1);
margin-top:30px;
}

.heading{

display:flex;
justify-content:space-between;
align-items:center;

margin-bottom:25px;

}

.heading h2{

color:#ff4f81;

}

.count{

background:#ff4f81;
color:white;

padding:8px 15px;

border-radius:20px;

font-weight:bold;

}

table{

width:100%;
border-collapse:collapse;

}

th{

background:#ff4f81;
color:white;

padding:15px;

}

td{

padding:14px;

border-bottom:1px solid #eee;

vertical-align:top;

}

tr:hover{

background:#fff6fa;

}

.statusUnread{

color:red;
font-weight:bold;
/* font-size:10px; */

}

.statusRead{

color:green;
font-weight:bold;

}

.action{

display:flex;
gap:10px;

}

.readBtn{

background:#28a745;
color:white;

padding:8px 12px;

border-radius:6px;

text-decoration:none;

}

.deleteBtn{

background:#dc3545;
color:white;

padding:8px 12px;

border-radius:6px;

text-decoration:none;

}

.readBtn:hover{

opacity:.8;

}

.deleteBtn:hover{

opacity:.8;

}

.message{

max-width:350px;
word-wrap:break-word;

}

</style>

</head>

<body>
<?php include "admin_navbar.php";?>
<div class="container">

<div class="heading">

<h2>📩 Customer Contact Messages</h2>

<div class="count">

Total :
<?= mysqli_num_rows($result); ?>

</div>

</div>

<table>

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Subject</th>

<th>Message</th>

<th>Status</th>

<th>Date</th>

<th>Action</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['name']; ?></td>

<td><?= $row['email']; ?></td>

<td><?= $row['subject']; ?></td>

<td class="message"><?= $row['message']; ?></td>

<td>

<?php

if($row['status']=="Unread")
{

?>

<span class="statusUnread">
🔴Unread
</span>

<?php

}
else
{

?>

<span class="statusRead">
🟢Read
</span>

<?php

}

?>

</td>

<td><?= $row['created_at']; ?></td>

<td>

<div class="action">

<a
class="readBtn"
href="mark_read.php?id=<?= $row['id']; ?>">

Read

</a>

<a
class="deleteBtn"
href="delete_message.php?id=<?= $row['id']; ?>"
onclick="return confirm('Delete this message?')">

Delete

</a>

</div>

</td>

</tr>

<?php

}

?>

</table>

</div>

</body>

</html>