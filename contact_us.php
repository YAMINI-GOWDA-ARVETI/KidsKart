<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contact Us | BabyBloom</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{

background:
linear-gradient(rgba(255,105,180,.20),
rgba(255,182,193,.20)),
url("https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=1400&auto=format&fit=crop");

background-size:cover;
background-position:center;

display:flex;
justify-content:center;
align-items:center;

min-height:100vh;

}

.container{

width:450px;

background:rgba(255,255,255,.25);

backdrop-filter:blur(15px);

padding:35px;

border-radius:25px;

box-shadow:0 10px 30px rgba(0,0,0,.15);

border:1px solid rgba(255,255,255,.3);

}

.logo{

font-size:55px;
text-align:center;
margin-bottom:10px;

}

h2{

text-align:center;
color:#ff4f81;
margin-bottom:8px;

}

.subtitle{

text-align:center;
margin-bottom:25px;
color:#444;

}

.input-group{

margin-bottom:18px;

}

label{

display:block;
margin-bottom:7px;
font-weight:600;
color:#444;

}

input,
textarea{

width:100%;

padding:13px;

border:none;

border-radius:12px;

background:rgba(255,255,255,.9);

font-size:15px;

}

textarea{

resize:none;

height:130px;

}

input:focus,
textarea:focus{

outline:none;

box-shadow:0 0 8px #ff7eb3;

}

button{

width:100%;

padding:14px;

border:none;

border-radius:12px;

font-size:17px;

font-weight:bold;

background:linear-gradient(135deg,#ff4f81,#ff85c1);

color:white;

cursor:pointer;

transition:.3s;

}

button:hover{

transform:translateY(-2px);

box-shadow:0 8px 18px rgba(255,79,129,.4);

}

</style>

</head>

<body>

<div class="container">

<div class="logo">🧸</div>

<h2>Contact Us</h2>

<p class="subtitle">
We'd love to hear from you.
</p>

<form action="save_contact.php" method="POST">

<div class="input-group">

<label>Full Name</label>

<input
type="text"
name="name"
placeholder="Enter your name"
required>

</div>

<div class="input-group">

<label>Email Address</label>

<input
type="email"
name="email"
placeholder="Enter your email"
required>

</div>

<div class="input-group">

<label>Subject</label>

<input
type="text"
name="subject"
placeholder="Subject"
required>

</div>

<div class="input-group">

<label>Message</label>

<textarea
name="message"
placeholder="Write your message..."
required></textarea>

</div>

<button type="submit">

📩 Send Message

</button>

</form>

</div>

</body>

</html>