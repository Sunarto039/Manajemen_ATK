<?php

	include_once '../include/config.php';
	$atk_id = mysqli_escape_string($connect, $_POST['atk_id']);

	$query = "DELETE FROM tbl_tipe_atk"
			." WHERE id = ".$atk_id;
	$runquery_atk = mysqli_query($connect, $query);
?>