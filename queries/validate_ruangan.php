<?php

	include_once '../include/config.php';

	$uc_ruangan = ucfirst(mysqli_escape_string($connect, $_POST['ruangan']));
	
	$query = "SELECT nama_ruangan FROM tbl_ruangan"
					." WHERE nama_ruangan = '".$uc_ruangan."'";
	
	$runquery = mysqli_query($connect, $query);
	$data = mysqli_fetch_array($runquery);
	if (is_null($data)) {
		echo "success";
	}
	else {
		echo "failed";
	}
?>