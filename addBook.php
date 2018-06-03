<?php
	session_start();
	include 'connect.php';

	if(!$_SESSION){
		header('location:loginAdmin.php');}

	// connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if ($db->connect_errno){
		die ("Could not connect to the database: <br />". $db->connect_error);
	}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Perpustakaan Karangduren</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/font-awesome.css" rel="stylesheet">
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
				<h2 class="section-heading">Tambah Buku</h2>
			</div>
			<br /><br />
			<center>

	<!--action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"-->
<?php

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

if (isset($_POST["submit"])){
	$error = false;

	$no_buku = test_input($_POST['no_buku']);
	if (!preg_match("/[-0-9]/",$no_buku)) {
	   $error = true;
	   $error_no_buku = "ID Buku hanya dapat berupa angka dan strip (-) ";
	}else{
	 $error = false;
	}

	$Pengarang = test_input($_POST['Pengarang']);
	if(strlen($Pengarang)>50){
		$error = true;
		$error_Pengarang = "Pengarang maksimal 50 karakter";
	}else{
		$error = false;
	}

	$Judul = $_POST['Judul'];

	$Penerbit = $_POST['Penerbit'];
	if(strlen($Penerbit)>50){
		$error = true;
		$error_Penerbit = "Penerbit maksimal 50 karakter";
	}else{
		$error = false;
	}

	$id_kategori = $_POST['id_kategori'];

	$TahunBuku = $_POST['TahunBuku'];

	$stok = $_POST['stok'];

	if (!$error){
	$target_dir = "uploads/";
	// $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$file_gambar = basename($_FILES['file_gambar']['name']); //untuk masukkin ke DB nya
	$target_file = $target_dir . $file_gambar;
	// $file_gambar_name = sha1(date("Y-m-d H:i:s").rand(1,100).rand(1,10)).'.'.$imageFileType;
	// $target_file = $target_dir.$file_gambar_name;
	$upload_ok = 1;
	$file_type = pathinfo($target_file,PATHINFO_EXTENSION);

	if ($_FILES['file_gambar']['error'] > 0)
	{
		echo '<div class="text-danger">Problem: ';
		switch ($_FILES['file_gambar']['error'])
		{
			case 1:  echo 'File exceeded upload_max_filesize';
			break;
			case 2:  echo 'File exceeded max_file_size';
			break;
			case 3:  echo 'File only partially uploaded';
			break;
			case 4:  echo 'No file uploaded';
			break;
			case 6:  echo 'Cannot upload file: No temp directory specified';
			break;
			case 7:  echo 'Upload failed: Cannot write to disk';
			break;
		}
		echo "</div>";
		exit;
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "<div class='text-danger'>Sorry, file already exists.</div><br />";
		$upload_ok = 0;
	}
	// Check file size if you not use hidden input 'MAX_FILE_SIZE'
	/*if ($_FILES['userfile']['size'] > 1000000) {
		echo "Sorry, your file is too large.<br />";

		$upload_ok = 0;
	}*/
	// Allow certain file formats
	$allowed_type = array("jpg", "png", "jpeg", "gif");
	if(!in_array($file_type, $allowed_type)) {
		echo "<div class='text-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
		$upload_ok = 0;
	}
	// Does the file have the right MIME type?
	/*if ($_FILES['userfile']['type'] != 'text/plain'){
		echo 'Problem: file is not plain text';
		$uploadOk = 0;
	}*/
	// put the file where we'd like it
	if ($upload_ok != 0){
		if (is_uploaded_file($_FILES['file_gambar']['tmp_name'])){
			if (!move_uploaded_file($_FILES['file_gambar']['tmp_name'], $target_file)){
				echo 'Problem: Could not move file to destination directory';
			}else{
				echo '<h3 class="text-muted text-box">Gambar berhasil diunggah<br />';
				echo 'Filename = '.basename($_FILES['file_gambar']['name']).'<br />';
				echo 'Size = '.$_FILES['file_gambar']['size'].' byte</h3>';
			}
		}else{
			echo '<div class="text-danger">Problem: Possible file upload attack. Filename: ';
			echo $_FILES['file_gambar']['name'];
			echo "</div>";
		}
	}

	//$file_gambar = $_POST['file_gambar'];
	if ($file_gambar == '' || $file_gambar == 'none'){
		$error_file_gambar = "File Gambar is required";
		$valid_file_gambar = FALSE;
	}else{
		$valid_file_gambar = TRUE;
	}

		$query = "INSERT into buku(no_buku, Judul, id_kategori, Pengarang, Penerbit, TahunBuku, file_gambar, stok, stok_tersedia) values('$no_buku','$Judul','$id_kategori','$Pengarang', '$Penerbit', '$TahunBuku', '$file_gambar', '$stok', '$stok') ";

		// Execute the query
		$result = $db->query( $query );
		if (!$result){
			die ("Could not query the database: <br />". $db->error);
		}else{
			echo '<h2 class="text-muted text-box">Buku berhasil ditambahkan</h2>';
			$db->close();
			exit;
		}
	}

}
?>

<form method="POST" autocomplete="on" enctype="multipart/form-data" >
	<div class="row">
		 <div class="col-md-4 col-md-offset-4 well">
							<fieldset>
									<div class="form-group">
											<label for="name">ID Buku</label>
											<input type="text" name="no_buku" required class='form-control' maxlength="15" placeholder="Masukkan ID Buku" autofocus value="<?php if(isset($no_buku)){echo $no_buku;}?>">
									    <span class="text-danger"><?php if(isset($error_no_buku)){echo $error_no_buku;}?></span>
									</div>

									<div class="form-group">
											<label for="name">ID Kategori</label>
											<input name="id_kategori" required class='form-control' maxlength="2" placeholder="Pilih ID Kategori" autofocus list="dataid_kategori">
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
											<input type="text" name="Judul" class='form-control' required maxlength="50" placeholder="Masukkan judul buku" autofocus value="<?php if(isset($Judul)){echo $Judul;}?>">
									    <span class="text-danger"><?php if(isset($error_Judul)){echo $error_Judul;}?></span>
									</div>

									<div class="form-group">
											<label for="name">Pengarang</label>
											<input type="text" name="Pengarang" class='form-control' required maxlength="50" placeholder="Masukkan nama pengarang (maks 50 karakter)" autofocus value="<?php if(isset($Pengarang)){echo $Pengarang;}?>">
									    <span class="text-danger"><?php if(isset($error_Pengarang)){echo $error_Pengarang;}?></span>
									</div>

									<div class="form-group">
											<label for="name">Penerbit</label>
											<input type="text" name="Penerbit" class='form-control' required maxlength="50" placeholder="Masukkan penerbit (maksimal 50 karakter)" autofocus value="<?php if(isset($Penerbit)){echo $Penerbit;}?>">
									    <span class="text-danger"><?php if(isset($error_Penerbit)){echo $error_Penerbit;}?></span>
									</div>

									<div class="form-group">
											<label for="name">Tahun</label>
											<input type="number" name="TahunBuku" class="form-control" min="1" maxlength="4" required placeholder="Tahun terbit buku" autofocus value="<?php if(isset($TahunBuku)){echo $TahunBuku;}?>">
									    <span class="text-danger"><?php if(isset($error_TahunBuku)){echo $error_TahunBuku;}?></span>
									</div>

									<div class="form-group">
											<label for="name">Stok</label>
											<input type="number" name="stok" class="form-control" min="1" maxlength="3" required placeholder="Stok" autofocus value="<?php if(isset($stok)){echo $stok;}?>">
									    <span class="text-danger"><?php if(isset($error_stok)){echo $error_stok;}?></span>
									</div>

									<div class="form-group">
											<label for="name">Upload a picture</label>
											<span class="text-muted">(jpg, jpeg, png, or gif)</span>
											<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
											<input class="btn" type="file" name="file_gambar" id="file_gambar"/>
									</div>

									<div class="form-group">
											<input class="btn" type="submit" name="submit" value="Submit">
									</div>
							</fieldset>
		</form>
</div>
</body>
</html>
<?php
$db->close();
?>
