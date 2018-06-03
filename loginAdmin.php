<?php
	require_once('db_login.php');
	session_start();
	$db= new mysqli($db_host, $db_username, $db_password, $db_database);
	if(!isset($_SESSION['login_admin'])){
	    if(isset($_POST['login'])){
		  if((!empty($_POST['username']))&&(!empty($_POST['password']))){
			$username = $db->real_escape_string($_POST['username']);
			$password = ($_POST['password']);

			$query=$db->query("SELECT * FROM petugas WHERE nama='$username' AND pas='$password'");

			if ($query->num_rows!=0)
			{
				$_SESSION['login_admin']=$username;
				header("Location:index.php");		//halaman utama admin
			}else{
				$warning= "Cek kembali username dan password";
			}
		  }else{
			$warning = "Username dan password harus di isi!";
		  }
		}
	}else{
		header("Location:index.php");
		exit;
	}
	$site_name = "Perpustakaan Karangduren";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $site_name ?></title>
        <!-- Main styles for this application -->
        <link href="assets/css/style2.css" rel="stylesheet">
		    <link href="assets/css/style.css" rel="stylesheet">
		    <link href="assets/css/font-awesome.css" rel="stylesheet">
    </head>
    <body>
			<nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
				<div class="container">
					<div class="container-fluid">
						<div class="navbar-header page-scroll">
							<a class="navbar-brand page-scroll" href="index.php">home</a>
						</div>
					</div>
				</div>
			</nav>
				<div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card-group vamiddle">
                        <div class="card  p-a-2">
                            <div class="card-block">
							<form method="POST">
                                <h1>Masuk</h1>
                                <p class="text-muted">Masuk sebagai admin</p>
                                <div class="input-group m-b-1">
                                    <span class="input-group-addon"><i class="icon-user"></i></span>
                                    <input name="username" type="text" class="form-control" placeholder="Username">
                                </div>
                                <div class="input-group m-b-2">
                                    <span class="input-group-addon"><i class="icon-lock"></i></span>
                                    <input name="password" type="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input name="login" type="submit" class="btn btn-primary p-x-2" value="Masuk"></button>
																				<span class="text-muted">Atau</span>
																				<a href="loginAnggota.php" class="text-orange"><b>Masuk sebagai anggota</b></a>
                                    </div>

                                </div>
								<div class="row alert" >
                                    <?php if(isset($warning)) echo "<i class='fa fa-circle text-danger'></i>".$warning; ?>
                                </div>
								</form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap and necessary plugins -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/tether.min.js"></script>
        <script src="assets/js/bootstrap2.min.js"></script>
        <script>
        function verticalAlignMiddle()
        {
            var bodyHeight = $(window).height();
            var formHeight = $('.vamiddle').height();
            var marginTop = (bodyHeight / 2) - (formHeight / 2);
            if (marginTop > 0)
            {
                $('.vamiddle').css('margin-top', marginTop);
            }
        }
        $(document).ready(function()
        {
            verticalAlignMiddle();
        });
        $(window).bind('resize', verticalAlignMiddle);
        </script>


    </body>
</html>
