<?php
	include_once '../../include/phpqrcode/qrlib.php';

	if(!empty($_GET['ruangan'])){
		$nama_ruangan = $_GET['ruangan'];
		QRcode::png  (
	    $nama_ruangan,
	    $outfile = false,
	    $level = QR_ECLEVEL_L,
	    $size = 10,
	    $margin = 4,
	    $saveandprint = false
		);
	}   
?>