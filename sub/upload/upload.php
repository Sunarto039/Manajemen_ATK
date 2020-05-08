<?php 
	include "../../include/config.php";

	include "../../plug_in/phpexcel/Classes/PHPExcel.php";
	// include "../../plug_in/spreadsheet-reader-master/php-excel-reader/excel_reader2.php";
	// include "../../plug_in/spreadsheet-reader-master/SpreadsheetReader.php";



	$semester_start = $_POST["from_date"];
	$semester_end = $_POST["to_date"];

	$path = "../../uploaded_file/DATA.xlsx";

	// \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);
	$inputFileType = "Excel2007";
	// // $inputFileType = "Excel5";
	$inputFileName = $_FILES["upload_file"]["tmp_name"];

 //    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
	// $objReader->setReadDataOnly(true);
 //    $objPHPExcel = $objReader->load($inputFileName);
 //    $worksheet = $objPHPExcel->setActiveSheetIndex(0);
 //    $highestcol = $worksheet->getHighestColumn();
 //    $highestrow = $worksheet->getHighestRow();
	// // $keyCell = $worksheet->getCellByColumnAndRow("C",6)->getFormattedValue();
	// // echo $keyCell;

	try {
	    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
	    $objPHPExcel = $objReader->load($inputFileName);
	    $worksheet = $objPHPExcel->setActiveSheetIndex(0);
	    $highestcol = $worksheet->getHighestColumn();
	    $highestrow = $worksheet->getHighestRow();

	    echo "<table>";
	    for ($j=0; $j < $highestrow; $j++) { 
	    	echo "<tr>";
		    for ($i="A"; $i  < $highestcol ; $i++) { 
		    	// echo "<td>".$i." ".$j." ".$worksheet->getCell($i.$j)->getValue()."</td>";
		    	echo "<td>".$worksheet->getCell($i.$j)->getCalculatedValue()."</td>";
		    }
		    echo "</tr>";
	    }
	    echo "</table>";

	} catch(Exception $e) {
	    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}

?>