<?php
session_start();
include 'connect.php';

if(!$_SESSION){
	header('location:loginAdmin.php');}

?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Perpustakaan Karangduren</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/font-awesome.css" rel="stylesheet">
</head>
<body>
	<body class="bg-gray">
		<span class="navbar-default navbar-fixed-top text-muted" align="center">Masuk sebagai <?php echo $_SESSION['login_admin']?></span>
	  <nav id="mainNav" class="navbar navbar-default navbar-custom">
	    <div class="container">
	      <div class="container-fluid">
	        <div class="navbar-header page-scroll">
	          <a class="navbar-brand page-scroll" href="index.php">home</a>
	        </div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a class="page-scroll" href="viewBook.php">Kembali ke data buku</a>
							</li>
						</ul>
					</div>
	      </div>
	    </div>
	  </nav>
		<div id="page" class="animated fadeInDown delay-05s">
			<center>
				<?php
	$id_buku = $_GET['id_buku'];

	// connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if ($db->connect_errno){
		die ("Could not connect to the database: <br />". $db->connect_error);
	}

	$query = $db->query(" DELETE FROM buku WHERE id_buku='$id_buku' ");

	if(!$query){
		echo "<div class='text-danger'>Buku tidak dapat dihapus</div>";
	}else{
		echo "<h2 class='text-muted text-box'>Buku terhapus</h2>";
	}

$db->close();
?>
		</div>
	</body>
</html>
