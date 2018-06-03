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

<?php
	$id_anggota = $_GET['id_anggota'];

	// connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if ($db->connect_errno){
		die ("Could not connect to the database: <br />". $db->connect_error);
	}

	if (!isset($_POST["submit"])){
		$query = " SELECT * FROM anggota WHERE id_anggota='".$id_anggota."' ";

		// Execute the query
		$result = $db->query( $query );
		if (!$result){
			die ("Could not query the database: <br />". $db->error);
		}else{
			while ($row = $result->fetch_object()){
				$id_anggota = $row->id_anggota;
				$nama = $row->nama;
				$pass = $row->pass;
				$no_telp = $row->no_telp;
				$alamat = $row->alamat;
			}
		}

	}else{
		$id_anggota = test_input($_POST['id_anggota']);
		if ($id_anggota == ''){
			$error_id_anggota = "ID Anggota harus diisi";
			$valid_id_anggota = FALSE;
		}elseif (!preg_match("/[0-9]/",$id_anggota)) {
	       $error_id_anggota = "Hanya dapat berupa angka";
		   	 $valid_id_anggota = FALSE;
		}else{
			$valid_id_anggota = TRUE;
		}

		$nama = $_POST['nama'];
		if ($nama == '' || $nama == 'none'){
			$error_nama = "Nama harus diisi";
			$valid_nama = FALSE;
		}else{
			$valid_nama = TRUE;
		}

		$pass = $_POST['pass'];
		if(strlen($pass)<6) {
			$error_pass = "Password harus minimal 6 karakter";
			$valid_pass = FALSE;
		}else{
			$valid_pass = TRUE;
		}

		$alamat = $_POST['alamat'];
		if ($alamat == '' || $alamat == 'none'){
			$error_alamat = "Alamat harus diisi";
			$valid_alamat = FALSE;
		}else{
			$valid_alamat = TRUE;
		}

		$no_telp = test_input($_POST['no_telp']);
		if(!preg_match('~^\d{12}$~', $no_telp)) {
	       $error_no_telp = "Hanya nomor yang valid";
		   	 $valid_no_telp = FALSE;
		}else{
			$valid_no_telp = TRUE;
		}

		//update data into database
		if ($valid_id_anggota && $valid_alamat && $valid_pass && $valid_nama && $alamat){
			//escape inputs data
			$id_anggota = $db->real_escape_string($id_anggota);
			$nama = $db->real_escape_string($nama);
			$pass = $db->real_escape_string($pass);
			$no_telp = $db->real_escape_string($no_telp);
			$alamat = $db->real_escape_string($alamat);

			echo '<body class="bg-gray">
				<span class="navbar-default navbar-fixed-top text-muted" align="center">Masuk sebagai ';
			echo $_SESSION['login_admin'];
			echo '</span>
				<nav id="mainNav" class="navbar navbar-default navbar-custom">
					<div class="container">
						<div class="container-fluid">
							<div class="navbar-header page-scroll">
								<a class="navbar-brand page-scroll" href="index.php">home</a>
							</div>
							<div class="collapse navbar-collapse">
								<ul class="nav navbar-nav navbar-right">
									<li>
										<a class="page-scroll" href="viewAnggota.php">Kembali ke data anggota</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</nav>
			</body>';
			$query = "UPDATE anggota SET id_anggota='".$id_anggota."', nama='".$nama."', pass='".$pass."', no_telp='".$no_telp."', alamat='".$alamat."' WHERE id_anggota='".$id_anggota."' ";

			//Execute the query
			$result = $db->query( $query );
			if (!$result){
				echo "<div class='text-danger'>Data tidak dapat diubah</div>";
			  //die ("Could not query the database: <br />". $db->error);
			}else{
				echo "<center><h2 class='text-muted text-box'>Update Success</h2></center>";
				$db->close();
				exit;
			}
		}
	}

	function test_input($data) {
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

?>
</head>
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
						<li>`
							<a class="page-scroll" href="viewAnggota.php">Kembali ke data anggota</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
	<div id="page" class="animated fadeInDown delay-05s">
		<div class="container" align="center">
			<h2 class="section-heading">Edit Anggota</h2>
		</div>
		<br /><br />
		<center>


<!-- <form method="POST" autocomplete="on" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id_buku='.$id_buku;?>"> -->
<form method="POST" autocomplete="on" enctype="multipart/form-data" >
<div class="row">
	 <div class="col-md-4 col-md-offset-4 well">
		<fieldset>
			<div class="form-group">
					<label for="name">ID Anggota</label>
					<input type="text" name="id_anggota" class="form-control" maxlength="16" placeholder="Masukkan no KTP/ Kartu Pelajar (maks 16 karakter)" autofocus value="<?php if(isset($id_anggota)){echo $id_anggota;}?>">
					<span class="text-danger"><?php if(isset($error_id_anggota)){echo $error_id_angota;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Nama</label>
					<input name="nama" required class='form-control' maxlength="30" placeholder="Masukkan nama sesuai ID" autofocus value="<?php if(isset($nama)){echo $nama;}?>">
					<span class="text-danger"><?php if(isset($error_nama)){echo $error_nama;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Password</label>
					<input type="text" name="pass" class="form-control"  maxlength="15" placeholder="Masukkan password" autofocus value="<?php if(isset($pass)){echo $pass;}?>">
					<span class="text-danger"><?php if(isset($error_pass)){echo $error_pass;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Nomor Telepon</label>
					<input type="text" name="no_telp" class="form-control" maxlength="12" placeholder="Masukkan nomor telepon" autofocus value="<?php if(isset($no_telp)){echo $no_telp;}?>">
					<span class="text-danger"><?php if(isset($error_no_telp)){echo $error_no_telp;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Alamat</label>
					<input type="text" name="alamat" class="form-control" maxlength="100" placeholder="Masukkan alamat" autofocus value="<?php if(isset($alamat)){echo $alamat;}?>">
					<span class="text-danger"><?php if(isset($error_alamat)){echo $error_alamat;}?></span>
			</div>
			<div class="form-group">
					<input class="btn" type="submit" name="submit" value="Submit">
			</div>
		</form>
	</div>
</body>
</html>
<?php
$db->close();
?>
