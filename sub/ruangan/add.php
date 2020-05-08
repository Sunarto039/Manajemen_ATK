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
					<form id="add-ruangan-form" method="POST">
						<div class="form-body">
							<div class="form-data">
								<label>Ruangan</label>
								<input type="text" name="input-nama-ruangan" class="form-value">
							</div>
							<div class="form-data">
								<label>Tipe Ruangan</label>
								<select class="form-value" name="input-tipe-ruangan">
									<?php
										$query = "SELECT id,deskripsi FROM tbl_tipe_ruangan"
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
								<label>List ATK</label>
								<div id="atk-holder" class="selection-holder">
									<div id="atk-selection-row" class="selection-row">
										<select class="atk-value" name="input-atk-ruangan-0">
										<?php
											generate_list_atk($connect);
										?>
										</select>
									</div>
									<button id="add-atk" type="button">+</button>
								</div>
							</div>
						</div>
						<button id="btn-add-ruangan" class="btn-add" type="button">+ Add Ruangan</button>
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function() {
			var i = 0;
			
			$("#add-atk").on("click", function() {
				i++;
				$("#atk-selection-row").append('<select id="new-atk-'+i+'" class="atk-value" name="input-atk-ruangan-'+i+'"> <?php generate_list_atk($connect); ?> </select><button id="new-remove-button-'+i+'" class="remove-atk-value" type="button">X</button>');
			});

			$(document).on("click",".remove-atk-value", function(){
				var btn_id = $(this).attr("id");
				$("#new-atk-"+i).remove();
				$("#new-remove-button-"+i).remove();
			});
			$("#btn-add-ruangan").on("click", function() {
				var data = [];
				data = $("#add-ruangan-form").serializeArray();

				var nama_ruangan = data[0].value;
				var tipe_ruangan = data[1].value;
				var list_atk = [];

				if (nama_ruangan != null && nama_ruangan != "")
				{
					for (var counter = 2; counter < data.length; counter++) {
						list_atk.push(data[counter].value);
					}

					$.ajax({		
						type: 'post',
						url: "queries/validate_ruangan.php",
						data: {
						   ruangan: nama_ruangan
						},
						success: function(result) {
						    if (result == "success"){
						    	$.ajax({
									type: 'post',
									url: "queries/add_ruangan.php",
									data: {
									   ruangan: nama_ruangan,
									   tipe: tipe_ruangan,
									   list: list_atk
									},
									success: function(result) {
										window.open("sub/ruangan/generate_qrcode.php?ruangan="+nama_ruangan, "_blank");
						    			window.location.href = "manajemen_ruangan.php";
									}
								});
						    }
						    else {
						    	alert("ruangan udah ada sebelumnya");
						    }
						}
					});
				}
				else {
					alert("nama ruangan mohon diisi");
				}
			});
		});
	</script>
</html>
