<?php
	include_once 'include/bootstrap.php';
	include_once 'include/config.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script type="text/javascript" src="plug_in/js-xlsx-master/dist/xlsx.full.min.js"></script>
	</head>
	<body>
		<div id="wrapper">

			<?php
				include_once 'include/sidenav.php';
			?>

			<div id="main-contain">
				<div id="list-peminjaman" class="detail-head">
					<h1 id="from_date_header" class="toggle-heading" onclick="toggle_heading('from_date_div')">Semester Start</h1>
					<div id="from_date_div" class="">
						<input type="text" name="from_date" id="from_date" class="form-control" />
					</div>

					<h1 id="to_date_header" class="toggle-heading" onclick="toggle_heading('to_date_div')">Semester End</h1>
					<div id="to_date_div" class="">
						<input type="text" name="to_date" id="to_date" class="form-control" />
					</div>

					<h1 id="upload_header" class="toggle-heading" onclick="toggle_heading('upload_div')">Upload File</h1>
					<div id="upload_div" class="">
						<input type="file" name="upload_file" id="upload_file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
					</div>

					<button id="btn-submit-jadwal" class="btn-edit extra-margin" type="button">Upload Jadwal</button>
				</div>
		</div>
	</body>
	<script type="text/javascript">

		$(function() {
			$("#from_date").datepicker();
			$("#to_date").datepicker();
		});

		document.getElementById("from_date_div").style.display = "none";
		document.getElementById("to_date_div").style.display = "none";
		document.getElementById("upload_div").style.display = "none";

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

		$("#btn-submit-jadwal").on("click", function() {
			var from_date = document.getElementById("from_date").value;
			var to_date = document.getElementById("to_date").value;
			var upload_file = document.getElementById("upload_file");

			var now = new Date();
			var cur_d = now.getDate();
			var cur_m = now.getMonth()+1;
			var cur_y = now.getFullYear();
			if (cur_d < 10) {
				cur_d = "0" + cur_d;
			}
			if (cur_m < 10) {
				cur_m = "0" + cur_m;
			}
			var current = cur_m + "/" + cur_d + "/" + cur_y;

			if ( from_date != "" && to_date != "" && upload_file != "") {
				if (from_date >= current) {
					if (to_date >= from_date) {
						var reader = new FileReader();
						reader.readAsArrayBuffer(upload_file.files[0]);

						reader.onload = function(e) {
							var data = new Uint8Array(reader.result);
							var wb = XLSX.read(data, {type:"array"});
							var htmlstr = XLSX.write(wb, {sheet:"ALL", type:"binary", bookType:"html"});
							var form = $(document.createElement("form"));

							$(form).attr("action", "queries/upload_add_semester.php");
							$(form).attr("method", "POST");
							$(form).css("display", "none");

							var input_from_date = $("<input>")
							.attr("type", "text")
							.attr("name", "from_date")
							.val(from_date);
							$(form).append($(input_from_date));

							var input_to_date = $("<input>")
							.attr("type", "text")
							.attr("name", "to_date")
							.val(to_date);
							$(form).append($(input_to_date));

							var input_file = $("<input>")
							.attr("type", "text")
							.attr("name", "uploaded_to_str")
							.val(htmlstr);
							$(form).append($(input_file));

							form.appendTo( document.body );
							$(form).submit();
						}
					}
					else {
						alert("Date to tidak boleh lebih kecil dari Date from");
					}
				}
				else {
					alert("Date from tidak boleh lebih kecil dari tanggal hari ini");
				}
			}
			else {
				alert("Upload jadwal gagal. Data upload jadwal kurang lengkap, mohon di lengkapi");
			}
		});

	</script>
</html>
