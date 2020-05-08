<?php

	include '../../include/config.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

	$arr = array();

	if (isset($_POST['username']) && isset($_POST['password']))
	{
		$username = mysqli_escape_string($connect, $_POST['username'])."@uib.ac.id";
		$password = mysqli_escape_string($connect, $_POST['password']);
		$query = "SELECT id, username, nama, blokir FROM tbl_user"
				." WHERE username = '" .$username."' AND password = MD5('" .$password. "')"
				." LIMIT 1";
		$runquery = mysqli_query($connect, $query);

		if (mysqli_num_rows($runquery) != 0) {
			while ($data = mysqli_fetch_array($runquery)) {
				if ($data["blokir"] == "Y") {
					array_push($arr, array("id"=>"blocked"));
				}
				else {
					array_push($arr, array("id"=>$data['id']));
					array_push($arr, array("username"=>$data['username']));
					array_push($arr, array("nama"=>$data['nama']));
				}
			}
		}
		else {
			array_push($arr, array("id"=>""));
		}
	}

	echo json_encode($arr);
?>