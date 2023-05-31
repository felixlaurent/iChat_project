<?php
session_start();
  include('Config/connect.php');
  include("funct.php");   
?>

<html>
 <head>
  <title>Confirm</title>
 </head>
  <link rel="stylesheet" href="login.css">
 <body>
  <?php
  $namesalah = $emailsalah = $passwordsalah= "";
  $username1 = $email = $password = $confirm_password= "";

		$username1 = test_input($_POST["username1"]);
		if (!preg_match("/^[a-zA-Z;0-9]*$/",$username1)){
			$namesalah = "Only use letters and numbers in your username";
		}

		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$emailsalah = "Email format is wrong";
		}
		

		$password = test_input($_POST["password"]);

		$confirm_password= test_input($_POST["confirm_password"]);
		if ($password != $confirm_password){
		$passwordsalah = "Password do not match";
		}

	
    function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
  ?>
   <?php 
   if (($namesalah =="Only use letters and numbers in your username") or ($emailsalah == "Email format is wrong") or ($passwordsalah == "Password do not match")){
	?>
  <div class ="login">
  <h1>REGISTER</h1>

  <form method="POST" action="register2.php">
    <input type="text" name="username1" maxlength="25" placeholder="Insert your Username..." required><div class="salah"><?php echo $namesalah;?></div>
    <input type="email" name="email" placeholder="Insert your Email..." required><div class="salah"><?php echo $emailsalah?></div>
    <input type="password" name="password" placeholder="Insert your Password..." required>
    <input type="password" name="confirm_password" placeholder="Confirm your Password..." required><div class="salah"><?php echo $passwordsalah;?></div>
    <input type="submit" class="btn" value="Register" name="submit">
    <h5 style="margin-top: 10px;"> do you already have an account? </h5>
  </form>
  <div class="registericon">
    <button type="submit" class ="register" onClick="window.location.href='Login.php'">Login</button>
  </div>
 </div>
   <?php } else { 
    $servername ="localhost";
    $username ="root";
    $password ="";
    $database="db_ichat";
    $connect = new mysqli($servername,$username,$password,$database);
    $username1  =  $_POST['username1'];
    $email  =  $_POST['email'];
    $password  = md5($_POST['password']);
  
  if ($connect->connect_error){
  die("Tidak Terhubung".$connect->connect_error);
} 

$masukdata="INSERT INTO `login` (`username1`, `email`, `password`) 
VALUES ('$username1', '$email', '$password')";

if ($connect->query($masukdata) === TRUE){
    ?>
   <div class="login">
     <h2>Konfirmasi</h2><br><br>
    Username&nbsp: <?php echo $_POST["username1"];?><br>
    Email &nbsp &nbsp &nbsp &nbsp : <?php echo $_POST["email"];?><br>
	<br><br>
  <div class="registericon">
	<input class="register" type="submit" value="Login" onclick=window.location.href="Login.php">
  </div>
   </div>
   <?php 
  echo "<script>alert('Registration Completed');</script>";
}else{
 echo "<script>alert('Registration Failed');</script>" . $connect->error;
}

$connect->close();}
?>
 </body>
</html>