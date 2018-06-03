<?php

include_once 'db_login.php';
$con = mysqli_connect($db_host,$db_username, $db_password, $db_database) or die("Error " . mysqli_error($con));
//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['daftar'])) {
    $id_anggota = mysqli_real_escape_string($con, $_POST['id_anggota']);
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $alamat = mysqli_real_escape_string($con, $_POST['alamat']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    $no_telp = mysqli_real_escape_string($con, $_POST['no_telp']);

    //nama hanya dapat berupa alphabet dan spasi
    if (!preg_match("/^[0-9]+$/",$id_anggota)) {
        $error = true;
        $id_anggota_error = "ID hanya dapat berupa angka";
    }

    if (!preg_match("/^[a-zA-Z ]+$/",$nama)) {
        $error = true;
        $nama_error = "Nama hanya dapat berupa huruf";
    }

    if (strlen($alamat)>100) {
        $error = true;
        $nama_error = "Alamat maksimal 100 karakter";
    }

    if(strlen($password) < 6) {
        $error = true;
        $password_error = "Password harus minimal 6 karakter";
    }

    if($password != $cpassword) {
        $error = true;
        $cpassword_error = "Konfirmasi password tidak sesuai";
    }

    if(!preg_match('~^\d{12}$~', $no_telp)) {
        $error = true;
        $no_telp_error = "Masukkan nomor HP yang valid";
    }

    if (!$error) {
        if(mysqli_query($con, "INSERT INTO anggota(id_anggota,nama,alamat,pass,no_telp) VALUES('".$id_anggota."','".$nama."','".$alamat."','".($password)."','".$no_telp."')")) {
            $successmsg = "<h4>Sukses mendaftar</h4>";
        } else {
            $errormsg = "Pendaftaran gagal, akun sudah pernah terdaftar";
        }
    }
}
?>
<?php

session_start();
include 'connect.php';

if(!$_SESSION){
  header('location:loginAdmin.php');
}

 ?>
<!DOCTYPE html>
<html>
<head>
  <title>Perpustakaan Karangduren</title>
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/font-awesome.css" rel="stylesheet">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" >
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
      <h2 class="section-heading">Pendaftaran anggota</h2>
    </div>
    <br /><br /><center>
    <div class="row">
       <div class="col-md-4 col-md-offset-4 well">
          <span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
          <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="formpendaftaran">
                <fieldset>
                    <legend><label>Daftar</label></legend>
                    <div class="form-group">
                        <label for="name">ID Anggota</label>
                        <input type="text" name="id_anggota" placeholder="Masukkan nomor KTP/ Kartu Pelajar" required value="<?php if($error) echo $id_anggota; ?>" class="form-control" />
                        <span class="text-danger"><?php if (isset($id_anggota_error)) echo $id_anggota_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="nama" placeholder="Masukkan nama" required value="<?php if($error) echo $nama; ?>" class="form-control" />
                        <span class="text-danger"><?php if (isset($nama_error)) echo $nama_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Password</label>
                        <input type="password" name="password" placeholder="Password" required class="form-control" />
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Konfirmasi Password</label>
                        <input type="password" name="cpassword" placeholder="Konfirmasi password" required class="form-control" />
                        <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Nomor Telepon</label>
                        <input type="text" name="no_telp" placeholder="Masukkan nomor handphone" required class="form-control" />
                        <span class="text-danger"><?php if (isset($no_telp_error)) echo $no_telp_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Alamat</label>
                        <input type="text" name="alamat" placeholder="Masukkan alamat tempat tinggal" required value="<?php if($error) echo $alamat; ?>" class="form-control" />
                        <span class="text-danger"><?php if (isset($alamat_error)) echo $alamat_error; ?></span>
                    </div>

                    <div class="form-group">
                        <input class="btn" type="submit" name="daftar" value="Daftar" class="btn btn-primary" />
                    </div>
                </fieldset>
            </form>

    </div>
</div>
</div>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
