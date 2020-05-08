<?php
	include_once '../../include/bootstrap.php';
	include_once '../../include/config.php';

	$gedung = ucfirst(mysqli_escape_string($connect, $_POST['gedung']));
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
					<h1>Manajemen Ruangan</h1>
					<br>
					<form  action="#">
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>Nama ATK</th>
									<th>ATK Tersedia</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$query = "SELECT id, nama_atk FROM tbl_tipe_atk"
												." ORDER BY id ASC";
									$runquery = mysqli_query($connect, $query);
									$id_atk = array();
									$nama_atk = array();
									while ($data = mysqli_fetch_array($runquery)) {
										array_push($id_atk, $data[0]);
										array_push($nama_atk, $data[1]);
									}

									for ($i=0; $i < sizeof($id_atk); $i++) { 
										echo "<tr>";
										echo "<td>".($i+1)."</td>";
										echo "<td>".$nama_atk[$i]."</td>";
										echo "<td>";

										$query_count = "SELECT COUNT(id) FROM tbl_atk"
														." WHERE status_atk_id = 1"
														." AND SUBSTR(nama_ruangan_id,1,1) = '".$gedung."'"
														." AND tipe_atk_id = ".$id_atk[$i]
														." GROUP BY tipe_atk_id"
														." ORDER BY tipe_atk_id";
										$runquery = mysqli_query($connect, $query_count);
										while ($data2 = mysqli_fetch_array($runquery)) {
											$count = $data2[0];
										}

										if (mysqli_num_rows($runquery)) {
											 echo $count;
										}
										else {
											echo "0";
										}
										echo "</td>";
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
</html>
