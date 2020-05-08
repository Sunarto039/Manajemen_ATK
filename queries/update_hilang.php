<?php

	include_once '../include/config.php';

	$list_atk = array();

	if (!empty($_POST['checked_data'])) {
		$list_atk = $_POST['checked_data'];
		for ($i=0; $i < sizeof($list_atk); $i++) { 
			$list_atk[$i] = mysqli_escape_string($connect, $list_atk[$i]);
		}
		for ($i=0; $i < sizeof($list_atk); $i++) { 
			$query = "UPDATE tbl_atk SET status_atk_id = 1"
					." WHERE id = ".$list_atk[$i];
			$runquery_atk = mysqli_query($connect, $query);
			echo "success";
		 }

	}
?>