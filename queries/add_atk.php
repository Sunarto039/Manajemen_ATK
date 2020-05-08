<?php

	include_once '../include/config.php';

	$atk = ucwords(mysqli_escape_string($connect, $_POST['atk']));

	$query_insert_ruangan = "INSERT INTO tbl_tipe_atk(nama_atk)"
					." VALUES('".$atk."')";
		$runquery_ruangan = mysqli_query($connect, $query_insert_ruangan);
?>