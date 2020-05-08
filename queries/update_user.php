<?php

	include_once '../include/config.php';
	$id = (mysqli_escape_string($connect, $_POST['id']));
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

	$query_update_user;
	if ($password == null || $password == "") {
		$query_update_user = "UPDATE tbl_user"
						." SET blokir = '".$val_blocked."', level ='".$val_level."'"
						." WHERE id = ".$id;
	}
	else {
		$query_update_user = "UPDATE tbl_user"
						." SET password = MD5('".$password."'), blokir = '".$val_blocked."', level ='".$val_level."'"
						." WHERE id = ".$id;
	}
	$runquery_insert_user = mysqli_query($connect, $query_update_user);

?>