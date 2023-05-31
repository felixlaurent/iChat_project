<?php
$servername = "localhost";
$username = "root";
$password = "";

$connect = new mysqli($servername, $username, $password);

if ($connect->connect_error){
	die("Tidak terhubung ke server:".$connect->connect_error);
	}
$sql = "CREATE DATABASE db_ichat";
if ($connect->query($sql) === TRUE){
	echo "Database Berhasil Dibuat";
} else{
	echo "Gagal Membuat Database".$connect->error;
}

$connect->close();
?>