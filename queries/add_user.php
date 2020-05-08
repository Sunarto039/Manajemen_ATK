<?php

	include_once '../include/config.php';

	$email = (mysqli_escape_string($connect, $_POST['email']))."@uib.ac.id";
	$nama = (mysqli_escape_string($connect, $_POST['nama']));
	$password = (mysqli_escape_string($connect, $_POST['password']));
	$is_blocked = mysqli_escape_string($connect, $_POST['blocked']);
	$is_admin = mysqli_escape_string($connect, $_POST['admin']);
	$val_blocked = "N";
	$val_level = "";
	if ($is_blocked == "true") {
		$val_blocked = "Y";
	}
	if ($is_admin == "true") {
		$val_level = "superadmin";
	}

	echo $is_blocked." ".$val_blocked;

	$query_insert_user = "INSERT INTO tbl_user(username, password, blokir, id_biro, nama, level)"
					." VALUES('".$email."', MD5('".$password."'), '".$val_blocked."', 2, '".$nama."', '".$val_level."')";
	$runquery_insert_user = mysqli_query($connect, $query_insert_user);
					// echo $query_insert_user;
?>