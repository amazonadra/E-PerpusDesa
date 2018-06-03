<?php
	if(!isset($_SESSION))
    {
        session_start();
    }
	include 'connect.php';
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

			$query = " SELECT * FROM buku, kategori WHERE buku.id_kategori=kategori.id_kategori AND buku.id_buku='".$id_buku."'";

			// Execute the query
			$result = $db->query( $query );
			if (!$result){
				die ("Could not query the database: <br />". $db->error);
			}else{
				while ($row = $result->fetch_object()){
					$Nobuku = $row->no_buku;
					$Judul = $row->Judul;
					$Pengarang = $row->Pengarang;
					$Penerbit = $row->Penerbit;
					$TahunBuku = $row->TahunBuku;
					$kategori = $row->nama;
					$stok = $row->stok;
					$tgl_update = $row->tgl_update;
					$file_gambar = $row->file_gambar;
					$stok_tersedia = $row->stok_tersedia;
				}
    	}
		?>
	</head>
	<body class="bg-gray">
		<?php
		if(isset($_SESSION['login_anggota'])){
			echo '<span class="navbar-default navbar-fixed-top text-muted" align="center">Masuk sebagai '.$_SESSION['login_anggota'].'</span>';
		}elseif(isset($_SESSION['login_admin'])){
			echo '<span class="navbar-default navbar-fixed-top text-muted" align="center">Masuk sebagai '.$_SESSION['login_admin'].'</span>';
		}
		?>
	  <nav id="mainNav" class="navbar navbar-default navbar-custom">
	    <div class="container">
	      <div class="container-fluid">
	        <div class="navbar-header page-scroll">
	          <a class="navbar-brand page-scroll" href="index.php">home</a>
	        </div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<?php
									if(isset($_SESSION['login_admin'])){
										echo '<a class="page-scroll" href="viewBook.php">Kembali ke data buku</a>';
									}else{
										echo '<a class="page-scroll" href="viewBookAnggota.php">Kembali ke data buku</a>';
									}
							?>
							</li>
						</ul>
					</div>
	      </div>
	    </div>
	  </nav>
		<center>
		<div id="page" class="animated fadeInDown delay-05s">
			<div class="container" align="center">
        <h2 class="section-heading">Detail Buku</h2>
      </div>
			<br /><br />
			<table class="table table-striped" style="width:35%">
				<tr>
					<td colspan="3" valign="top" align="center">
						<img class="img-book" src="uploads/<?php echo $file_gambar; ?>" width='100px' height='100px' /></td>
				</tr>
				<tr>
					<td valign="top">ID Buku</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(isset($Nobuku)){echo $Nobuku;}?></td>
				</tr>
				<tr>
					<td valign="top">Judul</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(isset($Judul)){echo $Judul;}?></td>
				</tr>
				<tr>
					<td valign="top">Pengarang</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(isset($Pengarang)){echo $Pengarang;}?></td>
				</tr>
				<tr>
					<td valign="top">Penerbit</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(isset($Penerbit)){echo $Penerbit;}?></td>
				</tr>
				<tr>
					<td valign="top">Tahun</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(isset($TahunBuku)){echo $TahunBuku;}?></td>
				</tr>
				<tr>
					<td valign="top">Kategori</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(isset($kategori)){echo $kategori;}?></td>
				</tr>
				<tr>
					<td valign="top">Stok</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(isset($stok)){echo $stok;}?></td>
				</tr>
				<tr>
					<td valign="top">Stok Tersedia</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(isset($stok_tersedia)){echo $stok_tersedia;}?></td>
				</tr>
				<tr>
					<td valign="top">Tanggal Update</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(isset($tgl_update)){echo $tgl_update;}?></td>
				</tr>
			</table>
		</div>
	</body>
</html>
<?php
$db->close();
?>
