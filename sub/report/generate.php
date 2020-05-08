<?php
	include "../../include/config.php";
	include "pdf_mc_table.php";

	// $from_date = mysqli_escape_string($connect, $_POST['from_date']);
	// $to_date = mysqli_escape_string($connect, $_POST['to_date']);
	$tahun_ajaran_semester = mysqli_escape_string($connect, $_POST['selected_semester']);
	$arr = array(
		"row_number" => array(),
	    "ruangan" => array(),
	    "dosen" => array(),
	    "tgl_peminjaman" => array(),
	    "tgl_pengembalian" => array(),
	    "kelas" => array(),
	    "matakuliah" => array(),
	    "user_peminjaman" => array(),
	    "user_pengembali" => array(),
	    "ket" => array()
	);

	// $from_date = date_format(new DateTime($from_date), "Y-m-d");
	// $to_date = date_format(new DateTime($to_date), "Y-m-d");

	$query = "SELECT a.nama_ruangan_id, a.nama_dosen, a.tgl_peminjaman, b.tgl_pengembalian, c.kelas, c.matakuliah, a.staff_peminjaman, b.staff_pengembalian, b.keterangan FROM tbl_peminjaman a"
			 ." LEFT JOIN tbl_pengembalian b"
			 ." ON a.nama_ruangan_id = b.nama_ruangan_id AND a.id = b.peminjaman_id"
			 ." LEFT JOIN tbl_jadwal_perkuliahan c"
			 ." ON c.id = a.jadwal_kuliah_id"
			 ." WHERE (tgl_peminjaman BETWEEN (SELECT semester_mulai FROM tbl_semester WHERE tahun_ajaran = '".$tahun_ajaran_semester."' ORDER BY semester_mulai ASC LIMIT 1) AND (SELECT semester_akhir FROM tbl_semester WHERE tahun_ajaran = '".$tahun_ajaran_semester."' ORDER BY semester_akhir DESC LIMIT 1))AND a.jadwal_kuliah_id IN(SELECT id FROM tbl_jadwal_perkuliahan WHERE semester_id IN(SELECT id FROM tbl_semester WHERE tahun_ajaran='".$tahun_ajaran_semester."'))"
			 ." ORDER BY a.nama_ruangan_id ASC, a.id ASC";
			 // echo $query;die();
	$runquery = mysqli_query($connect, $query);
	$i = 0;
	while ($data = mysqli_fetch_array($runquery)) {
		$i++;
		array_push($arr["row_number"], $i);
		array_push($arr["ruangan"], $data[0]);
		array_push($arr["dosen"], $data[1]);
		array_push($arr["tgl_peminjaman"], $data[2]);
		array_push($arr["tgl_pengembalian"], $data[3]);
		array_push($arr["kelas"], $data[4]);
		array_push($arr["matakuliah"], $data[5]);
		array_push($arr["user_peminjaman"], $data[6]);
		array_push($arr["user_pengembali"], $data[7]);
		array_push($arr["ket"], $data[8]);
	}

	class PDF extends PDF_MC_TABLE {
		function Header() {
			//Logo
			$this->Image("../../img/logo.png",10,6,30);
		    
		    // Title
		    $this->SetFont("Arial","B",12);
		    $this->Cell(0,10,"Laporan ATK",0,1,"C");
		    $this->Cell(0,10,"Universitas International Batam",0,0,"C");

		    //Title Separator Line
		    $width=$this->w;
		    $this->Line(10,35,$width-10,35);
		    
		    // Line break
		    $this->Ln(20);

			$this->SetFont("Arial","B", 10);
			$this->Cell(10, 5, "No", 1,0);
			$this->Cell(20, 5, "Ruangan", 1,0);
			$this->Cell(35, 5, "Nama Dosen", 1,0);
			$this->Cell(35, 5, "Tgl Peminjaman", 1,0);
			$this->Cell(35, 5, "Tgl Pengembalian", 1,0);
			$this->Cell(15, 5, "Kelas", 1,0);
			$this->Cell(30, 5, "Matakuliah", 1,0);
			$this->Cell(30, 5, "User Peminjam", 1,0);
			$this->Cell(30, 5, "User Pengembali", 1,0);
			$this->Cell(35, 5, "Keterangan", 1,0);
		    $this->Ln();

		}

		function Footer() {
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Arial italic 8
		    $this->SetFont("Arial","I",8);
		    // Page number
		    $this->Cell(0,10,$this->PageNo(),0,0,"C");
		}
	}

	$pdf = new PDF();
	$pdf->AddPage("L", "A4");
	$pdf->SetFont('Arial','',10);
	// $pdf->SetLineHeight(5);

	
	$pdf->SetWidths(array(10, 20, 35, 35, 35, 15, 30, 30, 30, 35));
	for ($i=0; $i < sizeof($arr["ruangan"]); $i++) {
		$pdf->Row(array(
			$arr["row_number"][$i],
			$arr["ruangan"][$i],
			$arr["dosen"][$i],
			$arr["tgl_peminjaman"][$i],
			$arr["tgl_pengembalian"][$i],
			$arr["kelas"][$i],
			$arr["matakuliah"][$i],
			$arr["user_peminjaman"][$i],
			$arr["user_pengembali"][$i],
			$arr["ket"][$i]));
	}
	$pdf->Output();
?>