<?php

	include_once '../include/config.php';

	$atk = strtoupper(mysqli_escape_string($connect, $_POST['atk']));
	
	$query = "SELECT UPPER(nama_atk) FROM tbl_tipe_atk"
					." WHERE UPPER(nama_atk) = '".$atk."'";
	
	$runquery = mysqli_query($connect, $query);
	$data = mysqli_fetch_array($runquery);
	if (is_null($data)) {
		echo "success";
	}
	else {
		echo "failed";
	}
?>