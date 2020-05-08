<?php
	include_once '../../include/bootstrap.php';
	include_once '../../include/config.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body>
		<div id="wrapper">

			<?php
				include_once '../../include/sidenav.php';
			?>
			<div id="main-contain">
				<div class="form-area form-user form-add">
					<h1>Add User</h1>
					<br>
					<form id="add-user-form" method="POST">
						<div class="form-body">
							<div class="form-data">
								<label>Email User</label>
								<input type="text" name="input-email-user" class="form-value">
							</div>
							<div class="form-data">
								<label>Nama User</label>
								<input type="text" name="input-nama-user" class="form-value">
							</div>
							<div class="form-data">
								<label>Password</label>
								<input type="password" name="input-password" class="form-value">
							</div>
							<div class="form-data">
								<label>Konfirmasi Password</label>
								<input type="password" name="input-confirm-password" class="form-value">
							</div>
							<div class="form-data">
								<label>blokir ?</label>
								<input type="checkbox" name="is_blocked">
							</div>
							<div class="form-data">
								<label>Admin ?</label>
								<input type="checkbox" name="is_admin">
							</div>
						<button id="btn-add-user" class="btn-add" type="button">+ Add user</button>
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function() {

			$("#btn-add-user").on("click", function() {
				var data = [];
				data = $("#add-user-form").serializeArray();
				var is_blocked = document.getElementsByName("is_blocked")[0].checked;
				var is_admin = document.getElementsByName("is_admin")[0].checked;



				var email_user = data[0].value;
				var nama_user = data[1].value;
				var password = data[2].value;
				var conf_password = data[3].value;



				if (nama_user != null && nama_user != "" && email_user != null && email_user != "" && password != null && password != "")
				{
					if (password == conf_password) {
						$.ajax({		
							type: 'post',
							url: "queries/validate_user.php",
							data: {
								email: email_user,
							   	nama: nama_user
							},
							success: function(result) {
							    if (result == "success"){
							    	$.ajax({
										type: 'post',
										url: "queries/add_user.php",
										data: {
											email: email_user,
											nama: nama_user,
											password: password,
										   	blocked: is_blocked,
										   	admin: is_admin
										},
										success: function(result) {
							    			// console.log(result);
							    			// console.log(is_blocked);
											window.location.href = "user_management.php";
										}
									});
							    }
							    else {
							    	alert("user udah ada sebelumnya");
							    }
							}
						});
					}
					else {
						alert("password dan konfirmasi password beda");
					}
				}
				else {
					alert("nama, email, dan password user mohon diisi");
				}
			});
		});
	</script>
</html>
