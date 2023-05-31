<?php

function check_login($con)
{
	if(isset($_SESSION['user_id']))
	{

		$id = $_SESSION['user_id'];
		$query = "SELECT * FROM login WHERE user_id = '$id' limit 1 ";

		$result = mysqli_query($con,$query);
		if ($result && mysqli_num_rows($result)>0) 
		{
			$row= mysqli_fetch_assoc($result);
			return $row;
		}
	}

	//redirect to login
	header("location:login.php");
	die;
}
//---------------------------------------------------------------------------------------
function fetch_user_last_activity($user_id, $con)
{
 $query = "SELECT user_id,last_activity FROM login_details WHERE user_id = '$user_id'  ORDER BY last_activity DESC LIMIT 1
 ";
 $statement = $con->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['last_activity'];
 }
}



//---------------------------------------------------------------------------------------
function fetch_user_chat_history($from_user_id, $to_user_id, $con)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE (from_user_id = '".$from_user_id."' 
 AND to_user_id = '".$to_user_id."') 
 OR (from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."') 
 ORDER BY timestamp DESC
 ";
 $statement = $con->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '<ul class="list-unstyled">';
 foreach($result as $row)
 {
  $user_name = '';
  $dynamic_background = '';
  $chat_message = '';
  if($row["from_user_id"] == $from_user_id)
  {
   if($row["status"] == '2')
   {
    $chat_message = '<em>Pesan ini telah dihapus</em>';
    $user_name = '<b class="text-success">Kamu</b>';
   }
   else
   {
    $chat_message = $row['chat_message'];
    $user_name = '<button type="button" class="btn btn-danger btn-sm remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">Kamu</b>';
   }
   

   $dynamic_background = 'background-color:#edfaf0;';
  }
  else
  {
   if($row["status"] == '2')
   {
    $chat_message = '<em>Pesan ini telah dihapus</em>';
   }
   else
   {
    $chat_message = $row["chat_message"];
   }
   $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $con).'</b>';
   $dynamic_background = 'background-color:#fffff2;';
  }
  $output .= '
  <li style="border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
   <p>'.$user_name.' - '.$chat_message.'
    <div align="right">
     - <small><em>'.$row['timestamp'].'</em></small>
    </div>
   </p>
  </li>
  ';
 }
 $output .= '</ul>';
 $query = "
 UPDATE chat_message 
 SET status = '0' 
 WHERE from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."' 
 AND status = '1'
 ";
 $statement = $con->prepare($query);
 $statement->execute();
 return $output;
}



//---------------------------------------------------------------------------------------
function get_user_name($user_id, $con)
{
 $query = "SELECT username1 FROM login WHERE user_id = '$user_id'";
 $statement = $con->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['username'];
 }
}


//---------------------------------------------------------------------------------------
function count_unseen_message($from_user_id, $to_user_id, $con)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
 AND status = '1'
 ";
 $statement = $con->prepare($query);
 $statement->execute();
 $count = $statement->rowCount();
 $output = '';
 if($count > 0)
 {
  $output = '<span class="badge badge-success">'.$count.'</span>';
 }
 return $output;
}

//---------------------------------------------------------------------------------------
function fetch_is_type_status($user_id, $con)
{
 $query = "
 SELECT is_type FROM login_details 
 WHERE user_id = '".$user_id."' 
 ORDER BY last_activity DESC 
 LIMIT 1
 "; 
 $statement = $con->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  if($row["is_type"] == 'yes')
  {
   $output = ' - <small><em><span class="text-muted">mengetik...</span></em></small>';
  }
 }
 return $output;
}
?>
