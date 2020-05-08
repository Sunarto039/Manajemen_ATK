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
				<div id="list-peminjaman" class="detail-head">
					<!-- <h3 id="from_date_header" class="toggle-heading" onclick="toggle_heading('from_date_div')">Date From</h3>
					<div id="from_date_div" class="">
						<input type="text" name="from_date" id="from_date" class="form-control" />
					</div>

					<h3 id="to_date_header" class="toggle-heading" onclick="toggle_heading('to_date_div')">Date To</h3>
					<div id="to_date_div" class="">
						<input type="text" name="to_date" id="to_date" class="form-control" />
					</div> -->
					<h1 id="semester_header" class="toggle-heading" onclick="toggle_heading('semester_div')">Semester</h1>
					<div id="semester_div" class="">
						<?php
							// $id = array();
							$deskripsi = array();

							$query_get_semester_deskripsi = "SELECT DISTINCT tahun_ajaran FROM tbl_semester";
							$runquery_get_semester_deskripsi = mysqli_query($connect, $query_get_semester_deskripsi);
							while ($data = mysqli_fetch_array($runquery_get_semester_deskripsi)) {
								// array_push($id, $data[0]);
								array_push($deskripsi, $data[0]);
							}

							echo "<select id = 'select-semester' class='selector-semester form-control' name='input-semester'>";
							echo "<option value = 0 selected></option>";
							for($i = 0; $i < sizeof($deskripsi); $i++){
								echo "<option value='$deskripsi[$i]'>$deskripsi[$i]</option>";
							}
							echo "</select>";
						?>
					</div>

					<button id="btn-submit-report" class="btn-edit extra-margin" type="button">Generate Laporan</button>
				</div>
		</div>
	</body>
	<script type="text/javascript">

			// $(function() {
				// $("#from_date").datepicker();
				// $("#to_date").datepicker();
			// });

		// document.getElementById("from_date_div").style.display = "none";
		// document.getElementById("to_date_div").style.display = "none";
		document.getElementById("semester_div").style.display = "none";

		function toggle_heading(div_id) {
			var collapsable = document.getElementById(div_id);
			if (collapsable.style.display == "none") {
				collapsable.style.display = "block";
				collapsable.style.width = "100%";
			}
			else {
				collapsable.style.display = "none";
			}
		}

		$("#btn-submit-report").on("click", function() {
			// var from_date = document.getElementById("from_date");
			// var to_date = document.getElementById("to_date");
			var input_select = document.getElementById("select-semester");
			var selected = input_select.options[input_select.selectedIndex].value;

			// if ( from_date != "" && to_date != "") {
			// 	if (to_date >= from_date) {
			if (selected != 0) {
				var form = $(document.createElement("form"));
			    $(form).attr("action", "sub/report/generate.php");
			    $(form).attr("target", "_blank");
			    $(form).attr("method", "POST");
			    $(form).css("display", "none");

			    // var input_from_date = $("<input>")
			    // .attr("type", "text")
			    // .attr("name", "from_date")
			    // .val(from_date.value);
			    // $(form).append($(input_from_date));

			    // var input_to_date = $("<input>")
			    // .attr("type", "text")
			    // .attr("name", "to_date")
			    // .val(to_date.value);
			    // $(form).append($(input_to_date));

			    var input_semester = $("<input>")
			    .attr("type", "text")
			    .attr("name", "selected_semester")
			    .val(selected);
			    $(form).append($(input_semester));

			    form.appendTo( document.body );
			    $(form).submit();
			}
			else {
				alert("Silahkan pilih semester yang mau ditampilkan pada laporan");
			}
			// 	}
			// 	else {
			// 		alert("Date to tidak boleh lebih kecil dari Date from");
			// 	}
			// }
			// else {
			// 	alert("Generate laporan gagal. Tanggal laporan kurang lengkap, mohon di lengkapi");
			// }
		});

	</script>
</html>
