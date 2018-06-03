<?php
session_start();
include 'connect.php';

if(!$_SESSION){
	header('location:loginAdmin.php');
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Perpustakaan Karangduren</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/font-awesome.css" rel="stylesheet">
  <?php
	$limit=5;
	$page=isset($_GET['page'])?$_GET['page']:"";

	if(empty($page)){
		$start=0;
		$page=1;
	}
	else{
		$start=($page-1)*$limit;
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
				</div>
			</div>
		</nav>
    <div id="page" class="animated fadeInDown delay-05s">
      <div class="container" align="center">
        <h2 class="section-heading">Pengembalian buku</h2>
      </div>
      <br /><br /><center>
			<table class="table table-striped table-bordered table-center" style="width:80%">
      <thead><tr>
        <th>No</th>
				<th>ID Anggota</th>
				<th>Nama</th>
				<th>ID Buku</th>
				<th>Judul</th>
				<th>Tanggal Pinjam</th>
        <th>Pilihan</th>
      </tr></thead>
    <?php
      require_once "db_login.php";
      $db = new mysqli($db_host, $db_username, $db_password, $db_database);
      if($db->connect_errno){
        die("Could not connect to the database: <br />". $db->connect_error);
      }

      $query = "SELECT a.nama, a.id_anggota, p.tgl_pinjam, p.id_transaksi, b.judul, b.no_buku
                FROM detail_transaksi AS d INNER JOIN buku AS b
                ON d.id_buku = b.id_buku
                INNER JOIN peminjaman AS p
                ON d.id_transaksi = p.id_transaksi
                INNER JOIN anggota AS a
                ON p.id_anggota = a.id_anggota
                WHERE d.tgl_kembali IS NULL limit $start, $limit";

      $result = $db->query($query);
      if(!$result) {
        die("Could not connect to the database: <br />". $db->connect_error);
      }

      $i = $start + 1;
      while ($row = $result->fetch_object()){
        echo '<tr>';
        echo '<td>'.$i.'</td>';
				echo '<td>'.$row->id_anggota.'</td> ';
        echo '<td>'.$row->nama.'</td> ';
        echo '<td>'.$row->no_buku.'</td>';
				echo '<td>'.$row->judul.'</td>';
				echo '<td>'.$row->tgl_pinjam.'</td>';
        echo '<td><a class="a" href="pengembalian2.php?id_transaksi='.$row->id_transaksi.'">Mengembalikan</a></td>';
        echo '</tr>';
      	$i++;
      }
      echo '</table><br />';
      echo 'Total Rows = '.$result->num_rows;
      echo "<br /><br />";
      echo "<b>Halaman</b> = ";
      $result->free();
      $PageNum=$db->query("SELECT a.nama, a.id_anggota, p.tgl_pinjam, p.id_transaksi, b.judul, b.no_buku
	                FROM detail_transaksi AS d INNER JOIN buku AS b
	                ON d.id_buku = b.id_buku
	                INNER JOIN peminjaman AS p
	                ON d.id_transaksi = p.id_transaksi
	                INNER JOIN anggota AS a
	                ON p.id_anggota = a.id_anggota
	                WHERE d.tgl_kembali IS NULL")->num_rows;
      for($i=1; $i<=ceil($PageNum/$limit); $i++){
        echo "<a class='a' href='pengembalian.php?page=".$i."'>".$i." </a>";
      }
    ?>

    </table>
	</div>
  </body>
</html>
