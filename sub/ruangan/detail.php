<?php
	include_once '../../include/bootstrap.php';
	include_once '../../include/config.php';
	$ruangan = ucfirst(mysqli_escape_string($connect, $_POST['ruangan']));
	// $ruangan = 'A301';
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/ruangan.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body>
		<div id="wrapper">

			<?php
				include_once '../../include/sidenav.php';
			?>

			<div id="main-contain">
				<div id="detail-peminjaman" class="detail-head">
					<h1 id="peminjaman-heading" class="toggle-heading" onclick="toggle_heading('peminjaman-table')">Detail Peminjaman</h1>
					<div id="peminjaman-table" class="collapsable-table table-hide">
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>Ruangan</th>
									<th>Nama Dosen</th>
									<th>Tanggal Peminjaman</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$query = "SELECT id, nama_ruangan_id, nama_dosen, tgl_peminjaman FROM tbl_peminjaman"
											." WHERE nama_ruangan_id ='".$ruangan."'"
											." ORDER BY id DESC";
									$runquery = mysqli_query($connect, $query);
									$nama_ruangan = array();
									$nama_dosen = array();
									$tgl_peminjaman = array();
									while ($data = mysqli_fetch_array($runquery)) {
										// array_push($arr, array("id"=>$data['id']));
										array_push($nama_ruangan, $data[1]);
										array_push($nama_dosen, $data[2]);
										array_push($tgl_peminjaman, $data[3]);
									}
									for ($i=0; $i < sizeof($nama_ruangan); $i++) { 
										echo "<tr>";
										echo "<td>".($i+1)."</td>";
										echo "<td>".$nama_ruangan[$i]."</td>";
										echo "<td>".$nama_dosen[$i]."</td>";
										echo "<td>".$tgl_peminjaman[$i]."</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- -->
				<div id="detail-pengembalian" class="detail-head">
					<h1 id="pengembalian-heading" class="toggle-heading" onclick="toggle_heading('pengembalian-table')">Detail Pengembalian</h1>
					<div id="pengembalian-table" class="collapsable-table table-hide">
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>Ruangan</th>
									<th>Nama Dosen</th>
									<th>Tanggal Pengembalian</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$query = "SELECT id, nama_ruangan_id, nama_dosen, keterangan, tgl_pengembalian FROM tbl_pengembalian"
											." WHERE nama_ruangan_id ='".$ruangan."'"
											." ORDER BY id DESC";
									$runquery = mysqli_query($connect, $query);
									$nama_ruangan = array();
									$nama_dosen = array();
									$keterangan = array();
									$tgl_pengembalian = array();
									while ($data = mysqli_fetch_array($runquery)) {
										// array_push($arr, array("id"=>$data['id']));
										array_push($nama_ruangan, $data[1]);
										array_push($nama_dosen, $data[2]);
										array_push($keterangan, $data[3]);
										array_push($tgl_pengembalian, $data[4]);
									}
									for ($i=0; $i < sizeof($nama_ruangan); $i++) { 
										echo "<tr>";
										echo "<td>".($i+1)."</td>";
										echo "<td>".$nama_ruangan[$i]."</td>";
										echo "<td>".$nama_dosen[$i]."</td>";
										echo "<td>".$tgl_pengembalian[$i]."</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
		</div>
	</body>
	<script type="text/javascript">
		
		document.getElementById("peminjaman-table").style.display = "none";
		document.getElementById("pengembalian-table").style.display = "none";

		function toggle_heading(table_id) {
			var collapsable = document.getElementById(table_id);
			if (collapsable.style.display == "none") {
				collapsable.style.display = "block";
				collapsable.style.width = "100%";
			}
			else {
				collapsable.style.display = "none";
			}
		}
	</script>
</html>
