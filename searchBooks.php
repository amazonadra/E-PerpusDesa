<?php
    if(!isset($_SESSION))
    {
        session_start();
    }

	include 'connect.php';

	$error = false;
	$Judul = $_GET['title'];
	if($Judul == ""){
		$error = true;
	}
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
			</div>
		</div>
	</nav>

<center>
<div id="page" class="animated fadeInDown delay-05s">
  <div class="container" align="center" id="search2">
    <h2 class="section-heading">Hasil Pencarian</h2>
    <form action="searchBooks.php" method="GET">
      <table style="width:100%">
        <tr>
          <td align="right" style="width:22%"><b>Pencarian buku : </b></td>
          <td align="center"><input class="form-control" placeholder="Tuliskan judul buku" type="text" name="title" /></td>
          <td><input class="btn" type="submit" value="Cari" /></td>
        </tr>
      </table>
    </form>
  </div>
	<br /><br />
		<?php
		if(!($error)){
			$query="SELECT buku.*,kategori.nama FROM buku LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori WHERE Judul LIKE '%".$Judul."%'";
			$result=mysqli_query($db,$query);
			$result = $db->query( $query );
			if (!$result){
				die ("Could not query the database: <br />". $db->error);
			}else{
				echo'<table class="table table-striped table-bordered table-center" align="center" style="width:80%">';
			      	echo'<thead><tr>';
                echo'<th>No</th>';
				        echo'<th>ID Buku</th>';
				      	echo'<th>Judul</th>';
				        echo'<th>Pengarang</th>';
				      	echo'<th>Kategori</th>';
                echo'<th>Pilihan</th>';
			      	echo'</tr></thead>';
              $j = 1;
				while ($row = $result->fetch_object()){
					echo '<tr>';
          echo '<td>'.$j.'</td>';
					echo '<td>'.$row->no_buku.'</td>';
					echo '<td>'.$row->Judul.'</td>';
					echo '<td>'.$row->Pengarang.'</td>';
					echo '<td>'.$row->nama.'</td>';
					echo '<td><a class="a" href="detailBook.php?id_buku='.$row->id_buku.'">  Detail  </a></td>';
					echo '</tr>';
          $j++;
				}
				 echo '</table>';
	    }
		}else {
			echo "Maaf, Anda belum memasukkan kunci pencarian";
		}
	?>
  </table>
	</div>
</body>
</html>
