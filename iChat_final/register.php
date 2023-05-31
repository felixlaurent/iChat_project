<?php
session_start();
  include('Config/connect.php');
  include("funct.php");
    
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
 <div class ="login">
 	<h1>REGISTER</h1>

 	<form method="POST" action="register2.php">
 		<input type="text" name="username1" maxlength="25" placeholder="Insert your Username..." required>
 	 	<input type="email" name="email" placeholder="Insert your Email..." required>
 		<input type="password" name="password" placeholder="Insert your Password..." required>
  	<input type="password" name="confirm_password" placeholder="Confirm your Password..." required>
 		<input type="submit" class="btn" value="Register" name="submit">
 		<h5 style="margin-top: 10px;"> do you already have an account? </h5>
 	</form>
 	<div class="registericon">
 		<button type="submit" class ="register" onClick="window.location.href='login.php'">Login</button>
 	</div>
 </div>
</body>
</html> 
