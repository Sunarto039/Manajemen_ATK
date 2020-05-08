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
					<h1>Manajemen User</h1>
					<br>
					<form  action="sub/user_management/add.php">
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>Username</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$query = "SELECT id, username FROM tbl_user"
												." ORDER BY username ASC";
									$runquery = mysqli_query($connect, $query);
									$id = array();
									$username = array();
									while ($data = mysqli_fetch_array($runquery)) {
										// array_push($arr, array("id"=>$data['id']));
										array_push($id, $data[0]);
										array_push($username, $data[1]);
									}
									for ($i=0; $i < sizeof($username); $i++) { 
										echo "<tr>";
										echo "<td>".($i+1)."</td>";
										if ($sess_data['level'] == "superadmin" || $sess_data['id_user'] == $id[$i]) {
											echo "<td>".$username[$i]."</td>";
											echo "<td class='td-link' onclick='edit_user(\"".$id[$i]."\");'>Edit</td>";
										}
										else {
											echo "<td colspan=2>".$username[$i]."</td>";}
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
						<?php
							if ($sess_data['level'] == "superadmin") {
								echo "<button class='btn-add'>+ Add User</button>";
							}
						?>
					</form>
				</div>	
			</div>
		</div>
	</body>
	<script type="text/javascript">
			function edit_user(id) {

			    var form = $(document.createElement("form"));
			    $(form).attr("action", "sub/user_management/edit.php");
			    $(form).attr("method", "POST");
			    $(form).css("display", "none");

			    var input_user = $("<input>")
			    .attr("type", "text")
			    .attr("name", "user_id")
			    .val(id );
			    $(form).append($(input_user));

			    form.appendTo( document.body );
			    $(form).submit();
			}
	</script>
</html>
