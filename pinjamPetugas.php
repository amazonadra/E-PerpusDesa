<?php
session_start();
include 'connect.php';

if(!$_SESSION){
	header('location:loginAdmin.php');
}
?>


<!-- <?php
session_start();
if(isset($_POST['login'])){
	try{
		$username=$_POST['username'];
		$password=$_POST['password'];
		$query=$conn->prepare("SELECT * FROM anggota WHERE username='$nama' AND password='$pass'");
		//$query->bindParam(':email',$email);
		//$query->bindParam(':password',$password);
		$query->execute();
		$result=$query->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			$_SESSION['login_']=$result[0]['username'];
			header('location:index.php');
		}
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
}
?> -->

<?php

// session_start();
if(!isset($_SESSION))
    {
        session_start();
    }
include 'connect.php';

if(!$_SESSION){
  header('location:loginAnggota.php');
}

 ?>

<!DOCTYPE html>

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
			<h2 class="section-heading">History Peminjaman</h2>
		</div>
		<br /><br />
		<center>
	<table class="table table-striped table-bordered table-center" align="center" style="width:80%">
	<thead><tr>
		<th>No</th>
		<th>ID Anggota</th>
		<th>Nama</th>
		<th>ID Buku</th>
		<th>Judul</th>
		<th>Tanggal Pinjam</th>
		<th>Tanggal Kembali</th>
		<th>Total Denda</th>
	</tr></thead>

	<?php
			//include our login information
	  require_once "db_login.php";
      $db = new mysqli($db_host, $db_username, $db_password, $db_database);
      if($db->connect_errno){
        die("Could not connect to the database: <br />". $db->connect_error);
      }

      $query= "SELECT * FROM anggota, peminjaman, buku, detail_transaksi WHERE anggota.id_anggota=peminjaman.id_anggota AND detail_transaksi.id_transaksi=peminjaman.id_transaksi AND detail_transaksi.id_buku=buku.id_buku limit $start, $limit";

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
        echo '<td>'.$row->Judul.'</td>';
        echo '<td>'.$row->tgl_pinjam.'</td>';
				echo '<td>'.$row->tgl_kembali.'</td>';
        echo '<td>'.$row->total_denda.'</td>';
        echo '</tr>';
      	$i++;
      }
			/*try{
				$result = $con->query($query);
      				if(!$result) {
        			die("Could not connect to the database: <br />". $db->connect_error);
      					}
				$start=0;
				$query=$con->prepare("SELECT * FROM peminjaman, buku, detail_transaksi,anggota WHERE detail_transaksi.id_transaksi=peminjaman.id_transaksi AND detail_transaksi.id_buku=buku.id_buku AND anggota.email='".$_SESSION['login_anggota']."'");
				$query->execute();
				$i = $start + 1;
				while($row = $result->fetch_object()){
					echo '<tr>';
						echo '<td>'.$i.'</td>';
						echo '<td>'.$result["id_transaksi"].'</td>';
						echo '<td>'.$result["nim"].'</td>';
						echo '<td>'.$result["Judul"].'</td>';
						echo '<td>'.$result["tgl_pinjam"].'</td>';
						echo '<td>'.$result["total_denda"].'</td>';
					echo '</tr>';
					$i++;

				}
				//$result->free();

			}
			catch(Exception $e){
				echo $e->getMessage();
				}*/
		echo '</table>';
    echo '<br />';
    echo 'Total Rows = '.$result->num_rows;
    echo "<br><br>";
    echo "Halaman = ";
    $result->free();
    $banyakPage=$db->query("SELECT * FROM detail_transaksi")->num_rows;
    for ($i=1; $i<=ceil($banyakPage/$limit); $i++){
      echo "     <a class='a' href='pinjamPetugas.php?page=".$i."'>".$i."</a>";
    }
    echo '<br />';

	?>
	</table>
</div>
</body>
</html>
