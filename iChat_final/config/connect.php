<?php
$con = new mysqli("localhost","root","","db_ichat");

// Check connection
if ($con -> connect_error) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
}
?> 