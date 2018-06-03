<?php
    if(!empty($_GET['page'])){
      $page=(int)$_GET['page'];
    }else{
      $page=1;
    }
    if($page<1){
      $page=1;
    }
    $limit=5;
    $start=($page-1)*$limit;

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

</head>
<body class="bg-gray">
  <?php
  if(isset($_SESSION['login_anggota'])){
    echo '<span class="navbar-default navbar-fixed-top text-muted" align="center">Masuk sebagai '.$_SESSION['login_anggota'].'</span>';
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
    <?php
    //$namaNya = base64_decode($_COOKIE['petugas']);
    //$nama = explode (":", $namaNya);
    ?>

    <!--<h2 style="text-align:center;"><?php //echo $nama[3] ?> , <a href="logout.php">LOGOUT</a></h2>
    !-->
  <div class="container" align="center" id="search2">
    <h2 class="section-heading">Daftar Buku</h2>
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
  <table class="table table-striped table-bordered table-center" align="center" style="width:80%">
    <thead><tr>
      <th>No</th>
    	<th>ID Buku</th>
    	<th>Judul</th>
      <th>Pengarang</th>
      <th>Kategori</th>
    	<th>Pilihan</th>
    </tr></thead>

    <?php
// connect database
  require_once('db_login.php');
    $db = new mysqli($db_host, $db_username, $db_password, $db_database);
    if ($db->connect_errno){
        die ("Could not connect to the database: <br />". $db->connect_error);
    }

    //Asign a query
    $query = " SELECT * FROM buku, kategori WHERE buku.id_kategori=kategori.id_kategori ORDER BY id_buku ASC LIMIT $start, $limit";

    // Execute the query
    $result = $db->query( $query );
    if (!$result){
       die ("Could not query the database: <br />". $db->error);
    }

    // Fetch and display the results
    $i = $start + 1;
    while ($row = $result->fetch_object()){
    echo '<tr>';
        	echo '<td>'.$i.'</td>';
        	echo '<td>'.$row->no_buku.'</td> ';
    	    echo '<td>'.$row->Judul.'</td> ';
        	echo '<td>'.$row->Pengarang.'</td>';
          echo '<td>'.$row->nama.'</td>';
    	    echo '<td><a class="a" href="detailBook.php?id_buku='.$row->id_buku.'">  Detail  </a></td>';
    echo '</tr>';
    	$i++;
    }

    echo '</table>';
    echo '<br />';
    echo 'Total Rows = '.$result->num_rows;
    echo "<br><br>";
    echo "<b>Halaman</b> = ";
    $result->free();
    $banyakPage=$db->query("SELECT * FROM buku")->num_rows;
    for ($i=1; $i<=ceil($banyakPage/$limit); $i++){
      echo "     <a class='a' href='viewBookAnggota.php?page=".$i."'>".$i."</a>";
    }
?>
  </table>
  </div>
  </body>
</html>
