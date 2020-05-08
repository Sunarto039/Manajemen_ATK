<?php

	include_once '../include/config.php';

	$nama_ruangan = ucfirst(mysqli_escape_string($connect, $_POST['ruangan']));
	$tipe_ruangan = mysqli_escape_string($connect, $_POST['tipe']);

	$list_atk = array();
	$list_atk = $_POST['list'];

	for ($i=0; $i < sizeof($list_atk); $i++) { 
		$list_atk[$i] = mysqli_escape_string($connect, $list_atk[$i]);
	}

	$query_insert_ruangan = "INSERT INTO tbl_ruangan(nama_ruangan, tipe_ruangan_id, status_ruangan_id)"
					." VALUES('".$nama_ruangan."', ".$tipe_ruangan.", 1)";
		$runquery_ruangan = mysqli_query($connect, $query_insert_ruangan);

	for ($i=0; $i < sizeof($list_atk); $i++) { 
		$query_insert_atk = "INSERT INTO tbl_atk(nama_ruangan_id, tipe_atk_id, status_atk_id)"
						." VALUES('".$nama_ruangan."', ".$list_atk[$i].", 1)";
		$runquery_atk = mysqli_query($connect, $query_insert_atk);
	 }
?>