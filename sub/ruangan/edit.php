<?php
	include_once '../../include/bootstrap.php';
	include_once '../../include/config.php';

	$nama_ruangan = ucfirst(mysqli_escape_string($connect, $_POST['ruangan']));

	$query = "SELECT status_ruangan_id, tipe_ruangan_id FROM tbl_ruangan"
			." WHERE nama_ruangan = '".$nama_ruangan."'";
	$runquery = mysqli_query($connect, $query);
	$status_ruangan = array();
	$tipe_ruangan = array();
	while ($data = mysqli_fetch_array($runquery)) {
		array_push($status_ruangan, $data[0]);
		array_push($tipe_ruangan, $data[1]);
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
					<h1>Edit Ruangan</h1>
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

										if ($status_ruangan[0] == 2 && $sess_data['level'] != "superadmin") {
											echo "<select class='form-value' name='input-tipe-ruangan' disabled='disabled'>";
										}
										else {
											echo "<select class='form-value' name='input-tipe-ruangan'>";
										}
										$query = "SELECT id, deskripsi FROM tbl_tipe_ruangan"
													." ORDER BY deskripsi ASC";
										$runquery = mysqli_query($connect, $query);
										$id_tipe = array();
										$deskripsi = array();
										while ($data = mysqli_fetch_array($runquery)) {
											array_push($id_tipe, $data[0]);
											array_push($deskripsi, $data[1]);
											if ($data[0] == $tipe_ruangan[0]) {
												echo "<option value=$data[0] selected>$data[1]</option>";
											}
											else {
												echo "<option value=$data[0]>$data[1]</option>";
											}
										}
									?>
								</select>
							</div>
							<div class="form-data">
								<label>List ATK</label>
								<div id="atk-holder" class="selection-holder">
									<div id="atk-selection-row" class="selection-row">
										<?php
											$tot_list_atk = 0;
											$arr_atk_id = array();
											$query = "SELECT a.id, b.id, b.nama_atk FROM tbl_atk a"
												." INNER JOIN tbl_tipe_atk b ON a.tipe_atk_id = b.id"
												." WHERE a.nama_ruangan_id = '".$nama_ruangan."' AND status_atk_id IN(1,2)"
												." ORDER BY a.id ASC";
											$runquery = mysqli_query($connect, $query);

											while ($data = mysqli_fetch_array($runquery)) {
												array_push($arr_atk_id, $data[0]);
												$tot_list_atk += 1;
												if ($status_ruangan[0] == 2 && $sess_data['level'] != "superadmin") {
													echo "<select id='edit-atk-ruangan-".$data[0]."' class='atk-value' name='edit-atk-ruangan-".$data[0]."' disabled='disabled'>";
													generate_selected_atk($connect, $data[1]);
													echo "</select>";
												}
												else {
													echo "<select id='edit-atk-ruangan-".$data[0]."' class='atk-value' name='edit-atk-ruangan-".$data[0]."'>";
													generate_selected_atk($connect, $data[1]);
													echo "</select><button id='edit-remove-button-".$data[0]."' class='remove-existing-atk-value' type='button' value='".$data[0]."'>X</button>";
												}
											}
										?>
									</div>
									<?php
										if ($status_ruangan[0] == 2 && $sess_data['level'] != "superadmin") {
										}
										else {
											echo "<button id='add-atk' type='button'>+</button>";
										}

									?>
								</div>
							</div>
						</div>
						<button id="btn-edit-ruangan" class="btn-edit" type="button">Submit</button>
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function() {
			var i = 0;
			var tot_existing_list_atk = <?php echo $tot_list_atk ?>;
			var arr_id_atk = <?php echo json_encode($arr_atk_id); ?>;
			var arr_id_atk_remove = [];
			
			$("#add-atk").on("click", function() {
				i++;
				$("#atk-selection-row").append('<select id="new-atk-ruangan-'+i+'" class="atk-value" name="input-atk-ruangan-'+i+'"> <?php generate_list_atk($connect); ?> </select><button id="new-remove-button-'+i+'" class="remove-atk-value" type="button">X</button>');
			});

			$(document).on("click",".remove-existing-atk-value", function(){
				var btn_id = $(this).attr("value");
				$("#edit-atk-ruangan-"+btn_id).remove();
				$("#edit-remove-button-"+btn_id).remove();
				arr_id_atk_remove.push(btn_id);
				var index = arr_id_atk.indexOf(btn_id);
				arr_id_atk.splice(index, 1);
				tot_existing_list_atk--;
				// console.log(arr_id_atk);
				// console.log(arr_id_atk_remove);
			});
			$(document).on("click",".remove-atk-value", function(){
				var btn_id = $(this).attr("value");
				$("#new-atk-ruangan-"+i).remove();
				$("#new-remove-button-"+i).remove();
			});
			$("#btn-edit-ruangan").on("click", function() {
				var data = [];
				data = $("#add-ruangan-form").serializeArray();

				var nama_ruangan = '<?php echo $nama_ruangan ?>';
				var list_atk = [];
				var list_atk_id = [];
				var new_list_atk = [];

				if (nama_ruangan != null && nama_ruangan != "")
				{
					for (var counter = 1; counter < tot_existing_list_atk+1; counter++) {
						list_atk.push(data[counter].value);
					}
					for (var counter = tot_existing_list_atk+1; counter < data.length; counter++) {
						new_list_atk.push(data[counter].value);
					}
					// console.log(list_atk);
					// console.log(new_list_atk);
					// console.log(arr_id_atk_remove);
					$.ajax({		
						type: 'post',
						url: "queries/update_ruangan.php",
						data: {
						   ruangan: nama_ruangan,
						   deleted_atk: arr_id_atk_remove,
						   update_atk: list_atk,
						   update_atk_id: arr_id_atk,
						   new_atk: new_list_atk
						},
						success: function(result) {
							// console.log(result);
						    // if (result == "success"){
						    	alert("ruangan telah berhasil di ganti");
				    			window.location.href = "manajemen_ruangan.php";
						    // }
						}
					});
				}
			});
		});
	</script>
</html>
