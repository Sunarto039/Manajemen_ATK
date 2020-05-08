<?php
	include_once '../../include/bootstrap.php';
	include_once '../../include/config.php';

	$nama_ruangan = ucfirst(mysqli_escape_string($connect, $_POST['ruangan']));

	$query = "SELECT status_ruangan_id FROM tbl_ruangan"
			." WHERE nama_ruangan = '".$nama_ruangan."'";
	$runquery = mysqli_query($connect, $query);
	$status_ruangan = array();
	while ($data = mysqli_fetch_array($runquery)) {
		array_push($status_ruangan, $data[0]);
	}

	function generate_list_atk($connection) {
		$query = "SELECT id,nama_atk FROM tbl_tipe_atk"
					." ORDER BY nama_atk ASC";
		$runquery = mysqli_query($connection, $query);
		$id_tipe = array();
		$deskripsi = array();
		while ($data = mysqli_fetch_array($runquery)) {
			// array_push($arr, array("id"=>$data['id']));
			array_push($id_tipe, $data[0]);
			array_push($deskripsi, $data[1]);
			echo "<option value=$data[0]>$data[1]</option>";
		}
	}
	function generate_selected_atk($connection, $atk_id) {
		$query = "SELECT id,nama_atk FROM tbl_tipe_atk"
					." ORDER BY nama_atk ASC";
		$runquery = mysqli_query($connection, $query);
		$id_tipe = array();
		$deskripsi = array();
		while ($data = mysqli_fetch_array($runquery)) {
			// array_push($arr, array("id"=>$data['id']));
			array_push($id_tipe, $data[0]);
			array_push($deskripsi, $data[1]);
			if ($atk_id == $data[0]) {
				echo "<option value=$data[0] selected>$data[1]</option>";
			}
			else {
				echo "<option value=$data[0]>$data[1]</option>";
			}
		}
	}
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
				<div class="form-area form-ruangan form-add">
					<h1>Penggantian ATK</h1>
					<br>
					<form id="add-ruangan-form" method="POST">
						<div class="form-body">
							<div class="form-data">
								<label>Ruangan</label>
								<input type="text" name="input-nama-ruangan" disabled="disabled" class="form-value" value="<?php echo $nama_ruangan ?>">
							</div>
							<div class="form-data">
								<label>Tipe Ruangan</label>
									<?php
										echo "<select class='form-value' name='input-tipe-ruangan' disabled='disabled'>";
										$query = "SELECT id, deskripsi FROM tbl_tipe_ruangan"
													." ORDER BY deskripsi ASC";
										$runquery = mysqli_query($connect, $query);
										$id_tipe = array();
										$deskripsi = array();
										while ($data = mysqli_fetch_array($runquery)) {
											array_push($id_tipe, $data[0]);
											array_push($deskripsi, $data[1]);
											echo "<option value=$data[0]>$data[1]</option>";
										}
									?>
								</select>
							</div>
							<div class="form-data">
								<label>List ATK Hilang</label>
								<div id="atk-holder" class="selection-holder">
									<div id="atk-selection-row" class="selection-row">
										<?php
											$arr_atk_id = array();
											$query = "SELECT DISTINCT a.id, b.nama_atk FROM tbl_atk a"
													." INNER JOIN tbl_tipe_atk b ON a.tipe_atk_id = b.id"
													." WHERE status_atk_id= 3 AND nama_ruangan_id = '".$nama_ruangan."'"
													." ORDER BY b.nama_atk ASC";
											$runquery = mysqli_query($connect, $query);

											while ($data = mysqli_fetch_array($runquery)) {
												echo "<div class='atk-list-holder'>";
												echo "<input class='chk-box-atk' type='checkbox' value='".$data[0]."' name='chk-box-".$data[0]."'>";
												echo "<label class='chk-box-label'>".$data[1]."</label>";
												echo "</div>";
											}
										?>
									</div>
								</div>
							</div>
						</div>
						<button id="btn-submit-penggantian" class="btn-edit" type="button">Submit</button>
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$("#btn-submit-penggantian").on("click", function() {
			var chk_box = document.getElementsByClassName("chk-box-atk");
			var checked = [];
			var tot_chk_box = chk_box.length;
			for (var i = 0; i < tot_chk_box; i++) {
				if (chk_box[i].checked) {
					checked.push(chk_box[i].value);
				}
			}
			$.ajax({		
				type: 'post',
				url: "queries/update_hilang.php",
				data: {
				   checked_data: checked
				},
				success: function(result) {
					// console.log(result);
				    if (result == "success"){
				    	alert("ATK telah berhasil di gantikan");
		    			window.location.href = "penggantian.php";
				    }
				}
			});
		});
	</script>
</html>
