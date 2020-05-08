<?php
	include_once '../../include/bootstrap.php';
	include_once '../../include/config.php';

	function generate_list_atk($connection) {
		$query = "SELECT id,nama_atk FROM tbl_tipe_atk"
					." ORDER BY nama_atk ASC";
		$runquery = mysqli_query($connection, $query);
		$id_tipe = array();
		$deskripsi = array();
		while ($data = mysqli_fetch_array($runquery)) {
			array_push($id_tipe, $data[0]);
			array_push($deskripsi, $data[1]);
			echo "<option value=$data[0]>$data[1]</option>";
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
					<h1>Add Ruangan</h1>
					<br>
					<form id="add-atk-form" method="POST">
						<div class="form-body">
							<div class="form-data">
								<label>ATK</label>
								<input type="text" name="input-nama-atk" class="form-value">
							</div>
						</div>
						<button id="btn-add-atk" class="btn-add" type="button">+ Add ATK</button>
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#btn-add-atk").on("click", function() {
				var data = [];
				data = $("#add-atk-form").serializeArray();

				var nama_atk = (data[0].value).trim();

				if (nama_atk != null && nama_atk != "")
				{
					for (var counter = 2; counter < data.length; counter++) {
						list_atk.push(data[counter].value);
					}

					$.ajax({		
						type: 'post',
						url: "queries/validate_atk.php",
						data: {
						   atk: nama_atk
						},
						success: function(result) {
						    if (result == "success"){
						    	$.ajax({
									type: 'post',
									url: "queries/add_atk.php",
									data: {
									   atk: nama_atk,
									},
									success: function(result) {
						    			window.location.href = "manajemen_atk.php";
									}
								});
						    }
						    else {
						    	alert("ATK udah ada sebelumnya");
						    }
						}
					});
				}
				else {
					alert("nama ATK mohon diisi");
				}
			});
		});
	</script>
</html>
