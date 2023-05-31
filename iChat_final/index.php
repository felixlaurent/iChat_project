<script type="text/javascript">
	if(window.history.replaceState){
		window.history.replaceState(null, null, window.location.href);
	}
	function autorefresh()
	{
		header('location:index.php');
	}
		setInterval(autorefresh(), 8);
</script>
<?php
session_start();
include('Config/connect.php');
include("funct.php");


$row= check_login($con);
$id1= $_SESSION["user_id"];
$sql5 = "SELECT * FROM login";
$rerere = $con->query($sql5);
if($rerere->num_rows>0)
{
	while($lal = $rerere->fetch_assoc())
	{
		if($_SESSION['user_id'] === $lal['user_id'])
		{
			$username1 = $lal['username1'];
		}
	}
}
	if($_SERVER['REQUEST_METHOD']=="POST"){
		if(!empty($_POST['chat']) && $_POST['chat'] !== "")
		{

			$sql3="INSERT INTO chat_message(fromuser_name,chat_message) VALUES ('$username1','".$_POST['chat']."')";
			if($con->query($sql3)== TRUE){

			}					
		}	
	}

?>

<html>
<head>
	<title>iChat</title>
	<link rel="stylesheet" href="index.css">
</head>
<body>
	<div class="kiri">
		<div class="judulbesar">
			<div class="kiri-image"><img src="logoichat.png" width="60px" height="60px" style="margin-left: 10px; margin-top: 10px;"></div>
		 	<div class="welcome"> Welcome 
			 	<?php
			 	
			 	$query1="SELECT * FROM login";
			 	$result= $con->query($query1);
			 		if ($result->num_rows>0){
			 			while($row=$result->fetch_assoc()){
			 				if($row['user_id']==$id1){
			 					echo $row['username1'];
			 				}
			 			}
			 		} else {
			 			echo"???";
			 		}
			 	?> 
		 	</div>
		</div>
		<div class="garis"></div>
		<div class="member_judul">
			<h2><u>Members:</u></h2>
		</div>
		<div class="member_isi">
			<?php
        	if ($con->connect_error) {
        		die("connectsi gagal");
       		}
        	$sql = "SELECT user_id, username1 FROM login";
        	$result = $con->query($sql);
        	$output = "<ul style='margin-left:15px;'>";
        	if ($result->num_rows > 0) { 
        		while($row = $result->fetch_assoc())
        		{
        			if($_SESSION['user_id'] !== $row['user_id']){
           				$yusername = $row['username1'];
           				$output.="<li>$yusername</li>";
        			}
        		}
        	} else {
        		echo "0 results";
        	}
        	$output.="</ul>";
        	echo $output;
      		?>
		</div>
		<a style="text-decoration: none;" class="logout" href="logout.php">Logout</a>
	</div>
	<div class="kanan">
		<div class="atas" style="height:80px; background-color: white; border-left:3px solid #6f4a8e; font-size: 28pt;">
			<p style="padding-top: 15px; padding-left: 25px; color:#6f4a8e;">Group Chat</p>
		</div>
		<div class="chat_box"; style="height: 530px; border: 1px solid #6f4a8e; overflow-x: hidden; overflow-y: scroll;">
			<?php
				$sql2 = "SELECT * FROM chat_message";
				$resalt = $con->query($sql2);
				$sql = "SELECT user_id, username1 FROM login"; 
        		$result = $con->query($sql);
	    		if($resalt->num_rows > 0)
				{
					while($raws = $resalt->fetch_assoc())
					{
						$mychat=$raws['chat_message'];
						$myname=$raws['fromuser_name'];
						echo "<div style='border: 2px solid #dedede; background-color: #F0FFFF; border-radius: 25px; padding: 10px; margin-left:34%; margin-top: 5px; margin-right:10px;''>
						<p align='right'>$mychat - $myname</p>
						</div><br>";								
					}
	    		}
			?>
		</div>
		<div class="chat" style="border-left:1px solid #6f4a8e; ">
			<form method="POST">
				<textarea name="chat" placeholder="  Enter your message" style="resize:none; word-wrap: break-word; padding-left:10px; padding-top: 15px; width:90%; height: 6.8%; float:left;"></textarea> 
				<input type="submit" name="submit" style="width:10%; height:6.8%; float:left;">
			</form>
			<?php

			?>
		</div>
	</div>
</body>
</html>