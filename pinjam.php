<?php
	session_start();
	include 'connect.php';

	if(!$_SESSION){
		header('location:loginAdmin.php');
	}

	$nama_petugas = $_SESSION['login_admin'];
	include_once 'db_login.php';
	$con = mysqli_connect($db_host,$db_username, $db_password, $db_database) or die("Error " . mysqli_error($con));
	//set validation error flag as false
?>

<html>
	<script type="text/javascript" src="assets/js/jquery-1.10.2.js"></script>
 	<script type="text/javascript">
 		var counter = 0;
 		$(function(){
  		$('p#add_field').click(function(){
 				if(counter < 2){
    			counter += 1;
    			$('#container').append('<div class="container"><strong>Nama Buku Ke-' + counter + '</strong><br />'
    				+ '<input class="form-control" placeholder="Pilih Nama Buku" style="width:60%" list="namabuku" required id="field_' + counter + '" name="dynfields[]' + '" type="text" /><br /><br />' );
 				}else{
   				document.getElementById("limit").innerHTML = "<span class='text-danger'>Jumlah buku yang dipinjam maksimal 2 buku</span></div>";
 				}
  		});
 		});
 	</script>

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
	      </div>
	    </div>
	  </nav>
		<center>
		<div id="page" class="animated fadeInDown delay-05s">
			<div class="container" align="center">
        <h2 class="section-heading">Peminjaman Buku</h2>
      </div>
			<br /><br />

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="formpeminjaman">
				<div class="container">
        	<label for="id_anggota">ID Anggota :</label>
         	<input class="form-control" placeholder="Masukkan ID Anggota" style="width:60%" list="dataid_anggota" required name="id_anggota"/>
         	<datalist id="dataid_anggota">
						<?php
          		$query = " SELECT * FROM anggota ";
            	$result = mysqli_query($con,$query);
            	if (!$result){
               	die ("Could not query the database: <br />". mysqli_error($con));
            	}
            	while ($row = mysqli_fetch_array($result)){
               	echo "<option value='".$row['id_anggota']."'>";
            	}
          	?>
         	</datalist>

					<datalist id="namabuku">
            <?php
            	$query = " SELECT * FROM buku ";
            	$result = mysqli_query($con,$query);
            	if (!$result){
               	die ("Could not query the database: <br />". mysqli_error($con));
            	}
            	while ($row = mysqli_fetch_array($result)){
               	echo "<option value='".$row['Judul']."'>".$row['no_buku']."<option/>";
            	}
            ?>
         	</datalist>
					<br /><br />
      	</div>
				<div>
        	<div id="container"> </div>
       		<p id="add_field"><a class='a' href="#"><span>Tambah Buku</span></a></p>
       		<div id="limit"> </div><br />
       		<input class="btn" type="submit" name="submit_val" value="Submit" />
		 		</div>
   		</form>
 		</div>
 </body>

<?php
 if (isset($_POST['submit_val'])) {
   if ($_POST['dynfields']) {

   foreach ( $_POST['dynfields'] as $key=>$value ) {
     $querystok = "SELECT * from buku WHERE Judul='".$value."'";
     $resultstok = mysqli_query($con,$querystok);
     while ($row = mysqli_fetch_array($resultstok)){
       if ($row['stok_tersedia'] <1){
         $errorstok = "<br /><label class='text-danger'>Stok buku kosong.</label>";
       }
     }
   }

    //cek udah balikin apa belum
    $querystatus = "SELECT * FROM peminjaman INNER JOIN detail_transaksi ON peminjaman.id_transaksi = detail_transaksi.id_transaksi WHERE id_anggota='".$_POST['id_anggota']."' AND detail_transaksi.tgl_kembali  IS NULL ";
    $resultstatus = mysqli_query($con,$querystatus);
    $terpinjam = 0;
     while ($row = mysqli_fetch_array($resultstatus)){
       $terpinjam+=1;
       $id_anggotapeminjam = $row['id_anggota'];
     }

	if(isset($errorstok)){
     echo $errorstok;
   }
   elseif($terpinjam > 0){
     echo "<br /><label class='text-danger'>Maaf ".$id_anggotapeminjam." belum mengembalikan ".$terpinjam." buku.</label>";
   }else{

			 	echo "<br /><label class='text-muted'>Buku terpinjam</label>";
        $waktu = date('Y-m-d H:i:s');
        $query = "INSERT INTO peminjaman(id_anggota,tgl_pinjam,nama_petugas) VALUES('".$_POST['id_anggota']."','".$waktu."','".$nama_petugas."')";
        $result = mysqli_query($con,$query);
        if (!$result){
           die ("Could not query the database: <br />". mysqli_error($con));
        }

        $querytanggal = "SELECT * from peminjaman WHERE tgl_pinjam='".$waktu."'";
        $resultwaktu = mysqli_query($con,$querytanggal);
        while ($row = mysqli_fetch_array($resultwaktu)){
          $id_transaksi = $row['id_transaksi'];
        }

        foreach ( $_POST['dynfields'] as $key=>$value ) {
          $querystok = "SELECT * from buku WHERE Judul='".$value."'";
          $resultstok = mysqli_query($con,$querystok);
          while ($row = mysqli_fetch_array($resultstok)){
            $stok_tersedia = $row['stok_tersedia'];
            $id_buku = $row['id_buku'];
            $querypinjam = "INSERT INTO detail_transaksi(id_buku,id_transaksi) VALUES('".$id_buku."','".$id_transaksi."')";
            $resultpinjam = mysqli_query($con,$querypinjam);
            $stok_baru = $stok_tersedia - 1;
            $queryupdatestok = "UPDATE buku set stok_tersedia = ".$stok_baru." WHERE id_buku ='".$id_buku."' ";
            $resultupdatestok = mysqli_query($con,$queryupdatestok);

          }




        }



   }

   }
   }

    // mysql_close();
 ?>
</html>
