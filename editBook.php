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
	$id_buku = $_GET['id_buku'];

	// connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if ($db->connect_errno){
		die ("Could not connect to the database: <br />". $db->connect_error);
	}

	if (!isset($_POST["submit"])){
		$query = " SELECT * FROM buku WHERE id_buku='".$id_buku."' ";

		// Execute the query
		$result = $db->query( $query );
		if (!$result){
			die ("Could not query the database: <br />". $db->error);
		}else{
			while ($row = $result->fetch_object()){
				$id_buku = $row->id_buku;
				$no_buku = $row->no_buku;
				$Judul = $row->Judul;
				$id_kategori = $row->id_kategori;
				$Pengarang = $row->Pengarang;
				$Penerbit = $row->Penerbit;
				$TahunBuku = $row->TahunBuku;
				$stok = $row->stok;
				$file_gambar = $row->file_gambar;
			}
		}

	}else{

		// $id_buku = test_input($_POST['id_buku']);
		// if ($id_buku == ''){
		// 	$error_id_buku = "Id Buku is required";
		// 	$valid_id_buku = FALSE;
		// }else{
		// 	$valid_id_buku = TRUE;
		// }

		$no_buku = test_input($_POST['no_buku']);
		if ($no_buku == ''){
			$error_no_buku = "ID Buku is required";
			$valid_no_buku = FALSE;
		}elseif (!preg_match("/[-0-9]/",$no_buku)) {
	       $error_no_buku = "Hanya angka dan strip (-) yang diperbolehkan";
		   	 $valid_no_buku = FALSE;
		}else{
			$valid_no_buku = TRUE;
		}

		$Pengarang = test_input($_POST['Pengarang']);
		if ($Pengarang == ''){
			$error_Pengarang = "Pengarang harus diisi";
			$valid_Pengarang = FALSE;
		}else{
			$valid_Pengarang = TRUE;
		}

		$Judul = $_POST['Judul'];
		if ($Judul == '' || $Judul == 'none'){
			$error_Judul = "Judul harus diisi";
			$valid_Judul = FALSE;
		}else{
			$valid_Judul = TRUE;
		}

		$Penerbit = $_POST['Penerbit'];
		if ($Penerbit == '' || $Penerbit == 'none'){
			$error_Penerbit = "Penerbit harus diisi";
			$valid_Penerbit = FALSE;
		}else{
			$valid_Penerbit = TRUE;
		}

		$id_kategori = $_POST['id_kategori'];
		if ($id_kategori == '' || $id_kategori == 'none'){
			$error_id_kategori = "ID Kategori harus diisi";
			$valid_id_kategori = FALSE;
		}else{
			$valid_id_kategori = TRUE;
		}

		$TahunBuku = test_input($_POST['TahunBuku']);
		if ($TahunBuku == ''){
			$error_TahunBuku = "Tahun harus diisi";
			$valid_TahunBuku = FALSE;
		}elseif (!preg_match("/[0-9]/",$TahunBuku)) {
	       $error_TahunBuku = "Hanya nomor yang diperbolehkan";
		   	 $valid_TahunBuku = FALSE;
		}else{
			$valid_TahunBuku = TRUE;
		}

		$stok = $_POST['stok'];
		if ($stok == '' || $stok == 'none'){
			$error_stok = "Stok harus diisi";
			$valid_stok = FALSE;
		}else{
			$valid_stok = TRUE;
		}

		// $price = $_POST['price'];
		// if ($price == ''){
		// 	$error_price = "Price is required";
		// 	$valid_price = FALSE;
		// }elseif (!preg_match("/[0-9.]/",$price)){
		// 	$error_price = "Only number allowed";
		// 	$valid_price = FALSE;
		// }else{
		// 	$valid_price = TRUE;
		// }

		//update data into database
		if ($valid_no_buku && $valid_Pengarang && $valid_Penerbit && $valid_Judul && $TahunBuku){
			//escape inputs data
			$no_buku = $db->real_escape_string($no_buku);
			$Pengarang = $db->real_escape_string($Pengarang);
			$Penerbit = $db->real_escape_string($Penerbit);
			$Judul = $db->real_escape_string($Judul);
			$id_kategori = $db->real_escape_string($id_kategori);
			$TahunBuku = $db->real_escape_string($TahunBuku);
			// $file_gambar = $db->real_escape_string($file_gambar);
			//Asign a query
			// $query = " UPDATE buku SET ISBN='".$ISBN."', Judul='".$Judul."' , id_kategori='".$id_kategori."', Pengarang='".$Pengarang."', Penerbit='".$Penerbit."', kota_terbit='".$kota_terbit."' editor='".$editor."', file_gambar='".$file_gambar."', stok='".$stok."',  WHERE id_buku='".$id_buku."' ";


			if(!empty($_FILES['file_gambar']['tmp_name']))
			{
				$target_dir = "uploads/";
				$target_file = $target_dir . basename($_FILES["file_gambar"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$file_gambar_name = sha1(date("Y-m-d H:i:s").rand(1,100).rand(1,10)).'.'.$imageFileType;
				$target_file = $target_dir.$file_gambar_name;
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"])) {
				    $check = getimagesize($_FILES["file_gambar"]["tmp_name"]);
				    if($check !== false) {
				        echo "File is an image - " . $check["mime"] . "";
				        $uploadOk = 1;
				    } else {
				        echo "File is not an image";
				        $uploadOk = 0;
				    }
				}
				// Check if file already exists
				if (file_exists($target_file)) {
				    echo "Sorry, file already exists";
				    $uploadOk = 0;
				}
				// Check file size
				if ($_FILES["file_gambar"]["size"] > 500000) {
				    echo "Sorry, your file is too large";
				    $uploadOk = 0;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				    echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan";
				    $uploadOk = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
				    echo "Maaf, file anda tidak ter-unggah";
				// if everything is ok, try to upload file
				} else {
				    if (move_uploaded_file($_FILES["file_gambar"]["tmp_name"], $target_file)) {
				        $db->query("UPDATE buku SET file_gambar = '$file_gambar_name' WHERE id_buku = '$id_buku'");
				    }
				}
			}

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
										<a class="page-scroll" href="viewBook.php">Kembali ke data buku</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</nav>
			</body>';
			$query = "UPDATE buku SET no_buku='".$no_buku."', Judul='".$Judul."', id_kategori='".$id_kategori."', Pengarang='".$Pengarang."', Penerbit='".$Penerbit."', TahunBuku='".$TahunBuku."', stok='".$stok."' WHERE id_buku='".$id_buku."' ";

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
						<li>
							<a class="page-scroll" href="viewBook.php">Kembali ke data buku</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
	<div id="page" class="animated fadeInDown delay-05s">
		<div class="container" align="center">
			<h2 class="section-heading">Edit Buku</h2>
		</div>
		<br /><br />
		<center>


<!-- <form method="POST" autocomplete="on" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id_buku='.$id_buku;?>"> -->
<form method="POST" autocomplete="on" enctype="multipart/form-data" >
<div class="row">
	 <div class="col-md-4 col-md-offset-4 well">
		<fieldset>
			<div class="form-group">
				<label for="name">No</label>
				<input type="text" name="id_buku" disabled class="form-control" maxlength="4" placeholder="Nomor" autofocus value="<?php if(isset($id_buku)){echo $id_buku;}?>">
				<span class="text-danger"><?php if(isset($error_id_buku)){echo $error_id_buku;}?></span>
			</div>
			<div class="form-group">
					<label for="name">ID Buku</label>
					<input type="text" name="no_buku" class="form-control" maxlength="15" placeholder="Masukkan ID Buku" autofocus value="<?php if(isset($no_buku)){echo $no_buku;}?>">
					<span class="text-danger"><?php if(isset($error_no_buku)){echo $error_no_buku;}?></span>
			</div>
			<div class="form-group">
					<label for="name">ID Kategori</label>
					<input name="id_kategori" required class='form-control' maxlength="2" placeholder="Pilih ID Kategori" autofocus list="dataid_kategori" value="<?php if(isset($id_kategori)){echo $id_kategori;}?>">
					<datalist id="dataid_kategori">
						<?php
						$query = " SELECT * FROM kategori ";
						$result = $db->query( $query );
						if (!$result){
							die ("Could not query the database: <br />". mysqli_error($con));
						}
						while ($row = mysqli_fetch_array($result)){
							echo "<option value='".$row['id_kategori']."'>".$row['nama']."<option/>";
						}
						?>
					</datalist>
					<span class="text-danger"><?php if(isset($error_id_kategori)){echo $error_id_kategori;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Judul</label>
					<input type="text" name="Judul" class="form-control"  maxlength="50" placeholder="Masukkan judul buku" autofocus value="<?php if(isset($Judul)){echo $Judul;}?>">
					<span class="text-danger"><?php if(isset($error_Judul)){echo $error_Judul;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Pengarang</label>
					<input type="text" name="Pengarang" class="form-control" maxlength="50" placeholder="Masukkan nama pengarang" autofocus value="<?php if(isset($Pengarang)){echo $Pengarang;}?>">
					<span class="text-danger"><?php if(isset($error_Pengarang)){echo $error_Pengarang;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Penerbit</label>
					<input type="text" name="Penerbit" class="form-control" maxlength="50" placeholder="Masukkan penerbit" autofocus value="<?php if(isset($Penerbit)){echo $Penerbit;}?>">
					<span class="text-danger"><?php if(isset($error_Penerbit)){echo $error_Penerbit;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Tahun</label>
					<input type="number" name="TahunBuku" class="form-control" maxlength="4" placeholder="Masukkan tahun buku" autofocus value="<?php if(isset($TahunBuku)){echo $TahunBuku;}?>">
					<span class="text-danger"><?php if(isset($error_TahunBuku)){echo $error_TahunBuku;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Stok</label>
					<input type="number" name="stok" class="form-control" min="1" maxlength="2" placeholder="Stok" autofocus value="<?php if(isset($stok)){echo $stok;}?>">
					<span class="text-danger"><?php if(isset($error_stok)){echo $error_stok;}?></span>
			</div>
			<div class="form-group">
					<label for="name">Unggah gambar</label>
					<span class="text-muted">(jpg, jpeg, png, or gif)</span>
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
					<input class="btn" type="file" name="file_gambar" id="file_gambar"/>
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
