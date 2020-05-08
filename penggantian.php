<?php
	include_once 'include/bootstrap.php';
	include_once 'include/config.php';
	//$ruangan = ucfirst(mysqli_escape_string($connect, $_POST['ruangan']));
	// $ruangan = 'A301';
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
				<div id="list-peminjaman" class="detail-head">
					<?php
						$counter = 0;
						$query = "SELECT DISTINCT nama_ruangan_id FROM tbl_atk"
								." WHERE status_atk_id = 3"
								." ORDER BY nama_ruangan_id ASC";
						$runquery = mysqli_query($connect, $query);
						$nama_ruangan = array();
						while ($data = mysqli_fetch_array($runquery)) {
							array_push($nama_ruangan, $data[0]);
						}

						for ($counter=0; $counter < sizeof($nama_ruangan); $counter++) { 
							echo "<h1 id='ruangan-heading' class='toggle-heading' onclick='ganti_atk(\"".$nama_ruangan[$counter]."\")'>".$nama_ruangan[$counter]."</h1>";
						}

					?>
				</div>
		</div>
	</body>
	<script type="text/javascript">
		
		function ganti_atk(ruangan) {
			var form = $(document.createElement("form"));
		    $(form).attr("action", "sub/ruangan/penggantian_atk.php");
		    $(form).attr("method", "POST");
		    $(form).css("display", "none");

		    var input_ruangan = $("<input>")
		    .attr("type", "text")
		    .attr("name", "ruangan")
		    .val(ruangan );
		    $(form).append($(input_ruangan));

		    form.appendTo( document.body );
		    $(form).submit();
		}


	</script>
</html>
