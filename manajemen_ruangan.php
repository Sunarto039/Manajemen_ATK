<?php
	include_once 'include/bootstrap.php';
	include_once 'include/config.php';
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
				include_once 'include/sidenav.php';
			?>

			<div id="main-contain">
				<div class="form-area form-ruangan">
					<h1>Manajemen Ruangan</h1>
					<br>
					<form  action="sub/ruangan/add.php">
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>Ruangan</th>
									<th>Tipe</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$query = "SELECT a.nama_ruangan, b.deskripsi, c.deskripsi FROM tbl_ruangan a"
												." INNER JOIN tbl_tipe_ruangan b ON a.tipe_ruangan_id = b.id"
												." INNER JOIN tbl_status_ruangan c ON a.status_ruangan_id = c.id"
												." ORDER BY a.nama_ruangan ASC";
									$runquery = mysqli_query($connect, $query);
									$nama_ruangan = array();
									$tipe_ruangan = array();
									$status_ruangan = array();
									while ($data = mysqli_fetch_array($runquery)) {
										// array_push($arr, array("id"=>$data['id']));
										array_push($nama_ruangan, $data[0]);
										array_push($tipe_ruangan, $data[1]);
										array_push($status_ruangan, $data[2]);
									}
									for ($i=0; $i < sizeof($nama_ruangan); $i++) { 
										echo "<tr>";
										echo "<td>".($i+1)."</td>";
										echo "<td>".$nama_ruangan[$i]."</td>";
										echo "<td>".$tipe_ruangan[$i]."</td>";
										echo "<td>".$status_ruangan[$i]."</td>";
										echo "<td class='td-link' onclick='edit_ruangan(\"".$nama_ruangan[$i]."\");'>Edit</td>";
										// echo "<td class='td-link' onclick='detail(\"".$nama_ruangan[$i]."\");'>Detail Peminjaman</td>";
										// echo "<td class='td-link' onclick='detail(\"".$nama_ruangan[$i]."\");'>Detail Pengembalian</td>";
										echo "<td class='td-link' onclick='detail(\"".$nama_ruangan[$i]."\");'>Detail</td>";
										echo "<td><a class='ruangan-qr' href='sub/ruangan/generate_qrcode.php?ruangan=".$nama_ruangan[$i]."' target='_blank'>Print QR</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
						<button class="btn-add">+ Add Ruangan</button>
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">
			function edit_ruangan(nama_ruangan) {

			    var form = $(document.createElement("form"));
			    $(form).attr("action", "sub/ruangan/edit.php");
			    $(form).attr("method", "POST");
			    $(form).css("display", "none");

			    var input_ruangan = $("<input>")
			    .attr("type", "text")
			    .attr("name", "ruangan")
			    .val(nama_ruangan );
			    $(form).append($(input_ruangan));

			    form.appendTo( document.body );
			    $(form).submit();
			}
			// function detail_peminjaman(nama_ruangan) {

			//     var form = $(document.createElement("form"));
			//     $(form).attr("action", "sub/ruangan/detail_peminjaman.php");
			//     $(form).attr("method", "POST");
			//     $(form).css("display", "none");

			//     var input_ruangan = $("<input>")
			//     .attr("type", "text")
			//     .attr("name", "ruangan")
			//     .val(nama_ruangan );
			//     $(form).append($(input_ruangan));

			//     form.appendTo( document.body );
			//     $(form).submit();
			// }
			// function detail_pengembalian(nama_ruangan) {

			//     var form = $(document.createElement("form"));
			//     $(form).attr("action", "sub/ruangan/detail_pengembalian.php");
			//     $(form).attr("method", "POST");
			//     $(form).css("display", "none");

			//     var input_ruangan = $("<input>")
			//     .attr("type", "text")
			//     .attr("name", "ruangan")
			//     .val(nama_ruangan );
			//     $(form).append($(input_ruangan));

			//     form.appendTo( document.body );
			//     $(form).submit();
			// }
			function detail(nama_ruangan) {

			    var form = $(document.createElement("form"));
			    $(form).attr("action", "sub/ruangan/detail.php");
			    $(form).attr("method", "POST");
			    $(form).css("display", "none");

			    var input_ruangan = $("<input>")
			    .attr("type", "text")
			    .attr("name", "ruangan")
			    .val(nama_ruangan );
			    $(form).append($(input_ruangan));

			    form.appendTo( document.body );
			    $(form).submit();
			}
	</script>
</html>
