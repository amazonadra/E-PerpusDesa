<?php
session_start();
include 'connect.php';

if(!$_SESSION){
	header('location:loginAdmin.php');
}
require_once('db_login.php');
$db = new mysqli($db_host, $db_username, $db_password, $db_database);
if ($db->connect_errno){
	die ("Could not connect to the database: <br />". $db->connect_error);
}
?>

<!DOCTYPE html>
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
									<a class="page-scroll" href="pengembalian.php">Kembali ke data buku</a>
								</li>
							</ul>
						</div>
		      </div>
		    </div>
		  </nav>
			<div id="page" class="animated fadeInDown delay-05s">
				<div class="container" align="center">
					<h2 class="section-heading">Pengembalian Buku</h2>
				</div>
				<br /><br /><center>
<?php
if(!empty($_GET['id_transaksi'])){
	$id_transaksi = $db->real_escape_string($_GET['id_transaksi']);
	// $id_buku = $db->real_escape_string();

	$query = $db->query("SELECT * FROM peminjaman AS a INNER JOIN anggota AS c ON c.id_anggota = a.id_anggota WHERE a.id_transaksi = '$id_transaksi'") or die($db->error);
	$query2 = $db->query("SELECT * FROM peminjaman AS a INNER JOIN detail_transaksi AS b ON a.id_transaksi = b.id_transaksi INNER JOIN anggota AS c ON c.id_anggota = a.id_anggota INNER JOIN buku AS d ON d.id_buku = b.id_buku WHERE a.id_transaksi = '$id_transaksi'") or die($db->error);
	if($query->num_rows!=0){
		$detail_peminjaman = $query->fetch_object();
		echo "<b><table class='table table-striped' style='width:80%'>";
		echo "<tr><td>ID Anggota : ".$detail_peminjaman->id_anggota."</td></tr>" ;
		echo "<tr><td>Nama : ".$detail_peminjaman->nama."</td></tr>";
		echo "<tr><td>Tanggal Pinjam : ".$detail_peminjaman->tgl_pinjam."</td></tr></table></b>";
		$subdenda = 0;
		// $stok_tersedia = $query->fetch_object();
		// $id_buku = $query->fetch_object();

		echo "<table class='table table-striped table-bordered' style='width:80%'>";
		echo "<thead><tr>	<th>No</th>
											<th>Judul</th>
											<th>Pengarang</th>
											<th>ID Buku</th>
											<th>Denda</th></tr></thead>";
		$i=1;
		while($peminjaman = $query2->fetch_object()){
			$id_bukunya = $peminjaman->id_buku;
			echo "<tr><td>".$i."</td>";
			echo "<td>".$peminjaman->Judul."</td>";
			echo "<td>".$peminjaman->Pengarang."</td>";
			echo "<td>".$peminjaman->no_buku."</td>";
			$tgl_peminjaman = $peminjaman->tgl_pinjam;
			$tgl_sekarang = date("Y-m-d");
			$waktu_sekarang = strtotime($tgl_sekarang);
			$tgl_diff = $waktu_sekarang - strtotime($tgl_peminjaman);
			$day_diff = ceil($tgl_diff/(3600*24));
			$denda = 0;
			$i++;
			if($day_diff>14){
				$denda = ($day_diff - 14) * 500;
			}
			echo "<td>".$denda."</td></tr>";
			$subdenda += $denda;

			if(isset($_POST['kembali'])){
				$db->query("UPDATE detail_transaksi SET tgl_kembali = '$tgl_sekarang', denda = '$denda' WHERE id_transaksi = '$id_transaksi' AND id_buku = '".$peminjaman->id_buku."'") or die($db->error);
			}
	}
	echo "</table>";
	echo "<h3 class='text-danger'>Total Denda : ".$subdenda."</h3><br/>";

	if(isset($_POST['kembali'])){
		$query2 = $db->query("SELECT * FROM peminjaman AS a INNER JOIN detail_transaksi AS b ON a.id_transaksi = b.id_transaksi INNER JOIN anggota AS c ON c.id_anggota = a.id_anggota INNER JOIN buku AS d ON d.id_buku = b.id_buku WHERE a.id_transaksi = '$id_transaksi'") or die($db->error);
		while($peminjaman = $query2->fetch_object())
		{
				$id_bukunya = $peminjaman->id_buku;
				$db->query("UPDATE buku AS g, (SELECT c.stok_tersedia+1 AS tersedia FROM buku AS c WHERE c.id_buku = '$id_bukunya') AS stok_baru SET g.stok_tersedia = stok_baru.tersedia WHERE g.id_buku = '$id_bukunya'") or die($db->error);
		}
		// $stok_baruu= $stok_tersedia + 1 ;
		$db->query("UPDATE peminjaman SET total_denda = '$subdenda' WHERE id_transaksi = '$id_transaksi'") or die($db->error);
		echo "<label class='text-muted'>Buku sudah Dikembalikan</label>";
	}else {
		echo "<form method='POST'>
		<button class='btn' type='submit' name='kembali'>Kembalikan Buku</button>
		</form>";

	}
	}
}
?>
			</center>
		</div>
	</body>
</html>
