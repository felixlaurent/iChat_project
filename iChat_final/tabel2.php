<?php
$servername = "localhost";
$username = "root";
$password = "";
$database ="db_ichat";

$con = new mysqli($servername,$username,$password,$database);

if ($con->connect_error){
 die("Gagal ".$con->connect_error);
}
$sql = "CREATE TABLE login_details
 (login_details_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
 user_id INT(11) NOT NULL,
 last_activity TIMESTAMP NOT NULL,
 is_type ENUM ('no','yes') NOT NULL)";
if ($con->query($sql) === TRUE){
 echo "Tabel 1 Dibuat";
} else{
 echo "Tabel 1 Gagal".$con->error;
}

$sql2 = "CREATE TABLE login
 (user_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
 username1 varchar(25) NOT NULL,
 email varchar(255) NOT NULL,
 password varchar(50) NOT NULL)";
if ($con->query($sql2) === TRUE){
 echo "Tabel 2 Dibuat";
} else{
 echo "Tabel 2 Gagal".$con->error;
}

$sql3 = "CREATE TABLE chat_message
 (chat_message_id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
 to_user_id int(11) NOT NULL,
 from_user_id int(11) NOT NULL,
 chat_message mediumtext NOT NULL,
 timestamp timestamp NOT NULL,
 status int(1) NOT NULL";
if ($con->query($sql3) === TRUE){
 echo "Tabel 3 Dibuat";
} else{
 echo "Tabel 3 Gagal".$con->error;
}


$con->close();
?>