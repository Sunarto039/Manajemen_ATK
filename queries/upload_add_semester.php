<?php 
	include "../include/config.php";

	$from_date = mysqli_escape_string($connect, $_POST['from_date']);
	$to_date = mysqli_escape_string($connect, $_POST['to_date']);
	$excel_str = $_POST["uploaded_to_str"];

	$str = explode("<tr>", $excel_str);
	$from_date = date_format(new DateTime($from_date), "Y-m-d");
	$to_date = date_format(new DateTime($to_date), "Y-m-d");

	$semester = strtoupper(get_string_between($str[1], "SEMESTER", "TAHUN"));

	$html_perkuliahan = explode("/td>", $str[1]);
	$txt_perkuliahan;
	preg_match('/>(.*?)</', $html_perkuliahan[0], $txt_perkuliahan);
	$txt_perkuliahan = trim($txt_perkuliahan[0],"<>");
	$tahun_ajaran = $semester." ".substr($txt_perkuliahan, -11, 11);

	$tipe_semester = 0;
	if ($semester == "GANJIL") {
		$tipe_semester = 1;
	}
	else if ($semester == "GENAP") {
		$tipe_semester = 2;
	}
	else if ($semester == "SISIPAN GENAP") {
		$tipe_semester = 3;
	}

	$is_today = null;	
	$query_is_today = "SELECT DATE(NOW())";
	$runquery_is_today = mysqli_query($connect, $query_is_today);
	while ($data = mysqli_fetch_array($runquery_is_today)) {
		if ($from_date == $data[0]) {
			$is_today = 1;
		}
		else {
			$is_today = 0;
		}
	}
	$from_time = "";
	if ($is_today) {
		$query_cur_time = "SELECT CURRENT_TIME()";
		$runquery_cur_time = mysqli_query($connect, $query_cur_time);
		while ($data = mysqli_fetch_array($runquery_cur_time)) {
			$from_time = $data[0];	
		}
	}
	else {
		$from_time = "00:00:00";
	}

	$query = "SELECT id FROM tbl_semester"
			." WHERE ('".$from_date." ".$from_time."' BETWEEN semester_mulai AND semester_akhir)"
			." OR ('".$to_date." 23:59:59' BETWEEN semester_mulai AND semester_akhir)";
	$runquery = mysqli_query($connect, $query);
	$data = mysqli_fetch_array($runquery);
	if (!is_null($data)) {
		$query_update_semester = "UPDATE tbl_semester SET semester_akhir = '".$from_date." ".$from_time."' WHERE tahun_ajaran = '".$tahun_ajaran."' AND ('".$from_date." ".$from_time."' BETWEEN semester_mulai AND semester_akhir)";
		$runquery_update_semester = mysqli_query($connect, $query_update_semester);
	}

	$query_insert_semester = "INSERT INTO tbl_semester(tipe_semester_id, semester_mulai, semester_akhir, tahun_ajaran)"
						." VALUES (".$tipe_semester.", '".$from_date." ".$from_time."'".", '".$to_date." 23:59:59', '".$tahun_ajaran."')";
	$runquery_insert_semester = mysqli_query($connect, $query_insert_semester);

	$query_select_semester = "SELECT id FROM tbl_semester"
		." WHERE semester_mulai = '".$from_date." ".$from_time."'"
		." AND semester_akhir = '".$to_date." 23:59:59'"
		." ORDER BY id DESC LIMIT 1";
	$semester_id=0;
	$runquery_select_semester = mysqli_query($connect, $query_select_semester);
	while ($data = mysqli_fetch_array($runquery_select_semester)) {
		$semester_id = $data[0];
	}

	$i = 3;
	while ($i <= sizeof($str)) {
		
		$td_data = explode("/td>", $str[$i]);

		$hari;
		$jam;
		$matakuliah;
		$kelas;
		$nama_dosen;
		$nama_ruangan_id;
		$jam_mulai;
		$jam_akhir;
		
		preg_match('/>(.*?)</', $td_data[0], $hari);
		preg_match('/>(.*?)</', $td_data[1], $jam);
		preg_match('/>(.*?)</', $td_data[2], $matakuliah);
		preg_match('/>(.*?)</', $td_data[3], $kelas);
		preg_match('/>(.*?)</', $td_data[4], $nama_dosen);
		preg_match('/>(.*?)</', $td_data[5], $nama_ruangan_id);

		$hari = mysqli_escape_string($connect, trim($hari[0],"<>"));
		$nama_ruangan_id = mysqli_escape_string($connect, trim($nama_ruangan_id[0],"<>"));
		$jam = trim($jam[0],"<>");
		$matakuliah = mysqli_escape_string($connect, trim($matakuliah[0],"<>"));
		$kelas = mysqli_escape_string($connect, trim($kelas[0],"<>"));
		$nama_dosen = mysqli_escape_string($connect, trim($nama_dosen[0],"<>"));

		if (strtoupper(substr($nama_ruangan_id, 0, 13)) == 'LAB. KOMPUTER') {
			$nama_ruangan_id = substr($nama_ruangan_id, -5, 4);
		}

		if ($hari == "") {
			break;
		}

		$jam_data = explode("-", $jam);
		$jam_mulai = mysqli_escape_string($connect, trim($jam_data[0]));
		$jam_akhir = mysqli_escape_string($connect, trim($jam_data[1]));

		$query_insert_jadwal_perkuliahan = "INSERT INTO tbl_jadwal_perkuliahan(semester_id, nama_ruangan_id, hari, jam_mulai, jam_akhir, matakuliah, kelas, nama_dosen)"
											." VALUES (".$semester_id.", '".$nama_ruangan_id."', '".$hari."', '".$jam_mulai."', '".$jam_akhir."', '".$matakuliah."', '".$kelas."', '".$nama_dosen."')";
		$runquery_insert_jadwal_perkuliahan = mysqli_query($connect, $query_insert_jadwal_perkuliahan);

		$i++;
	}
	javascript_alert("Data berhasil terupload", "../index.php");
	
	function get_string_between($string, $start, $end) {
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);   
		$len = strpos($string,$end,$ini) - $ini;
		return trim(substr($string,$ini,$len));
	}

	function javascript_alert($string, $url) {
		echo "<script type='text/javascript'>";
		echo "alert('".$string."');";
		echo "window.location.href = '".$url."';";
		echo "</script>";
	}

?>