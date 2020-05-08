<?php

	include '../../include/config.php';

	$username = $_POST["username"]."@uib.ac.id";
	$password = $_POST["password"];

	$query = "SELECT username, nama, id_biro, level, id, blokir FROM tbl_user"
				." WHERE username ='".$username."' AND password = MD5('" .$password. "')"
				." LIMIT 1";
	$runquery = mysqli_query($connect, $query);
	$sess_data = array();
	
	while ($data = mysqli_fetch_array($runquery)) {
		$sess_data['username']    = $data[0];
		$sess_data['nama']    = $data[1];
		$sess_data['biro']    = $data[2];
		$sess_data['level']    = $data[3];
		$sess_data['id_user']    = $data[4];
		$sess_data['blokir']    = $data[5];
	}


	if ($username == null || $username == "" || $password == null || $password == "" || mysqli_num_rows($runquery) == 0) {
		echo "<script>";
		echo "alert('Username atau Password yang anda masukkan salah.');";
		echo "window.location.href = '../../login.php';";
		echo "</script>";
	}
	else {
		if ($sess_data['blokir'] == 'Y') {
			echo "<script>";
			echo "alert('Username tersebut telah diblokir oleh admin');";
			echo "window.location.href = '../../login.php';";
			echo "</script>";
		}
		else {
			session_start();
			$_SESSION['sess_data'] = $sess_data;
			header('Location: ../../index.php');
		}
	}
?>