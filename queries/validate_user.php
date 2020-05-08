<?php

	include_once '../include/config.php';

	$uc_email = strtoupper(mysqli_escape_string($connect, $_POST['email']))."@uib.ac.id";
	$uc_nama = strtoupper(mysqli_escape_string($connect, $_POST['nama']));
	
	$query = "SELECT id FROM tbl_user"
					." WHERE UPPER(username) = '".$uc_email."' AND UPPER(nama) = '".$uc_nama."'";
	$runquery = mysqli_query($connect, $query);
	$data = mysqli_fetch_array($runquery);
	if (is_null($data)) {
		echo "success";
	}
	else {
		echo "failed";
	}
?>