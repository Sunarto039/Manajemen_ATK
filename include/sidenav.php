<!DOCTYPE html>
<html>
	<head>
		<base href="http://localhost/manajem_atk/" />
		<link rel="stylesheet" href="css/sidenav.css">
		<?php
			include 'bootstrap.php';
			session_start();
			// $val = isset($_SESSION["sess_data"]["username"]);
			// print_r($_SESSION["sess_data"]);
			// echo $val;
			// die();
			$sess_data = array();
			if (isset($_SESSION["sess_data"])) {
				$sess_data = $_SESSION["sess_data"];
				// print_r($sess_data);
				// die();
			}
			else {
				header("Location: login.php");
			}


			function generate_nav() {

				$is_selected = array();
				$url_link = array();
				$link_var = array();
				$nav_text = array();

				array_push($url_link, "index.php");
				array_push($url_link, "manajemen_ruangan.php");
				array_push($url_link, "manajemen_atk.php");
				array_push($url_link, "penggantian.php");
				array_push($url_link, "laporan.php");
				array_push($url_link, "upload_jadwal.php");
				array_push($url_link, "user_management.php");
				array_push($url_link, "logout.php");

				array_push($link_var, "dashboard");
				array_push($link_var, "ruangan");
				array_push($link_var, "atk");
				array_push($link_var, "penggantian");
				array_push($link_var, "laporan");
				array_push($link_var, "jadwal");
				array_push($link_var, "user_management");
				array_push($link_var, "logout");

				array_push($nav_text, "DASHBOARD");
				array_push($nav_text, "MANAJEMEN RUANGAN");
				array_push($nav_text, "MANAJEMEN ATK");
				array_push($nav_text, "PENGGANTIAN ATK");
				array_push($nav_text, "LAPORAN");
				array_push($nav_text, "UPLOAD JADWAL");
				array_push($nav_text, "MANAJEMEN USER");
				array_push($nav_text, "LOGOUT");

				if (isset($_POST['selected'])) {
					for ($i=0; $i < sizeof($link_var); $i++) { 
						if ($_POST['selected'] == $link_var[$i]) {
							array_push($is_selected, "selected");
						}
						else {
							array_push($is_selected, "");
						}
					}
				}
				else {
					array_push($is_selected, "selected");
					for ($i=0; $i < sizeof($link_var)-1; $i++) { 
						array_push($is_selected, "");
					}
				}

				for ($i=0; $i < sizeof($link_var); $i++) { 
					echo '<a href="'.$url_link[$i].'" class="link'.$is_selected[$i].'" var="'.$link_var[$i].'"><li class="list-group-item list-group-item-action">'.$nav_text[$i].'</li></a>';
				}
			}
		?>

	</head>
	<body>
		<div id="sidebar">

			<!--
				Top nav
			-->
			<div id="topnav" class="navbar">
				<div class="nav-header">
						<button id="toggle_btn" class ="toggle_bar">
							<span class="ic_bar bar1"></span>
							<span class="ic_bar bar2"></span>
							<span class="ic_bar bar3"></span>
						</button>
						<p><?php echo $sess_data["nama"]; ?></p>
				</div>
				<div id="topmenu" class="collapse">
					<nav>
						<ul class="nav">
							<?php
								generate_nav();
							?>
						</ul>
					</nav>
				</div>
			</div>

			<!--
				Side Nav
			-->


			<nav id="btmnav" class="navbar"">
				<ul class="nav">
					<?php
						generate_nav();
					?>
				</ul>
			</nav>
		</div>
		<!--
			Top nav Script for Toggle
		-->
		<script src="javascript/sidebar.js"></script> 
		<script type="text/javascript">
			$(".link").click(function() {
				var data = $(this).attr('var');
				var href = $(this).attr('href');
				console.log(href);
				redirect_post(href, "selected",data);
			});
		</script>

	</body>
</html>