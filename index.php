<?php
if(!isset($_SESSION))
  {
    session_start();
  }
include 'connect.php';
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
    <!--Navigation-->
    <?php
  	if(isset($_SESSION['login_anggota'])){
  		echo '<span class="navbar-default navbar-fixed-top text-muted" align="center">Masuk sebagai '.$_SESSION['login_anggota'].'</span>';
  	}elseif(isset($_SESSION['login_admin'])){
  		echo '<span class="navbar-default navbar-fixed-top text-muted" align="center">Masuk sebagai '.$_SESSION['login_admin'].'</span>';
  	}
  	?>
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
      <div class="container">
        <div class="container-fluid">
          <div class="navbar-header page-scroll">
            <a class="navbar-brand page-scroll" href="#header">home</a>
          </div>
          <div class="collapse navbar-collapse">
              <ul class="nav navbar-nav navbar-right">
                <?php
        				if(!((isset($_SESSION['login_anggota'])) or (isset($_SESSION['login_admin'])))){
                  echo '<li><a href="loginAnggota.php">Masuk</a></li>';}

                if((isset($_SESSION['login_anggota'])) or (isset($_SESSION['login_admin']))){
                  echo '<li><a href="logout.php">Keluar</a></li>';}

                if(isset($_SESSION['login_anggota'])){
                  echo '<li><a href="pinjamAnggota.php">History Pinjam</a></li>';}

                if(isset($_SESSION['login_admin'])){
          				echo '<li><a href="pinjam.php">Pinjam Buku</a></li>';
          				echo '<li><a href="pengembalian.php">Pengembalian</a></li>';
          				echo '<li><a href="pendaftaran.php">Pendaftaran</a></li>';
          				echo '<li><a href="pinjamPetugas.php">History Pinjam</a></li>';
          				}
                ?>
                <li><a class="page-scroll" href="#search">Pencarian</a></li>
                <li><a class="page-scroll" href="#about">Tentang</a></li>
              </ul>
            </div>
        </div>
      </div>
    </nav>

    <!--Header-->
    <header id="header">
      <div class="container">
          <div class="intro-text animated fadeInDown delay-05s">
              <div class="intro-lead-in">Perpustakaan Desa</div>
              <div class="intro-heading">Karangduren</div>
              <?php
              if(!isset($_SESSION['login_admin'])){
                echo '<a class="link" href="viewBookAnggota.php" >Daftar Buku</a>';}
              if(isset($_SESSION['login_admin'])){
                echo '<table align="center">
                      <th><a class="link" href="viewBook.php" >Daftar Buku</a></th>';
                echo '<th><a class="link" href="viewAnggota.php" >Daftar Anggota</a></th></table>';}
              ?>
          </div>
      </div>
    </header>

    <!--Search-->
    <section id="search">
      <div class="container" align="center">
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
    </section>

    <!--About-->
    <section id="about" class="bg-gray">
      <div class="container">
        <div class="row text-center">
          <h2 class="section-heading">Tentang</h2>
          <h3 class="section-subheading text-muted">Perpustakaan Desa Karangduren
          merupakan sebuah perpustakan desa dimana banyak menyimpan berbagai macam buku
          yang bermanfaat. Perpustakaan dimana tempat masyarakat desa banyak melakukan
          akivitas membaca, dengan ruang yang hening dan jauh dari kebisingan yang mampu
          menciptakan ruang membaca yang nyaman sebagai fasilitas untuk meningkatkan
          minat baca dan gerakan gemar membaca khususnya untuk masyarakat Desa Karangduren.
          <br/><br/><b>"I have always imagined that paradise will be a kind of library"</b></h3>
        </div>
      </div>
    </section>

    <!--footer-->
    <footer>
      <div class="container">
        <div class="row">
          <span class="copyright">Copyright &copy; Tim II KKN Undip 2017</span>
          <span class="hashtag">Desa Karangduren, Kecamatan Tengaran, Kabupaten Semarang</span>
        </div>
      </div>
    </footer>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
