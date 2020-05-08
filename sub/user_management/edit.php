<?php
	include_once '../../include/bootstrap.php';
	include_once '../../include/config.php';

	$id = mysqli_escape_string($connect, $_POST['user_id']);

	$query = "SELECT username, nama, blokir, level FROM tbl_user"
			." WHERE id = ".$id;
	$runquery = mysqli_query($connect, $query);
	$nama;
	$username;
	$is_blocked;
	$is_admin;
	while ($data = mysqli_fetch_array($runquery)) {
		$username = explode("@", $data[0])[0];
		$nama = $data[1];
		$is_blocked = $data[2];
		$is_admin = $data[3];
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
				<div class="form-area form-user form-add">
					<h1>Edit User</h1>
					<br>
					<form id="add-user-form" method="POST">
						<div class="form-body">
							<div class="form-data">
								<label>Email User</label>
								<input type="text" name="input-email-user" class="form-value" disabled="disabled" value="<?php echo $username; ?>">
							</div>
							<div class="form-data">
								<label>Nama User</label>
								<input type="text" name="input-nama-user" class="form-value" disabled="disabled" value="<?php echo $nama; ?>">
							</div>
							<?php
								if ($sess_data['id_user'] == $id || $sess_data['level'] == "superadmin") {
									echo '<div class="form-data">';
									echo '<label>Password</label>';
									echo '<input type="password" name="input-password" class="form-value">';
									echo '</div>';
									echo '<div class="form-data">';
									echo '<label>Konfirmasi Password</label>';
									echo '<input type="password" name="input-confirm-password" class="form-value">';
									echo '</div>';
								}
								if ($sess_data['level'] == "superadmin") {
									echo '<div class="form-data">';
									echo '<label>blokir ?</label>';
									if ($is_blocked == "Y") {
										echo '<input type="checkbox" name="is_blocked" checked>';
									}
									else {
										echo '<input type="checkbox" name="is_blocked">';
									}
									echo '</div>';
									echo '<div class="form-data">';
									echo '<label>Admin ?</label>';
									if ($is_admin == "superadmin") {
										echo '<input type="checkbox" name="is_admin" checked>';
									}
									else {
										echo '<input type="checkbox" name="is_admin">';
									}
									echo '</div>';
								}
							?>
						<button id="btn-edit-user" class="btn-add" type="button">Edit user</button>
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">

		$("#btn-edit-user").on("click", function() {
			var chk_blocked = document.getElementsByName("is_blocked")[0];
			var chk_admin = document.getElementsByName("is_admin")[0];
			var input_password = document.getElementsByName("input-password")[0];
			var input_conf_password = document.getElementsByName("input-confirm-password")[0];

			var id = <?php echo $id; ?>;
			var is_blocked = false;
			var is_admin = false;
			var password = "";
			var conf_password = "";

			if (chk_blocked) {
				is_blocked = chk_blocked.checked;
			}
			if (chk_admin) {
				is_admin = chk_admin.checked;
			}
			if (input_password) {
				password = input_password.value;
			}
			if (input_conf_password) {
				conf_password = input_conf_password.value;
			}

			if (password == conf_password) {
				$.ajax({		
					type: 'post',
					url: "queries/update_user.php",
					data: {
						id: id,
						password: password,
					   	blocked: is_blocked,
					   	admin: is_admin
					},
					success: function(result) {
				    	alert("User telah berhasil di ganti");
						window.location.href = "user_management.php";
					}
				});
			}
			else {
				alert("password dan konfirmasi password beda");
			}
		});
			
	</script>
</html>
