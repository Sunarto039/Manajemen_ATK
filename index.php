<?php
	include_once 'include/bootstrap.php';
	include_once 'include/config.php';

	$tahun_ajaran = null;
	
	if(isset($_POST['selected_semester'])) {
		$tahun_ajaran = $_POST['selected_semester'];
	}
	else {
		$query_get_latest_semester = "SELECT tahun_ajaran FROM tbl_semester WHERE NOW() BETWEEN semester_mulai AND semester_akhir ORDER BY id DESC LIMIT 1";
		$runquery_get_latest_semester = mysqli_query($connect, $query_get_latest_semester);
		while ($data = mysqli_fetch_array($runquery_get_latest_semester)) {
			$tahun_ajaran = $data[0];
		}
		if (is_null($tahun_ajaran)) {
			$query_get_latest_semester = "SELECT tahun_ajaran FROM tbl_semester ORDER BY id DESC LIMIT 1";
			$runquery_get_latest_semester = mysqli_query($connect, $query_get_latest_semester);
			while ($data = mysqli_fetch_array($runquery_get_latest_semester)) {
				$tahun_ajaran = $data[0];
			}
		}
	}

	$gedung = array();
	$count_peminjaman = array(array());
	$query_get_gedung = "SELECT DISTINCT SUBSTR(nama_ruangan_id, 1, 1)"
						." FROM tbl_peminjaman"
						." WHERE (tgl_peminjaman BETWEEN (SELECT semester_mulai FROM tbl_semester WHERE tahun_ajaran = '".$tahun_ajaran."' ORDER BY semester_mulai ASC LIMIT 1) AND (SELECT semester_akhir FROM tbl_semester WHERE tahun_ajaran = '".$tahun_ajaran."' ORDER BY semester_akhir DESC LIMIT 1))"
						." AND nama_ruangan_id NOT IN('%Lab. Teknik Sipil%','%Lab. Teknik Elektro%','%Kelas Khusus%', 'Studio Gambar')";
						
	$runquery_get_gedung = mysqli_query($connect, $query_get_gedung);
	while ($data = mysqli_fetch_array($runquery_get_gedung)) {
		array_push($gedung, $data[0]);
		$count_peminjaman[$data[0]] = array();
	}

	$graph_color = array();
	array_push($graph_color, "rgb(62, 112, 165)");
	array_push($graph_color, "rgb(171, 66, 70)");
	array_push($graph_color, "rgb(138, 171, 80)");
	array_push($graph_color, "rgb(125, 101, 149)");
	array_push($graph_color, "rgb(66, 150, 174)");
	array_push($graph_color, "rgb(219, 133, 60)");
	array_push($graph_color, "rgb(146, 167, 210)");
	array_push($graph_color, "rgb(167, 121, 123)");
	array_push($graph_color, "rgb(179, 199, 150)");

?>

<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="javascript/chart.js"></script>
		<link rel="stylesheet" href="css/index.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div id="wrapper">
			<?php
				include_once 'include/sidenav.php';

			?>
			<div id="main-contain">
				<div id="chart-contain">
					<div id="chart-semester-selector">
						<p id="semester-selector-text">Semester</p>
						<?php
							
							$deskripsi = array();

							$query_get_semester_deskripsi = "SELECT DISTINCT tahun_ajaran FROM tbl_semester";
							$runquery_get_semester_deskripsi = mysqli_query($connect, $query_get_semester_deskripsi);
							while ($data = mysqli_fetch_array($runquery_get_semester_deskripsi)) {
								array_push($deskripsi, $data[0]);
							}

							echo "<select id = 'select-semester' class='selector-semester' name='input-semester'>";
							for($i = 0; $i < sizeof($deskripsi); $i++){
								if ($deskripsi[$i] == $tahun_ajaran) {
									echo "<option value='$deskripsi[$i]' selected>$deskripsi[$i]</option>";
								}
								else {
									echo "<option value='$deskripsi[$i]'>$deskripsi[$i]</option>";
								}
							}
							echo "</select>";
						?>
						<button id="btn-submit-semester" class="btn-semester">Tampil</button>
						<?php 
							$query_get_total_peminjaman = "SELECT COUNT(id)"
														." FROM tbl_peminjaman"
														." WHERE (tgl_peminjaman BETWEEN (SELECT semester_mulai FROM tbl_semester WHERE tahun_ajaran = '".$tahun_ajaran."' ORDER BY semester_mulai ASC LIMIT 1) AND (SELECT semester_akhir FROM tbl_semester WHERE tahun_ajaran = '".$tahun_ajaran."' ORDER BY semester_akhir DESC LIMIT 1))"
														." AND nama_ruangan_id NOT IN('%Lab. Teknik Sipil%','%Lab. Teknik Elektro%','%Kelas Khusus%', 'Studio Gambar')"
														." AND jadwal_kuliah_id IN(SELECT id FROM tbl_jadwal_perkuliahan WHERE semester_id IN(SELECT id FROM tbl_semester WHERE tahun_ajaran='".$tahun_ajaran."'))";
							$runquery_get_total_peminjaman = mysqli_query($connect, $query_get_total_peminjaman);
							while ($data = mysqli_fetch_array($runquery_get_total_peminjaman)) {

								echo "<p class='float-right'>Total Peminjaman : ";
								echo $data[0];
								echo "</p>";
							}
						?>
					</div>
					<div id="chart-body">
						<canvas id="chart_penggantian"></canvas>
					</div>
				</div>

			    <script type="text/javascript">
		                	<?php
								$month = array();
								$count = array();

								$query = "CALL sp_gen_dashboard_data('".$tahun_ajaran."')";
								// echo $query;
								// die();
								$runquery = mysqli_query($connect, $query);
								if (mysqli_num_rows($runquery) != 0) {
									while ($data = mysqli_fetch_array($runquery)) {
										array_push($month, $data[0]);
										for ($i = 0; $i < sizeof($gedung); $i++) {
											array_push($count_peminjaman[$gedung[$i]], $data[$i+1]);
										}
									}
								}
								else {
									array_push($month, date('m'));
									array_push($count_peminjaman[0], 0);
								}
								while($connect->next_result()){

								}
		                	?>

		                    var month = [];
		                    var tot = [];


		                    <?php
		                    	for ($i = 0; $i < sizeof($month); $i++) {
		                    		echo "month.push(translate_month(".$month[$i]."));";
		                    	}
		                    	for ($i = 0; $i < sizeof($gedung); $i++) {
		                    		echo "tot[".$i."] = [];";
		                    		for ($j = 0; $j < sizeof($count_peminjaman[$gedung[$i]]); $j++) {
		                    			echo "tot[".$i."].push(".$count_peminjaman[$gedung[$i]][$j].");";
		                    		}
		                    	}
		                    ?>
		                    var chartdata = {
		                        labels: month,
		                        datasets : [
		                        	<?php
		                        		for($i = 0; $i < sizeof($gedung); $i++) {
		                        			echo "{";
		                        			echo "label : 'Gedung ".$gedung[$i]."',";
		                        			echo "data : tot[".$i."],";
		                        			echo "backgroundColor : '".$graph_color[$i]."',";
		                        			echo "borderColor : '".$graph_color[$i]."',";
								            echo "fill : false,";
								            echo "lineTension : 0,";
								            echo "pointRadius : 5";
								            if ( ($i + 1) != sizeof($gedung)) {
								            	echo "},";
								            }
								            else {
								            	echo "}";
								            }
		                        		}
						          	?>
		                        ]
		                    };
		                    var options = {
		                    	responsive:true,
								maintainAspectRatio: false,
								scales : {
									yAxes: [{
										gridLines: {
								        display: true,
								        color: "rgba(0, 0, 0)"
								      },
						                ticks: {
                							precision:0,
                							beginAtZero:true,
                    						fontColor: "rgba(0, 0, 0)"
						                }
						            }],
						            xAxes: [{
						            	ticks: {
						            		fontColor: "rgba(0, 0, 0)"
						            	}
						            }]
								},
								layout : {
									padding: {
										left: 15,
										right: 25,
										bottom: 10
									}
								},
						        title : {
						          	display : true,
						          	position : "top",
						          	text : "ATK yang Terpinjam",
						          	fontSize : 18,
						          	fontColor : "black"
					        	},
						        legend : {
						          	display : true,
						          	position: "bottom"
						        }
						    };

		                    var ctx = $("#chart_penggantian");
							var chart = new Chart( ctx, {
							        type : "line",
							        data : chartdata,
							        options : options
					        });
			    </script>

			    	<?php
			    		$query_get_gedung_overall = "SELECT DISTINCT SUBSTR(nama_ruangan, 1, 1)"
												." FROM tbl_ruangan"
												." WHERE nama_ruangan NOT IN('%Lab. Teknik Sipil%','%Lab. Teknik Elektro%','%Kelas Khusus%', 'Studio Gambar')";
						$runquery_get_gedung_overall = mysqli_query($connect, $query_get_gedung_overall);
						$gedung_overall = array();

						while ($data = mysqli_fetch_array($runquery_get_gedung_overall)) {
							array_push($gedung_overall, $data[0]);
						}

			    		for ($i=0; $i < sizeof($gedung_overall); $i++) { 

							$count_ruangan = "";
							$count_atk = "";
							$count_hilang = "";
							$count_ganti = "";
							$query_get_ruangan = "SELECT COUNT(nama_ruangan) FROM tbl_ruangan"
												." WHERE SUBSTR(nama_ruangan,1,1) = '".$gedung_overall[$i]."'";
							$runquery_ruangan = mysqli_query($connect, $query_get_ruangan);
							while ($data = mysqli_fetch_array($runquery_ruangan)) {
								$count_ruangan = $data[0];
							}

							$query_get_atk = "SELECT COUNT(id) FROM tbl_atk"
											." WHERE status_atk_id = 1 AND SUBSTR(nama_ruangan_id,1,1) = '".$gedung_overall[$i]."'";
							$runquery_atk = mysqli_query($connect, $query_get_atk);
							while ($data = mysqli_fetch_array($runquery_atk)) {
								$count_atk = $data[0];
							}
							
							$query_get_hilang = "SELECT COUNT(id) FROM tbl_atk"
											." WHERE status_atk_id = 3 AND SUBSTR(nama_ruangan_id,1,1) = '".$gedung_overall[$i]."'";
							$runquery_hilang = mysqli_query($connect, $query_get_hilang);
							while ($data = mysqli_fetch_array($runquery_hilang)) {
								$count_hilang = $data[0];
							}
							
							$query_get_ganti = "SELECT COUNT(id) FROM tbl_pengembalian_hilang"
												." WHERE SUBSTR(nama_ruangan_id, 1,1) = '".$gedung_overall[$i]."'";
							$runquery_ganti = mysqli_query($connect, $query_get_ganti);
							while ($data = mysqli_fetch_array($runquery_ganti)) {
								$count_ganti = $data[0];
							}

			    			echo "<div class='statistic-container'>";
				    			echo "<h1>Gedung ".$gedung_overall[$i]."</h1>";
				    			echo "<div class='statistic'>";
									echo "<div class='statistic_data statistic_1'>";
							    		echo "<i class='material-icons data_1'>assignment_turned_in</i>";
							    		echo "<h3 class='statistic_title'>".$count_ruangan."</h3>";
							    		echo "<p class='statistic_info'>Ruangan yang Tersedia</p>";
						    		echo "</div>";
							    		echo "<div class='statistic_data statistic_1'  onclick='cek_atk(\"".$gedung_overall[$i]."\")'>";
							    		echo "<i class='material-icons data_2'>brush</i>";
							    		echo "<h3 class='statistic_title'>".$count_atk."</h3>";
							    		echo "<p class='statistic_info'>ATK yang Tersedia</p>";
						    		echo "</div>";
						    		echo "<div class='statistic_data statistic_1'>";
							    		echo "<i class='material-icons data_3'>cancel</i>";
							    		echo "<h3 class='statistic_title'>".$count_hilang."</h3>";
							    		echo "<p class='statistic_info'>ATK Hilang</p>";
						   		 	echo "</div>";
					    			echo "<div class='statistic_data statistic_last'>";
							    		echo "<i class='material-icons data_4'>refresh</i>";
							    		echo "<h3 class='statistic_title'>".$count_ganti."</h3>";
							    		echo "<p class='statistic_info'>ATK yang Terganti</p>";
						    		echo "</div>";
				    			echo "</div>";
			    			echo "</div>";
			    		}
			    		echo "<br>";
			    	?>
			    </div>
			</div>	
		</div>

	</body>

	<script type="text/javascript">
		
		function cek_atk(gedung) {
			var form = $(document.createElement("form"));
		    $(form).attr("action", "sub/atk/atk_tersedia.php");
		    $(form).attr("method", "POST");
		    $(form).css("display", "none");

		    var input_ruangan = $("<input>")
		    .attr("type", "text")
		    .attr("name", "gedung")
		    .val(gedung);
		    $(form).append($(input_ruangan));

		    form.appendTo( document.body );
		    $(form).submit();
		}

		$("#btn-submit-semester").on("click", function() {
			var input_select = document.getElementById("select-semester");
			var selected = input_select.options[input_select.selectedIndex].value;

			var form = $(document.createElement("form"));
		    $(form).attr("action", "index.php");
		    $(form).attr("method", "POST");
		    $(form).css("display", "none");

		    var input_from_date = $("<input>")
		    .attr("type", "text")
		    .attr("name", "selected_semester")
		    .val(selected);
		    $(form).append($(input_from_date));

		    form.appendTo( document.body );
		    $(form).submit();

		});


	</script>
</html>