<?php
	include_once '../../include/bootstrap.php';
	include_once '../../include/config.php';
	$nama_ruangan = ucfirst(mysqli_escape_string($connect, $_POST['ruangan']));
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
				<div class="form-area form-ruangan">
					<h1>Detail Peminjaman Ruangan</h1>
					<br>
					<form>
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>Ruangan</th>
									<th>Nama Dosen Peminjam</th>
									<th>Tanggal Peminjaman</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$query = "SELECT id, nama_ruangan_id, nama_dosen, tgl_peminjaman FROM tbl_peminjaman"
											." WHERE nama_ruangan_id ='".$nama_ruangan."'"
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
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">
	</script>
</html>
