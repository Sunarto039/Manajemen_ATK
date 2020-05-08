<?php

	include_once '../include/config.php';
	$nama_ruangan = ucfirst(mysqli_escape_string($connect, $_POST['ruangan']));

	$update_atk = array();
	$update_atk_id = array();
	$deleted_atk = array();
	$list_atk = array();

	if (!empty($_POST['update_atk'])) {
		$update_atk = $_POST['update_atk'];
		$update_atk_id = $_POST['update_atk_id'];
		for ($i=0; $i < sizeof($update_atk); $i++) { 
			$update_atk[$i] = mysqli_escape_string($connect, $update_atk[$i]);
			$update_atk_id[$i] = mysqli_escape_string($connect, $update_atk_id[$i]);
		}
		for ($i=0; $i < sizeof($update_atk); $i++) { 
			$query_update_atk = "UPDATE tbl_atk"
							." SET tipe_atk_id = ".$update_atk
							." WHERE id = ".$update_atk_id[$i];
			$runquery_atk = mysqli_query($connect, $query_update_atk);
		 }

	}

	if (!empty($_POST['deleted_atk'])) {
		$deleted_atk = $_POST['deleted_atk'];
		for ($i=0; $i < sizeof($deleted_atk); $i++) { 
			$deleted_atk[$i] = mysqli_escape_string($connect, $deleted_atk[$i]);
		}
		for ($i=0; $i < sizeof($deleted_atk); $i++) { 
			$query_delete_atk = "DELETE FROM tbl_atk"
							." WHERE id = ".$deleted_atk[$i];
			$runquery_atk = mysqli_query($connect, $query_delete_atk);
		 }

	}

	if (!empty($_POST['new_atk'])) {
		$list_atk = $_POST['new_atk'];
		for ($i=0; $i < sizeof($list_atk); $i++) { 
			$list_atk[$i] = mysqli_escape_string($connect, $list_atk[$i]);
		}
		for ($i=0; $i < sizeof($list_atk); $i++) { 
			$query_insert_atk = "INSERT INTO tbl_atk(nama_ruangan_id, tipe_atk_id, status_atk_id)"
							." VALUES('".$nama_ruangan."', ".$list_atk[$i].", 1)";
			$runquery_atk = mysqli_query($connect, $query_insert_atk);
		 }

	}
?>