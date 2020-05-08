<?php
	include_once 'include/bootstrap.php';
	include_once 'include/config.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body>
		<div id="wrapper">

			<?php
				include_once 'include/sidenav.php';
			?>

			<div id="main-contain">
				<div class="form-area form-atk">
					<h1>Manajemen ATK</h1>
					<br>
					<form  action="sub/atk/add.php">
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>Nama ATK</th>
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

									$query2 = "SELECT id FROM tbl_tipe_atk"
												." WHERE id NOT IN("
												." SELECT DISTINCT tipe_atk_id FROM tbl_atk)";
									$runquery2 = mysqli_query($connect, $query2);
									$atk_tak_tergunakan = array();
									while ($data2 = mysqli_fetch_array($runquery2)) {
										array_push($atk_tak_tergunakan, $data2[0]);
									}

									$deletable = array();
									for ($i=0; $i < sizeof($id_atk); $i++) { 
										$bool = 0;
										for ($j=0; $j < sizeof($atk_tak_tergunakan); $j++) { 
											if ($id_atk[$i] == $atk_tak_tergunakan[$j]) {
												$bool = 1;
												break;
											}
										}
										if ($bool == 1) {
											array_push($deletable, 1);
										}
										else {
											array_push($deletable, 0);
										}
									}

									for ($i=0; $i < sizeof($id_atk); $i++) { 
										echo "<tr>";
										echo "<td>".($i+1)."</td>";
										echo "<td>".$nama_atk[$i]."</td>";
										echo "<td>";
										// for ($j=0; $j < sizeof($atk_tak_tergunakan); $j++) {
											if ($deletable[$i] == 1 || $sess_data['level'] == "superadmin") {
												echo "<button id='remove-atk-button-".$id_atk[0]."' value='".$id_atk[$i]."' class='remove-existing-atk-value'>X</button>";
											}
											else {
												echo "";
											}
										// }
										echo "</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
						<button class="btn-add">+ Add ATK</button>
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).on("click",".remove-existing-atk-value", function(){
			var btn_id = $(this).attr("value");
			console.log(btn_id);
			$.ajax({		
				type: 'post',
				url: "queries/delete_atk.php",
				data: {
				   atk_id: btn_id
				},
				success: function(result) {
				    	alert("ATK telah berhasil di hapus");
		    			window.location.href = "manajemen_atk.php";
				}
			});
			});
	</script>
</html>
