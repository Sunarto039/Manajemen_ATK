<?php

	include_once '../include/config.php';
	header('Content-Type: application/json');
	
	$arr = array();

		$query = "SELECT MONTH(tgl_pengembalian) AS month ,COUNT(tgl_pengembalian) AS tot FROM tbl_pengembalian_hilang WHERE YEAR(tgl_pengembalian)=YEAR(NOW()) GROUP BY MONTH(tgl_pengembalian) ORDER BY MONTH(tgl_pengembalian) ASC";
		$runquery = mysqli_query($connect, $query);
		
		while ($data = mysqli_fetch_array($runquery)) {
			array_push($arr, array("month"=>$data['month'],"tot"=>$data['tot']));
		}
		print json_encode($arr);
?>