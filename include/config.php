<?php

$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "manajemen_atk"; 

$connect = mysqli_connect($host, $username, $password, $database);

if ($connect->connect_error) {
	die("Connection failed".$connect->connect_error);
}

?>