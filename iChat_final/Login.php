<?php
session_start();
include('config/connect.php');
include("funct.php");

if ($_SERVER['REQUEST_METHOD']=="POST") 
{
	$username1 = $_POST['username1'];;
	$password = md5($_POST['password']);

    if (!empty($username1) && !empty($password)) 
    {
	
    $query = "SELECT * FROM login WHERE username1 = '$username1' limit 1";
    $result = $con->query($query);
	$data = mysqli_fetch_array($result,MYSQLI_ASSOC);
		if(mysqli_num_rows($result)>0){
			
			if($password == $data['password']){
				$_SESSION['user_id'] = $data['user_id'];
				$_SESSION['username1'] = $_POST['username1'];
				$sub_query = "INSERT INTO login_details(user_id)VALUES ('".$data['user_id']."')";
				$result_sub_query = $con -> query($sub_query);
				
				if ($con->query($sub_query)) {
  					$last_id = $con->insert_id;
 					 echo "New record created successfully. Last inserted ID is: " . $last_id;
  					$_SESSION['login_details_id'] = $last_id;
					header("location:index.php");
				}else{
					header("location:login.php");
				}
				
				
				
				
			}else{
				echo "Login Gagal";
			}
		
			
	
		}
      
    }else{
      echo "Please fill Username or Password";
    } 
}
    
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
 <div class ="login">
 	<h1>LOGIN</h1>
 	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 		<input type="text" name="username1" placeholder="Enter your Username..." required>
 		<input type="password" name="password" placeholder="Enter your Password..." required>
 		<button type="submit" class="btn"> Login </button>
 		<h5 style="margin-top: 10px;"> don't have an account? </h5>
 	</form>
 	<div class="registericon">
 		<button type="submit" class ="register" onClick="window.location.href='register.php'">Register</button>
 	</div>
 </div>
</body>
</html> 